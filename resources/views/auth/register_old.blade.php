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
        :root {
            --pink: #ee0979;

        }

        /* Card */
        .form-card {
            background: #fff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        }
        /* Step Bar (TOP) */
        .stepper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .stepper-item {
            text-align: center;
            width: 33%;
            color: white;
        }

        .stepper-item .circle {
            width: 30px;
            height: 30px;
            border-radius: 30px;
            background: white;
            color:  var(--pink);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-weight: bold;
        }

        .stepper-item.active .circle {
            background: var(--pink);
            color: white;
        }

        .stepper-item.completed .circle {
            background: var(--pink);
            color: white;
        }

        .stepper-item .label {
            margin-top: 8px;
            font-size: 11px;
            /* letter-spacing: 1px; */
        }

        /* Line between steps */
        .stepper-line {
            position: absolute;
            top: 35px;
            left: 10%;
            width: 80%;
            height: 3px;
            background: rgba(255,255,255,0.7);
            z-index: -1;
        }

        .stepper-line-progress {
            position: absolute;
            top: 35px;
            left: 10%;
            width: 0%;
            height: 3px;
            background: var(--pink);
            z-index: -1;
            transition: width .3s ease;
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

                <div class="row justify-content-center d-none d-lg-flex">{{-- DESKTOP MODE --}}
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

                                <div class="position-relative">
                                    <input type="text" class="form-control mt-3" id="contact" placeholder="Mobile number or email address" name="email_or_mobile" required data-msg="Enter a valid mobile or email">
                                </div>

                                <div class="position-relative">
                                    <input type="password" class="form-control mt-3" id="password" name="password" placeholder="New password" required minlength="6" data-msg="Enter at least 6 characters">
                                </div>

                                <p class="info-text">By clicking Sign Up, you agree to our Terms, Privacy Policy and Cookies Policy. You may receive SMS notifications from us and can opt out at any time.</p>
                                <button class=" signup-btn mt-3" type="submit">
                                    Sign Up
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-5 d-lg-none">{{-- PHONE MODE --}}
                    <!-- CARD -->
                    <div class="row justify-content-center w-100">
                        <div class="col-md-6" style="z-index: 1;">
                            <div class="auth-card p-4">
                                <div class="position-relative mb-4">
                                    <div class="stepper-line"></div>
                                    <div class="stepper-line-progress" id="lineProgress"></div>
                                </div>

                                <div class="stepper">
                                    <div class="stepper-item completed" id="si1">
                                        <div class="circle">1</div>
                                        <div class="label">PERSONAL DETAILS</div>
                                    </div>

                                    <div class="stepper-item" id="si2">
                                        <div class="circle">2</div>
                                        <div class="label">DATE OF BIRTH</div>
                                    </div>

                                    <div class="stepper-item" id="si3">
                                        <div class="circle">3</div>
                                        <div class="label">GENDER</div>
                                    </div>

                                    <div class="stepper-item" id="si4">
                                        <div class="circle">4</div>
                                        <div class="label">CONTACT</div>
                                    </div>
                                </div>
                                <form id="regForm">
                                    <!-- STEP 1 -->
                                    <div class="step-box active" id="step1">
                                        <h4 class="text-center">PERSONAL DETAILS</h4>
                                        <p class="text-center text-muted mb-4">Tell us something more about you</p>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" class="form-control" id="ms_firstName" placeholder="First Name" name="first_name">
                                                <p class="text-danger" id="ms_firstNameError"></p>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control" id="ms_surname" placeholder="Surname" name="surname">
                                                <p class="text-danger" id="ms_surnameError"></p>
                                            </div>
                                        </div>
                                        <button type="button" class="next-btn float-end" onclick="validateStep1()">Next</button>
                                    </div>

                                    <!-- STEP 2 -->
                                    <div class="step-box" id="step2">
                                        <h4 class="text-center">DATE OF BIRTH</h4>
                                        <p class="text-center text-muted mb-4">Select your date of birth</p>

                                        <input type="date" class="form-control mb-2" id="ms_dob" name="date_of_birth" data-msg="Select date of Birth">
                                        <p class="text-danger" id="ms_dobError"></p>

                                        <button type="button" class="back-btn mt-4" onclick="goStep(1)">Back</button>
                                        <button type="button" class="next-btn float-end mt-4" onclick="validateStep2()">Next</button>
                                    </div>

                                    <!-- STEP 3 -->
                                    <div class="step-box" id="step3">
                                        <h4 class="text-center">GENDER</h4>

                                        <div class="d-flex gap-2 position-relative" id="ms_genderGroup">
                                            <label class="gender-option flex-fill"><span>Male</span>
                                                <input type="radio" name="ms_gender" value="male" data-msg="Select gender">
                                            </label>
                                            <label class="gender-option flex-fill"><span>Female</span>
                                                <input type="radio" name="ms_gender" value="female" data-msg="Select gender">
                                            </label>
                                            <label class="gender-option flex-fill"><span>Other</span>
                                                <input type="radio" name="ms_gender" value="custom" data-msg="Select gender">
                                            </label>
                                        </div>

                                        <p class="text-danger" id="ms_genderError"></p>

                                        <button type="button" class="back-btn mt-4" onclick="goStep(2)">Back</button>
                                        <button type="button" class="next-btn float-end mt-4" onclick="validateStep3()">Next</button>
                                    </div>

                                    <!-- STEP 4 -->
                                    <div class="step-box" id="step4">
                                        <h4 class="text-center">CONTACT DETAILS</h4>

                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" class="form-control mt-4" id="ms_contact" placeholder="Mobile or Email" name="email_or_mobile" data-msg="Enter a valid mobile or email">
                                                <p class="text-danger" id="ms_contactError"></p>
                                            </div>
                                            <div class="col-12">
                                                <input type="password" class="form-control mt-3" id="ms_password" placeholder="New password" data-msg="Enter at least 6 characters">
                                                <p class="text-danger" id="ms_passwordError"></p>
                                            </div>
                                        </div>

                                        <button type="button" class="back-btn mt-4" onclick="goStep(3)">Back</button>
                                        <button type="button" class="next-btn float-end mt-4" onclick="validateStep4()">Next</button>
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

        function clearAllTooltips() {
            form.querySelectorAll('.tooltip-custom').forEach(t => t.remove());
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        }

        function validateStep1() {
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
                    goStep(2);
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
        function validateStep2() {
            let data = {
                date_of_birth: $("#ms_dob").val(),
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('register.step2') }}",
                method: "POST",
                data: data,
                success: function () {
                    goStep(3);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    $("#ms_dobError").text(errors.date_of_birth[0]);
                }
            });
        }
        function validateStep3() {
            let data = {
                gender: $("input[name='ms_gender']:checked").val(),
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('register.step3') }}",
                method: "POST",
                data: data,
                success: function () {
                    goStep(4);
                },
                error: function (xhr) {
                    $("#ms_genderError").text(xhr.responseJSON.errors.gender[0]);
                }
            });
        }
        function validateStep4() {
            let data = {
                email_or_mobile: $("#ms_contact").val(),
                password: $("#ms_password").val(),
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

        // Show Step
        function goStep(step){
            $(".step-box").removeClass("active");
            $("#step"+step).addClass("active");

            $(".stepper-item").removeClass("active completed");

            for (let i = 1; i <= step; i++) {
                if (i < step) $("#si"+i).addClass("completed");
                else $("#si"+i).addClass("active");
            }

            $("#lineProgress").css("width", ((step-1)*25)+"%");
        }


        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById('signupForm');
            const daySel = document.getElementById('day');
            const monthSel = document.getElementById('month');
            const yearSel = document.getElementById('year');

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
