@extends('layouts.main')

@section('konten')
<div class="container my-5">
    <h2 class="mb-4 font-weight-bold text-center" style="color: #333;">Your Cart</h2>

    @if(session('cart'))
        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm" style="background-color: #fff; border-radius: 8px;">
                <thead class="thead-dark">
                    <tr>
                        <th>Course</th>
                        <th>Original Price</th>
                        <th>Discount</th>
                        <th>Discounted Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $details)
                        @php
                            $originalPrice = $details['price'];
                            $discountRate = $details['discountRate'] ?? 0; // Display as percentage
                            $discountedPrice = $details['discountedPrice'];
                            $subtotal = $discountedPrice * $details['quantity'];
                        @endphpb
                        <tr>
                            <td class="align-middle">{{ $details['title'] }}</td>
                            <td class="align-middle">Rp{{ number_format($originalPrice, 2) }}</td>
                            <td class="align-middle">{{ $discountRate }}%</td>
                            <td class="align-middle">Rp{{ number_format($discountedPrice, 2) }}</td>
                            <td class="align-middle">{{ $details['quantity'] }}</td>
                            <td class="align-middle">Rp{{ number_format($subtotal, 2) }}</td>
                            <td class="align-middle">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 20px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right font-weight-bold">Total</td>
                        <td colspan="2" class="font-weight-bold">Rp{{ number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ url('/courses') }}" class="btn btn-outline-secondary" style="border-radius: 20px; padding: 10px 30px;">Back to Courses</a>
            <a href="{{ route('checkout') }}" class="btn btn-primary" style="background-color: #17a2b8; border: none; border-radius: 20px; padding: 10px 30px;">
                Proceed to Checkout
            </a>
        </div>
    @else
        <div class="alert alert-info text-center">Your cart is empty!</div>
        <div class="text-center">
            <a href="{{ url('/courses') }}" class="btn btn-outline-secondary" style="border-radius: 20px; padding: 10px 30px;">Back to Courses</a>
        </div>
    @endif
</div>
@endsection
