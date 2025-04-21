@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Proses Pembayaran</h1>
    <div class="text-center">
        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
    </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('checkout.success') }}";
            },
            onPending: function(result) {
                console.log('pending', result);
            },
            onError: function(result) {
                console.log('error', result);
            },
            onClose: function() {
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection
