<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    /**
     * Classement général
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 50);
        
        $rankings = User::orderBy('total_xp', 'desc')
            ->limit($limit)
            ->get(['id', 'uuid', 'name', 'school', 'governorate', 'total_xp', 'level']);
        
        // Ajouter le rang
        $rankings->each(function ($user, $index) {
            $user->rank = $index + 1;
        });

        return response()->json([
            'success' => true,
            'rankings' => $rankings
        ]);
    }

    /**
     * Classement par gouvernorat
     */
    public function byGovernorate(Request $request)
    {
        $governorate = $request->input('governorate');
        
        if (!$governorate) {
            return response()->json([
                'success' => false,
                'message' => 'Le gouvernorat est requis'
            ], 422);
        }

        $rankings = User::where('governorate', $governorate)
            ->orderBy('total_xp', 'desc')
            ->limit(50)
            ->get(['id', 'uuid', 'name', 'school', 'total_xp', 'level']);

        return response()->json([
            'success' => true,
            'governorate' => $governorate,
            'rankings' => $rankings
        ]);
    }

    /**
     * Classement par école
     */
    public function bySchool(Request $request)
    {
        $school = $request->input('school');
        
        if (!$school) {
            return response()->json([
                'success' => false,
                'message' => "Le nom de l'école est requis"
            ], 422);
        }

        $rankings = User::where('school', 'LIKE', "%{$school}%")
            ->orderBy('total_xp', 'desc')
            ->limit(50)
            ->get(['id', 'uuid', 'name', 'governorate', 'total_xp', 'level']);

        return response()->json([
            'success' => true,
            'school' => $school,
            'rankings' => $rankings
        ]);
    }

    /**
     * Top 10 des écoles par XP total
     */
    public function topSchools()
    {
        $topSchools = User::select('school', 'governorate')
            ->selectRaw('SUM(total_xp) as total_xp')
            ->selectRaw('COUNT(*) as student_count')
            ->groupBy('school', 'governorate')
            ->orderBy('total_xp', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'top_schools' => $topSchools
        ]);
    }

    /**
     * Mon rang
     */
    public function myRank()
    {
        $user = Auth::user();
        
        // Compter les utilisateurs avec plus de XP
        $rank = User::where('total_xp', '>', $user->total_xp)->count() + 1;

        return response()->json([
            'success' => true,
            'rank' => $rank,
            'total_users' => User::count(),
            'user' => [
                'name' => $user->name,
                'school' => $user->school,
                'total_xp' => $user->total_xp,
                'level' => $user->level,
            ]
        ]);
    }

    /**
     * Classement en direct (dernières 24h)
     */
    public function live()
    {
        // Récupérer les utilisateurs avec activité dans les 24h
        $rankings = User::where('last_activity_date', '>=', now()->subDay())
            ->orderBy('total_xp', 'desc')
            ->limit(20)
            ->get(['id', 'uuid', 'name', 'school', 'governorate', 'total_xp', 'level', 'last_activity_date']);

        return response()->json([
            'success' => true,
            'rankings' => $rankings
        ]);
    }
}