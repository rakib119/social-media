
// Email Verification
function validateEmail() {
    let email       = $('#email').val();
    let name        = $('#name').val();
    let messageDiv  = $('#otp-sending-message');
    let otpInput    = $('#email_verification_box');
    let otpBtn      = $('#otp-email-sending-btn');
    let otpBtnText  = $('#otp-email-sending-btn-html');
    let email_otp   = $('#email-otp');

    // Basic Email Validation using regular expression
    let emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    if (emailRegex.test(email)) {
        // Email is valid, now send AJAX request to verify

        // Disable the button while sending OTP
        otpBtn.prop('disabled', true);
        otpBtnText.text("Sending OTP...");

        // Send AJAX request to backend to send OTP
        $.ajax({
            url: "/send-email-otp", // Laravel route for sending OTP
            type: "POST",
            data: { email: email, name: name },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
            },
            success: function(response) {
                if (response.success) {
                    otpInput.val('');
                    email_otp.val('');
                    otpInput.removeClass('d-none');
                    // verifyBtn.removeClass('d-none');

                    // Update button text to "OTP Sent" and keep it disabled
                    otpBtnText.text("OTP Sent");
                    otpBtn.prop('disabled', true);

                        setTimeout(function() {
                            if (otpBtnText.text()!='Verified')
                            {
                                // Update button text and enable it
                                otpBtnText.text("Resend OTP");
                                otpBtn.prop('disabled', false);
                            }
                        }, 30000); //30sec


                } else {
                    messageDiv.html(response.message).css("color", "red");
                    otpInput.addClass('d-none');
                    // verifyBtn.addClass('d-none');
                    clearValidatorMsg('otp-sending-message');
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    if (errors && errors.email) {
                        messageDiv.html(errors.email[0]).css("color", "red");
                    }
                } else {
                    messageDiv.html("Error sending OTP. Please try again.").css("color", "red");
                }

                // Hide OTP fields in case of error
                otpInput.addClass('d-none');
                // verifyBtn.addClass('d-none');
                clearValidatorMsg('otp-sending-message');
            }
        });

    } else {
        // Invalid email format
        messageDiv.html("Please enter a valid email address.").css("color", "red");

        // Hide OTP input and verify button
        otpInput.addClass('d-none');
        clearValidatorMsg('otp-sending-message');
    }
}
function validateEmailOtp() {
    let enteredOtp      = $('#email-otp').val();
    let messageDiv      = $('#email_otp_error');
    let otpStatus       = $('#otp-sending-message');
    let verifyBtn       = $('#verifyBtn');
    let verifyBtnText   = $('#verifyBtnText');
    let otpInput        = $('#email_verification_box');
    let otpBtnText      = $('#otp-email-sending-btn-html');
    let phnNmbrContainer= $('#phnNmbrContainer');

    if (!enteredOtp) {
        messageDiv.html("Please enter the OTP").css("color", "red");
        return;
    }

    // Disable the button and show verifying state
    verifyBtn.prop('disabled', true);
    verifyBtnText.fadeOut(200, function() {
        $(this).text("Verifying...").fadeIn(200);
    });

    $.ajax({
        url: '/verify-email-otp', // Laravel route handling the OTP verification
        type: 'POST',
        data: {
            otp: enteredOtp
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                otpStatus.html(response.message).css("color", "green");

                // Optionally hide the OTP input (or disable it)
                otpBtnText.text("Verified");
                $('#email').prop('disabled', true);
                otpInput.addClass('d-none');
                phnNmbrContainer.removeClass('d-none');
                otpInput.val('');
                setTimeout(function() {
                    otpStatus.html('').css("", "");
                    otpBtn.prop('disabled', false);

                }, 5000); //30sec
            } else {
                messageDiv.html(response.message).css("color", "red");

                // Re-enable the button for another try
                verifyBtn.prop('disabled', false);
                verifyBtnText.fadeOut(200, function() {
                    $(this).text("Confirm").fadeIn(200);
                });
            }
        },
        error: function(xhr, status, error) {
            messageDiv.html("Something went wrong. Please try again.").css("color", "red");

            // Re-enable the button on error
            verifyBtn.prop('disabled', false);
            verifyBtnText.fadeOut(200, function() {
                $(this).text("Confirm").fadeIn(200);
            });
        }
    });
}
// Mobile Verification
function validateMobileNumber() {
    let phone       = $('#phone').val();
    let name        = $('#name').val();
    let messageDiv  = $('#phone-otp-sending-message');
    let otpInput    = $('#phone_verification_box');
    let otpBtn      = $('#otp-phone-sending-btn');
    let otpBtnText  = $('#otp-phone-sending-btn-html');
    let phoneOtp    = $('#phone-otp');

    // Basic phone Validation using regular expression
    let phoneRegex = /^(?:\+88|88)?01[3-9]\d{8}$/;

    if (phoneRegex.test(phone)) {
        // phone is valid, now send AJAX request to verify

        // Disable the button while sending OTP
        otpBtn.prop('disabled', true);
        otpBtnText.text("Sending OTP...");

        // Send AJAX request to backend to send OTP
        $.ajax({
            url: "/send-phone-otp", // Laravel route for sending OTP
            type: "POST",
            data: { phone: phone, name: name },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
            },
            success: function(response) {
                if (response.success) {
                    otpInput.removeClass('d-none');
                    // verifyBtn.removeClass('d-none');
                    phoneOtp.val('');
                    // Update button text to "OTP Sent" and keep it disabled
                    otpBtnText.text("OTP Sent");
                    otpBtn.prop('disabled', true);

                        setTimeout(function() {
                            if (otpBtnText.text()!='Verified')
                            {
                                // Update button text and enable it
                                otpBtnText.text("Resend OTP");
                                otpBtn.prop('disabled', false);
                            }
                        }, 30000); //30sec


                } else {
                    messageDiv.html(response.message).css("color", "red");
                    otpInput.addClass('d-none');
                    // verifyBtn.addClass('d-none');
                    clearValidatorMsg('phone-otp-sending-message');
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    if (errors && errors.phone) {
                        messageDiv.html(errors.phone[0]).css("color", "red");
                    }
                } else {
                    messageDiv.html("Error sending OTP. Please try again.").css("color", "red");
                }

                // Hide OTP fields in case of error
                otpInput.addClass('d-none');
                // verifyBtn.addClass('d-none');
                clearValidatorMsg('phone-otp-sending-message');
            }
        });

    } else {
        // Invalid phone format
        messageDiv.html("Please enter a valid phone number.").css("color", "red");

        // Hide OTP input and verify button
        otpInput.addClass('d-none');
        clearValidatorMsg('phone-otp-sending-message');
    }
}
function validateMobileOtp() {
    let enteredOtp      = $('#phone-otp').val();
    let messageDiv      = $('#phone_otp_error');
    let otpStatus       = $('#phone-otp-sending-message');
    let verifyBtn       = $('#verifyBtn');
    let verifyBtnText   = $('#verifyBtnText');
    let otpInput        = $('#phone_verification_box');
    let otpBtnText      = $('#otp-phone-sending-btn-html');
    let submitBtn       = $('#submitBtnContainer');

    if (!enteredOtp) {
        messageDiv.html("Please enter the OTP").css("color", "red");
        clearValidatorMsg('phone_otp_error');
        return;
    }

    // Disable the button and show verifying state
    verifyBtn.prop('disabled', true);
    verifyBtnText.fadeOut(200, function() {
        $(this).text("Verifying...").fadeIn(200);
    });

    $.ajax({
        url: '/verify-phone-otp', // Laravel route handling the OTP verification
        type: 'POST',
        data: {
            otp: enteredOtp
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                otpStatus.html(response.message).css("color", "green");

                // Optionally hide the OTP input (or disable it)
                otpBtnText.text("Verified");
                $('#phone').prop('disabled', true);
                otpInput.addClass('d-none');
                submitBtn.removeClass('d-none');
                setTimeout(function() {
                    otpStatus.html('').css("", "");
                    otpBtn.prop('disabled', false);

                }, 5000); //30sec
            } else {
                messageDiv.html(response.message).css("color", "red");

                // Re-enable the button for another try
                verifyBtn.prop('disabled', false);
                verifyBtnText.fadeOut(200, function() {
                    $(this).text("Confirm").fadeIn(200);
                });
                clearValidatorMsg('phone_otp_error');
            }
        },
        error: function(xhr, status, error) {
            messageDiv.html("Something went wrong. Please try again.").css("color", "red");

            // Re-enable the button on error
            verifyBtn.prop('disabled', false);
            verifyBtnText.fadeOut(200, function() {
                $(this).text("Confirm").fadeIn(200);
            });
            clearValidatorMsg('phone_otp_error');
        }
    });
}

