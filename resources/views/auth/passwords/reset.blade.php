@php
    $data = DB::table('genarel_infos')->select('field_name','value')->get();
    $dataArray = [];
    foreach ($data as $v) {
        $dataArray[$v->field_name] = $v->value;
    }
    extract($dataArray);

    $logo       = asset('assets/images/info/'.$logo);
    $favicon    = asset('assets/images/info/'.$favicon);
    $logo_white = asset('assets/images/info/'.$logo_white);
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
        {{-- <div class="banner-one_shadow-layer"
             style="background-image:url({{ asset('assets/images/background/pattern-27.png') }})">
        </div> --}}

        <div class="row justify-content-center">
            <div class="col-6" style="z-index: 1;">
                {{-- <div class="auth-logo text-center mb-3">
                    <a href="{{ route('home') }}">
                        <img src="{{ $logo }}" alt="{{ $web_title }}">
                    </a>
                </div> --}}

                <div class="auth-card p-4">
                    <h2 class="fw-bold">Reset Password</h2>
                    <p>Enter your registered email or mobile number and new password.</p>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST"
                          action="{{ isset($userId) ? route('confirm.password.reset.submit', $userId) : route('password.update') }}">
                        @csrf

                        {{-- Hidden token (for email reset link) --}}
                        @if(isset($token))
                            <input type="hidden" name="token" value="{{ $token }}">
                        @endif

                        {{-- Email or mobile --}}
                        <div class="row mb-3">
                            <label class="col-12 col-form-label">Email or Mobile</label>
                            <div class="col-12">
                                <input type="text"
                                       name="login"
                                       class="form-control @error('login') is-invalid @enderror"
                                       value="{{ old('login', $login ?? '') }}"
                                       placeholder="Enter your email or mobile number"
                                       required autofocus>

                                @error('login')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-3">
                            <label for="password" class="col-12 col-form-label">New Password</label>
                            <div class="col-12 position-relative">
                                <input id="password" type="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Enter new password"
                                       required minlength="6">
                                <i class="fas fa-eye-slash position-absolute top-50 end-0 translate-middle-y me-3"
                                   id="togglePassword"
                                   style="cursor:pointer;"></i>
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-12 col-form-label">Confirm Password</label>
                            <div class="col-12 position-relative">
                                <input id="password_confirmation" type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       placeholder="Confirm password"
                                       required minlength="6">
                                <i class="fas fa-eye-slash position-absolute top-50 end-0 translate-middle-y me-3"
                                   id="toggleConfirm"
                                   style="cursor:pointer;"></i>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-12 text-center">
                                <button type="submit" class="signup-btn mt-3 w-100">
                                    Reset Password
                                </button>
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
    {{-- Password show/hide --}}
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('password');
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            input.type = input.type === 'password' ? 'text' : 'password';
        });
        document.getElementById('toggleConfirm').addEventListener('click', function() {
            const input = document.getElementById('password_confirmation');
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    </script>
    <script src="{{asset('assets/js/otpValidation.js')}}"></script>
@endsection
