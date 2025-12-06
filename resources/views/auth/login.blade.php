@php
    $data = DB::table('genarel_infos')->select('field_name','value')->get();
    $dataArray = array();
    foreach ($data as $v)
    {
        $dataArray[$v->field_name] = $v->value;
    }
    extract($dataArray);

    $logo          = asset('assets/images/info/'.$logo);
    $favicon       = asset('assets/images/info/'.$favicon);
    $logo_white    = asset('assets/images/info/'.$logo_white);
@endphp
@extends('fontend.layout.layout')

@section('mainContent')

<section class="banner-one">
    {{-- <div class="bubble-dotted">
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
    </div> --}}
    <div class="auto-container">
        {{-- <div class="banner-one_shadow-layer" style="background-image:url({{asset("assets/images/background/pattern-27.png")}})"></div> --}}
        <div class="row justify-content-center" >
            <div class="col-md-6" style="z-index: 1;">
                {{-- <div class="auth-logo">
                    <div id="logo">
                        <a href="{{ route('home')}}"> <img src="{{ $logo }}" alt="{{ $web_title }}"></a>
                    </div>
                </div> --}}
                <div class="auth-card p-4">
                    <h2>Welcome Back</h2>
                    <p>Sign in to access your account and continue where you left off.</p>
                    <hr>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error_message'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error_message') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email_or_mobile" class="col-md-6 col-form-label">{{ __('Email or Mobile') }}</label>
                            <div class="col-12">
                                <input id="email" type="text" class="form-control @error('email_or_mobile') is-invalid @enderror" name="email_or_mobile" value="{{ old('email_or_mobile') }}" placeholder="Mobile number or email address" name="email_or_mobile" required autofocus>

                                @error('email_or_mobile')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-12 col-form-label">{{ __('Password') }}</label>

                            <div class="col-12">
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
                                </div>
                                <div class="row justify-content-center mb-0">
                                    <div class="col-md-12 " style="text-align:center;">
                                        <button class=" signup-btn mt-3" type="submit">Login</button>
                                    </div>
                                    <div class="col-md-12 mt-3" style="text-align: center;">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}">
                                                {{ __('Forgotten password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <hr class="my-3">
                                    <div class="col-12" style="text-align:center;">
                                        @if (Route::has('register'))
                                            <a class="btn-style-tean theme-btn btn-item" href="{{ route('register') }}">
                                                <div class="btn-wrap">
                                                    <span class="text-one">{{ __("Create new account") }}</span>
                                                </div>
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
    </div>
</section>
@endsection
@section('javaScricpt')
    <script src="{{asset('assets/js/otpValidation.js')}}"></script>
@endsection
