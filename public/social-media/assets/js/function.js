

//Blob Creation Function
function dataURItoBlob(dataURI) {
    // covert base64/URLencoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(",")[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(",")[1])
    else byteString = decodeURI(dataURI.split(",")[1])

    // separate out the mime file
    var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0]

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length)
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i)
    }
    return new Blob([ia], { type: mimeString })
}


//Image Cropping Function
function cropImage(inputObj, photo_gallery='', cropHeight=150, cropWidth=150, viewImgID='', minWidth=0, minHeight=0, maxWidth=0, maxHeight=0, allowedTypes=['image/jpeg', 'image/png', 'image/gif'], maxFileSize=15) {
    var modalHTML = `
        <div id="modal-example" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <div class="img-container">
                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
                <div class="uk-text-right uk-margin-small-top">
                    <button style="background:#4a4444!important;" class="button uk-button-default uk-modal-close" type="button">Cancel</button>
                    <button style="background:#4a4444!important;" class="button uk-button-secondary" id="crop" type="button">Save</button>
                </div>
            </div>
        </div>
    `;
    $('body').append(modalHTML);
    var files = inputObj.files;
    var oldInputImgId = inputObj.id;
    var $modal = UIkit.modal('#modal-example');
    var image = document.getElementById('image');
    var cropper;
    if (files && files.length > 0) {
        var file = files[0];

        // Check file size
        if (file.size > (maxFileSize * 1024 * 1024)) {
            alert('The file size exceeds the ' + maxFileSize + ' MB limit.');
            inputObj.value = '';
            return;
        }

        // Check MIME type
        if (!allowedTypes.includes(file.type)) {
            alert('Invalid file type. Only ' + allowedTypes.join(', ') + ' files are allowed.');
            inputObj.value = '';
            return;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function () {
                var imgWidth = img.width;
                var imgHeight = img.height;

                if (minWidth > 0 && maxWidth == 0) { maxWidth = minWidth; }
                if (minHeight > 0 && maxHeight == 0) { maxHeight = minHeight; }

                // Check image dimensions
                if (minWidth > 0 && (imgWidth < minWidth || imgHeight < minHeight)) {
                    alert('Image dimensions are too small. Minimum width and height are ' + minWidth + 'x' + minHeight + '.');
                    inputObj.value = '';
                    return;
                }
                if (maxWidth > 0 && (imgWidth > maxWidth || imgHeight > maxHeight)) {
                    alert('Image dimensions are too large. Maximum width and height are ' + maxWidth + 'x' + maxHeight + '.');
                    inputObj.value = '';
                    return;
                }

                image.src = e.target.result;
                $modal.show();

                cropper = new Cropper(image, {
                    aspectRatio: cropWidth / cropHeight,
                    viewMode: 2,
                    // preview: '.cropper-preview',
                    cropBoxResizable: false,
                    dragMode: 'move',
                });

                // Make sure Cropper and modal clean-up is done properly
                UIkit.util.on('#modal-example', 'hide', function () {
                    cropper.destroy();
                    cropper = null;
                });

                // Handle the crop button click
                document.getElementById('crop').addEventListener('click', function () {
                    var canvas = cropper.getCroppedCanvas({
                        width: cropWidth,
                        height: cropHeight,
                    });

                    console.log("Creating blob from canvas...");

                    canvas.toBlob(function (blob) {
                        if (!blob) {
                            console.log("Blob creation failed.");
                            // alert('Crop failed. Please try again.');
                            return;
                        }

                        console.log("Blob created successfully.");

                        var url = URL.createObjectURL(blob);
                        var reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function () {
                        var base64data = reader.result;
                        // Create FormData to send both original and cropped images
                        var formData = new FormData();
                        formData.append('thumbnail', base64data); // Cropped image
                        formData.append('original_image', file); // Original image
                        formData.append('photo_gallery', photo_gallery);
                            // Make AJAX request to Laravel backend
                        $.ajax({
                            url: '/social-media/upload-photo',  // Laravel route
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
                            },
                            success: function (response) {
                                console.log(response.data.thumbnail_url);

                                // You can handle response here, like showing the cropped image in the view
                                if (response.data.thumbnail_url)
                                {
                                    $(`#${viewImgID}`).show();
                                    $(`#${viewImgID}`).attr('src', response.data.thumbnail_url);
                                }

                                $modal.hide();  // Close the modal
                            },
                            error: function (xhr, status, error) {
                                console.error('Error uploading images:', error);
                            }
                        });
                            // console.log(base64data);

                            /* if (newInputID) {
                                $(`#${newInputID}`).val(base64data);
                            } else {
                                $(`#${oldInputImgId}`).val(base64data);
                            } */
                            // if (viewImgID != '') {
                            //     $(`#${viewImgID}`).show();
                            //     $(`#${viewImgID}`).attr('src', base64data);
                            // }


                            // $modal.hide(); // Close UIkit modal
                        };
                    }, 'image/jpeg');
                });

            };
        };
        reader.readAsDataURL(file);
    }
}


