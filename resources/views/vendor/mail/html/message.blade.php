<x-mail::layout>
    {{-- Header --}}
    <x-slot:header>
        <x-mail::header :url="config('app.url')">
            <a class="navbar-brand fw-bold text-success" href="/">
                <i class="fas fa-briefcase me-2 text-success"></i> {{ config('app.name') }}
            </a>
        </x-mail::header>
    </x-slot:header>

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        <x-slot:subcopy>
            <x-mail::subcopy>
                {{ $subcopy }}
            </x-mail::subcopy>
        </x-slot:subcopy>
    @endisset

    {{-- Footer --}}
    <x-slot:footer>
        <x-mail::footer>
            © {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
        </x-mail::footer>
    </x-slot:footer>
</x-mail::layout>
