<x-mail::message>
    {{-- Header Custom --}}
    <div style="text-align: center; padding: 20px 0; background-color: #f3f4f6;">
        {{-- <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height: 50px;"> --}}
        <h1 style="color: #4f46e5;">Reset Password</h1>
    </div>

    {{-- Konten Dinamis --}}
    @foreach ($introLines as $line)
        <p>{{ $line }}</p>
    @endforeach

    {{-- Tombol Custom --}}
    <x-mail::button :url="$actionUrl" style="background-color: #4f46e5; border-radius: 8px;">
        {{ $actionText }}
    </x-mail::button>

    {{-- Footer --}}
    <div style="margin-top: 30px; text-align: center; color: #6b7280;">
        <p>© {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</x-mail::message>