function completeFull_name(inputFieldsIds, showInputId) {
    // Split inputFieldsIds by '*' to get an array of IDs
    const inputFields = inputFieldsIds.split('*');

    // Array to store the values from each input field
    const nameParts = inputFields.map(id => document.getElementById(id)?.value || '');

    // Join the name parts with a space, filtering out any empty strings
    const fullName = nameParts.filter(part => part).join(' ');

    // Set the concatenated full name in the showInputId element
    const showInput = document.getElementById(showInputId);
    if (showInput) {
        showInput.value = fullName;
    }
}

let currentStep = 1;

// Function to handle form submission
function handleFormSubmit(stepNumber, formData) {
    $.ajax({
    url: `/social-media/submit-step/${stepNumber}`, // Backend route for each step
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        if (response.success) {
            // Update current step and load the next step
            currentStep = stepNumber + 1;
            $('#multi-step-form-container').html(response.html);
            UIkit.notification({message: 'Saved successfully!', status: 'success'});
            // console.log(currentStep);
            if (stepNumber == 4) {
                location.reload();
            }

        } else {
            // Show validation errors
            showValidationErrors(response.errors);
        }
    },
    error: function(xhr) {
        console.error('Form submission error:', xhr.responseText);
    }
    });
}

// Function to handle back button click
function handleBackButton(stepNumber) {
    $.ajax({
    url: `/social-media/load-step/${stepNumber - 1}`, // Route to load the previous step
    type: 'GET',
    success: function(response) {
        if (response.success) {
            // Update current step and load the previous step
            currentStep = stepNumber - 1;
            $('#multi-step-form-container').html(response.html);
        }
    },
    error: function(xhr) {
        if (xhr.status === 422) { // Validation error
            showValidationErrors(xhr.responseJSON.errors); // Call the error function with the errors
        } else {
            // Handle other errors (optional)
            UIkit.notification({message: 'An unexpected error occurred.', status: 'danger'});
        }
    }
    });
}

function showValidationErrors(errors)
{
    $('.uk-text-danger').text('');
    for (const [key, value] of Object.entries(errors)) {
        const inputField = $(`[name="${key}"]`);
        inputField.next('.uk-text-danger').text(value[0]);
    }
}

// Event listeners for form submissions
$(document).on('submit', 'form', function(event) {
    event.preventDefault(); // Prevent normal form submission

    // Get the current step number
    const stepNumber = $(this).data('step');
    // Create FormData object from form
    const formData = new FormData(this);

    // Call the submit handler
    handleFormSubmit(stepNumber, formData);
});

// Event listener for back button
$(document).on('click', '#back-button', function() {
    // Call the back handler
    handleBackButton(currentStep);
});




//     if (files && files.length > 0) {
//         var file = files[0];

//         // Check file size
//         if (file.size > (maxFileSize * 1024 * 1024)) {
//             alert('The file size exceeds the ' + maxFileSize + ' MB limit.');
//             inputObj.value = '';
//             return;
//         }

//         // Check MIME type
//         if (!allowedTypes.includes(file.type)) {
//             alert('Invalid file type. Only ' + allowedTypes.join(', ') + ' files are allowed.');
//             inputObj.value = '';
//             return;
//         }

//         var reader = new FileReader();
//         reader.onload = function (e) {
//             var img = new Image();
//             img.src = e.target.result;

//             img.onload = function () {
//                 var imgWidth = img.width;
//                 var imgHeight = img.height;

//                 if (minWidth > 0 && maxWidth == 0) { maxWidth = minWidth; }
//                 if (minHeight > 0 && maxHeight == 0) { maxHeight = minHeight; }

//                 // Check image dimensions
//                 if (minWidth > 0 && (imgWidth < minWidth || imgHeight < minHeight)) {
//                     alert('Image dimensions are too small. Minimum width and height are ' + minWidth + 'x' + minHeight + '.');
//                     inputObj.value = '';
//                     return;
//                 }
//                 if (maxWidth > 0 && (imgWidth > maxWidth || imgHeight > maxHeight)) {
//                     alert('Image dimensions are too large. Maximum width and height are ' + maxWidth + 'x' + maxHeight + '.');
//                     inputObj.value = '';
//                     return;
//                 }

//                 image.src = e.target.result;
//                 $modal.show();

//                 cropper = new Cropper(image, {
//                     aspectRatio: cropWidth / cropHeight,
//                     viewMode: 2,
//                     cropBoxResizable: false,
//                     dragMode: 'move',  // Enable image moving
//                 });

