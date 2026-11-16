<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ConversationController extends Controller
{
    public function index()
    {
        $userId = (int) Auth::id();

        $conversations = Conversation::query()
            ->with(['publication.user', 'initiator', 'messages.sender'])
            ->whereHas('publication', function ($query) use ($userId) {
                $query->where('usuario_id', $userId);
            })
            ->orWhere('iniciador_id', $userId)
            ->latest('fecha_creacion')
            ->get();

        return response()->json([
            'data' => $conversations,
        ]);
    }

    public function show(Conversation $conversation)
    {
        $conversation->load([
            'publication.user',
            'initiator',
            'messages.sender',
        ]);

        $this->authorizeParticipant($conversation);

        return response()->json([
            'data' => $conversation,
        ]);
    }

    public function store(Request $request, Publicacion $publication)
    {
        $validated = $request->validate([
            'contenido' => ['required', 'string', 'max:1000'],
        ]);

        if ((int) $publication->usuario_id === (int) Auth::id()) {
            throw ValidationException::withMessages([
                'conversation' => 'No puedes iniciar una conversación con tu propia publicación.',
            ]);
        }

        $conversation = DB::transaction(function () use ($validated, $publication) {
            $conversation = Conversation::firstOrCreate(
                [
                    'publicacion_id' => $publication->id,
                    'iniciador_id' => Auth::id(),
                ],
                ['estado' => 'ACTIVA']
            );

            if ($conversation->estado !== 'ACTIVA') {
                throw ValidationException::withMessages([
                    'conversation' => 'Esta conversación está disponible solo para lectura.',
                ]);
            }

            $message = $conversation->messages()->create([
                'remitente_id' => Auth::id(),
                'contenido' => $validated['contenido'],
            ]);

            $this->createRecipientNotification($conversation, $message);

            return $conversation->load([
                'publication.user',
                'initiator',
                'messages.sender',
            ]);
        });

        return response()->json([
            'message' => 'Conversación creada y mensaje enviado.',
            'data' => $conversation,
        ], 201);
    }

    private function authorizeParticipant(Conversation $conversation): void
    {
        if (!$conversation->loadMissing('publication')->includesUser((int) Auth::id())) {
            abort(403, 'No tienes permiso para consultar esta conversación.');
        }
    }

    private function createRecipientNotification(Conversation $conversation, Message $message): void
    {
        $recipientId = (int) $conversation->publication->usuario_id === (int) Auth::id()
            ? (int) $conversation->iniciador_id
            : (int) $conversation->publication->usuario_id;

        $message->notification()->create([
            'usuario_id' => $recipientId,
            'leida' => false,
        ]);
    }
}
