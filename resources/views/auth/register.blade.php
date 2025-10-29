@extends('fontend.layout.layout')
@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.min.css') }}"> --}}
@endsection
@section('mainContent')
<!-- Banner One -->
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" style="z-index: 1;">
                    <div class="sec-title centered">
                        <div class="sec-title_title">Register</div>
                        <h3 class="sec-title_heading">Passionate Personalities, <br> <span class="theme_color">Versatile</span> Brains</h3>
                    </div>
                    <div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Mr. XXXXX" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- EMAIL --}}
                            <div class="row ">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="example@gmail.com">
                                        <div class="input-group-append">
                                            <button onclick="validateEmail()" id="otp-email-sending-btn" class="otp-style-btn theme-btn btn-item" type="button"> <span id="otp-email-sending-btn-html">Send Otp</span>
                                            </button>
                                        </div>
                                    </div>
                                    <p id="otp-sending-message"></p>
                                    @error('email')
                                        <p class="text-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 d-none" id="email_verification_box" >
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Verify Otp') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="email-otp" type="text" class="form-control @error('email_otp') is-invalid @enderror" name="email_otp" placeholder="Enter Otp">
                                        <div class="input-group-append">
                                            <button class="otp-style-btn theme-btn btn-item" onclick="validateEmailOtp()" type="button" id="verifyBtn"><span>Confirm</span></button>
                                        </div>
                                    </div>
                                    <p id="email_otp_error"></p>
                                </div>
                            </div>
                            {{-- Phone Number --}}
                            <div class="row " id="phnNmbrContainer">
                                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="01*********">
                                        <div class="input-group-append">
                                            <button onclick="validateMobileNumber()" id="otp-phone-sending-btn" class="otp-style-btn theme-btn btn-item" type="button"> <span id="otp-phone-sending-btn-html">Send Otp</span>
                                            </button>
                                        </div>
                                    </div>
                                    <p id="phone-otp-sending-message"></p>
                                    <p class="my-2 text-danger" id="valid-msg"></p>
                                    <p class="my-2 text-danger" id="error-msg"></p>
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 d-none" id="phone_verification_box" >
                                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Verify Otp') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="phone-otp" type="text" class="form-control @error('phone_otp') is-invalid @enderror" name="phone_otp" placeholder="Enter Otp">
                                        <div class="input-group-append">
                                            <button class="otp-style-btn theme-btn btn-item" onclick="validateMobileOtp()" type="button" id="verifyBtn"><span>Confirm</span></button>
                                        </div>
                                    </div>
                                    <p id="phone_otp_error"></p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <div class="mb-2 d-flex">
                                        <input id="newPassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter password">
                                        <i class="fas fa-eye-slash" id="NewTogglePassword" style="margin:auto -30px; cursor: pointer;"></i></i>
                                    </div>
                                    <span class="my-2 text-danger " id="newPasswordError"></span>
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <div class="mb-2 d-flex">
                                        <input id="confirmPassword" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                                        <i class="fas fa-eye-slash" id="confirmTogglePassword" style="margin:auto -30px; cursor: pointer;"></i></i>
                                    </div>
                                    <span class="my-2 text-danger " id="confirmPasswordError"></span>
                                </div>
                            </div>

                            <div class="row mb-0 d-none" id="submitBtnContainer">
                                <div class="col-md-6 offset-md-4">
                                    <input name="country" type="hidden" id="address-country">
                                    <input name="country_code" type="hidden" value="{{old('country_code')}}" id="country-code">
                                    <input name="dial_code" type="hidden" value="{{old('dial_code')}}" id="dial-code">
                                    <button type="submit" class="btn-style-three theme-btn btn-item">
                                        <div class="btn-wrap">
                                            <span class="text-one">Register<i class="fas fa-sign-in-alt"></i></span>
                                            <span class="text-two">Register<i class="fas fa-sign-in-alt"></i></span>
                                        </div>
								    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javaScricpt')
    <script src="{{asset('assets/js/otpValidation.js')}}"></script>
    {{-- <script src="{{ asset('assets/js/intlTelInput.min.js') }}"></script>
    <script>
        var countryData = window.intlTelInputGlobals.getCountryData(),
        input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg"),
        countryInput = document.querySelector("#address-country");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap = ["Invalid number", "Invalid country code", "Number is too short", "Number is too long", "Invalid number"];
        // let blockedCountries = ["af",'cn','np','ma','dz','eg','ws','gm','ye','bd'];
        let blockedCountries = [];
        // initialise plugin
        var iti = window.intlTelInput(input, {
        utilsScript: "{{ asset('assets/js/utils.js') }}",
        preferredCountries: [],
        initialCountry: "auto",
        separateDialCode:true,
        excludeCountries: blockedCountries,
        geoIpLookup: function(callback) {
            $.getJSON('https://get.geojs.io/v1/ip/country.json', function(resp) {
            var countryCode = resp.country;
            if(blockedCountries.includes(countryCode.toLowerCase()) ){
                $('#error-msg').html('You are in restricted area');
            }else{
                callback(countryCode);
                $('#error-msg').html('');
            }
            });
        }
        });
        // set it's initial value
        iti.promise.then(function() {
                let selectedData = iti.getSelectedCountryData();
                var countryCode = selectedData.iso2;
                if (countryCode) {
                    countryInput.value = selectedData.name;
                    $("#country-code").val(countryCode);
                    $("#dial-code").val(selectedData.dialCode);
                } else {
                    let code = $("#country-code").val();
                    iti.setCountry(code); // set default country to United States
                    countryCode = code; // set countryCode to United States
                }
        });

        // listen to the telephone input for changes
        input.addEventListener('countrychange', function(e) {
            let selectedData =iti.getSelectedCountryData();
            // console.log(selectedData);
            countryInput.value = selectedData.name;
            $("#country-code").val(selectedData.iso2);
            $("#dial-code").val(selectedData.dialCode);
        });

        var reset = function() {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        // on blur: validate
        input.addEventListener('blur', function() {
            reset();
            if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                input.classList.add("error");
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
            }
        });
        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    </script> --}}
@endsection
