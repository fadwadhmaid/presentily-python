<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    /**
     * Register a new user with security measures
     */
    public function register(Request $request)
    {
        // 1. RATE LIMITING - Protection contre les attaques par force brute
        $key = 'register:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Trop de tentatives. Veuillez réessayer dans {$seconds} secondes.",
                'retry_after' => $seconds
            ], 429);
        }

        // 2. VALIDATION AVANCÉE DES DONNÉES
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\pL\s\-]+$/u',
                'min:2'
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'unique:users,email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'required',
                'string',
                'min:12',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/'
            ],
            'school' => 'required|string|max:150',
            'grade' => 'required|in:1ere,2eme,3eme,4eme,Bac',
            'governorate' => 'required|string|max:50',
            'terms' => 'required|accepted',
            'age' => 'required|integer|min:13|max:120',
        ], [
            'name.regex' => 'Le nom ne peut contenir que des lettres et des espaces.',
            'name.min' => 'Le nom doit contenir au moins 2 caractères.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.min' => 'Le mot de passe doit contenir au moins 12 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'terms.accepted' => 'Vous devez accepter les conditions générales.',
            'age.min' => 'Vous devez avoir au moins 13 ans pour vous inscrire.',
            'age.max' => 'Âge invalide.',
        ]);

        if ($validator->fails()) {
            RateLimiter::hit($key, 3600);

            Log::warning('Tentative d\'inscription échouée - Validation', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'errors' => $validator->errors()
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 3. NETTOYAGE DES DONNÉES
            $name = $this->sanitizeInput($request->name);
            $school = $this->sanitizeInput($request->school);
            $email = strtolower(trim($request->email));

            // 4. VÉRIFICATION ADDITIONNELLE CONTRE LES EMAILS TEMPORAIRES
            if ($this->isTemporaryEmail($email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Les emails temporaires ne sont pas autorisés.'
                ], 422);
            }

            // 5. CRÉATION DE L'UTILISATEUR
            //    ⚠️ Le rôle est TOUJOURS 'student' à l'inscription (sécurité)
            $user = User::create([
                'uuid' => (string) Str::uuid(),
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($request->password, ['rounds' => 12]),
                'school' => $school,
                'grade' => $request->grade,
                'governorate' => $request->governorate,
                'age' => $request->age,
                'role' => 'student', // 👈 sécurité : forcer student
                'avatar_config' => [
                    'hair' => 'short',
                    'hairColor' => '#1E1B4B',
                    'skin' => '#F3D2B3',
                    'outfit' => 'hoodie',
                    'accessory' => 'none',
                ],
                'email_verification_token' => (string) Str::uuid(),
                'last_activity_date' => now(),
            ]);

            // 6. ENVOI DE L'EMAIL DE VÉRIFICATION
            $this->sendVerificationEmail($user);

            // 7. CRÉATION DU TOKEN AVEC EXPIRATION
            $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;

            // 8. LOG DE SÉCURITÉ
            Log::info('Nouvelle inscription réussie', [
                'user_id' => $user->id,
                'email' => $email,
                'ip' => $request->ip(),
                'grade' => $request->grade,
                'governorate' => $request->governorate
            ]);

            // 9. RÉINITIALISER LE RATE LIMITING
            RateLimiter::clear($key);

            // 10. RÉPONSE
            return response()->json([
                'success' => true,
                'message' => 'Inscription réussie ! Un email de vérification vous a été envoyé.',
                'user' => $this->formatUserData($user),
                'token' => $token,
                'role' => $user->role ?? 'student', // 👈 AJOUT
                'requires_verification' => true,
                'verification_sent' => true
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'inscription', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? null,
                'ip' => $request->ip(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer plus tard.'
            ], 500);
        }
    }

    /**
     * Login with security measures (commun élève + admin)
     */
    public function login(Request $request)
    {
        // 1. RATE LIMITING
        $key = 'login:' . $request->ip() . ':' . $request->email;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Trop de tentatives. Veuillez réessayer dans {$seconds} secondes.",
                'retry_after' => $seconds
            ], 429);
        }

        // 2. VALIDATION
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            RateLimiter::hit($key, 3600);
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // 3. RECHERCHE DE L'UTILISATEUR
        $user = User::where('email', strtolower(trim($request->email)))->first();

        // 4. VÉRIFICATION DE L'UTILISATEUR
        if (!$user) {
            RateLimiter::hit($key, 3600);
            return response()->json([
                'success' => false,
                'message' => 'Email ou mot de passe incorrect.'
            ], 401);
        }

        // 5. VÉRIFICATION DU COMPTE VERROUILLÉ
        if (method_exists($user, 'isLocked') && $user->isLocked()) {
            $remainingMinutes = now()->diffInMinutes($user->locked_until);
            return response()->json([
                'success' => false,
                'message' => "Compte verrouillé. Réessayez dans {$remainingMinutes} minutes.",
                'locked_until' => $user->locked_until
            ], 403);
        }

        // 6. VÉRIFICATION DU MOT DE PASSE
        if (!Hash::check($request->password, $user->password)) {
            if (method_exists($user, 'incrementFailedLoginAttempts')) {
                $user->incrementFailedLoginAttempts();
            }
            RateLimiter::hit($key, 3600);

            Log::warning('Tentative de connexion échouée', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'attempts' => $user->failed_login_attempts ?? 0
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Email ou mot de passe incorrect.',
                'attempts_remaining' => 5 - ($user->failed_login_attempts ?? 0)
            ], 401);
        }

        // 7. CONNEXION RÉUSSIE
        if (method_exists($user, 'resetFailedLoginAttempts')) {
            $user->resetFailedLoginAttempts();
        }
        $user->last_login = now();
        $user->save();

        // 8. MISE À JOUR DU STREAK
        $this->updateStreak($user);

        // 9. CRÉATION DU TOKEN
        $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;

        // 10. LOG
        Log::info('Connexion réussie', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role ?? 'student',
            'ip' => $request->ip()
        ]);

        // 11. RÉINITIALISER LE RATE LIMITING
        RateLimiter::clear($key);

        // 12. RÉPONSE
        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie !',
            'user' => $this->formatUserData($user),
            'token' => $token,
            'role' => $user->role ?? 'student', // 👈 AJOUT CRUCIAL
            'requires_verification' => !$user->isVerified()
        ]);
    }

    /**
     * Verify user email
     */
    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token de vérification invalide.'
            ], 404);
        }

        if ($user->isVerified()) {
            return response()->json([
                'success' => false,
                'message' => 'Email déjà vérifié.'
            ], 400);
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        Log::info('Email vérifié avec succès', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Email vérifié avec succès !'
        ]);
    }

    /**
     * Resend verification email
     */
    public function resendVerification(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé.'
            ], 404);
        }

        if ($user->isVerified()) {
            return response()->json([
                'success' => false,
                'message' => 'Email déjà vérifié.'
            ], 400);
        }

        // Rate limiting pour l'envoi d'email
        $key = 'resend_verification:' . $user->id;
        if (Cache::has($key)) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez attendre 5 minutes avant de renvoyer un email.'
            ], 429);
        }

        $user->email_verification_token = (string) Str::uuid();
        $user->save();

        $this->sendVerificationEmail($user);
        Cache::put($key, true, 300); // 5 minutes

        return response()->json([
            'success' => true,
            'message' => 'Email de vérification renvoyé avec succès.'
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if ($user) {
                // Supprimer le token actuel
                $request->user()->currentAccessToken()->delete();

                Log::info('Déconnexion réussie', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la déconnexion', [
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie'
        ]);
    }

    /**
     * Get current user
     */
    public function me(Request $request)
    {
        $user = $request->user();
        $user->load('section');

        return response()->json([
            'success' => true,
            'user' => [
                'id'          => $user->id,
                'uuid'        => $user->uuid,
                'name'        => $user->name,
                'email'       => $user->email,
                'level'       => $user->level ?? 1,
                'total_xp'    => $user->total_xp ?? 0,
                'streak_days' => $user->streak_days ?? 0,
                'school'      => $user->school,
                'grade'       => $user->grade,
                'governorate' => $user->governorate,
                'age'         => $user->age,
                'avatar_config' => $user->avatar_config,
                'is_verified' => $user->isVerified(),
                // 👇 NOUVEAU
                'role'        => $user->role ?? 'student',
                'is_admin'    => ($user->role ?? 'student') === 'admin',
                'section'     => $user->section ? [
                    'id'         => $user->section->id,
                    'code'       => $user->section->code,
                    'name'       => $user->section->name,
                    'short_name' => $user->section->short_name,
                    'color'      => $user->section->color,
                ] : null,
            ],
        ]);
    }

    /**
     * Check if email exists
     */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $exists = User::where('email', strtolower(trim($request->email)))->exists();
        return response()->json([
            'exists' => $exists,
            'available' => !$exists
        ]);
    }

    /**
     * PRIVATE METHODS
     */

    /**
     * Sanitize input string
     */
    private function sanitizeInput(string $input): string
    {
        $input = strip_tags($input);
        $input = preg_replace('/\s+/', ' ', $input);
        $input = preg_replace('/[^\p{L}\p{N}\s\-]/u', '', $input);
        return trim($input);
    }

    /**
     * Check if email is from temporary email service
     */
    private function isTemporaryEmail(string $email): bool
    {
        $temporaryDomains = [
            'tempmail.com', 'temp-mail.org', '10minutemail.com',
            'guerrillamail.com', 'mailinator.com', 'yopmail.com',
            'throwawayemail.com', 'trashmail.com', 'fake-mail.net',
            'spambox.us', 'dispostable.com', 'getnada.com',
            'mailnator.com', 'tempail.com', 'tempmail.net',
            'maildrop.cc', 'mytemp.email', 'inboxkitten.com',
            'sharklasers.com', 'guerrillamail.info'
        ];

        $domain = substr(strrchr($email, "@"), 1);
        return in_array(strtolower($domain), $temporaryDomains);
    }

    /**
     * Send verification email
     */
    private function sendVerificationEmail(User $user): void
    {
        try {
            Mail::send('emails.verify-email', [
                'user' => $user,
                'token' => $user->email_verification_token,
                'frontend_url' => env('FRONTEND_URL', 'http://localhost:5173')
            ], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Vérifiez votre adresse email - Presentily');
            });
        } catch (\Exception $e) {
            Log::error('Erreur envoi email vérification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update user streak
     */
    private function updateStreak(User $user): void
    {
        try {
            $today = now()->toDateString();

            if ($user->last_activity_date) {
                $lastActivity = $user->last_activity_date->toDateString();

                if ($lastActivity === $today) {
                    return;
                }

                $yesterday = now()->subDay()->toDateString();
                if ($lastActivity === $yesterday) {
                    $user->streak_days += 1;
                } else {
                    $user->streak_days = 1;
                }
            } else {
                $user->streak_days = 1;
            }

            $user->last_activity_date = now();
            $user->save();
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour streak', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Format user data for response
     */
    private function formatUserData(User $user): array
    {
        return [
            'id' => $user->id,
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
            'school' => $user->school,
            'grade' => $user->grade,
            'governorate' => $user->governorate,
            'age' => $user->age,
            'total_xp' => $user->total_xp ?? 0,
            'level' => $user->level ?? 1,
            'streak_days' => $user->streak_days ?? 0,
            'is_premium' => $user->is_premium ?? false,
            'subscription_type' => $user->subscription_type,
            'avatar_config' => $user->avatar_config,
            'is_verified' => $user->isVerified(),
            // 👇 NOUVEAU
            'role' => $user->role ?? 'student',
            'is_admin' => ($user->role ?? 'student') === 'admin',
            'created_at' => $user->created_at,
        ];
    }
}