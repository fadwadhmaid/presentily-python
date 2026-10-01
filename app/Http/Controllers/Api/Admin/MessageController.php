<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Liste de tous les messages (avec filtres)
     */
    public function index(Request $request)
    {
        $query = Message::with('user:id,name,email,school,grade')
            ->orderBy('created_at', 'desc');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $messages = $query->paginate(20);

        $stats = [
            'total'      => Message::count(),
            'en_attente' => Message::where('status', 'en_attente')->count(),
            'en_cours'   => Message::where('status', 'en_cours')->count(),
            'resolu'     => Message::where('status', 'resolu')->count(),
            'avis'       => Message::where('type', 'avis')->count(),
            'reclamation' => Message::where('type', 'reclamation')->count(),
        ];

        return response()->json([
            'success'  => true,
            'messages' => $messages,
            'stats'    => $stats,
        ]);
    }

    /**
     * Détail d'un message
     */
    public function show($id)
    {
        $message = Message::with('user')->find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message introuvable.',
            ], 404);
        }

        return response()->json(['success' => true, 'data' => $message]);
    }

    /**
     * Répondre à un message
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|min:5|max:2000',
            'status'      => 'nullable|in:en_attente,en_cours,resolu,ferme',
        ]);

        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message introuvable.',
            ], 404);
        }

        $message->update([
            'admin_reply' => $request->admin_reply,
            'replied_by'  => Auth::id(),
            'replied_at'  => now(),
            'status'      => $request->status ?? 'resolu',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Réponse envoyée avec succès.',
            'data'    => $message->fresh('user'),
        ]);
    }

    /**
     * Changer le statut
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:en_attente,en_cours,resolu,ferme',
        ]);

        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message introuvable.',
            ], 404);
        }

        $message->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour.',
            'data'    => $message,
        ]);
    }

    /**
     * Supprimer un message
     */
    public function destroy($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message introuvable.',
            ], 404);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message supprimé.',
        ]);
    }
}