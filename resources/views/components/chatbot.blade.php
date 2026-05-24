
<style>
    /*  Botón flotante  */
    .cb-fab {
        position: fixed; bottom: 28px; right: 28px; z-index: 999;
        width: 56px; height: 56px; border-radius: 50%;
        background: #973100; color: #fff;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 24px rgba(151,49,0,0.35);
        border: none; cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .cb-fab:hover { transform: scale(1.08); box-shadow: 0 8px 28px rgba(151,49,0,0.45); }
    .cb-fab .material-symbols-outlined { font-size: 26px; font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24; }

    /* Ventana del chat  */
    .cb-window {
        position: fixed;
        bottom: 96px;
        right: 28px;
        z-index: 998;
        width: 360px;
        max-height: calc(100vh - 96px - 16px);
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 12px 48px rgba(61,31,13,0.18);
        display: flex; flex-direction: column;
        overflow: hidden;
        transform: scale(0.85) translateY(20px);
        transform-origin: bottom right;
        opacity: 0; pointer-events: none;
        transition: transform 0.25s cubic-bezier(.32,.72,0,1), opacity 0.2s;
    }
    .cb-window.open {
        transform: scale(1) translateY(0);
        opacity: 1; pointer-events: all;
    }

    /* Header */
    .cb-header {
        background: linear-gradient(135deg, #3d1f0d, #973100);
        padding: 16px 18px;
        display: flex; align-items: center; gap: 10px;
        flex-shrink: 0;
    }
    .cb-header-icon {
        width: 36px; height: 36px; border-radius: 50%;
        background: rgba(254,203,198,0.2);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .cb-header-icon .material-symbols-outlined { font-size: 20px; color: #fecbc6; font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24; }
    .cb-header-name { font-family: 'Playfair Display', serif; font-size: 15px; font-weight: 700; color: #fff; }
    .cb-header-sub  { font-size: 11px; color: rgba(255,255,255,0.6); margin-top: 1px; }
    .cb-close-btn {
        margin-left: auto; background: none; border: none;
        color: rgba(255,255,255,0.7); cursor: pointer; font-size: 20px; line-height: 1;
    }
    .cb-close-btn:hover { color: #fff; }

    /* Mensajes */
    .cb-messages {
        flex: 1; overflow-y: auto; padding: 16px;
        display: flex; flex-direction: column; gap: 10px;
        background: #fdf8f4;
    }
    .cb-messages::-webkit-scrollbar { width: 4px; }
    .cb-messages::-webkit-scrollbar-thumb { background: #e8ddd8; border-radius: 9999px; }

    .cb-msg {
        max-width: 85%; border-radius: 14px;
        padding: 10px 13px; font-size: 13px; line-height: 1.55;
        font-family: 'DM Sans', sans-serif;
        animation: cbPop 0.2s ease both;
    }
    @keyframes cbPop {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Bot (izquierda) */
    .cb-msg.bot {
        background: #fff;
        border: 1px solid #e8ddd8;
        color: #1e1210;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }
    /* Usuario (derecha) */
    .cb-msg.user {
        background: #973100;
        color: #fff;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }

    /* Typing indicator */
    .cb-typing {
        display: flex; align-items: center; gap: 4px;
        padding: 10px 13px;
        background: #fff; border: 1px solid #e8ddd8;
        border-radius: 14px; border-bottom-left-radius: 4px;
        align-self: flex-start; width: fit-content;
    }
    .cb-typing span {
        width: 7px; height: 7px; border-radius: 50%;
        background: #9e7a72; display: inline-block;
        animation: cbDot 1.2s ease infinite;
    }
    .cb-typing span:nth-child(2) { animation-delay: 0.2s; }
    .cb-typing span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes cbDot {
        0%, 80%, 100% { transform: scale(0.7); opacity: 0.4; }
        40%            { transform: scale(1);   opacity: 1;   }
    }

    /* Input */
    .cb-input-wrap {
        padding: 12px 14px;
        border-top: 1px solid #f0e8e4;
        display: flex; gap: 8px; align-items: center;
        background: #fff; flex-shrink: 0;
    }
    .cb-input {
        flex: 1; border: 1.5px solid #e8ddd8; border-radius: 10px;
        padding: 9px 12px; font-size: 13px; color: #1e1210;
        font-family: 'DM Sans', sans-serif; outline: none;
        transition: border-color 0.2s;
        resize: none; max-height: 80px; overflow-y: auto;
    }
    .cb-input:focus { border-color: #973100; }
    .cb-send {
        width: 36px; height: 36px; border-radius: 10px;
        background: #973100; color: #fff;
        border: none; cursor: pointer; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        transition: opacity 0.2s;
    }
    .cb-send:hover   { opacity: 0.85; }
    .cb-send:disabled { opacity: 0.4; cursor: not-allowed; }
    .cb-send .material-symbols-outlined { font-size: 18px; font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24; }

    @media (max-width: 480px) {
        .cb-fab    { right: 16px; bottom: 16px; }
        .cb-window {
            width: calc(100vw - 32px);
            right: 16px;
            bottom: 80px;
            max-height: calc(100vh - 80px - 16px);
        }
    }
</style>

{{-- Botón flotante --}}
<button class="cb-fab" id="cb-fab" onclick="toggleChat()" title="Asistente Amoretti">
    <span class="material-symbols-outlined" id="cb-fab-icon">chat</span>
</button>

{{-- Ventana del chat --}}
<div class="cb-window" id="cb-window">
    <div class="cb-header">
        <div class="cb-header-icon">
            <span class="material-symbols-outlined">cake</span>
        </div>
        <div>
            <div class="cb-header-name">Asistente Amoretti</div>
            <div class="cb-header-sub">Te ayudo a elegir tu pastel</div>
        </div>
        <button class="cb-close-btn" onclick="toggleChat()">×</button>
    </div>

    <div class="cb-messages" id="cb-messages">
        {{-- Mensaje de bienvenida --}}
        <div class="cb-msg bot">
            ¡Hola! 🎂 Soy el asistente de <strong>Amoretti</strong>.<br><br>
            Cuéntame sobre tu celebración y te recomendaré el pastel perfecto. Por ejemplo:<br>
            <em>"Voy a hacer una fiesta de cumpleaños para 15 personas..."</em>
        </div>
    </div>

    <div class="cb-input-wrap">
        <textarea class="cb-input" id="cb-input" placeholder="Describe tu evento..."
                  rows="1" onkeydown="handleKey(event)" oninput="autoResize(this)"></textarea>
        <button class="cb-send" id="cb-send" onclick="enviarMensaje()">
            <span class="material-symbols-outlined">send</span>
        </button>
    </div>
</div>

<script>
    const CHATBOT_URL = @json(route('client.chatbot.responder'));
    let chatAbierto = false;
    function toggleChat() {
        chatAbierto = !chatAbierto;
        document.getElementById('cb-window').classList.toggle('open', chatAbierto);
        document.getElementById('cb-fab-icon').textContent = chatAbierto ? 'close' : 'chat';
        if (chatAbierto) {
            setTimeout(() => document.getElementById('cb-input').focus(), 300);
        }
    }

    function handleKey(e) {
        // Enter sin Shift: enviar
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            enviarMensaje();
        }
    }

    function autoResize(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 80) + 'px';
    }

    function agregarMensaje(texto, rol) {
        const cont = document.getElementById('cb-messages');
        const div = document.createElement('div');
        div.className = `cb-msg ${rol}`;
        // Permitir saltos de línea del bot
        div.innerHTML = rol === 'bot'
            ? texto.replace(/\n/g, '<br>')
            : escapeHtml(texto);
        cont.appendChild(div);
        cont.scrollTop = cont.scrollHeight;
        return div;
    }

    function mostrarTyping() {
        const cont = document.getElementById('cb-messages');
        const div = document.createElement('div');
        div.className = 'cb-typing';
        div.id = 'cb-typing';
        div.innerHTML = '<span></span><span></span><span></span>';
        cont.appendChild(div);
        cont.scrollTop = cont.scrollHeight;
    }

    function quitarTyping() {
        document.getElementById('cb-typing')?.remove();
    }

    function escapeHtml(text) {
        return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    async function enviarMensaje() {
        const input  = document.getElementById('cb-input');
        const sendBtn = document.getElementById('cb-send');
        const texto  = input.value.trim();
        if (!texto) return;

        // Mostrar mensaje del usuario
        agregarMensaje(texto, 'user');
        input.value = '';
        input.style.height = 'auto';
        sendBtn.disabled = true;

        // Indicador de escritura
        mostrarTyping();

        try {
            const res = await fetch(CHATBOT_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ mensaje: texto }),
            });

            quitarTyping();

            if (!res.ok) throw new Error('Error de red');

            const data = await res.json();
            agregarMensaje(data.respuesta, 'bot');

        } catch (err) {
            quitarTyping();
            agregarMensaje('Ocurrió un error. Por favor intenta de nuevo.', 'bot');
        } finally {
            sendBtn.disabled = false;
            input.focus();
        }
    }
</script>