//                 UIkit.util.on('#modal-example', 'hide', function () {
//                     cropper.destroy();
//                     cropper = null;
//                 });

//                 document.getElementById('crop').addEventListener('click', function () {
//                     var canvas = cropper.getCroppedCanvas({
//                         width: cropWidth,
//                         height: cropHeight,
//                     });


//                     canvas.toBlob(function (croppedBlob) {
//                         if (!croppedBlob) {
//                             alert('Crop failed. Please try again.');
//                             return;
//                         }

//                         // Create FormData to send both original and cropped images
//                         var formData = new FormData();
//                         formData.append('cropped_image', croppedBlob, 'cropped.jpg'); // Cropped image
//                         formData.append('original_image', file); // Original image

//                         // Make AJAX request to Laravel backend
//                         $.ajax({
//                             url: '/social-media/upload-photo',  // Laravel route
//                             method: 'POST',
//                             data: formData,
//                             contentType: false,
//                             processData: false,
//                             headers: {
//                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
//                             },
//                             success: function (response) {
//                                 console.log(response);

//                                /*  // You can handle response here, like showing the cropped image in the view
//                                 if (viewImgID != '') {
//                                     $(`#${viewImgID}`).show();
//                                     $(`#${viewImgID}`).attr('src', response.cropped_image_url); // Assume the response contains URLs for the images
//                                 } */

//                                 $modal.hide();  // Close the modal
//                             },
//                             error: function (xhr, status, error) {
//                                 console.error('Error uploading images:', error);
//                                 alert('Image upload failed. Please try again.');
//                             }
//                         });
//                     }, 'image/jpeg');
//                 });
//             };
//         };
//         reader.readAsDataURL(file);
//     }
// }




// Upload image Preview
let loadFile = function(event,previewClass) {
    var output = document.getElementById(previewClass);
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};


function loadDropDown(routeUrl, data, containerId) {
    $.ajax({
        url: routeUrl,
        method: 'GET',
        data: "data="+data,
        success: function(response) {
            // console.log(containerId);

            $('#' + containerId).html(response);
            // set_all_onclick();
        },
        error: function(xhr, status, error) {
            // Handle any errors here
            console.error("There was an error loading the dropdown:", error);
        }
    });
}

function loadHtmlElement(routeUrl, data, containerId) {
    $.ajax({
        url: routeUrl,
        method: 'GET',
        data: "data="+data,
        success: function(response) {
            // console.log(response);
            $('#' + containerId).html(response);
        },
        error: function(xhr, status, error) {
            // Handle any errors here
            console.error("There was an error loading:", error);
        }
    });
}
function loadHtmlElement_multiple(routeUrl, data, inputIds,columnNames) {
    splitInputIds   = inputIds.split('*');
    splitcolumnName = columnNames.split('*');
    if (splitInputIds.length != splitcolumnName.length) {
        console.error("Input IDs and column names do not match in length.");
        return;
    }
    $.ajax({
        url: routeUrl,
        method: 'GET',
        data: "data="+data,
        success: function(responseJSON) {
            for (let i = 0; i < splitInputIds.length; i++) {
                let InputId     = splitInputIds[i];
                let columnName  = splitcolumnName[i];
                let value       = responseJSON[columnName] || ''; 
                // console.log(`Setting value for ${InputId}: ${value}`);
                $(`#${InputId}`).val(value);
            }
        },
        error: function(xhr, status, error) {
            console.error("There was an error loading:", error);
        }
    });
}

function handleCheckboxClick(input)
{
    inputdescriptionLink = input.dataset.descriptionLink;
    if (input.checked) {
        $('#checkboxError').html('');
        window.open(inputdescriptionLink, 'blank');
    }
}
function getPaymentComponent(method,routeUrl, data, containerId,checked=false)
{
    // $('#checkboxError').html('');
    // console.log(method,routeUrl, data, containerId,$('#cbox').prop('checked'));
    // checked_status = checked ?? $('#cbox').prop('checked');
    if(!checked)
    {
        if ($('.link-checkbox:checked').length === $('.link-checkbox').length) {
           checked=true;
        } else {
            checked=false;
        }
    }
    checked_status = checked ;

    if (checked_status==1)
    {
        if(method==1)
        {
            // redirect to payment page but not open in new tab
            window.location.href = routeUrl;
            return;
        }
        else if(method==2)
        {
            data1 = "'"+data+"*"+method+"'";
            // console.log(routeUrl, data1, containerId);
            loadHtmlElement(routeUrl, data1, containerId);
            $('#package_container').css('display', 'none');

        }
        else
        {
            $('#checkboxError').html('Payment method not available');
            return;
        }
    }
    else
    {
        $('#checkboxError').html('Please checked first');
    }
}
function getNotifications() {
    $.ajax({
        url: "/social-media/get-notifications",
        type: "GET",
        success: function (response)
        {
            // console.log(response);
            splitData   = response.split('**');
            $('#unread_notification').html(splitData[0]);
            $('#notification_list').html(splitData[1]);

        }
    });


}
setInterval(getNotifications, 30000);//30000 milliseconds = 30 seconds