function clearValidatorMsg(elementId){
    setTimeout(function() {
        $('#'+elementId).html('').css("", "");
    }, 10000);//10s
}

$('#NewTogglePassword').click(function() {
    var icon = $("#NewTogglePassword");
    var passInput = $("#newPassword");
    if (passInput.attr('type') === 'password') {
        passInput.attr('type', 'text');
        icon.removeClass('fa-eye-slash');
        icon.addClass('fa-eye');
    } else {
        passInput.attr('type', 'password');
        icon.removeClass('fa-eye');
        icon.addClass('fa-eye-slash');
    }
});
$('#confirmTogglePassword').click(function() {
    var icon      = $("#confirmTogglePassword");
    var passInput = $("#confirmPassword");
    if (passInput.attr('type') === 'password') {
        passInput.attr('type', 'text');
        icon.removeClass('fa-eye-slash');
        icon.addClass('fa-eye');
    } else {
        passInput.attr('type', 'password');
        icon.removeClass('fa-eye');
        icon.addClass('fa-eye-slash');
    }
});
$('#confirmPassword').keyup(function() {
    var newPassword = $("#newPassword").val();
    var confirmPassword = $(this).val();
    if (newPassword) {
        if (newPassword != confirmPassword) {
            $('#confirmPasswordError').html("Password doesn't matched");
        } else {
            $('#confirmPasswordError').html("");
            $('#newPasswordError').html("");
        }
    } else {
        $('#confirmPasswordError').html("Please set a new password first");
    }
    clear_pass_error();
});

$('#newPassword').keyup(function() {
    var confirmPassword = $("#confirmPassword").val();
    var newPassword = $(this).val();
    if (confirmPassword) {
        if (newPassword != confirmPassword) {
            $('#newPasswordError').html("password doesn't matched");
        } else {
            $('#confirmPasswordError').html("");
            $('#newPasswordError').html("");
        }
    }
    clear_pass_error();
});

$('#loginTogglePassword').click(function() {
    var icon = $("#loginTogglePassword");
    var passInput = $("#password");
    if (passInput.attr('type') === 'password') {
        passInput.attr('type', 'text');
        icon.removeClass('fa-eye-slash');
        icon.addClass('fa-eye');
    } else {
        passInput.attr('type', 'password');
        icon.removeClass('fa-eye');
        icon.addClass('fa-eye-slash');
    }
});

function clear_pass_error(){
    var newPassword     = $('#newPassword').val();
    var confirmPassword = $('#confirmPassword').val();

    if (!newPassword && !confirmPassword)
    {
        $('#confirmPasswordError').html("");
        $('#newPasswordError').html("");
    }
}

