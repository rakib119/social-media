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
        <div class="row justify-content-center">
            <div class="col-md-8" style="z-index: 1;">
                <div class="sec-title centered">
                    <div class="sec-title_title">{{ __('Confirm Password') }}</div>
                    <h3 class="sec-title_heading">Please confirm your <br> <span class="theme_color">password</span> before continuing</h3>
                </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn-style-three theme-btn btn-item">
                                    <div class="btn-wrap">
                                        <span class="text-one">{{ __('Confirm Password') }}</i></span>
                                        <span class="text-two">{{ __('Confirm Password') }}</i></span>
                                    </div>
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</section>
@endsection
