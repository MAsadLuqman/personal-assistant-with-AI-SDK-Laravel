<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Text Chat - AI Assistant</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white">
    <div class="flex flex-col h-full max-w-2xl mx-auto">

        {{-- Header --}}
        <header class="flex items-center gap-3 px-6 py-4 border-b border-slate-700/50">
            <a href="/" class="w-10 h-10 rounded-full bg-slate-700/50 border border-slate-600/50 flex items-center justify-center hover:bg-slate-700 transition-colors">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Text Chat</h1>
                <p class="text-xs text-slate-400">Type to chat with your AI assistant</p>
            </div>
        </header>

        {{-- Chat Messages --}}
        <div id="chat-messages" class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
            <div class="flex justify-center">
                <div class="text-sm text-slate-500 bg-slate-800/50 rounded-full px-4 py-2">
                    Type a message below to start chatting
                </div>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="border-t border-slate-700/50 px-4 py-4">
            <div class="flex items-end gap-2">
                <div class="flex-1">
                    <textarea
                        id="message-input"
                        rows="1"
                        class="w-full resize-none rounded-2xl bg-slate-700/50 border border-slate-600/50 px-4 py-3 text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all"
                        placeholder="Type your message..."
                        maxlength="5000"
                    ></textarea>
                </div>
                <button
                    id="send-btn"
                    class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center hover:bg-blue-500 transition-all disabled:opacity-40 disabled:cursor-not-allowed shadow-lg"
                    disabled
                >
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                    </svg>
                </button>
            </div>
            <p class="text-center text-xs text-slate-500 mt-2">
                Press <kbd class="px-1.5 py-0.5 bg-slate-700/50 rounded text-slate-400 text-[10px]">Enter</kbd> to send &bull;
                <kbd class="px-1.5 py-0.5 bg-slate-700/50 rounded text-slate-400 text-[10px]">Shift+Enter</kbd> for new line
            </p>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatMessages = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-btn');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        let conversationHistory = [];
        let isProcessing = false;

        // Auto-resize textarea
        messageInput.addEventListener('input', () => {
            messageInput.style.height = 'auto';
            messageInput.style.height = Math.min(messageInput.scrollHeight, 120) + 'px';
            sendBtn.disabled = !messageInput.value.trim();
        });

        // Enter to send
        messageInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (messageInput.value.trim()) sendMessage();
            }
        });

        sendBtn.addEventListener('click', () => {
            if (messageInput.value.trim()) sendMessage();
        });

        function addMessage(role, content) {
            const welcome = chatMessages.querySelector('.justify-center');
            if (welcome) welcome.remove();

            const wrapper = document.createElement('div');
            wrapper.className = `flex ${role === 'user' ? 'justify-end' : 'justify-start'}`;

            const bubble = document.createElement('div');
            if (role === 'user') {
                bubble.className = 'max-w-[80%] rounded-2xl rounded-br-md px-4 py-2.5 text-sm bg-blue-600 text-white whitespace-pre-wrap';
            } else {
                bubble.className = 'max-w-[80%] rounded-2xl rounded-bl-md px-4 py-2.5 text-sm bg-slate-700/70 text-slate-100 whitespace-pre-wrap';
            }
            bubble.textContent = content;

            wrapper.appendChild(bubble);
            chatMessages.appendChild(wrapper);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return bubble;
        }

        function addThinking() {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex justify-start';
            wrapper.id = 'thinking';
            wrapper.innerHTML = `
                <div class="rounded-2xl rounded-bl-md px-4 py-3 bg-slate-700/70 flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                    <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                    <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                </div>`;
            chatMessages.appendChild(wrapper);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function removeThinking() {
            const el = document.getElementById('thinking');
            if (el) el.remove();
        }

        async function sendMessage() {
            const message = messageInput.value.trim();
            if (!message || isProcessing) return;

            isProcessing = true;
            messageInput.value = '';
            messageInput.style.height = 'auto';
            sendBtn.disabled = true;

            addMessage('user', message);
            conversationHistory.push({ role: 'user', content: message });
            addThinking();

            try {
                const res = await fetch('/assistant/stream', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'text/event-stream',
                    },
                    body: JSON.stringify({
                        message: message,
                        history: conversationHistory.slice(0, -1),
                    }),
                });

                removeThinking();
                if (!res.ok) throw new Error('Request failed');

                // Create empty bubble and stream text into it
                const bubble = addMessage('assistant', '');
                let fullText = '';

                const reader = res.body.getReader();
                const decoder = new TextDecoder();
                let buffer = '';

                while (true) {
                    const { done, value } = await reader.read();
                    if (done) break;

                    buffer += decoder.decode(value, { stream: true });
                    const lines = buffer.split('\n');
                    buffer = lines.pop();

                    for (const line of lines) {
                        if (!line.startsWith('data: ')) continue;
                        const payload = line.substring(6).trim();
                        if (payload === '[DONE]') continue;

                        try {
                            const event = JSON.parse(payload);
                            if (event.type === 'text_delta') {
                                fullText += event.delta;
                                bubble.textContent = fullText;
                                chatMessages.scrollTop = chatMessages.scrollHeight;
                            }
                        } catch (e) {}
                    }
                }

                conversationHistory.push({ role: 'assistant', content: fullText });
            } catch (err) {
                removeThinking();
                addMessage('assistant', 'Sorry, something went wrong. Please try again.');
                console.error(err);
            } finally {
                isProcessing = false;
            }
        }
    });
    </script>
</body>
</html>
