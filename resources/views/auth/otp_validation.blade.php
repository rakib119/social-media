@php
    $data = DB::table('genarel_infos')->select('field_name','value')->get();
    $dataArray = array();
    foreach ($data as $v)
    {
        $dataArray[$v->field_name] = $v->value;
    }
    extract($dataArray);

    $logo           = asset('assets/images/info/'.$logo);
    $favicon        = asset('assets/images/info/'.$favicon);
    $logo_white     = asset('assets/images/info/'.$logo_white);
    $signup_payload = session('signup_payload');
    $contact_type   = isset($signup_payload['contact_type']) ?$signup_payload['contact_type'] : 'Email or Mobile';
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
                            <h2>Verify Your {{$contact_type}}</h2>
                            <p class="mb-3">A one-time password (OTP) has been sent to your {{$contact_type}}. Enter the OTP below to verify your contact and complete the signup process.</p>
                            <hr>

                            <form method="POST" action="{{ route('register') }}" class="position-relative" id="otpValidateForm" novalidate>
                                @csrf
                                <label class="col-form-label mt-3 mb-1">OTP</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control mb-2" id="otp" placeholder="one-time password (OTP)" name="otp" required data-msg="Enter a your OTP">
                                </div>
                                <button class=" signup-btn mt-3" type="submit"> Confirm Otp </button>
                            </form>


                            <form class="d-inline" method="POST" action="{{ route('otp.resend') }}">
                                @csrf
                                <p class="info-text">Before proceeding, please check your {{$contact_type}} for a verification OTP. If you did not receive the OTP
                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                                </p>
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
            const form = document.getElementById('otpValidateForm');
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
                const formData = new FormData(form);
                try {
                    const response = await fetch("{{ route('validate.otp') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();
                    console.log(result);

                    if (result.status=='error') {

                        const el = form.querySelector(`[name="otp"]`);
                        if (el) showTooltip(el, result.otp);

                    } else if (result.status == 'success') {
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
