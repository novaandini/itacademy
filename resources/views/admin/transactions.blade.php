@extends('layouts.main')

@section('konten')
<div class="container">
    <h1 class="mb-4 text-center">Pending Transactions</h1>

    @if($transactions->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Total</th>
                    <th>Payment Proof</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->course->title }}</td>
                        <td>${{ number_format($transaction->total, 2) }}</td>
                        <td><a href="{{ Storage::url($transaction->payment_proof) }}" target="_blank">View Proof</a></td>
                        <td>
                            <form action="{{ route('admin.transactions.confirm', $transaction->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">Confirm</button>
                            </form>
                            <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info text-center">No pending transactions.</div>
    @endif
</div>
@endsection
