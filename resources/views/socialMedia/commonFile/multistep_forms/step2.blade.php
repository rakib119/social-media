@php
    $userinfo = DB::table('user_infos')->select('verification_type','full_name','first_name','middle_name','last_name','gender','profession','religion','mobile','email','nid_or_dob','documents','country','district','upazila','division','postcode','address','audio_verification_code','video_verification_code')->where('user_id',auth()?->id())->first();
    $userinfoArray = (array)$userinfo;
    // echo "<pre>";print_r($userinfoArray);
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
        <h2>Personal Information</h2>
    </div>
    <hr class="m-0">
    <p> Verification type <i class="icon-material-outline-arrow-forward"></i> Personal Information  <i class="icon-material-outline-arrow-forward"></i> Documents <i class="icon-material-outline-arrow-forward"></i> Guardian Information <i class="icon-material-outline-arrow-forward"></i> Review & Submit </p>
</div>
<div>
    <form id="step2-form" data-step="2" >
        @csrf
        <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
            <div>
                <h5 class="uk-text-bold mb-2"> Full Name *</h5>
                <input type="text" name="full_name" class="uk-input text_boxes uk-text-uppercase" id="full_name" value="{{ $full_name ?? ''}}"  readonly>
                <div class="uk-text-danger" id="full_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> First Name *</h5>
                <input type="text" name="first_name" class="uk-input text_boxes_uppercase" id="first_name" onkeyup="completeFull_name('first_name*middle_name*last_name', 'full_name')" placeholder="First Name" value="{{$first_name??''}}">
                <div class="uk-text-danger" id="first_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2">Middle Name</h5>
                <input type="text" name="middle_name" class="uk-input text_boxes_uppercase" onkeyup="completeFull_name('first_name*middle_name*last_name', 'full_name')" id="middle_name" placeholder="Middle Name" value="{{$middle_name??''}}">
                <div class="uk-text-danger" id="middle_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Last Name</h5>
                <input type="text" name="last_name" class="uk-input text_boxes_uppercase" onkeyup="completeFull_name('first_name*middle_name*last_name', 'full_name')" id="last_name" placeholder="Last Name" value="{{$last_name??''}}">
                <div class="uk-text-danger" id="last_name"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Gender *</h5>
                <div class="uk-form-controls uk-form-controls-text">
                    <label><input class="uk-radio" type="radio"  value="1" name="gender" {{ isset($gender)&&$gender==1?'checked':''}}> Male</label>&nbsp;
                    <label><input class="uk-radio" type="radio" value="2" name="gender" {{ isset($gender)&&$gender==2?'checked':''}}> Female</label>&nbsp;
                    <label><input class="uk-radio" type="radio" value="3" name="gender" {{ isset($gender)&&$gender==3?'checked':''}}> Other</label>
                    <div class="uk-text-danger" id="gender"></div>
                </div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Country *</h5>
               <div id="country-container">
                   {!!createDropDownUiKit( "country","", $country_arr,"", 1, "-- Select --",20, "loadDropDown('".route('loadDivision')."', this.value, 'division-container');",0,0 )!!}
               </div>
                <div class="uk-text-danger" id="country"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Division *</h5>
                <div id="division-container">
                    @php
                        $division = isset($division)?$division:"";
                    @endphp
                    {!!createDropDownUiKit( "division","", $division_arr,"", 1, "-- Select --","$division", "loadDropDown('".route('loadDistrict')."', this.value, 'district-container');",0,0 )!!}
                </div>
                <div class="uk-text-danger" id="division"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> District *</h5>
                <div id="district-container">
                    @php
                        $district = isset($district)?$district:"";
                    @endphp
                    {!!createDropDownUiKit( "district","", $district_arr,"", 1, "-- Select --","$district", "loadDropDown('".route('loadUpazila')."', this.value, 'upazila-container');",0,0 )!!}
                </div>
                <div class="uk-text-danger" id="district"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Upazila *</h5>
                <div id="upazila-container">
                    @php
                        $upazila = isset($upazila)?$upazila:"";
                    @endphp
                    {!!createDropDownUiKit( "upazila","", $upazila_arr ,"", 1, "-- Select --","$upazila", "",0,0 )!!}
                </div>
                <div class="uk-text-danger" id="upazila"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Postal Code *</h5>
                <input type="text" name="postcode" class="uk-input text_boxes_numeric"  placeholder="Postal Code" value="{{$postcode??''}}">
                <div class="uk-text-danger" id="postcode"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Address *</h5>
                <textarea class="uk-textarea text_boxes" rows="1" name="address"  placeholder="Address">{{$address??''}}</textarea>
                <div class="uk-text-danger" id="address"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Profession *</h5>
                @php
                    $profession = isset($profession)?$profession:"";
                @endphp
                {!!createDropDownUiKit( "profession","",$professionArray,"", 1, "-- Select --","$profession", "",0,0 )!!}

                <div class="uk-text-danger" id="profession"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Religion *</h5>
                <div class="uk-form-controls">
                    @php
                        $religion = isset($religion)?$religion:"";
                    @endphp
                    {!!createDropDownUiKit( "religion","",$religionArray,"", 1, "-- Select --","$religion", "",0,0 )!!}
                    <div class="uk-text-danger" id="religionError"></div>
                </div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Mobile *</h5>

                <div class="phone-input-container">
                    <span class="phone-prefix">+88</span>
                    <input type="text" name="mobile" class="uk-input phone-input" placeholder="01XXXXXXXXX" value="{{$mobile??''}}">
                </div>
                <div class="uk-text-danger" id="mobile"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> E-mail *</h5>
                <input type="email" name="email" class="uk-input email-input" placeholder="E-mail" value="{{$email??''}}">
                <div class="uk-text-danger" id="email"></div>
            </div>

            <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                <h5 class="uk-text-bold mb-2"> NID OR DOB Certificate *</h5>
                <input type="file" multiple accept=".jpg,.jpeg" name="nid_or_dob[]">
                <input class="uk-input uk-form-width-large" type="text" placeholder="Upload Files" disabled="">
                <div class="uk-text-danger" id="nid_or_dob"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                <h5 class="uk-text-bold mb-2"> Document *</h5>
                <input type="file" multiple accept=".jpg,.jpeg" name="documents[]">
                <input class="uk-input uk-form-width-large" type="text" placeholder="Upload Documents" disabled="">
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
                    <input type="text" name="audio_verification_code" class="uk-input text_boxes_numeric" placeholder="Audio verification Code" value="{{$audio_verification_code??''}}" maxlength="5">
                    <div class="uk-text-danger" id="audio_verification_code"></div>
                </div>
                <div>
                    <h5 class="uk-text-bold mb-2"> Video verification Code *</h5>
                    <input type="text" name="video_verification_code" class="uk-input text_boxes_numeric" placeholder="Video verification Code" value="{{$video_verification_code??''}}" maxlength="5">
                    <div class="uk-text-danger" id="video_verification_code"></div>
                </div>
            </div>
        </div>
        <div class="uk-flex uk-flex-between p-4">
            <a class="button soft-primary" id="back-button" onclick="preventDefault()">Previous</a>
            <button class="button primary" type="submit">Next</button>
        </div>
    </form>
</div>
<script>
        // $('#country').select2();
        // $('#division').select2();
        // $('#district').select2();
        // $('#upazila').select2();
</script>
