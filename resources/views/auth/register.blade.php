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
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.min.css') }}"> --}}
    <style>


    /* @media (max-width: 767px) {
        .desktop-only {
            display: none;
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
    }
    @media (min-width: 768px) {
        .mobile-only {
            display: none;
        }
    } */
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
                <div class="row justify-content-center">
                    <div class="auth-logo">
                        <div id="logo">
                            <a href="{{ route('home')}}"> <img src="{{ $logo }}" alt="{{ $web_title }}"></a>
                        </div>
                    </div>
                    <div class="col-md-6" style="z-index: 1;">
                        <div class="auth-card p-4">
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
            </div>
        </div>
    </section>
@endsection

@section('javaScricpt')
    <script>
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
