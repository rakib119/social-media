@php
    $data = DB::table('genarel_infos')->select('field_name','value')->get();
    $dataArray = array();
    foreach ($data as $v) {
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
        {{-- <div class="banner-one_shadow-layer" style="background-image:url({{ asset('assets/images/background/pattern-27.png') }})"></div> --}}
        <div class="row justify-content-center">
            <div class="col-md-6" style="z-index: 1;">
                {{-- <div class="auth-logo text-center mb-3">
                    <a href="{{ route('home') }}"><img src="{{ $logo }}" alt="{{ $web_title }}"></a>
                </div> --}}

                <div class="auth-card p-4">
                    <h2>Verify OTP</h2>
                    <p>Enter the 6-digit OTP sent to your mobile number.</p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    @if (session('error_message'))
                        <div class="alert alert-danger" role="alert">{{ session('error_message') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.verify-otp.submit') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="otp" class="col-12 col-form-label">One-Time Password (OTP)</label>
                            <div class="col-12">
                                <input id="otp" type="text" maxlength="6" class="form-control @error('otp') is-invalid @enderror"
                                       name="otp" required autofocus placeholder="Enter 6-digit OTP">
                                @error('otp')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="signup-btn mt-3">Verify OTP</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-5 mb-3">
                        <div class="col-12" style="text-align:center;">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __("Back to Forgot Password") }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
