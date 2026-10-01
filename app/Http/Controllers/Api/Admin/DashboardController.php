<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;                  

class DashboardController extends Controller
{
    public function stats()
    {
        $totalUsers    = User::where('role', 'student')->count();
        $totalAdmins   = User::where('role', 'admin')->count();
        $totalMessages = Message::count();
        $pendingMsgs   = Message::where('status', 'en_attente')->count();
        $resolvedMsgs  = Message::where('status', 'resolu')->count();

        // Nouveaux utilisateurs des 30 derniers jours
        $newUsersThisMonth = User::where('role', 'student')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Répartition par établissement (top 5)
        $topSchools = User::where('role', 'student')
            ->whereNotNull('school')
            ->select('school', DB::raw('count(*) as total'))
            ->groupBy('school')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Messages par jour (7 derniers jours)
        $messagesPerDay = Message::where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'success' => true,
            'stats' => [
                'total_users'         => $totalUsers,
                'total_admins'        => $totalAdmins,
                'total_messages'      => $totalMessages,
                'pending_messages'    => $pendingMsgs,
                'resolved_messages'   => $resolvedMsgs,
                'new_users_this_month' => $newUsersThisMonth,
            ],
            'top_schools'      => $topSchools,
            'messages_per_day' => $messagesPerDay,
        ]);
    }

    /**
     * Liste des utilisateurs (pour gestion admin)
     */
    public function users(Request $request)
    {
        $query = User::where('role', 'student')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('school', 'like', "%{$s}%");
            });
        }

        return response()->json([
            'success' => true,
            'users'   => $query->paginate(20),
        ]);
    }
}