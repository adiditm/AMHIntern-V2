<!-- Chat AI Widget -->
<style>
  #ai-chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  #ai-chat-button {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: #007bff;
    color: white;
    text-align: center;
    line-height: 60px;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    transition: transform 0.3s;
  }
  #ai-chat-button:hover {
    transform: scale(1.1);
  }
  #ai-chat-box {
    display: none;
    width: 350px;
    height: 500px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    position: absolute;
    bottom: 75px;
    right: 0;
    flex-direction: column;
    overflow: hidden;
  }
  #ai-chat-header {
    background-color: #007bff;
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
    background-color: #f8f9fa;
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
  }
  .ai-message.user {
    background-color: #007bff;
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 0;
  }
  .ai-message.bot {
    background-color: #e9ecef;
    color: #333;
    align-self: flex-start;
    border-bottom-left-radius: 0;
  }
  #ai-chat-input-area {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ddd;
    background-color: white;
  }
  #ai-chat-input {
    flex-grow: 1;
    border: 1px solid #ccc;
    border-radius: 20px;
    padding: 10px 15px;
    outline: none;
  }
  #ai-chat-send {
    background-color: transparent;
    border: none;
    color: #007bff;
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
    background-color: #888;
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
</style>

<div id="ai-chat-widget">
  <div id="ai-chat-box">
    <div id="ai-chat-header">
      <span>AMH Assistant</span>
      <span id="ai-chat-header-close">&times;</span>
    </div>
    <div id="ai-chat-messages">
      <div class="ai-message bot">Halo! Saya asisten virtual AMH Techno. Ada yang bisa saya bantu terkait sistem kami?</div>
    </div>
    <div id="ai-chat-input-area">
      <input type="text" id="ai-chat-input" placeholder="Tulis pesan..." autocomplete="off" />
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

  let chatHistory = [];

  btn.addEventListener('click', () => {
    box.style.display = box.style.display === 'flex' ? 'none' : 'flex';
    if(box.style.display === 'flex') input.focus();
  });

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
  input.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') sendMessage();
  });
});
</script>
