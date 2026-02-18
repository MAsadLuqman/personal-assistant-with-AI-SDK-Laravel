<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Ai\Audio;
use Laravel\Ai\Transcription;

use function Laravel\Ai\agent;

class AssistantController extends Controller
{
    public function chat()
    {
        return view('chat');
    }

    public function voice()
    {
        return view('voice');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'history' => 'array',
        ]);

        $messages = collect($request->input('history', []))->map(function ($msg) {
            return [
                'role' => $msg['role'],
                'content' => $msg['content'],
            ];
        })->toArray();

        $response = agent(
            instructions: 'You are a friendly and helpful personal AI assistant. You answer questions clearly and concisely. You can help with general knowledge, writing, coding, math, and everyday tasks. Keep responses conversational and helpful.',
            messages: $messages,
        )->prompt($request->input('message'));

        return response()->json([
            'reply' => $response->text,
        ]);
    }

    public function streamMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'history' => 'array',
        ]);

        $messages = collect($request->input('history', []))->map(function ($msg) {
            return [
                'role' => $msg['role'],
                'content' => $msg['content'],
            ];
        })->toArray();

        return agent(
            instructions: 'You are a friendly and helpful personal AI assistant. You answer questions clearly and concisely. You can help with general knowledge, writing, coding, math, and everyday tasks. Keep responses conversational and helpful.',
            messages: $messages,
        )->stream($request->input('message'));
    }

    public function transcribe(Request $request)
    {
        $request->validate([
            'audio' => 'required|string',
        ]);

        $base64Audio = $request->input('audio');

        // Save to temp file with .webm extension so OpenAI recognizes the format
        $tempPath = sys_get_temp_dir().'/voice_'.uniqid().'.webm';
        file_put_contents($tempPath, base64_decode($base64Audio));

        try {
            $response = Transcription::fromPath($tempPath, 'audio/webm')
                ->language('en')
                ->generate();

            return response()->json([
                'text' => $response->text,
            ]);
        } finally {
            @unlink($tempPath);
        }
    }

    public function speak(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        // Truncate to 4500 chars to stay within TTS API limits
        $text = mb_substr($request->input('text'), 0, 4500);

        $response = Audio::of($text)
            ->voice('alloy')
            ->generate();

        return response()->json([
            'audio' => $response->audio,
            'mime' => $response->mime,
        ]);
    }
}
