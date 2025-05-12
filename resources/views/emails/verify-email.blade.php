<x-mail::message>
    # Verifikasi Alamat Email

    Terima kasih telah mendaftar! Silakan klik tombol di bawah untuk memverifikasi alamat email Anda.

    <x-mail::button :url="$url">
        Verifikasi Alamat Email
    </x-mail::button>

    Jika Anda tidak membuat akun, abaikan email ini.

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>
