<x-mail::message>
# Halo, {{ $data['name'] }}

@if($status == 'approved')
**Selamat!** Akun Anda telah disetujui.  
Silakan login dengan email dan password yang Anda daftarkan.

<x-mail::button :url="route('auth.login')">
Login Sekarang
</x-mail::button>
@else
Kami mohon maaf, pendaftaran Anda telah **ditolak**.  
Silakan hubungi admin untuk informasi lebih lanjut.
@endif

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>