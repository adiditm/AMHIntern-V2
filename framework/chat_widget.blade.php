<!-- Chat AI Widget -->
<?php
// classes/ai_doc_processor.php isn't guaranteed to already be included on
// every page this widget appears on (it's normally only needed by
// main/api_chat.php) -- include_once here makes this file self-contained
// regardless of where it's dropped in.
include_once __DIR__ . '/../classes/ai_doc_processor.php';
$ai_chat_role_name = ai_chat_role_display_name();
$ai_chat_greeting = $ai_chat_role_name !== null
    ? "Assalamu'alaikum warahmatullahi wabarakatuh! Saya asisten virtual AMH Techno. Anda login sebagai {$ai_chat_role_name}. Ada yang bisa saya bantu terkait sistem kami?"
    : "Assalamu'alaikum warahmatullahi wabarakatuh! Saya asisten virtual AMH Techno. Ada yang bisa saya bantu terkait sistem kami?";
?>
<style>
  /* Originally kept off the site's gold/amber (reserved for real CTAs, to
     avoid this launcher reading as an action button) in favor of a softer
     sky-blue -- explicitly overridden per direct request to make this
     button gold/amber like the rest of the site's accents. */
  #ai-chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: var(--amh-font, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif);
  }
  #ai-chat-button {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--amh-amber-gradient, linear-gradient(135deg, #fde68a 0%, #f59e0b 100%));
    color: #1e293b;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(245,158,11,0.45);
    transition: transform 0.3s;
    /* flexbox centers the Font Awesome icon precisely -- the previous
       line-height-based centering left it sitting slightly above middle
       (a Font Awesome glyph-metrics quirk, pre-existing, just more
       noticeable once the button became a solid gold fill). */
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #ai-chat-button:hover {
    transform: scale(1.1);
  }
  #ai-chat-box {
    display: none;
    width: 350px;
    height: 500px;
    background: #0f172a;
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.45);
    position: absolute;
    bottom: 75px;
    right: 0;
    flex-direction: column;
    overflow: hidden;
  }
  /* Vertical-only resize (drag the top edge up/down). Width stays fixed --
     deliberately not a horizontal resize per direct request. */
  #ai-chat-resize-handle {
    height: 8px;
    flex-shrink: 0;
    cursor: ns-resize;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.03);
  }
  #ai-chat-resize-handle::before {
    content: '';
    width: 36px;
    height: 3px;
    border-radius: 2px;
    background: rgba(255,255,255,0.25);
  }
  #ai-chat-resize-handle:hover::before,
  #ai-chat-resize-handle.amh-dragging::before {
    background: rgba(251,191,36,0.6);
  }
  #ai-chat-header {
    background: linear-gradient(135deg, #38bdf8 0%, #0369a1 100%);
    color: white;
    padding: 15px;
    font-size: 16px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  #ai-chat-header-close {
    cursor: pointer;
    font-size: 20px;
  }
  #ai-chat-messages {
    flex-grow: 1;
    padding: 15px;
    overflow-y: auto;
    background: #0b1220;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .ai-message {
    max-width: 80%;
    padding: 10px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.4;
    /* Without this, a long unbroken string (a URL, an error message with no
       spaces to wrap at) pushes past max-width instead of wrapping --
       caught live via a Gemini quota-error message containing a long URL. */
    overflow-wrap: break-word;
    word-wrap: break-word;
    word-break: break-word;
  }
  .ai-message.user {
    background: linear-gradient(135deg, #38bdf8 0%, #0369a1 100%);
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 0;
  }
  .ai-message.bot {
    background: rgba(255,255,255,0.08);
    color: #e2e8f0;
    align-self: flex-start;
    border-bottom-left-radius: 0;
  }
  #ai-chat-input-area {
    display: flex;
    padding: 10px;
    border-top: 1px solid rgba(255,255,255,0.12);
    background: #0f172a;
  }
  #ai-chat-input {
    flex-grow: 1;
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 16px;
    padding: 10px 15px;
    outline: none;
    background: rgba(15,23,42,0.6);
    color: #e2e8f0;
    font-family: inherit;
    font-size: 14px;
    resize: none;
    max-height: 120px;
    overflow-y: auto;
    line-height: 1.4;
  }
  #ai-chat-input::placeholder {
    color: #cbd5e1;
  }
  #ai-chat-send {
    background-color: transparent;
    border: none;
    color: #38bdf8;
    font-size: 20px;
    cursor: pointer;
    padding: 0 10px;
    margin-left: 5px;
  }
  .ai-typing {
    display: flex;
    align-items: center;
    gap: 4px;
    height: 20px;
  }
  .ai-typing span {
    width: 6px;
    height: 6px;
    background-color: #94a3b8;
    border-radius: 50%;
    animation: typing 1.4s infinite both;
  }
  .ai-typing span:nth-child(1) { animation-delay: 0s; }
  .ai-typing span:nth-child(2) { animation-delay: 0.2s; }
  .ai-typing span:nth-child(3) { animation-delay: 0.4s; }
  @keyframes typing {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
  }
  /* Mobile: shrink so it doesn't crowd a phone screen, keep clear of the
     Lobibox notification stack this project already reserves screen
     edges for. */
  @media (max-width: 480px) {
    #ai-chat-widget {
      bottom: 12px;
      right: 12px;
    }
    #ai-chat-button {
      width: 50px;
      height: 50px;
      font-size: 20px;
    }
    #ai-chat-box {
      width: calc(100vw - 24px);
      max-width: 350px;
      height: 65vh;
      max-height: 500px;
      bottom: 62px;
      right: 0;
    }
    /* Drag-to-resize is a desktop-mouse interaction (matches this project's
       existing sidebar-resizer, also mouse-only/desktop-hidden); mobile
       keeps the fixed height above instead. */
    #ai-chat-resize-handle {
      display: none;
    }
  }
