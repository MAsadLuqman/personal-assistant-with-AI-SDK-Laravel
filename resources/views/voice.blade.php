<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shera - AI Assistant</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes ripple {
            0% { transform: scale(1); opacity: 0.4; }
            100% { transform: scale(2.5); opacity: 0; }
        }
        .ripple-ring {
            animation: ripple 1.5s ease-out infinite;
        }
        .ripple-ring:nth-child(2) { animation-delay: 0.5s; }
        .ripple-ring:nth-child(3) { animation-delay: 1s; }

        @keyframes waveform {
            0%, 100% { height: 8px; }
            50% { height: 32px; }
        }
        .wave-bar {
            animation: waveform 0.8s ease-in-out infinite;
        }
        @keyframes thinkingPulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }
        .thinking-dot {
            animation: thinkingPulse 1.2s ease-in-out infinite;
        }
        .thinking-dot:nth-child(2) { animation-delay: 0.2s; }
        .thinking-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes idlePulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.4); }
            50% { box-shadow: 0 0 0 20px rgba(139, 92, 246, 0); }
        }
        .idle-pulse {
            animation: idlePulse 2.5s ease-in-out infinite;
        }
    </style>
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
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-pink-500 flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Shera</h1>
                <p class="text-xs text-slate-400">Say "Hey Shera" to start</p>
            </div>
        </header>

        {{-- Conversation Log --}}
        <div id="conversation-log" class="flex-1 overflow-y-auto px-6 py-4 space-y-3">
            <div class="flex justify-center">
                <div class="text-sm text-slate-500 bg-slate-800/50 rounded-full px-4 py-2">
                    Say "Hey Shera" to start talking
                </div>
            </div>
        </div>

        {{-- Voice Controls --}}
        <div class="border-t border-slate-700/50 px-6 py-8">

            {{-- Status Text --}}
            <p id="status-text" class="text-center text-sm text-slate-400 mb-6">Starting...</p>

            {{-- Waveform (visible when recording) --}}
            <div id="waveform" class="hidden flex items-center justify-center gap-1 mb-6 h-10">
                <div class="wave-bar w-1 bg-violet-400 rounded-full" style="animation-delay: 0.0s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-violet-400 rounded-full" style="animation-delay: 0.1s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-violet-400 rounded-full" style="animation-delay: 0.2s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-violet-400 rounded-full" style="animation-delay: 0.3s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-violet-400 rounded-full" style="animation-delay: 0.4s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-pink-400 rounded-full" style="animation-delay: 0.5s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-pink-400 rounded-full" style="animation-delay: 0.6s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-pink-400 rounded-full" style="animation-delay: 0.7s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-pink-400 rounded-full" style="animation-delay: 0.8s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-pink-400 rounded-full" style="animation-delay: 0.9s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-violet-400 rounded-full" style="animation-delay: 1.0s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-violet-400 rounded-full" style="animation-delay: 1.1s; height: 8px;"></div>
                <div class="wave-bar w-1 bg-violet-400 rounded-full" style="animation-delay: 1.2s; height: 8px;"></div>
            </div>

            {{-- Mic Button --}}
            <div class="flex justify-center">
                <div class="relative">
                    {{-- Ripple rings (shown when recording) --}}
                    <div id="ripple-1" class="hidden ripple-ring absolute inset-0 rounded-full border-2 border-violet-500/30"></div>
                    <div id="ripple-2" class="hidden ripple-ring absolute inset-0 rounded-full border-2 border-violet-500/30"></div>
                    <div id="ripple-3" class="hidden ripple-ring absolute inset-0 rounded-full border-2 border-violet-500/30"></div>

                    <button
                        id="mic-btn"
                        class="relative z-10 w-20 h-20 rounded-full bg-gradient-to-br from-violet-500 to-pink-500 flex items-center justify-center shadow-2xl shadow-violet-500/30 hover:shadow-violet-500/50 hover:scale-105 active:scale-95 transition-all"
                    >
                        <svg id="mic-icon" class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/>
                        </svg>
                        <svg id="stop-icon" class="hidden w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="6" y="6" width="12" height="12" rx="2"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Stop Speaking Button --}}
            <div class="flex justify-center mt-4">
                <button id="stop-speaking-btn" class="hidden text-sm text-slate-400 hover:text-white border border-slate-600/50 rounded-full px-4 py-1.5 hover:border-slate-500 transition-all">
                    Stop speaking
                </button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const conversationLog = document.getElementById('conversation-log');
        const statusText = document.getElementById('status-text');
        const waveform = document.getElementById('waveform');
        const micBtn = document.getElementById('mic-btn');
        const micIcon = document.getElementById('mic-icon');
        const stopIcon = document.getElementById('stop-icon');
        const ripple1 = document.getElementById('ripple-1');
        const ripple2 = document.getElementById('ripple-2');
        const ripple3 = document.getElementById('ripple-3');
        const stopSpeakingBtn = document.getElementById('stop-speaking-btn');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        const WAKE_WORD = 'hey shera';

        let conversationHistory = [];
        let mediaRecorder = null;
        let audioChunks = [];
        let isRecording = false;
        let isProcessing = false;
        let currentAudio = null;
        let audioContext = null;
        let analyser = null;
        let silenceCheckInterval = null;
        let recognition = null;
        let isListeningForWakeWord = false;

        // ── Wake Word Detection using Web Speech API ──
        function startWakeWordListening() {
            if (isProcessing || isRecording) return;

            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                statusText.textContent = 'Speech recognition not supported. Use the mic button.';
                return;
            }

            recognition = new SpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;
            recognition.lang = 'en-US';

            recognition.onresult = (event) => {
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    const transcript = event.results[i][0].transcript.toLowerCase().trim();
                    if (transcript.includes('hey shera') || transcript.includes('hey shira') || transcript.includes('hey sheera') || transcript.includes('a shera') || transcript.includes('hey sera')) {
                        // Wake word detected!
                        stopWakeWordListening();
                        playActivationChime();
                        startRecording();
                        return;
                    }
                }
            };

            recognition.onerror = (event) => {
                console.log('Speech recognition error:', event.error);
                if (event.error === 'not-allowed') {
                    statusText.textContent = 'Microphone access denied. Please allow it.';
                    return;
                }
                // Restart on other errors
                if (isListeningForWakeWord) {
                    setTimeout(() => startWakeWordListening(), 500);
                }
            };

            recognition.onend = () => {
                // Auto-restart if we should still be listening
                if (isListeningForWakeWord && !isRecording && !isProcessing) {
                    try {
                        recognition.start();
                    } catch (e) {
                        setTimeout(() => startWakeWordListening(), 500);
                    }
                }
            };

            try {
                recognition.start();
                isListeningForWakeWord = true;
                statusText.textContent = 'Listening for "Hey Shera"...';
                micBtn.classList.add('idle-pulse');
            } catch (e) {
                console.error('Failed to start speech recognition:', e);
                statusText.textContent = 'Could not start listening. Use the mic button.';
            }
        }

        function stopWakeWordListening() {
            isListeningForWakeWord = false;
            micBtn.classList.remove('idle-pulse');
            if (recognition) {
                try {
                    recognition.stop();
                } catch (e) {}
                recognition = null;
            }
        }

        // ── Activation Chime ──
        function playActivationChime() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.frequency.setValueAtTime(880, ctx.currentTime);
                osc.frequency.setValueAtTime(1100, ctx.currentTime + 0.1);
                gain.gain.setValueAtTime(0.3, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);

                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.3);

                setTimeout(() => ctx.close(), 500);
            } catch (e) {}
        }

        // ── Manual mic button (fallback) ──
        micBtn.addEventListener('click', () => {
            if (isProcessing) return;
            if (isRecording) {
                stopRecording();
            } else {
                stopWakeWordListening();
                startRecording();
            }
        });

        stopSpeakingBtn.addEventListener('click', () => {
            if (currentAudio) {
                currentAudio.pause();
                currentAudio = null;
            }
            stopSpeakingBtn.classList.add('hidden');
            returnToIdle();
        });

        function returnToIdle() {
            startWakeWordListening();
        }

        // ── UI Helpers ──
        function addLogEntry(role, text) {
            const welcome = conversationLog.querySelector('.justify-center');
            if (welcome) welcome.remove();

            const wrapper = document.createElement('div');
            wrapper.className = `flex ${role === 'user' ? 'justify-end' : 'justify-start'}`;

            const bubble = document.createElement('div');
            if (role === 'user') {
                bubble.className = 'max-w-[80%] rounded-2xl rounded-br-md px-4 py-2.5 text-sm bg-violet-600/80 text-white';
            } else {
                bubble.className = 'max-w-[80%] rounded-2xl rounded-bl-md px-4 py-2.5 text-sm bg-slate-700/70 text-slate-100';
            }

            const label = document.createElement('div');
            label.className = 'text-[10px] uppercase tracking-wider mb-1 ' + (role === 'user' ? 'text-violet-300' : 'text-slate-400');
            label.textContent = role === 'user' ? 'You said' : 'Shera';

            bubble.appendChild(label);
            const textEl = document.createElement('div');
            textEl.className = 'whitespace-pre-wrap';
            textEl.textContent = text;
            bubble.appendChild(textEl);

            wrapper.appendChild(bubble);
            conversationLog.appendChild(wrapper);
            conversationLog.scrollTop = conversationLog.scrollHeight;
        }

        function addThinking() {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex justify-start';
            wrapper.id = 'thinking-bubble';

            const bubble = document.createElement('div');
            bubble.className = 'rounded-2xl rounded-bl-md px-4 py-3 bg-slate-700/70 flex items-center gap-2';

            const label = document.createElement('div');
            label.className = 'text-[10px] uppercase tracking-wider text-slate-400 mr-1';
            label.textContent = 'Shera is thinking';

            const dot1 = document.createElement('span');
            dot1.className = 'thinking-dot w-2 h-2 bg-violet-400 rounded-full inline-block';
            const dot2 = document.createElement('span');
            dot2.className = 'thinking-dot w-2 h-2 bg-violet-400 rounded-full inline-block';
            const dot3 = document.createElement('span');
            dot3.className = 'thinking-dot w-2 h-2 bg-violet-400 rounded-full inline-block';

            bubble.appendChild(label);
            bubble.appendChild(dot1);
            bubble.appendChild(dot2);
            bubble.appendChild(dot3);
            wrapper.appendChild(bubble);
            conversationLog.appendChild(wrapper);
            conversationLog.scrollTop = conversationLog.scrollHeight;
        }

        function removeThinking() {
            const el = document.getElementById('thinking-bubble');
            if (el) el.remove();
        }

        function addStreamingEntry() {
            const welcome = conversationLog.querySelector('.justify-center');
            if (welcome) welcome.remove();

            const wrapper = document.createElement('div');
            wrapper.className = 'flex justify-start';

            const bubble = document.createElement('div');
            bubble.className = 'max-w-[80%] rounded-2xl rounded-bl-md px-4 py-2.5 text-sm bg-slate-700/70 text-slate-100';

            const label = document.createElement('div');
            label.className = 'text-[10px] uppercase tracking-wider mb-1 text-slate-400';
            label.textContent = 'Shera';

            const textEl = document.createElement('div');
            textEl.className = 'whitespace-pre-wrap';
            textEl.textContent = '';

            bubble.appendChild(label);
            bubble.appendChild(textEl);
            wrapper.appendChild(bubble);
            conversationLog.appendChild(wrapper);
            conversationLog.scrollTop = conversationLog.scrollHeight;

            return textEl;
        }

        function updateStreamingEntry(textEl, text) {
            textEl.textContent = text;
            conversationLog.scrollTop = conversationLog.scrollHeight;
        }

        function setRecordingUI(on) {
            if (on) {
                micIcon.classList.add('hidden');
                stopIcon.classList.remove('hidden');
                micBtn.classList.add('from-red-500', 'to-red-600');
                micBtn.classList.remove('from-violet-500', 'to-pink-500');
                waveform.classList.remove('hidden');
                ripple1.classList.remove('hidden');
                ripple2.classList.remove('hidden');
                ripple3.classList.remove('hidden');
                statusText.textContent = "I'm listening...";
            } else {
                micIcon.classList.remove('hidden');
                stopIcon.classList.add('hidden');
                micBtn.classList.remove('from-red-500', 'to-red-600');
                micBtn.classList.add('from-violet-500', 'to-pink-500');
                waveform.classList.add('hidden');
                ripple1.classList.add('hidden');
                ripple2.classList.add('hidden');
                ripple3.classList.add('hidden');
            }
        }

        // ── Silence Detection ──
        function startSilenceDetection(stream) {
            audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const source = audioContext.createMediaStreamSource(stream);
            analyser = audioContext.createAnalyser();
            analyser.fftSize = 2048;
            source.connect(analyser);

            const bufferLength = analyser.fftSize;
            const dataArray = new Uint8Array(bufferLength);
            let lastSoundTime = Date.now();

            silenceCheckInterval = setInterval(() => {
                analyser.getByteTimeDomainData(dataArray);

                let maxDeviation = 0;
                for (let i = 0; i < bufferLength; i++) {
                    const deviation = Math.abs(dataArray[i] - 128);
                    if (deviation > maxDeviation) maxDeviation = deviation;
                }

                if (maxDeviation > 5) {
                    lastSoundTime = Date.now();
                }

                if (Date.now() - lastSoundTime > 2000 && isRecording) {
                    stopRecording();
                }
            }, 100);
        }

        function stopSilenceDetection() {
            if (silenceCheckInterval) {
                clearInterval(silenceCheckInterval);
                silenceCheckInterval = null;
            }
            if (audioContext) {
                audioContext.close();
                audioContext = null;
            }
            analyser = null;
        }

        // ── Recording ──
        async function startRecording() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream, { mimeType: 'audio/webm' });
                audioChunks = [];

                mediaRecorder.ondataavailable = (e) => {
                    if (e.data.size > 0) audioChunks.push(e.data);
                };

                mediaRecorder.onstop = async () => {
                    stream.getTracks().forEach(t => t.stop());
                    stopSilenceDetection();
                    const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    await processVoice(audioBlob);
                };

                mediaRecorder.start();
                isRecording = true;
                setRecordingUI(true);
                startSilenceDetection(stream);
            } catch (err) {
                console.error('Microphone denied:', err);
                statusText.textContent = 'Microphone access denied. Please allow it.';
                returnToIdle();
            }
        }

        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
            }
            isRecording = false;
            setRecordingUI(false);
            statusText.textContent = 'Processing...';
        }

        // ── Process Voice ──
        async function processVoice(audioBlob) {
            isProcessing = true;
            micBtn.classList.add('opacity-50', 'cursor-not-allowed');

            try {
                // Convert to base64
                const reader = new FileReader();
                const base64Promise = new Promise((resolve) => {
                    reader.onloadend = () => resolve(reader.result.split(',')[1]);
                });
                reader.readAsDataURL(audioBlob);
                const base64Audio = await base64Promise;

                // Step 1: Transcribe
                statusText.textContent = 'Transcribing...';
                const transcribeRes = await fetch('/assistant/transcribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ audio: base64Audio }),
                });

                if (!transcribeRes.ok) throw new Error('Transcription failed');
                const { text: userText } = await transcribeRes.json();

                if (!userText || !userText.trim()) {
                    statusText.textContent = "Couldn't catch that.";
                    isProcessing = false;
                    micBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    returnToIdle();
                    return;
                }

                addLogEntry('user', userText.trim());
                conversationHistory.push({ role: 'user', content: userText.trim() });

                // Step 2: Fire BOTH stream (for live text) and chat (for TTS) in parallel
                statusText.textContent = 'Shera is thinking...';
                addThinking();

                const historyForRequest = conversationHistory.slice(0, -1);
                const messageBody = {
                    message: userText.trim(),
                    history: historyForRequest,
                };

                // Start streaming for live text display
                const streamPromise = fetch('/assistant/stream', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'text/event-stream',
                    },
                    body: JSON.stringify(messageBody),
                });

                // Start regular chat request in parallel - use its response for TTS
                const chatPromise = fetch('/assistant/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(messageBody),
                }).then(async (res) => {
                    if (!res.ok) return null;
                    const data = await res.json();
                    if (!data.reply || !data.reply.trim()) return null;
                    // Immediately request TTS as soon as chat response arrives
                    const speakText = data.reply.length > 4500 ? data.reply.substring(0, 4500) + '...' : data.reply;
                    const speakRes = await fetch('/assistant/speak', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ text: speakText }),
                    });
                    if (!speakRes.ok) return null;
                    return await speakRes.json();
                }).catch(() => null);

                // Process the stream for live text
                const streamRes = await streamPromise;

                if (!streamRes.ok) {
                    removeThinking();
                    throw new Error('Stream request failed');
                }

                removeThinking();
                statusText.textContent = 'Shera is responding...';
                const streamBubble = addStreamingEntry();
                let fullText = '';

                const streamReader = streamRes.body.getReader();
                const decoder = new TextDecoder();
                let buffer = '';

                while (true) {
                    const { done, value } = await streamReader.read();
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
                                updateStreamingEntry(streamBubble, fullText);
                            }
                        } catch (e) {}
                    }
                }

                conversationHistory.push({ role: 'assistant', content: fullText });

                // Step 3: Play audio - TTS was requested in parallel, should be ready by now
                const speakData = await chatPromise;

                if (speakData && speakData.audio) {
                    statusText.textContent = 'Shera is speaking...';
                    stopSpeakingBtn.classList.remove('hidden');

                    const audioBytes = atob(speakData.audio);
                    const audioArray = new Uint8Array(audioBytes.length);
                    for (let i = 0; i < audioBytes.length; i++) {
                        audioArray[i] = audioBytes.charCodeAt(i);
                    }
                    const blob = new Blob([audioArray], { type: speakData.mime || 'audio/mpeg' });
                    const url = URL.createObjectURL(blob);

                    currentAudio = new Audio(url);
                    currentAudio.play().catch(() => {});
                    currentAudio.onended = () => {
                        URL.revokeObjectURL(url);
                        currentAudio = null;
                        stopSpeakingBtn.classList.add('hidden');
                        returnToIdle();
                    };
                } else {
                    returnToIdle();
                }
            } catch (err) {
                console.error(err);
                removeThinking();
                statusText.textContent = 'Something went wrong.';
                addLogEntry('assistant', 'Sorry, something went wrong. Please try again.');
                setTimeout(() => returnToIdle(), 2000);
            } finally {
                isProcessing = false;
                micBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        // ── Start listening on page load ──
        startWakeWordListening();
    });
    </script>
</body>
</html>
