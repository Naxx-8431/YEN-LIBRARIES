<!-- ═══════════════ AI CHAT BOX (YEN-Bot) ════════════════ -->
<button class="chat-fab" onclick="toggleChat()" aria-label="Open Chat">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
  </svg>
</button>
<div class="chat-window" id="chatWindow">
  <div class="chat-header">
    <div style="display:flex;align-items:center;gap:12px;">
      <span class="chat-avatar">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
          <path
            d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5M3 8.062C3 6.76 4.235 5.765 5.53 5.889a28.047 28.047 0 0 1 4.94 0C11.765 5.765 13 6.76 13 8.062v1.157a.933.933 0 0 1-.765.935c-.845.147-2.34.346-4.235.346-1.895 0-3.39-.2-4.235-.346A.933.933 0 0 1 3 9.219zm4.542-.827a.25.25 0 0 0-.217.068l-.92.9a24.767 24.767 0 0 1-1.871-.183.25.25 0 0 0-.068.495c.55.076 1.232.149 2.02.193a.25.25 0 0 0 .189-.071l.754-.736.847 1.71a.25.25 0 0 0 .404.062l.932-.97a25.286 25.286 0 0 0 1.922-.188.25.25 0 0 0-.068-.495c-.538.074-1.207.145-1.98.189a.25.25 0 0 0-.166.076l-.754.785-.842-1.7a.25.25 0 0 0-.182-.135M8.5 1.866a1 1 0 1 0-1 0V3h-2A4.5 4.5 0 0 0 1 7.5V8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v-.5A4.5 4.5 0 0 0 10.5 3h-2V1.866M14 7.5V13a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7.5A3.5 3.5 0 0 1 5.5 4h5A3.5 3.5 0 0 1 14 7.5" />
        </svg>
      </span>
      <div style="line-height:1.2;">
        <strong>YEN-Bot</strong><br>
        <span style="font-size:11px; opacity:0.8; display:flex; align-items:center; gap:4px;">
          <span style="display:inline-block;width:6px;height:6px;background:#4ade80;border-radius:50%;"></span> Online
        </span>
      </div>
    </div>
    <button class="chat-close" onclick="toggleChat()" aria-label="Close Chat">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 6L6 18M6 6l12 12" />
      </svg>
    </button>
  </div>
  <div class="chat-body" id="chatBody">
    <div class="chat-msg bot">Hello! I'm YEN-Bot, your virtual library assistant. I can help you find books, OPAC
      links, or remote access details. What do you need today?</div>
  </div>
  <form class="chat-footer" id="chatForm">
    <input type="text" id="chatInput" placeholder="Type your message..." autocomplete="off">
    <button type="submit" id="chatSendBtn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="22" y1="2" x2="11" y2="13" />
        <polygon points="22 2 15 22 11 13 2 9 22 2" />
      </svg>
    </button>
  </form>
</div>

<script>
/* ── Toggle Chat ── */
function toggleChat() {
  var win = document.getElementById('chatWindow');
  if (win) {
    win.classList.toggle('open');
    if (win.classList.contains('open')) {
      var inp = document.getElementById('chatInput');
      if (inp) setTimeout(function() { inp.focus(); }, 300);
    }
  }
}

/* ── YEN-Bot Chat Engine ── */
(function() {
  var chatBody = document.getElementById('chatBody');
  var chatForm = document.getElementById('chatForm');
  var chatInput = document.getElementById('chatInput');
  var chatSendBtn = document.getElementById('chatSendBtn');
  if (!chatForm || !chatBody) return;

  function appendMessage(text, sender) {
    var msg = document.createElement('div');
    msg.className = 'chat-msg ' + sender;
    var formatted = text
      .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
      .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" style="color:#6366f1;text-decoration:underline;">$1</a>')
      .replace(/\n/g, '<br>')
      .replace(/• /g, '&bull; ');
    msg.innerHTML = formatted;
    chatBody.appendChild(msg);
    chatBody.scrollTop = chatBody.scrollHeight;
    return msg;
  }

  function showTyping() {
    var typing = document.createElement('div');
    typing.className = 'chat-msg bot chat-typing';
    typing.innerHTML = '<span class="dot"></span><span class="dot"></span><span class="dot"></span>';
    typing.id = 'typingIndicator';
    chatBody.appendChild(typing);
    chatBody.scrollTop = chatBody.scrollHeight;
  }

  function hideTyping() {
    var typing = document.getElementById('typingIndicator');
    if (typing) typing.remove();
  }

  chatForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    var message = chatInput.value.trim();
    if (!message) return;

    appendMessage(message, 'user');
    chatInput.value = '';
    chatSendBtn.disabled = true;
    chatInput.disabled = true;
    showTyping();

    try {
      var response = await fetch('api/chatbot.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: message })
      });
      var data = await response.json();
      hideTyping();
      if (data.error) {
        appendMessage('Sorry, something went wrong. Please try again.', 'bot');
      } else {
        appendMessage(data.reply, 'bot');
      }
    } catch (error) {
      hideTyping();
      appendMessage("I'm having trouble connecting. Please check your internet and try again.", 'bot');
    }

    chatSendBtn.disabled = false;
    chatInput.disabled = false;
    chatInput.focus();
  });
})();
</script>
