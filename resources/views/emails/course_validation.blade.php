<x-mail::message>
# Halo, {{ $data['user']['name'] }}

@if($status == 'approved')
**Selamat!** Course {{ $data['title'] }} telah disetujui.  
Mohon persiapkan jadwal belajar sebelum course dimulai ({{ $data['start_date'] }}).

@else
Kami mohon maaf, pendaftaran course {{ $data['title'] }} telah **ditolak**.  
Silakan hubungi admin untuk informasi lebih lanjut.
@endif

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>