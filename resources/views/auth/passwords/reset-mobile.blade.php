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
                    <h2>Set new Password</h2>
                    <p>Enter your new password below to reset your account.</p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('reset.password.form', $userId) }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-12 col-form-label">Email address or Mobile number</label>

                            <div class="col-12">
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" placeholder="Rewrite Email address or Mobile number" required autofocus>

                                @error('login')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-12 col-form-label">New Password</label>
                            <div class="col-12">
                                <div class="mb-2 d-flex">
                                    <input id="newPassword" type="password" class="form-control @error('password') is-invalid @enderror"  name="password" required placeholder="Enter new password">
                                    <i class="fas fa-eye-slash" id="NewTogglePassword" style="margin:auto -30px; cursor: pointer;"></i></i>
                                </div>
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-12 col-form-label">Confirm Password</label>
                            <div class="col-12">
                                <div class="mb-2 d-flex">
                                        <input id="confirmPassword" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm new password">
                                        <i class="fas fa-eye-slash" id="confirmTogglePassword" style="margin:auto -30px; cursor: pointer;"></i></i>
                                    </div>
                                    <span class="my-2 text-danger " id="confirmPasswordError"></span>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="signup-btn mt-3">Reset Password</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-5 mb-3">
                        <div class="col-12" style="text-align:center;">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}">
                                    {{ __("Back to Login") }}
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

@section('javaScricpt')
    {{-- Password show/hide --}}

    <script src="{{asset('assets/js/otpValidation.js')}}"></script>
@endsection
