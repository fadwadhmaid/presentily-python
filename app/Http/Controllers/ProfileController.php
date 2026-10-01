<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Récupérer le profil de l'utilisateur
     */
    public function show()
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Mettre à jour le profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:100',
            'school' => 'sometimes|string|max:150',
            'grade' => 'sometimes|in:1ere,2eme,3eme,4eme,Bac',
            'governorate' => 'sometimes|string|max:50',
            'avatar_config' => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update($request->only([
            'name', 'school', 'grade', 'governorate', 'avatar_config'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Profil mis à jour avec succès',
            'user' => $user
        ]);
    }

    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Vérifier l'ancien mot de passe
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mot de passe actuel incorrect'
            ], 401);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Mot de passe mis à jour avec succès'
        ]);
    }

    /**
     * Mettre à jour l'avatar
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'avatar_config' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->avatar_config = $request->avatar_config;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Avatar mis à jour avec succès',
            'avatar_config' => $user->avatar_config
        ]);
    }

    /**
     * Statistiques de l'utilisateur
     */
    public function stats()
    {
        $user = Auth::user();
        
        $nextLevelXp = ($user->level) * 500;
        $progress = ($user->total_xp % 500) / 500 * 100;
        
        return response()->json([
            'success' => true,
            'stats' => [
                'total_xp' => $user->total_xp,
                'level' => $user->level,
                'next_level_xp' => $nextLevelXp,
                'progress_to_next_level' => round($progress, 2),
                'streak_days' => $user->streak_days,
                'completed_lessons' => $user->completed_lessons,
                'completed_exercises' => $user->completed_exercises,
                'badges' => $user->badges ?? [],
                'is_premium' => $user->is_premium,
                'subscription_type' => $user->subscription_type,
            ]
        ]);
    }
}