@extends('layouts.main')

@section('konten')
    <div class="container my-5">
        <h2 class="mb-4 text-center font-weight-bold" style="color: #333;">Checkout</h2>

        <div class="alert alert-light shadow-sm p-4 rounded"
            style="background-color: #e3f7fc; border-left: 5px solid #17a2b8;">
            <p><strong>Total Amount:</strong> <span
                    style="color: #17a2b8;">Rp{{ number_format($transaction->amount, 2) }}</span></p>
        </div>

        <form action="{{ route('payment.handle') }}" method="POST" id="payment-form" class="text-center">
            @csrf
            <input type="hidden" name="snapToken" value="{{ $snapToken }}">
            <button type="submit" class="btn btn-lg btn-primary mt-4"
                style="background-color: #28a745; border: none; border-radius: 50px; padding: 10px 30px; transition: background-color 0.3s;">
                Pay Now
            </button>
        </form>
    </div>

    <!-- Modal -->
    <div id="success_tic" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <a class="close" href="#" data-dismiss="modal">&times;</a>
                <div class="page-body">
                    <div class="head">
                        <h3 style="margin-top:5px;">Payment Successful</h3>
                        <h4>Thank you for your purchase!</h4>
                    </div>

                    <h1 style="text-align:center;">
                        <div class="checkmark-circle">
                            <div class="background"></div>
                            <div class="checkmark draw"></div>
                        </div>
                    </h1>
                </div>
            </div>

        </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script type="text/javascript">
        document.getElementById('payment-form').onsubmit = function(event) {
            event.preventDefault();
            snap.pay(this.snapToken.value, {
                onSuccess: function(result) {
                    // Menampilkan modal
                    $('#success_tic').modal('show');

                    // Menutup modal setelah 3 detik dan mengarahkan ke /my-courses
                    setTimeout(function() {
                        $('#success_tic').modal('hide');
                        window.location.href = "/my-courses";
                    }, 3000); // Modal akan tertutup setelah 3 detik
                },
                onPending: function(result) {
                    alert("Waiting for payment confirmation!");
                },
                onError: function(result) {
                    alert("Payment failed!");
                }
            });
        };
    </script>
    <style>
        body {
            background-color: #e6e6e6;
            width: 100%;
            height: 100%;
        }

        #success_tic .page-body {
            max-width: 300px;
            background-color: #FFFFFF;
            margin: 10% auto;
        }

        #success_tic .page-body .head {
            text-align: center;
        }

        #success_tic .close {
            opacity: 1;
            position: absolute;
            right: 0px;
            font-size: 30px;
            padding: 3px 15px;
            margin-bottom: 10px;
        }

        #success_tic .checkmark-circle {
            width: 150px;
            height: 150px;
            position: relative;
            display: inline-block;
            vertical-align: top;
        }

        .checkmark-circle .background {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #1ab394;
            position: absolute;
        }

        #success_tic .checkmark-circle .checkmark {
            border-radius: 5px;
        }

        #success_tic .checkmark-circle .checkmark.draw:after {
            -webkit-animation-delay: 300ms;
            -moz-animation-delay: 300ms;
            animation-delay: 300ms;
            -webkit-animation-duration: 1s;
            -moz-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-timing-function: ease;
            -moz-animation-timing-function: ease;
            animation-timing-function: ease;
            -webkit-animation-name: checkmark;
            -moz-animation-name: checkmark;
            animation-name: checkmark;
            -webkit-transform: scaleX(-1) rotate(135deg);
            -moz-transform: scaleX(-1) rotate(135deg);
            -ms-transform: scaleX(-1) rotate(135deg);
            -o-transform: scaleX(-1) rotate(135deg);
            transform: scaleX(-1) rotate(135deg);
            -webkit-animation-fill-mode: forwards;
            -moz-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
        }

        #success_tic .checkmark-circle .checkmark:after {
            opacity: 1;
            height: 75px;
            width: 37.5px;
            -webkit-transform-origin: left top;
            -moz-transform-origin: left top;
            -ms-transform-origin: left top;
            -o-transform-origin: left top;
            transform-origin: left top;
            border-right: 15px solid #fff;
            border-top: 15px solid #fff;
            border-radius: 2.5px !important;
            content: '';
            left: 35px;
            top: 80px;
            position: absolute;
        }

        @-webkit-keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 37.5px;
                opacity: 1;
            }

            40% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }

            100% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }
        }

        @-moz-keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 37.5px;
                opacity: 1;
            }

            40% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }

            100% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }
        }

        @keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 37.5px;
                opacity: 1;
            }

            40% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }

            100% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }
        }
    </style>
@endsection
