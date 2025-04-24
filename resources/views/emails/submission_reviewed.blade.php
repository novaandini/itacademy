<x-mail::message>
# Halo, {{ $data['name'] }}

**Selamat!** Tugas {{ $data['assignment_title'] }} telah dinilai.
Silahkan login untuk membaca feedback dari instructor.

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>