@extends('layouts.main')

@section('konten')
<br><br>
<!-- Product Section Start -->
<section class="section" id="product">
    <div class="container wow fadeInUp" data-wow-delay="0.1s">
        <div class="row">
            <div class="col-lg-8">
                <div class="left-images">
                    <img src="{{ asset('storage/courses/' . $course->image) }}" alt="{{ $course->title }}" class="img-fluid rounded mb-4 w-100">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-content">
                    <h4 class="mb-3">{{ $course->title }}</h4>

                    @php
                        $usdExchangeRate = 0.000065; // Example conversion rate IDR to USD
                        $priceUSD = $course->price * $usdExchangeRate;
                        $discountedPrice = $course->discount > 0 ? (1 - $course->discount / 100) * $course->price : $course->price;
                        $discountedPriceUSD = $course->discount > 0 ? (1 - $course->discount / 100) * $priceUSD : $priceUSD;

                        // Check the selected currency from the session
                        $selectedCurrency = session('currency', 'IDR'); // Default to IDR if not set
                    @endphp

                    <!-- Display pricing based on selected currency -->
                    @if($selectedCurrency === 'USD')
                        <span class="price h5 text-primary mb-3">
                            ${{ number_format($discountedPriceUSD, 2) }} 
                            @if($course->discount > 0)
                                <span class="h5 text-muted text-decoration-line-through">
                                    ${{ number_format($priceUSD, 2) }}
                                </span>
                                <small class="text-danger ms-1">Save {{ intval($course->discount) }}%</small>
                            @endif
                        </span>
                    @else
                        <span class="price h5 text-primary mb-3">
                            Rp{{ number_format($discountedPrice, 2) }}
                        </span>
                        @if($course->discount > 0)
                            <span class="h5 text-muted text-decoration-line-through">
                                Rp{{ number_format($course->price, 2) }}
                            </span>
                            <small class="text-danger ms-1">Save {{ intval($course->discount) }}%</small>
                        @endif
                    @endif

                    <ul class="stars list-unstyled d-flex mb-3">
                        @for($i = 0; $i < 5; $i++)
                            <li class="me-1">
                                <i class="fa fa-star {{ $i < $course->rating ? 'text-warning' : 'text-muted' }}"></i>
                            </li>
                        @endfor
                    </ul>
                    <p>{!! $course->description !!}</p>
                    <div class="quote p-3 my-3 bg-light rounded">
                        <i class="fa fa-quote-left text-primary me-2"></i>
                        <p class="mb-0">Unlock the secrets of {{ $course->title }} and elevate your digital creations to new heights.</p>
                    </div>
                    <div class="total mb-4">
                        <h4>
                            Total:
                            @if($selectedCurrency === 'USD')
                                ${{ number_format($discountedPriceUSD, 2) }}
                            @else
                                Rp{{ number_format($discountedPrice, 2) }}
                            @endif
                        </h4>

                        <!-- Check if user is a student -->
                        @if(Auth::check() && Auth::user()->role === 'student')
                            <div class="main-border-button">
                                @php
                                    $cart = session('cart');
                                    $inCart = isset($cart[$course->id]);

                                    // Check if user has a confirmed transaction for this course
                                    $transactionFinished = \App\Models\TransactionItem::whereHas('transaction', function($query) {
                                        $query->where('user_id', auth()->id())
                                              ->where('status', 'settlement');
                                    })->where('course_id', $course->id)->exists();
                                @endphp

                                <!-- Disable button if the number of students = 0 -->
                                @if($course->capacity <= 0)
                                    <button class="btn btn-secondary w-100" disabled>
                                        Students Full
                                    </button>
                                @elseif($inCart)
                                    <button class="btn btn-secondary w-100" disabled>
                                        Already in Cart
                                    </button>
                                @elseif($transactionFinished)
                                    <button class="btn btn-secondary w-100" disabled>
                                        Already Purchased
                                    </button>
                                @else
                                    <form action="{{ route('cart.add', $course->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">
                                            Add to Cart
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <!-- If not logged in -->
                            <div class="main-border-button">
                                <a href="{{ route('auth.login') }}" class="btn btn-primary w-100">
                                    Login to Add to Cart
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection
