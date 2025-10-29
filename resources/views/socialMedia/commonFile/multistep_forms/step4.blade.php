@php
    $userinfo = DB::table('user_infos')->where('user_id',auth()?->id())->first();
    $userinfoArray = (array)$userinfo;
    extract($userinfoArray); //Array to variable
    $verification_type_arr  = explode(',',$verification_type);
    $religionArray      = session('religionArray');
    $professionArray    = session('professionArray');
    $country_arr        = session('country_arr');
    $division_arr       = session('division_arr');
    $district_arr       = session('district_arr');
    $upazila_arr        = session('upazila_arr');
@endphp
<div class="p-3">
    <div class="p-4">
        <div style="display:flex; justify-content:space-between">
            <h2>Verify Account</h2>
            @if ($final_info_approved_at)
                <a class="button info" href="{{ route('generatePDF',Crypt::encrypt(auth()->id())) }}">Download Now<i class="icon-feather-download-cloud"></i> </a>
            @elseif ($is_final_submited==1)
                <a class="button info"  href="javaScript:void(0)">Pending <i class="icon-feather-alert-circle"></i> </a>
            @endif
        </div>

    </div>
    @if ($final_info_approved_at)
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading text-success">Your information is approved!</h4>
            <p class="text-success">You can download your information.Click download now. </p>

        </div>
    @elseif ($is_final_submited==1 && $final_info_approved_at==null)
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading text-success">Your information is submitted successfully!</h4>
            <p class="text-info">Our team will review your information and get back to you soon.</p>
        </div>
    @else
        <hr class="m-0">
        <p> Verification type <i class="icon-material-outline-arrow-forward"></i> Personal Information  <i class="icon-material-outline-arrow-forward"></i> Documents <i class="icon-material-outline-arrow-forward"></i> Guardian Information <i class="icon-material-outline-arrow-forward"></i> Review & Submit </p>
    @endif

</div>
@if (!$is_final_submited==1)
    <div class="p-4">
        <h2>Review & Submit</h2>
    </div>
    <div class="uk-container uk-margin-top">
        <div class="p-4">
            <p>Review your information before submitting.</p>
        </div>
        <form id="step4-form" data-step="4">
            @csrf
            <input readonly type="hidden" name="is_final_submited" value="1" class="uk-input">

            {{-- Step 1 --}}
            <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
                <div>
                    <h5 class="uk-text-bold mb-2"> Verification Type </h5>
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input readonly name="verification_type[]" value="1" class="uk-checkbox" type="checkbox" {{in_array(1, $verification_type_arr)?'checked':''}} > Employee</label>
                        <label><input readonly name="verification_type[]" value="2" class="uk-checkbox" type="checkbox" {{in_array(2, $verification_type_arr)?'checked':''}}> Freelancer</label>
                    </div>
                    <div class="uk-text-danger" id="verification_type_error"></div>
                </div>
            </div>
            {{-- Step 2 --}}
            <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
                <div>
                    <h5 class="uk-text-bold mb-2"> Full Name *</h5>
                    <input readonly type="text" name="full_name" class="uk-input" id="full_name" value="{{ $full_name ?? ''}}"  placeholder="First Name" readonly>
                    <div class="uk-text-danger" id="full_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> First Name *</h5>
                    <input readonly type="text" name="first_name" class="uk-input" id="first_name" onkeyup="completeFull_name('first_name*middle_name*last_name', 'full_name')" placeholder="First Name" value="{{$first_name??''}}">
                    <div class="uk-text-danger" id="first_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2">Middle Name *</h5>
                    <input readonly type="text" name="middle_name" class="uk-input" onkeyup="completeFull_name('first_name*middle_name*last_name', 'full_name')" id="middle_name" placeholder="Middle Name" value="{{$middle_name??''}}">
                    <div class="uk-text-danger" id="middle_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Last Name *</h5>
                    <input readonly type="text" name="last_name" class="uk-input" onkeyup="completeFull_name('first_name*middle_name*last_name', 'full_name')" id="last_name" placeholder="Last Name" value="{{$last_name??''}}">
                    <div class="uk-text-danger" id="last_name"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Gender *</h5>
                    <div class="uk-form-controls uk-form-controls-text">
                        <label><input readonly class="uk-radio" type="radio"  value="1" name="gender" {{ isset($gender)&&$gender==1?'checked':''}}> Male</label>&nbsp;
                        <label><input readonly class="uk-radio" type="radio" value="2" name="gender" {{ isset($gender)&&$gender==2?'checked':''}}> Female</label>&nbsp;
                        <label><input readonly class="uk-radio" type="radio" value="3" name="gender" {{ isset($gender)&&$gender==3?'checked':''}}> Other</label>
                        <div class="uk-text-danger" id="gender"></div>
                    </div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Country *</h5>
                <div id="country-container">
                    {!!createDropDownUiKit( "country","", $country_arr,"", 1, "-- Select --",20, "loadDropDown('".route('loadDivision')."', this.value, 'division-container');",1,0 )!!}
                </div>
                    <div class="uk-text-danger" id="country"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Division *</h5>
                    <div id="division-container">
                        @php
                            $division = isset($division)?$division:"";
                        @endphp
                        {!!createDropDownUiKit( "division","", $division_arr,"", 1, "-- Select --","$division", "loadDropDown('".route('loadDistrict')."', this.value, 'district-container');",1,0 )!!}
                    </div>
                    <div class="uk-text-danger" id="division"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> District *</h5>
                    <div id="district-container">
                        @php
                            $district = isset($district)?$district:"";
                        @endphp
                        {!!createDropDownUiKit( "district","", $district_arr,"", 1, "-- Select --","$district", "loadDropDown('".route('loadUpazila')."', this.value, 'upazila-container');",1,0 )!!}
                    </div>
                    <div class="uk-text-danger" id="district"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Upazila *</h5>
                    <div id="upazila-container">
                        @php
                            $upazila = isset($upazila)?$upazila:"";
                        @endphp
                        {!!createDropDownUiKit( "upazila","", $upazila_arr ,"", 1, "-- Select --","$upazila", "",1,0 )!!}
                    </div>
                    <div class="uk-text-danger" id="upazila"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Postal Code *</h5>
                    <input readonly type="text" name="postcode" class="uk-input" placeholder="Postal Code" value="{{$postcode??''}}">
                    <div class="uk-text-danger" id="postcode"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Address *</h5>
                    <textarea readonly class="uk-textarea" rows="1" name="address"  placeholder="Address">{{$address??''}}</textarea>
                    <div class="uk-text-danger" id="address"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Profession *</h5>
                    @php
                        $profession = isset($profession)?$profession:"";
                    @endphp
                    {!!createDropDownUiKit( "profession","",$professionArray,"", 1, "-- Select --","$profession", "",1,0 )!!}

                    <div class="uk-text-danger" id="profession"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Religion *</h5>
                    <div class="uk-form-controls">
                        @php
                            $religion = isset($religion)?$religion:"";
                        @endphp
                        {!!createDropDownUiKit( "religion","",$religionArray,"", 1, "-- Select --","$religion", "",1,0 )!!}
                        <div class="uk-text-danger" id="religionError"></div>
                    </div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Mobile *</h5>
                    <input readonly type="text" name="mobile" class="uk-input" placeholder="Mobile" value="{{$mobile??''}}">
                    <div class="uk-text-danger" id="mobile"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> E-mail *</h5>
                    <input readonly type="email" name="email" class="uk-input" placeholder="E-mail" value="{{$email??''}}">
                    <div class="uk-text-danger" id="email"></div>
                </div>

                <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                    <h5 class="uk-text-bold mb-2"> NID OR DOB Certificate *</h5>
                    <input readonly type="file" name="nid_or_dob">
                    <input readonly class="uk-input uk-form-width-large" type="text" placeholder="Upload File" disabled="">
                    <div class="uk-text-danger" id="nid_or_dob"></div>
                </div>
                <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                    <h5 class="uk-text-bold mb-2"> Document *</h5>
                    <input readonly type="file" name="nid_or_dob">
                    <input readonly class="uk-input uk-form-width-large" type="text" placeholder="Upload Document" disabled="">
                    <div class="uk-text-danger" id=""></div>
                </div>
            </div>
            <div class="{{!in_array(1, $verification_type_arr)?'uk-hidden':''}}">
                <h1 class="uk-text-bold uk-text-center mb-2">Employee Verification</h1>
                <div>
                    <h5 class="uk-text-bold mb-2 p-3">NB: Please contact 0174146545 whatsapp number for verification code and Video call verification </h5>
                </div>
                <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
                    <div>
                        <h5 class="uk-text-bold mb-2"> Audio verification Code *</h5>
                        <input readonly type="text" name="audio_verification_code" class="uk-input" placeholder="Audio verification Code" value="{{$audio_verification_code??''}}">
                        <div class="uk-text-danger" id="audio_verification_code"></div>
                    </div>
                    <div>
                        <h5 class="uk-text-bold mb-2"> Video verification Code *</h5>
                        <input readonly type="text" name="video_verification_code" class="uk-input" placeholder="Video verification Code" value="{{$video_verification_code??''}}">
                        <div class="uk-text-danger" id="video_verification_code"></div>
                    </div>
                </div>
            </div>
            {{-- step 3 --}}
            <h1 class="uk-text-bold uk-text-center mb-2">Guardian Information (Father)</h1>
            <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
                <div>
                    <h5 class="uk-text-bold mb-2"> Full Name *</h5>
                    <input readonly type="text" name="father_full_name" id="father_full_name" class="uk-input" placeholder="Full Name" readonly value="{{ $father_full_name ?? ''}}"  >
                    <div class="uk-text-danger" id="full_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> First Name *</h5>
                    <input readonly type="text" name="father_first_name" id="father_first_name" onkeyup="completeFull_name('father_first_name*father_middle_name*father_last_name', 'father_full_name')"  class="uk-input" placeholder="First Name" value="{{ $father_first_name ?? ''}}">
                    <div class="uk-text-danger" id="father_first_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Middle Name</h5>
                    <input readonly type="text" name="father_middle_name" id="father_middle_name" onkeyup="completeFull_name('father_first_name*father_middle_name*father_last_name', 'father_full_name')"  class="uk-input" placeholder="Middle Name" value="{{ $father_middle_name ?? ''}}">
                    <div class="uk-text-danger" id="father_middle_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Last Name</h5>
                    <input readonly type="text" name="father_last_name" id="father_last_name" onkeyup="completeFull_name('father_first_name*father_middle_name*father_last_name', 'father_full_name')"  class="uk-input" placeholder="Last Name" value="{{ $father_last_name ?? ''}}">
                    <div class="uk-text-danger" id="father_last_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Address *</h5>
                    <textarea readonly class="uk-textarea text_boxes" rows="1" name="father_address"  placeholder="Address">{{$father_address??''}}</textarea>
                    <div class="uk-text-danger" id="father_address"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Profession *</h5>
                    <div class="uk-form-controls">
                        @php
                            $father_profession = isset($father_profession)?$father_profession:"";
                        @endphp
                        {!!createDropDownUiKit( "father_profession","", $professionArray,"", 1, "-- Select --","$father_profession", "",1,0 )!!}
                    </div>
                    <div class="uk-text-danger" id="father_profession_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Religion *</h5>
                    <div class="uk-form-controls">
                        @php
                            $father_religion = isset($father_religion)?$father_religion:"";
                        @endphp
                        {!!createDropDownUiKit( "father_religion","", $religionArray,"", 1, "-- Select --","$father_religion", "",1,0 )!!}
                    </div>
                    <div class="uk-text-danger" id="father_religion_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Mobile *</h5>
                    <input readonly type="text" name="father_mobile" class="uk-input" placeholder="Mobile" value="{{ $father_mobile ?? ''}}">
                    <div class="uk-text-danger" id="father_mobile_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> E-mail *</h5>
                    <input readonly type="email" name="father_email" class="uk-input" placeholder="E-mail" value="{{ $father_email ?? ''}}">
                    <div class="uk-text-danger" id="father_email_error"></div>
                </div>
                <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                    <h5 class="uk-text-bold mb-2"> NID OR DOB Certificate *</h5>
                    <input readonly type="file" name="father_nid_or_dob">
                    <input readonly class="uk-input uk-form-width-large" type="text" placeholder="Upload File" disabled="">
                    <div class="uk-text-danger" id="father_nid_or_dob_error"></div>
                </div>
            </div>
            <h1 class="uk-text-bold uk-text-center mb-2">Guardian Information (Mother)</h1>
            <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
                <div>
                    <h5 class="uk-text-bold mb-2"> Full Name *</h5>
                    <input readonly type="text" name="mother_full_name" id="mother_full_name" class="uk-input" placeholder="Full Name" readonly value="{{ $mother_full_name ?? ''}}">
                    <div class="uk-text-danger" id="mother_full_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> First Name *</h5>
                    <input readonly type="text" name="mother_first_name" id="mother_first_name" class="uk-input" placeholder="First Name" onkeyup="completeFull_name('mother_first_name*mother_middle_name*mother_last_name', 'mother_full_name')" value="{{ $mother_first_name ?? ''}}" >
                    <div class="uk-text-danger" id="mother_first_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Middle Name</h5>
                    <input readonly type="text" name="mother_middle_name" id="mother_middle_name" class="uk-input" placeholder="Middle Name"  onkeyup="completeFull_name('mother_first_name*mother_middle_name*mother_last_name', 'mother_full_name')" value="{{ $mother_middle_name ?? ''}}" >
                    <div class="uk-text-danger" id="mother_middle_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Last Name</h5>
                    <input readonly type="text" name="mother_last_name" id="mother_last_name" onkeyup="completeFull_name('mother_first_name*mother_middle_name*mother_last_name', 'mother_full_name')" class="uk-input" placeholder="Last Name" value="{{ $mother_last_name ?? ''}}" >
                    <div class="uk-text-danger" id="mother_last_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Address *</h5>
                    <textarea readonly class="uk-textarea text_boxes" rows="1" name="mother_address"  placeholder="Address">{{$mother_address??''}}</textarea>
                    <div class="uk-text-danger" id="mother_address"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Profession *</h5>
                    <div class="uk-form-controls">
                        @php
                            $mother_profession = isset($mother_profession)?$mother_profession:"";
                        @endphp
                        {!!createDropDownUiKit( "mother_profession","", $professionArray,"", 1, "-- Select --","$mother_profession", "",1,0 )!!}
                    </div>
                    <div class="uk-text-danger" id="mother_profession_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Religion *</h5>
                    <div class="uk-form-controls">
                        @php
                            $mother_religion = isset($mother_religion)?$mother_religion:"";
                        @endphp
                        {!!createDropDownUiKit( "mother_religion","", $religionArray,"", 1, "-- Select --","$mother_religion", "",1,0 )!!}
                    </div>
                    <div class="uk-text-danger" id="mother_religion_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Mobile *</h5>
                    <input readonly type="text" name="mother_mobile" class="uk-input" placeholder="Mobile" value="{{ $mother_mobile ?? ''}}" >
                    <div class="uk-text-danger" id="mother_mobile_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> E-mail *</h5>
                    <input readonly type="email" name="mother_email" class="uk-input" placeholder="E-mail" value="{{ $mother_email ?? ''}}" >
                    <div class="uk-text-danger" id="mother_email_error"></div>
                </div>
                <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                    <h5 class="uk-text-bold mb-2"> NID OR DOB Certificate *</h5>
                    <input readonly type="file" name="mother_nid_or_dob">
                    <input readonly class="uk-input uk-form-width-large" type="text" placeholder="Upload File" disabled="">
                    <div class="uk-text-danger" id="mother_nid_or_dob_error"></div>
                </div>
            </div>
            <h1 class="uk-text-bold uk-text-center mb-2">Emergency Contact Person</h1>
            <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
                <div>
                    <h5 class="uk-text-bold mb-2"> Full Name *</h5>
                    <input readonly type="text" name="emergency_full_name" id="emergency_full_name" class="uk-input" placeholder="Full Name" readonly value="{{ $emergency_full_name ?? ''}}" >
                    <div class="uk-text-danger" id="emergency_full_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> First Name *</h5>
                    <input readonly type="text" name="emergency_first_name" id="emergency_first_name" class="uk-input" placeholder="First Name"  onkeyup="completeFull_name('emergency_first_name*emergency_middle_name*emergency_last_name', 'emergency_full_name')" value="{{ $emergency_first_name ?? ''}}">
                    <div class="uk-text-danger" id="emergency_first_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Middle Name</h5>
                    <input readonly type="text" name="emergency_middle_name" id="emergency_middle_name" class="uk-input" placeholder="Middle Name"  onkeyup="completeFull_name('emergency_first_name*emergency_middle_name*emergency_last_name', 'emergency_full_name')" value="{{ $emergency_middle_name ?? ''}}">
                    <div class="uk-text-danger" id="emergency_middle_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Last Name</h5>
                    <input readonly type="text" name="emergency_last_name" id="emergency_last_name" class="uk-input" placeholder="Last Name"  onkeyup="completeFull_name('emergency_first_name*emergency_middle_name*emergency_last_name', 'emergency_full_name')" value="{{ $emergency_last_name ?? ''}}" >
                    <div class="uk-text-danger" id="emergency_last_name_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Relation *</h5>
                    <input readonly type="text" name="emergency_relation" class="uk-input" placeholder="Relation" value="{{ $emergency_relation ?? ''}}" >
                    <div class="uk-text-danger" id="emergency_relation_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Address *</h5>
                    <textarea readonly class="uk-textarea text_boxes" rows="1" name="emergency_address"  placeholder="Address">{{$emergency_address??''}}</textarea>
                    <div class="uk-text-danger" id="emergency_address"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Profession *</h5>
                    <div class="uk-form-controls">
                        @php
                            $emergency_profession = isset($emergency_profession)?$emergency_profession:"";
                        @endphp
                        {!!createDropDownUiKit( "emergency_profession","", $professionArray,"", 1, "-- Select --","$emergency_profession", "",1,0 )!!}
                    </div>
                    <div class="uk-text-danger" id="emergency_profession_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Religion *</h5>
                    <div class="uk-form-controls">
                        @php
                            $emergency_religion = isset($emergency_religion)?$emergency_religion:"";
                        @endphp
                        {!!createDropDownUiKit( "emergency_religion","", $religionArray,"", 1, "-- Select --","$emergency_religion", "",1,0 )!!}
                        <div class="uk-text-danger" id="emergency_religion_error"></div>
                    </div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Mobile *</h5>
                    <input readonly type="text" name="emergency_mobile" class="uk-input" placeholder="Mobile" value="{{ $emergency_mobile ?? ''}}">
                    <div class="uk-text-danger" id="emergency_mobile_error"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> E-mail *</h5>
                    <input readonly type="email" name="emergency_email" class="uk-input" placeholder="E-mail" value="{{ $emergency_email ?? ''}}">
                    <div class="uk-text-danger" id="emergency_email_error"></div>
                </div>
                <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                    <h5 class="uk-text-bold mb-2"> NID OR DOB Certificate *</h5>
                    <input readonly type="file" name="emergency_nid_or_dob">
                    <input readonly class="uk-input uk-form-width-large" type="text" placeholder="Upload File" disabled="">
                    <div class="uk-text-danger" id="emergency_nid_or_dob_error"></div>
                </div>
            </div>

            {{-- button --}}
            <div class="uk-flex uk-flex-between p-4">
                @if ($is_final_submited!=1)
                    <a class="button soft-primary" id="back-button" onclick="preventDefault();">Previous</a>
                    <button class="button primary" type="submit" type="submit">Submit</button>
                @endif

            </div>
        </form>
    </div>
@endif
