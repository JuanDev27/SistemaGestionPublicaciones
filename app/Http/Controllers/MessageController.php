<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
        $validated = $request->validate([
            'contenido' => ['required', 'string', 'max:1000'],
        ]);

        $conversation->load('publication');

        if (!$conversation->includesUser((int) Auth::id())) {
            abort(403, 'No tienes permiso para enviar mensajes en esta conversación.');
        }

        if ($conversation->estado !== 'ACTIVA') {
            throw ValidationException::withMessages([
                'conversation' => 'Esta conversación está disponible solo para lectura.',
            ]);
        }

        $message = DB::transaction(function () use ($conversation, $validated) {
            $message = $conversation->messages()->create([
                'remitente_id' => Auth::id(),
                'contenido' => $validated['contenido'],
            ]);

            $recipientId = (int) $conversation->publication->usuario_id === (int) Auth::id()
                ? (int) $conversation->iniciador_id
                : (int) $conversation->publication->usuario_id;

            $message->notification()->create([
                'usuario_id' => $recipientId,
                'leida' => false,
            ]);

            return $message->load('sender');
        });

        return response()->json([
            'message' => 'Mensaje enviado.',
            'data' => $message,
        ], 201);
    }
}
