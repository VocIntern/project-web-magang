<x-mail::message>
# Reset Password Notification

Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.

<x-mail::panel>
Keamanan akun Anda adalah prioritas kami. Pastikan Anda tidak pernah membagikan password Anda kepada siapapun.
</x-mail::panel>

<x-mail::button :url="$url">
Reset Password
</x-mail::button>

Link reset password ini akan kedaluwarsa dalam {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} menit.

Jika Anda tidak meminta reset password, tidak diperlukan tindakan lebih lanjut.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>