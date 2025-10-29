@extends('fontend.layout.layout')

@section('mainContent')

<section class="banner-one">
    <div class="bubble-dotted">
        <span class="dotted dotted-1"></span>
        <span class="dotted dotted-2"></span>
        <span class="dotted dotted-3"></span>
        <span class="dotted dotted-4"></span>
        <span class="dotted dotted-5"></span>
        <span class="dotted dotted-6"></span>
        <span class="dotted dotted-7"></span>
        <span class="dotted dotted-8"></span>
        <span class="dotted dotted-9"></span>
        <span class="dotted dotted-10"></span>
    </div>
    <div class="auto-container">
        <div class="banner-one_shadow-layer" style="background-image:url({{asset("assets/images/background/pattern-27.png")}})"></div>
        <div class="row justify-content-center" >
            <div class="col-md-8" style="z-index: 1;">
                <div class="sec-title centered">
                    <div class="sec-title_title">Login</div>
                    <h3 class="sec-title_heading">Passionate Personalities, <br> <span class="theme_color">Versatile</span> Brains</h3>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <div class="mb-2 d-flex">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <i class="fas fa-eye-slash" id="loginTogglePassword" style="margin:auto -30px; cursor: pointer;"></i></i>
                            </div>

                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror

                            <div class="row mt-2 mb-3">
                                <div class="col-6">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember" style="cursor:pointer;">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                <div class="col-6">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row justify-content-center mb-0">
                                <div class="col-md-12 " style="text-align:center;">
                                    <button type="submit" class="btn-style-three theme-btn btn-item">
                                        <div class="btn-wrap">
                                            <span class="text-one">Login<i class="fas fa-sign-in-alt"></i></span>
                                            <span class="text-two">Login<i class="fas fa-sign-in-alt"></i></span>
                                        </div>
								    </button>
                                </div>
                            </div>
                            <div class="row mt-5 mb-3">
                                <div class="col-12" style="text-align:center;">
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}">
                                            {{ __("Don't have account? Sign up") }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javaScricpt')
    <script src="{{asset('assets/js/otpValidation.js')}}"></script>
@endsection
