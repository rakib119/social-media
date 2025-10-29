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
                    <div class="sec-title_title">{{ __('Reset Password') }}</div>
                    {{-- <h3 class="sec-title_heading">Send Reset <span class="theme_color">Password Link </span>    <br> And Set A <br><span class="theme_color">New Password</span></h3> --}}
                </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn-style-three theme-btn btn-item">
                                    <div class="btn-wrap">
                                        <span class="text-one">{{ __('Send Password Reset Link') }}<i class="fas fa-sign-in-alt"></i></span>
                                        <span class="text-two">{{ __('Send Password Reset Link') }}<i class="fas fa-sign-in-alt"></i></span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</section>
@endsection
