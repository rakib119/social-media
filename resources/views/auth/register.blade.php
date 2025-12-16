@extends('fontend.layout.layout')
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
@section('css')
    <style>


        /* Card */
        .form-card {
            background: #fff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        }



        /* Steps */
        .step-box {
            display: none;
            margin-bottom: 50px;
        }
        .step-box.active { display: block; animation: fadeIn .4s ease; }

        @keyframes fadeIn {
            from { opacity:0; transform: translateY(10px); }
            to   { opacity:1; transform: translateY(0); }
        }

        /* Buttons */
        .next-btn, .back-btn {
            width: 140px;
            padding: 10px;
            border-radius: 25px;
            border: none;
            font-size: 15px;
            font-weight: 600;
            border: none;
            font-size: 18px;
        }

        .next-btn {
            background: linear-gradient(to top left, var(--color-thirtythree) 0%, var(--color-thirtytwo) 100%);
            color: #fff;
        }

        .back-btn {
            background: #ee0979;
            color: white;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 4px;
        }
    </style>
@endsection
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
            <div class="container">

                <div class="row justify-content-center d-none d-lg-flex">{{--d-lg-flex DESKTOP MODE --}}
                    {{-- <div class="auth-logo">
                        <div id="logo">
                            <a href="{{ route('home')}}"> <img src="{{ $logo }}" alt="{{ $web_title }}"></a>
                        </div>
                    </div> --}}
                    <div class="col-md-6" style="z-index: 1;">
                        <div class="form-card p-4">
                            <h2>Create a new account</h2>
                            <p>It's quick and easy.</p>
                            <hr>
                            <form method="POST" action="{{ route('verify.otp') }}" class="desktop-only position-relative" id="signupForm" novalidate>
                                @csrf
                                <div class="row g-2">
                                    <div class="col-6 position-relative">
                                        <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First name" required data-msg="What's your name?">
                                        @error('first_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-6 position-relative">
                                        <input type="text" class="form-control" id="surname" placeholder="Surname" required data-msg="What's your surname?" name="surname">
                                        @error('surname')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <label class="col-form-label mt-3 mb-1">Date Of Birth</label>
                                <div class="row g-2">
                                    <div class="col-4 position-relative">
                                        <select class="form-select" id="day" required data-msg="Select day" name="day">
                                            <option value="">Day</option>
                                        </select>
                                    </div>
                                    <div class="col-4 position-relative">
                                        <select class="form-select" id="month" name="month" required data-msg="Select month">
                                            <option value="">Month</option>
                                        </select>
                                    </div>
                                    <div class="col-4 position-relative">
                                        <select class="form-select" id="year" name="year" required data-msg="Select year">
                                            <option value="">Year</option>
                                        </select>
                                    </div>
                                </div>

                                <label class="col-form-label mt-3 mb-1">Gender</label>
                                <div class="d-flex gap-2 position-relative" id="genderGroup">
                                    <label class="gender-option flex-fill"><span>Male</span>
                                        <input type="radio" name="gender" value="male" required data-msg="Select gender">
                                    </label>
                                    <label class="gender-option flex-fill"><span>Female</span>
                                        <input type="radio" name="gender" value="female" required data-msg="Select gender">
                                    </label>
                                    <label class="gender-option flex-fill"><span>Other</span>
                                        <input type="radio" name="gender" value="custom" required data-msg="Select gender">
                                    </label>
                                </div>
                                <label class="col-form-label mt-3 mb-1">Mobile or Email</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control mt-3" id="contact" placeholder="Mobile number or email address" name="email_or_mobile" required data-msg="Enter a valid mobile or email">
                                </div>
                                <label class="col-form-label mt-3 mb-1">Password</label>
                                <div class="position-relative">
                                    <div class="d-flex">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="New password" required minlength="6" data-msg="Enter at least 6 characters">
                                        <i class="fas fa-eye-slash" id="loginTogglePassword" style="margin:auto -30px; cursor: pointer;"></i>
                                    </div>
                                </div>

                                <p class="info-text">By clicking Sign Up, you agree to our Terms, Privacy Policy and Cookies Policy. You may receive SMS notifications from us and can opt out at any time.</p>
                                <button class=" signup-btn mt-3" type="submit">
                                    Sign Up
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-5 d-lg-none">{{--  d-lg-none PHONE MODE --}}
                    <!-- CARD -->
                    <div class="row justify-content-center w-100">
                        <div class="col-md-6" style="z-index: 1;">
                            <div class="auth-card p-4">
                                <div class="position-relative mb-4">
                                    <div class="stepper-line"></div>
                                    <div class="stepper-line-progress" id="lineProgress"></div>
                                </div>

                                <form id="regForm">
                                    <!-- STEP 1 -->
                                    <div class="step-box " id="step1">
                                        <div>
                                            <picture>
                                                <img src="{{asset('assets/images/background/5.jpg')}}" alt="">
                                            </picture>
                                        </div>
                                        <button type="button" class="signup-btn" onclick="validateStep1()">Get Started</button>
                                    </div>
                                    <!-- STEP 2 -->
                                    <div class="step-box" id="step2">
                                        <h4 class="">What's your name?</h4>
                                        <p class="text-muted mb-4">Enter the name you use in real life.</p>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="ms_firstName" placeholder="First Name" name="first_name">
                                                <p class="text-danger" id="ms_firstNameError"></p>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="ms_surname" placeholder="Surname" name="surname">
                                                <p class="text-danger" id="ms_surnameError"></p>
                                            </div>
                                        </div>
                                        <button type="button" class="signup-btn" onclick="validateStep2()">Next</button>
                                    </div>

                                    <!-- STEP 3 -->
                                    <div class="step-box" id="step3">
                                        <h4>What's your date of birth?</h4>
                                        <p class="text-muted mb-4">Choose your date of birth. You always make this private later.Why do I need to provide my date of birth?</p>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <input type="date" class="form-control mt-3 mb-2" id="ms_dob" name="date_of_birth" data-msg="Select date of Birth">
                                                <p class="text-danger" id="ms_dobError"></p>
                                            </div>
                                        </div>

                                        <button type="button" class="signup-btn mt-4" onclick="validateStep3()">Next</button>
                                    </div>

                                    <!-- STEP 4 -->
                                    <div class="step-box active" id="step4">
                                        <h4>What's your gender?</h4>

                                        <div class="row mt-3" id="ms_genderGroup">
                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="radio" name="ms_gender" value="male" data-msg="Select gender">
                                                        <label>Male</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" name="ms_gender" value="female" data-msg="Select gender">
                                                        <label>Female</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" name="ms_gender" value="custom" data-msg="Select gender">
                                                        <label>Other</label>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="radio" name="ms_gender" value="female" data-msg="Select gender">
                                                        <label>Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="radio" name="ms_gender" value="custom" data-msg="Select gender">
                                                        <label>Other</label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>

                                        <p class="text-danger" id="ms_genderError"></p>

                                        <button type="button" class="signup-btn mt-4" onclick="validateStep4()">Next</button>
                                    </div>

                                    <!-- STEP 5 -->
                                    <div class="step-box" id="step5">
                                        <h4 id="contactTitle">What's your mobile number?</h4>
                                         <p class="text-muted mb-4" id="contactInfo">Enter the mobile number on which you can be contacted. No one will see this on your profile.</p>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label id="contactLable">Mobile Number</label>
                                                <input type="text" class="form-control ms_contact_mobile" id="ms_contact" placeholder="Mobile" name="email_or_mobile">
                                                <p class="text-danger" style="margin-bottom:0;" id="ms_contactError"></p>
                                                <p class="text-muted" id="contactNote" >You may receive SMS notification from us.</p>
                                            </div>
                                            <div class="col-12">
                                                <label>Password</label>
                                                {{-- <input type="password" class="form-control" id="ms_password" placeholder="New password" data-msg="Enter at least 6 characters"> --}}
                                                <div class="d-flex">
                                                    <input type="password" class="form-control" id="ms_password" name="password" placeholder="New password" required minlength="6" data-msg="Enter at least 6 characters">
                                                    <i class="fas fa-eye-slash" id="msRegPassword" style="margin:auto -30px; cursor: pointer;"></i>
                                                </div>
                                                <p class="text-danger" id="ms_passwordError"></p>
                                            </div>
                                        </div>
                                        <button type="button" class="signup-btn mt-4" onclick="validateStep5()">Next</button>
                                        <button type="button" id="switchButton" class="signup-btn mt-4" value="1" onclick="switchContact(this)" >Sign up with email address</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javaScricpt')
    <script src="{{asset('assets/js/otpValidation.js')}}"></script>
    <script>


        // Clear errors on input and tooltip

        document.addEventListener('input', function(e) {

            const input = e.target;
            // Clear error message if input has a corresponding error element
            if (input.id.startsWith('ms_')) {
                const errorEl = document.getElementById(input.id + 'Error');
                if (errorEl) errorEl.textContent = '';
            }else{
                 clearAllTooltips();
            }
        });

        // hide tooltip immediately when user types or changes a field
        document.addEventListener('input', function(e) {
            const el = e.target;
            if (!(el instanceof HTMLInputElement || el instanceof HTMLTextAreaElement || el instanceof HTMLSelectElement)) return;
            // only act for fields inside the signup form
            if (!el.closest('#signupForm')) return;
            hideTooltip(el);
        });
        // Tooltip system
        function showTooltip(el, msg) {
            hideTooltip(el);
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip-custom';
            tooltip.innerText = msg;
            el.parentElement.style.position = 'relative';
            tooltip.style.position = 'absolute';
            tooltip.style.background = '#ff4747';
            tooltip.style.color = '#fff';
            tooltip.style.padding = '6px 10px';
            tooltip.style.borderRadius = '6px';
            tooltip.style.fontSize = '13px';
            tooltip.style.whiteSpace = 'nowrap';
            tooltip.style.top = '100%';
            tooltip.style.left = '0';
            tooltip.style.marginTop = '3px';
            tooltip.style.boxShadow = '0 2px 6px rgba(0,0,0,0.15)';
            el.parentElement.appendChild(tooltip);
            el.classList.add('is-invalid');
        }

        function hideTooltip(el) {
            const tooltip = el?.parentElement?.querySelector('.tooltip-custom');
            if (tooltip) tooltip.remove();
            el?.classList.remove('is-invalid');
        }



        function validateStep1() {
             goStep(2);
        }
        function validateStep2() {
            let data = {
                first_name: $("#ms_firstName").val(),
                surname: $("#ms_surname").val(),
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('register.step1') }}",
                method: "POST",
                data: data,
                success: function () {
                    goStep(3);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;

                    if (errors.first_name) {
                        $("#ms_firstNameError").text(errors.first_name[0]);
                    }
                    if (errors.surname) {
                        $("#ms_surnameError").text(errors.surname[0]);
                    }
                }
            });
        }
        function validateStep3() {
            let data = {
                date_of_birth: $("#ms_dob").val(),
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('register.step2') }}",
                method: "POST",
                data: data,
                success: function () {
                    goStep(4);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    $("#ms_dobError").text(errors.date_of_birth[0]);
                }
            });
        }
        function validateStep4() {
            let data = {
                gender: $("input[name='ms_gender']:checked").val(),
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('register.step3') }}",
                method: "POST",
                data: data,
                success: function () {
                    goStep(5);
                },
                error: function (xhr) {
                    $("#ms_genderError").text(xhr.responseJSON.errors.gender[0]);
                }
            });
        }
        function validateStep5() {
            var input_type = $('#ms_contact').attr('type');
            if(input_type=='email'){
                contact_type = 'Email Address';
            }else{
                contact_type = 'Mobile Number';
            }
            let data = {
                email_or_mobile: $("#ms_contact").val(),
                password: $("#ms_password").val(),
                contact_type: contact_type,
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('register.step4') }}",
                method: "POST",
                data: data,
                success: function () {
                    window.location.href = "{{ route('verify.otp') }}";
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;

                    if (errors.email_or_mobile) {
                        $("#ms_contactError").text(errors.email_or_mobile[0]);
                    }
                    if (errors.password) {
                        $("#ms_passwordError").text(errors.password[0]);
                    }
                }
            });
        }
        function switchContact(el) {

            var buttonVal = el.value;
            $('#ms_contact').val('');
            $('#ms_contactError').text('');
            $('#ms_passwordError').text('');
            if(buttonVal==1){
                el.innerHTML="Sign up with mobile number";
                $('#contactLable').text('Email Address');
                $('#ms_contact').attr('type','email');
                $('#ms_contact').attr('placeholder','Email Address');
                $('#contactTitle').text("What's your email address?");
                $('#contactInfo').text('Enter the email address on which you can be contacted. No one will see this on your profile.');
                $('#contactNote').text("You'll also receive emails from us and can opt out at any time.");
                el.value=2;
            }else{
                el.innerHTML="Sign up with email address";
                $('#contactLable').text('Mobile Number');
                $('#ms_contact').attr('type','text');
                $('#ms_contact').attr('placeholder','Mobile');
                $('#contactTitle').text("What's your mobile number?");
                $('#contactInfo').text('Enter the mobile number on which you can be contacted. No one will see this on your profile.');
                $('#contactNote').text('You may receive SMS notification from us.');
                el.value=1;
            }
        }
        function validateEmail(email) {
            var re =/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
            return re.test(email);
        }
        function validateMobile(mobile) {
            var cleaned = mobile.replace(/[\s\-()]/g,'');
            if(!cleaned) return false;
            if(cleaned[0]==='+'){
                cleaned = cleaned.slice(1);
            }
            if(!/^d{10,15}$/.test(cleaned)) return false;
            return true;
        }
        // Show Step
        function goStep(step){
            $(".step-box").removeClass("active");
            $("#step"+step).addClass("active");

            // $(".stepper-item").removeClass("active completed");

           /*  for (let i = 1; i <= step; i++) {
                if (i < step) $("#si"+i).addClass("completed");
                // else $("#si"+i).addClass("active");
            } */

            // $("#lineProgress").css("width", ((step-1)*25)+"%");
        }


        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById('signupForm');
            const daySel = document.getElementById('day');
            const monthSel = document.getElementById('month');
            const yearSel = document.getElementById('year');
            function clearAllTooltips() {
                form.querySelectorAll('.tooltip-custom').forEach(t => t.remove());
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            }
            // populate date selectors
            for (let d = 1; d <= 31; d++) daySel.innerHTML += `<option value="${d}">${d}</option>`;
            const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            months.forEach((m,i)=> monthSel.innerHTML += `<option value='${i+1}'>${m}</option>`);
            const currentYear = new Date().getFullYear();
            for (let y=currentYear; y>=1900; y--) yearSel.innerHTML += `<option value="${y}">${y}</option>`;



            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                clearAllTooltips();

                let valid = true;
                const day = parseInt(daySel.value);
                const month = parseInt(monthSel.value);
                const year = parseInt(yearSel.value);

                // Age validation
                if (day && month && year) {
                    const dob = new Date(year, month - 1, day);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const m = today.getMonth() - dob.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
                    if (age < 13) {
                        valid = false;
                        showTooltip(yearSel, "You must be at least 13 years old to sign up.");
                    }
                }

                if (!valid) return;

                const formData = new FormData(form);

                try {
                    const response = await fetch("{{ route('signup.validate') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (response.status === 422 && result.errors) {
                        Object.keys(result.errors).forEach(key => {
                            const el = form.querySelector(`[name="${key}"]`);
                            if (el) showTooltip(el, result.errors[key][0]);
                        });
                    } else if (result.status === 'success') {
                        form.submit();
                    } else {
                        alert('⚠ Something went wrong, please try again.');
                    }

                } catch (err) {
                    console.error(err);
                    alert("Server error. Please try again later.");
                }
            });

        });


    </script>
@endsection
