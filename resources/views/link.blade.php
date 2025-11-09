@extends('layouts.app')

@section('title', 'Your Link - NuxGame')

@section('content')
<div class="max-w-4xl mx-auto" id="gameContainer" data-token="{{ $link->token }}">
    <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Welcome, {{ $link->user->username }}!</h2>

        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600 mb-2">Your unique link:</p>
            <p class="font-mono text-sm break-all bg-white p-2 rounded border">{{ route('link.show', $link->token) }}</p>
            <p class="text-xs text-gray-500 mt-2">Expires: {{ $link->expires_at->format('Y-m-d H:i:s') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <form action="{{ route('link.regenerate', $link->token) }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                    Regenerate Link
                </button>
            </form>

            <form action="{{ route('link.deactivate', $link->token) }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    onclick="return confirm('Are you sure you want to deactivate this link?')"
                >
                    Deactivate Link
                </button>
            </form>
        </div>

        <div class="border-t pt-6">
            <h3 class="text-xl font-bold mb-4 text-center">Play Game</h3>

            <div class="flex flex-col items-center gap-4 mb-6">
                <button
                    id="playBtn"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg text-lg focus:outline-none focus:shadow-outline"
                >
                    I'm Feeling Lucky
                </button>

                <button
                    id="historyBtn"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline"
                >
                    History
                </button>
            </div>

            <div id="gameResult" class="hidden mb-6 p-4 rounded-lg"></div>

            <div id="historyContainer" class="hidden">
                <h4 class="font-bold mb-2">Last 3 Results:</h4>
                <div id="historyContent"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/game.js')
@endpush