</style>

<div id="ai-chat-widget">
  <div id="ai-chat-box">
    <div id="ai-chat-resize-handle"></div>
    <div id="ai-chat-header">
      <span>AMH Assistant</span>
      <span id="ai-chat-header-close">&times;</span>
    </div>
    <div id="ai-chat-messages">
      <div class="ai-message bot"><?=htmlspecialchars($ai_chat_greeting)?></div>
    </div>
    <div id="ai-chat-input-area">
      <textarea id="ai-chat-input" rows="1" placeholder="Tulis pesan..." title="Shift+Enter untuk baris baru" autocomplete="off"></textarea>
      <button id="ai-chat-send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </div>
  </div>
  <div id="ai-chat-button">
    <i class="fa fa-comments" aria-hidden="true"></i>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const btn = document.getElementById('ai-chat-button');
  const box = document.getElementById('ai-chat-box');
  const closeBtn = document.getElementById('ai-chat-header-close');
  const input = document.getElementById('ai-chat-input');
  const sendBtn = document.getElementById('ai-chat-send');
  const messagesDiv = document.getElementById('ai-chat-messages');
  const resizeHandle = document.getElementById('ai-chat-resize-handle');

  let chatHistory = [];

  // Restore a previously-dragged height (vertical-only resize, see below),
  // clamped to the current viewport in case the window shrank since it was saved.
  try {
    const savedHeight = parseInt(localStorage.getItem('amhChatHeight'), 10);
    if (savedHeight) {
      box.style.height = Math.min(savedHeight, window.innerHeight - 100) + 'px';
    }
  } catch (e) {}

  btn.addEventListener('click', () => {
    box.style.display = box.style.display === 'flex' ? 'none' : 'flex';
    if(box.style.display === 'flex') input.focus();
  });

  // Vertical-only resize: drag the handle at the top of the box. The box is
  // anchored with `bottom: 75px`, so increasing height naturally extends
  // upward (top edge moves up) -- exactly "resize atas bawah" with no
  // horizontal resize at all (width is never touched here).
  (function() {
    let resizing = false;
    let startY = 0;
    let startHeight = 0;
    const MIN_HEIGHT = 320;
    const MAX_HEIGHT = 800;

    resizeHandle.addEventListener('mousedown', function(e) {
      resizing = true;
      startY = e.clientY;
      startHeight = box.getBoundingClientRect().height;
      resizeHandle.classList.add('amh-dragging');
      document.body.style.userSelect = 'none';
      e.preventDefault();
    });
    document.addEventListener('mousemove', function(e) {
      if (!resizing) return;
      const delta = startY - e.clientY; // dragging up (smaller clientY) grows the box
      const maxAllowed = Math.min(MAX_HEIGHT, window.innerHeight - 100);
      const newHeight = Math.min(maxAllowed, Math.max(MIN_HEIGHT, startHeight + delta));
      box.style.height = newHeight + 'px';
    });
    document.addEventListener('mouseup', function() {
      if (!resizing) return;
      resizing = false;
      resizeHandle.classList.remove('amh-dragging');
      document.body.style.userSelect = '';
      try {
        localStorage.setItem('amhChatHeight', box.style.height);
      } catch (e) {}
    });
  })();

  // Auto-grow the textarea as the user types, capped by its own CSS
  // max-height (overflow scrolls beyond that).
  function autoGrowInput() {
    input.style.height = 'auto';
    input.style.height = input.scrollHeight + 'px';
  }
  input.addEventListener('input', autoGrowInput);

  closeBtn.addEventListener('click', () => {
    box.style.display = 'none';
  });

  function addMessage(text, sender) {
    const msg = document.createElement('div');
    msg.classList.add('ai-message', sender);
    msg.innerHTML = text.replace(/\n/g, '<br>');
    messagesDiv.appendChild(msg);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
  }

  function addTypingIndicator() {
    const msg = document.createElement('div');
    msg.classList.add('ai-message', 'bot', 'typing-indicator');
    msg.innerHTML = '<div class="ai-typing"><span></span><span></span><span></span></div>';
    messagesDiv.appendChild(msg);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
    return msg;
  }

  async function sendMessage() {
    const text = input.value.trim();
    if (!text) return;

    input.value = '';
    autoGrowInput(); // collapse back to one row after sending
    addMessage(text, 'user');
    chatHistory.push({"role": "user", "parts": [{"text": text}]});

    const indicator = addTypingIndicator();

    try {
      const response = await fetch('../main/api_chat.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ messages: chatHistory })
      });
      
      const data = await response.json();
      indicator.remove();

      if (data.status === 'success') {
        const botText = data.message;
        addMessage(botText, 'bot');
        chatHistory.push({"role": "model", "parts": [{"text": botText}]});
      } else {
        addMessage('Maaf, sistem AI sedang gangguan: ' + data.message, 'bot');
      }
    } catch (err) {
      indicator.remove();
      addMessage('Maaf, terjadi kesalahan koneksi server.', 'bot');
      console.error(err);
    }
  }

  sendBtn.addEventListener('click', sendMessage);
  // Enter sends the message; Shift+Enter inserts a newline instead (needs
  // keydown, not keypress, to reliably read e.shiftKey and to preventDefault
  // before the textarea inserts its own newline).
  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });
});
</script>