function readNotification() {
    let unReadNotification = $('#unread_notification').html()*1;
    if (unReadNotification) {
        $.ajax({
            url: "/social-media/read-notification",
            type: "get",
            success: function (response)
            {
                getNotifications();
            }
        });
    }
    else
    {
        getNotifications();
    }
}

function submitPayment() {
    // Create a FormData object to handle file uploads
    let formData = new FormData($('#payment-form')[0]);

    $.ajax({
        url: $('#payment-form').attr('action'), // Form action URL
        type: 'POST',
        data: formData, // Send the FormData object
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting the Content-Type header
        success: function (response) {
            if (response.success) {
                document.location.href="/"
                UIkit.notification({message: 'Submited successfully!', status: 'success'});
                // $('#payment-form')[0].reset(); // Reset form after success
                // $('#imgOutput').attr('src', ''); // Clear image preview

            }
        },
        error: function (xhr) {
            // Clear previous errors
            $('.uk-text-danger').text('');

            if (xhr.responseJSON && xhr.responseJSON.errors) {
                // Display validation errors
                $.each(xhr.responseJSON.errors, function (key, value) {
                    $('#' + key + '_error').text(value[0]);
                });
            }
        }
    });
}

function showHidePaymetInput(inputElement){
    if (inputElement.value == '1') {
        $('#payment_input').css('display', 'block');
    } else {
        $('#payment_input').css('display', 'none');
    }
}
$('#payment_type').on('change', function() {
    if (this.value == '1') {
        if ($('#branch-container')) {
            $('#branch-container').css('display', 'block');
        }
    }
    if (this.value == '2') {
        if ($('#branch-container')) {
            $('#branch-container').css('display', 'none');
        }
    }
  })
//====================================================================================================
                                // INPUT VALIDATION SCRIPTS START
//====================================================================================================

function allowNumbersOnly(inputElement) {
    let value = $(inputElement).val();
    // Remove invalid characters (anything except 0-9 and .)
    let validValue = value.replace(/[^0-9.]/g, '');
    // Ensure only one decimal point
    validValue = validValue.replace(/(\..*)\./g, '$1');
    $(inputElement).val(validValue);
}

function validateBangladeshiPhoneNumber(phoneNumber) {
    // Regular expression to match Bangladeshi phone number format
    const regex = /^(01[3-9]\d{8})$/;
    return regex.test(phoneNumber);
}

function validateEmailAddress(email) {
    // Regular expression to validate email format
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function capitalizeText(text) {
    return text.replace(/\b\w/g, function (char) {
        return char.toUpperCase();
    });
}
function textBoxes(inputElement) {
    return $(inputElement).val().trimStart().replace(/\s+/g, ' ').replace(/[^a-zA-Z\s-.;,]/g, '','-');

}

$(function() {

    $(document).on('input', '.text_boxes', function() {
        let validValue = textBoxes(this)
        $(this).val(validValue);
    });
    $(document).on('input', '.text_boxes_uppercase', function() {
        let validValue = textBoxes(this)
        $(this).val(validValue.toUpperCase());
    });

    $(document).on('input', '.text_boxes_numeric', function() {
        allowNumbersOnly(this);
    });

    $(document).on('input', '.phone-input', function() {
        let  phoneNumber = $(this).val();
        if (phoneNumber.length > 11) {
            phoneNumber = phoneNumber.slice(0, 11);
            $(this).val(phoneNumber);
        }
        if (validateBangladeshiPhoneNumber(phoneNumber)) {
            $(this).removeClass('uk-form-danger');
        } else {
            $(this).addClass('uk-form-danger');
        }
    });

    $(document).on('input', '.email-input', function() {
        const email = $(this).val();
        if (validateEmailAddress(email)) {
            $(this).removeClass('uk-form-danger');
        } else {
            $(this).addClass('uk-form-danger');
        }
    });
});
//====================================================================================================
                                    //INPUT VALIDATION SCRIPTS END
//====================================================================================================
function controlBankBranch(paymentType) {
    console.log(paymentType);

    if (paymentType == 1) { // If payment type is bank transfer
        $('.only-for-bank').attr('style', 'display: block;');

    } else {
        $('.only-for-bank').attr('style', 'display: none;');
    }
}
