<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Liste des messages de l'utilisateur connecté
     */
    public function index(Request $request)
    {
        $query = Message::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Filtre par type (avis / reclamation)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $messages = $query->get();

        // Statistiques
        $stats = [
            'total'        => Message::where('user_id', Auth::id())->count(),
            'en_attente'   => Message::where('user_id', Auth::id())->where('status', 'en_attente')->count(),
            'en_cours'     => Message::where('user_id', Auth::id())->where('status', 'en_cours')->count(),
            'resolu'       => Message::where('user_id', Auth::id())->where('status', 'resolu')->count(),
        ];

        return response()->json([
            'success'  => true,
            'messages' => $messages,
            'stats'    => $stats,
        ]);
    }

    /**
     * Créer un nouveau message (avis ou réclamation)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'    => 'required|in:avis,reclamation',
            'subject' => 'required|string|max:255',
            'content' => 'required|string|min:10|max:2000',
        ], [
            'type.required'    => 'Le type de message est obligatoire.',
            'type.in'          => 'Le type doit être "avis" ou "reclamation".',
            'subject.required' => 'Le sujet est obligatoire.',
            'subject.max'      => 'Le sujet ne doit pas dépasser 255 caractères.',
            'content.required' => 'Le contenu est obligatoire.',
            'content.min'      => 'Le contenu doit contenir au moins 10 caractères.',
            'content.max'      => 'Le contenu ne doit pas dépasser 2000 caractères.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $message = Message::create([
            'user_id' => Auth::id(),
            'type'    => $request->type,
            'subject' => $request->subject,
            'content' => $request->content,
            'status'  => 'en_attente',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Votre message a été envoyé avec succès.',
            'data'    => $message,
        ], 201);
    }

    /**
     * Afficher un message spécifique
     */
    public function show($id)
    {
        $message = Message::where('user_id', Auth::id())->find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message introuvable.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $message,
        ]);
    }

    /**
     * Supprimer un message (uniquement si en attente)
     */
    public function destroy($id)
    {
        $message = Message::where('user_id', Auth::id())->find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message introuvable.',
            ], 404);
        }

        if ($message->status !== 'en_attente') {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez supprimer qu\'un message en attente.',
            ], 403);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message supprimé avec succès.',
        ]);
    }
}