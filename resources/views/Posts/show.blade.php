<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contactar usuario | CampusFinder</title>
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>

<body class="contact-page" data-publication-id="{{ $post->id }}" data-current-user-id="{{ Auth::id() }}">
    <header class="site-header">
        <a href="{{ route('posts.index') }}" class="brand" aria-label="Volver a publicaciones">
            <span class="brand-mark">C</span>
            <span>
                <strong>CAMPUSFINDER</strong>
                <small>Objetos perdidos</small>
            </span>
        </a>
        <div class="user-summary">
            <span>Sesión iniciada</span>
            <span class="user-avatar">{{ strtoupper(substr(Auth::user()->nombres ?? 'U', 0, 1)) }}</span>
        </div>
    </header>

    <main class="contact-shell">
        <div class="page-heading">
            <a href="{{ route('posts.index') }}" class="back-link" aria-label="Volver a publicaciones">&larr;</a>
            <div>
                <p class="eyebrow">Ficha del objeto</p>
                <h1>Contactar usuario</h1>
            </div>
        </div>

        <div class="conversation-meta">
            <span class="meta-code">HU-13</span>
            <span>Contactar usuario</span>
            <span class="meta-separator">&bull;</span>
            <span>Inicio de conversación para coordinación de entrega</span>
            <span class="secure-badge">Chat institucional seguro</span>
        </div>

        <div class="contact-grid">
            <article class="publication-card">
                <div class="publication-image">
                    @if ($post->imagen)
                        <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen de {{ $post->titulo }}">
                    @else
                        <span class="image-placeholder">Sin imagen disponible</span>
                    @endif
                    <span class="status-label">{{ $post->tipo === 'PERDIDO' ? 'OBJETO PERDIDO' : 'ENCONTRADO' }}</span>
                    <span class="image-caption">Imagen del objeto</span>
                </div>
                <div class="publication-content">
                    <p class="section-label">Publicación</p>
                    <h2>{{ $post->titulo }}</h2>
                    <p class="publication-description">{{ $post->descripcion }}</p>

                    <div class="publication-details">
                        <div>
                            <span class="detail-label">Lugar reportado</span>
                            <strong>{{ $post->lugar ?? $post->lugar_detalle ?? 'No especificado' }}</strong>
                        </div>
                        <div>
                            <span class="detail-label">Publicado por</span>
                            <strong>{{ trim(($post->user->nombres ?? '') . ' ' . ($post->user->apellidos ?? '')) ?: ($post->user->name ?? 'Usuario') }}</strong>
                        </div>
                    </div>
                </div>
            </article>

            <section class="message-card" aria-labelledby="message-title">
                <div class="recipient">
                    <span class="recipient-avatar">{{ strtoupper(substr($post->user->nombres ?? 'U', 0, 1)) }}</span>
                    <div>
                        <h2 id="message-title">Enviar mensaje al publicador</h2>
                        <p>Coordina la entrega directamente con la persona que publicó este objeto.</p>
                    </div>
                </div>

                <button type="button" class="conversation-link" id="open-conversation">
                    <span aria-hidden="true">&#128172;</span>
                    Consultar conversación existente
                    <span aria-hidden="true">&rarr;</span>
                </button>

                <div class="divider"></div>

                <p class="section-label">Mensajes rápidos sugeridos</p>
                <div class="quick-messages" aria-label="Mensajes sugeridos">
                    <button type="button" class="quick-message">¿Es el código de ubicación?</button>
                    <button type="button" class="quick-message">¿Dónde podemos coordinar?</button>
                </div>

                <form id="contact-form" class="message-form">
                    <label for="message">Tu mensaje a {{ $post->user->nombres ?? 'este usuario' }}:</label>
                    <textarea id="message" name="message" maxlength="500" required>¡Hola! Creo que este objeto podría ser mío. ¿Podemos coordinar la entrega? Muchas gracias.</textarea>
                    <p class="privacy-note"><span aria-hidden="true">&#10003;</span> Esta conversación se vinculará a la publicación y estará protegida por el entorno institucional.</p>
                    <button type="submit" class="send-button">
                        <span aria-hidden="true">&#9655;</span>
                        Enviar mensaje al autor
                    </button>
                    <p id="form-feedback" class="form-feedback" role="status" hidden></p>
                </form>
            </section>
        </div>
    </main>

    <div class="conversation-modal" id="conversation-modal" hidden>
        <div class="conversation-backdrop" data-close-conversation></div>
        <section class="conversation-window" role="dialog" aria-modal="true" aria-labelledby="conversation-title">
            <header class="conversation-header">
                <div class="conversation-person">
                    <span class="recipient-avatar">{{ strtoupper(substr($post->user->nombres ?? 'U', 0, 1)) }}</span>
                    <div>
                        <p class="eyebrow">Conversación activa</p>
                        <h2 id="conversation-title">{{ trim(($post->user->nombres ?? '') . ' ' . ($post->user->apellidos ?? '')) ?: 'Publicador' }}</h2>
                    </div>
                </div>
                <button type="button" class="close-conversation" aria-label="Cerrar conversación" data-close-conversation>&times;</button>
            </header>

            <div class="conversation-publication">
                <div class="conversation-thumbnail">
                    @if ($post->imagen)
                        <img src="{{ asset('storage/' . $post->imagen) }}" alt="">
                    @else
                        <span>img</span>
                    @endif
                </div>
                <div>
                    <span class="detail-label">Publicación vinculada</span>
                    <strong>{{ $post->titulo }}</strong>
                    <small>La conversación permanece asociada a esta publicación.</small>
                </div>
                <span class="active-status"><i></i> Activa</span>
            </div>

            <div class="conversation-history" id="conversation-history" aria-live="polite">
                <p class="conversation-placeholder">Cargando conversación...</p>
            </div>

            <form class="conversation-composer" id="conversation-form">
                <label class="sr-only" for="conversation-message">Escribe un mensaje</label>
                <span class="composer-clip" aria-hidden="true">&#128206;</span>
                <input id="conversation-message" type="text" maxlength="500" placeholder="Escribe un mensaje institucional..." autocomplete="off">
                <button type="submit" aria-label="Enviar mensaje">&#9655;</button>
            </form>
        </section>
    </div>

    <script>
        const form = document.getElementById('contact-form');
        const message = document.getElementById('message');
        const feedback = document.getElementById('form-feedback');
        const modal = document.getElementById('conversation-modal');
        const history = document.getElementById('conversation-history');
        const conversationForm = document.getElementById('conversation-form');
        const conversationInput = document.getElementById('conversation-message');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const publicationId = document.body.dataset.publicationId;
        const currentUserId = Number(document.body.dataset.currentUserId);
        const currentUserName = @json(trim((Auth::user()->nombres ?? '') . ' ' . (Auth::user()->apellidos ?? '')) ?: 'Tú');
        const conversationLink = document.getElementById('open-conversation');
        let currentConversation = null;

        const requestOptions = (method, body = null) => ({
            method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: body ? JSON.stringify(body) : undefined
        });

        const formatMessageDate = (dateValue) => {
            const date = new Date(dateValue);
            return Number.isNaN(date.getTime())
                ? 'Fecha no disponible'
                : date.toLocaleString('es-CO', {
                    day: '2-digit',
                    month: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
        };

        const addMessage = (messageItem) => {
            const outgoing = Number(messageItem.remitente_id) === currentUserId;
            const article = document.createElement('article');
            article.className = `chat-message ${outgoing ? 'outgoing' : 'incoming'}`;

            const author = document.createElement('div');
            author.className = 'message-author';
            author.textContent = outgoing
                ? currentUserName
                : [messageItem.sender?.nombres, messageItem.sender?.apellidos]
                    .filter(Boolean)
                    .join(' ') || 'Usuario';
            article.appendChild(author);

            const content = document.createElement('p');
            content.textContent = messageItem.contenido;
            article.appendChild(content);

            const sentAt = document.createElement('time');
            sentAt.textContent = `${formatMessageDate(messageItem.fecha_envio)}${outgoing ? ' • Enviado' : ''}`;
            article.appendChild(sentAt);
            history.appendChild(article);
        };

        const renderConversation = (conversation) => {
            currentConversation = conversation;
            history.replaceChildren();

            if (!conversation.messages?.length) {
                const emptyState = document.createElement('p');
                emptyState.className = 'conversation-placeholder';
                emptyState.textContent = 'Aún no hay mensajes en esta conversación.';
                history.appendChild(emptyState);
            } else {
                conversation.messages.forEach(addMessage);
            }

            const isReadOnly = conversation.estado !== 'ACTIVA';
            conversationInput.disabled = isReadOnly;
            conversationForm.querySelector('button').disabled = isReadOnly;
            conversationInput.placeholder = isReadOnly
                ? 'Esta conversación está disponible solo para lectura.'
                : 'Escribe un mensaje institucional...';
            history.scrollTop = history.scrollHeight;
        };

        const showConversationError = (errorMessage) => {
            history.replaceChildren();
            const error = document.createElement('p');
            error.className = 'conversation-placeholder conversation-error';
            error.textContent = errorMessage;
            history.appendChild(error);
        };

        const loadConversation = async () => {
            history.replaceChildren();
            const loading = document.createElement('p');
            loading.className = 'conversation-placeholder';
            loading.textContent = 'Cargando conversación...';
            history.appendChild(loading);

            try {
                const response = await fetch("{{ route('conversations.index') }}", requestOptions('GET'));
                if (!response.ok) {
                    throw new Error('No fue posible consultar las conversaciones.');
                }

                const result = await response.json();
                const conversation = result.data.find((item) => Number(item.publicacion_id) === Number(publicationId));

                if (!conversation) {
                    showConversationError('Todavía no existe una conversación para esta publicación.');
                    return;
                }

                renderConversation(conversation);
            } catch (error) {
                showConversationError(error.message);
            }
        };

        document.querySelectorAll('.quick-message').forEach((button) => {
            button.addEventListener('click', () => {
                message.value = button.textContent.trim();
                message.focus();
            });
        });

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const content = message.value.trim();
            if (!content) {
                message.focus();
                return;
            }

            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            feedback.hidden = true;

            fetch("{{ route('conversations.store', ['publication' => $post->id]) }}", requestOptions('POST', { contenido: content }))
                .then(async (response) => {
                    const result = await response.json();
                    if (!response.ok) {
                        throw new Error(result.message || 'No fue posible enviar el mensaje.');
                    }
                    return result;
                })
                .then((result) => {
                    feedback.hidden = false;
                    feedback.textContent = 'Mensaje enviado correctamente.';
                    feedback.classList.add('is-visible');
                    message.value = '';
                    renderConversation(result.data);
                    modal.hidden = false;
                    document.body.classList.add('modal-open');
                    conversationInput.focus();
                })
                .catch((error) => {
                    feedback.hidden = false;
                    feedback.textContent = error.message;
                    feedback.classList.add('is-visible');
                })
                .finally(() => {
                    submitButton.disabled = false;
                });
        });

        conversationLink.addEventListener('click', async () => {
            modal.hidden = false;
            document.body.classList.add('modal-open');
            await loadConversation();
            conversationInput.focus();
        });

        document.querySelectorAll('[data-close-conversation]').forEach((control) => {
            control.addEventListener('click', () => {
                modal.hidden = true;
                document.body.classList.remove('modal-open');
            });
        });

        conversationForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const text = conversationInput.value.trim();

            if (!text || !currentConversation || currentConversation.estado !== 'ACTIVA') {
                conversationInput.focus();
                return;
            }

            const sendButton = conversationForm.querySelector('button');
            sendButton.disabled = true;

            fetch(`/conversations/${currentConversation.id}/messages`, requestOptions('POST', { contenido: text }))
                .then(async (response) => {
                    const result = await response.json();
                    if (!response.ok) {
                        throw new Error(result.message || 'No fue posible enviar el mensaje.');
                    }
                    return result;
                })
                .then((result) => {
                    addMessage(result.data);
                    currentConversation.messages.push(result.data);
                    conversationInput.value = '';
                    history.scrollTop = history.scrollHeight;
                })
                .catch((error) => {
                    showConversationError(error.message);
                })
                .finally(() => {
                    sendButton.disabled = false;
                });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !modal.hidden) {
                modal.hidden = true;
                document.body.classList.remove('modal-open');
            }
        });
    </script>
</body>

</html>
