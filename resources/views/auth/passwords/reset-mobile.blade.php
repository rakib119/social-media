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
        <div class="banner-one_shadow-layer" style="background-image:url({{ asset('assets/images/background/pattern-27.png') }})"></div>
        <div class="row justify-content-center">
            <div class="col-md-6" style="z-index: 1;">
                <div class="auth-logo text-center mb-3">
                    <a href="{{ route('home') }}"><img src="{{ $logo }}" alt="{{ $web_title }}"></a>
                </div>

                <div class="auth-card p-4">
                    <h2>Reset Password</h2>
                    <p>Enter your new password below to reset your account.</p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.reset.submit', $userId) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-12 col-form-label">New Password</label>
                            <div class="col-12">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" required placeholder="Enter new password">
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-12 col-form-label">Confirm Password</label>
                            <div class="col-12">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                       class="form-control" required placeholder="Confirm new password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="signup-btn mt-3">Reset Password</button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-muted">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
