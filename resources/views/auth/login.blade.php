<div class="wrapper">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <div class="logo">
        <img src="{{ asset('assets/img/bitac.png') }}" alt="">
    </div>
    <div class="text-center mt-4 name">
        Login
    </div>
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('error') }}
        </div>
    @endif
    <form class="p-3 mt-3" method="POST" action="{{ route('auth.login') }}">
        @csrf
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span>
            <input type="email" name="email" id="email" placeholder="Email">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span>
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        @if ($errors->has('error'))
            <div style="color: red">{{ $errors->first('error') }}</div>
        @endif
        <button class="btn mt-3">Login</button>
    </form>
    {{-- <div class="text-center fs-6">
        <a href="forgot-password">Forget password?</a> or <a href="{{ route('student.signup') }}">Sign Up as Student</a>
    </div> --}}
</div>
