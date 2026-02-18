<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Assistant</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white flex items-center justify-center">
    <div class="text-center px-6 max-w-xl mx-auto">

        {{-- Logo / Icon --}}
        <div class="mx-auto w-24 h-24 rounded-3xl bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center shadow-2xl shadow-violet-500/30 mb-8">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
            </svg>
        </div>

        {{-- Title --}}
        <h1 class="text-4xl font-bold mb-3 bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">
            AI Assistant
        </h1>
        <p class="text-slate-400 text-lg mb-12">
            Your personal AI powered by OpenAI. Chat by typing or talking.
        </p>

        {{-- Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">

            {{-- Text Chat Button --}}
            <a href="/chat" class="group relative flex items-center gap-4 px-8 py-5 bg-slate-800/80 border border-slate-700/50 rounded-2xl hover:border-violet-500/50 hover:bg-slate-800 transition-all shadow-lg hover:shadow-violet-500/10">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform flex-shrink-0">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="text-lg font-semibold text-white block">Text Chat</span>
                    <span class="text-sm text-slate-400">Type messages to your AI assistant</span>
                </div>
            </a>

            {{-- Voice Chat Button --}}
            <a href="/voice" class="group relative flex items-center gap-4 px-8 py-5 bg-slate-800/80 border border-slate-700/50 rounded-2xl hover:border-violet-500/50 hover:bg-slate-800 transition-all shadow-lg hover:shadow-violet-500/10">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-violet-500 to-pink-500 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform flex-shrink-0">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="text-lg font-semibold text-white block">Voice Chat</span>
                    <span class="text-sm text-slate-400">Speak and listen to your AI assistant</span>
                </div>
            </a>

        </div>

        <p class="text-slate-600 text-sm mt-10">Powered by Laravel AI &amp; OpenAI</p>
    </div>
</body>
</html>
