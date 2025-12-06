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
        <div class="row justify-content-center">
            <div class="col-md-6" style="z-index: 1;">
                    {{-- <div class="auth-logo">
                        <div id="logo">
                            <a href="{{ route('home')}}"> <img src="{{ $logo }}" alt="{{ $web_title }}"></a>
                        </div>
                    </div> --}}
                    <div class="auth-card p-4">
                        <h2>Reset Password</h2>
                        <p>Please enter your email address or mobile number and new password to reset your account password.</p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('send_reset_otp') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-12 col-form-label">Email address or Mobile number</label>

                                <div class="col-12">
                                    <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autofocus>

                                    @error('login')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12 " style="text-align:center;">
                                    <button class=" signup-btn mt-3" type="submit">Send Reset Otp</button>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</section>
@endsection
