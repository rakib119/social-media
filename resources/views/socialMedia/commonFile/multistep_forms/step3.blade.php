@php
    $userinfo = DB::table('user_infos')->select('father_full_name','father_first_name','father_middle_name','father_last_name','father_profession','father_religion','father_mobile','father_email','father_nid_or_dob','father_documents','mother_full_name','mother_first_name','mother_middle_name','mother_last_name','mother_profession','mother_religion','mother_mobile','mother_email','mother_nid_or_dob','mother_documents','emergency_full_name','emergency_first_name','emergency_middle_name','emergency_last_name','emergency_profession','emergency_religion','emergency_mobile','emergency_relation','emergency_email','emergency_nid_or_dob','emergency_documents','emergency_documents')->where('user_id',auth()?->id())->first();
    $userinfoArray = (array)$userinfo;
    extract($userinfoArray); //Array to variable
    $religionArray      = session('religionArray');
    // echo "<pre>";print_r($religionArray);die;
    $professionArray    = session('professionArray');
@endphp

<div class="p-3">
    <div class="p-4">
        <h2>Guardian Information</h2>
    </div>
    <hr class="m-0">
    <p> Verification type <i class="icon-material-outline-arrow-forward"></i> Personal Information  <i class="icon-material-outline-arrow-forward"></i> Documents <i class="icon-material-outline-arrow-forward"></i> Guardian Information <i class="icon-material-outline-arrow-forward"></i> Review & Submit </p>
</div>
<div>
    <form id="step3-form" data-step="3">
        @csrf
        <h1 class="uk-text-bold uk-text-center mb-2">Guardian Information (Father)</h1>
        <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
            <div>
                <h5 class="uk-text-bold mb-2"> Full Name *</h5>
                <input type="text" name="father_full_name" id="father_full_name" class="uk-input text_boxes uk-text-uppercase" readonly value="{{ $father_full_name ?? ''}}"  >
                <div class="uk-text-danger" id="full_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> First Name *</h5>
                <input type="text" name="father_first_name" id="father_first_name" onkeyup="completeFull_name('father_first_name*father_middle_name*father_last_name', 'father_full_name')"  class="uk-input text_boxes_uppercase" placeholder="First Name" value="{{ $father_first_name ?? ''}}">
                <div class="uk-text-danger" id="father_first_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Middle Name</h5>
                <input type="text" name="father_middle_name" id="father_middle_name" onkeyup="completeFull_name('father_first_name*father_middle_name*father_last_name', 'father_full_name')"  class="uk-input text_boxes_uppercase" placeholder="Middle Name" value="{{ $father_middle_name ?? ''}}">
                <div class="uk-text-danger" id="father_middle_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Last Name</h5>
                <input type="text" name="father_last_name" id="father_last_name" onkeyup="completeFull_name('father_first_name*father_middle_name*father_last_name', 'father_full_name')"  class="uk-input text_boxes_uppercase" placeholder="Last Name" value="{{ $father_last_name ?? ''}}">
                <div class="uk-text-danger" id="father_last_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Address *</h5>
                <textarea class="uk-textarea text_boxes" rows="1" name="father_address"  placeholder="Address">{{$father_address??''}}</textarea>
                <div class="uk-text-danger" id="father_address"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Profession *</h5>
                <div class="uk-form-controls">
                    @php
                        $father_profession = isset($father_profession)?$father_profession:"";
                    @endphp
                    {!!createDropDownUiKit( "father_profession","", $professionArray,"", 1, "-- Select --","$father_profession", "",0,0 )!!}
                </div>
                <div class="uk-text-danger" id="father_profession_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Religion *</h5>
                <div class="uk-form-controls">
                    @php
                        $father_religion = isset($father_religion)?$father_religion:"";
                    @endphp
                    {!!createDropDownUiKit( "father_religion","", $religionArray,"", 1, "-- Select --","$father_religion", "",0,0 )!!}
                </div>
                <div class="uk-text-danger" id="father_religion_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Mobile *</h5>
                <div class="phone-input-container">
                    <span class="phone-prefix">+88</span>
                    <input type="text" name="father_mobile" class="uk-input phone-input" placeholder="01XXXXXXXXX" value="{{ $father_mobile ?? ''}}">
                </div>
                <div class="uk-text-danger" id="father_mobile_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> E-mail *</h5>
                <input type="email" name="father_email" class="uk-input email-input" placeholder="E-mail" value="{{ $father_email ?? ''}}">
                <div class="uk-text-danger" id="father_email_error"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                <h5 class="uk-text-bold mb-2"> NID OR DOB Certificate *</h5>
                <input type="file" name="father_nid_or_dob[]" accept=".jpg,.jpeg" multiple>
                <input class="uk-input uk-form-width-large" type="text" placeholder="Upload File" disabled="">
                <div class="uk-text-danger" id="father_nid_or_dob_error"></div>
            </div>
        </div>
        <h1 class="uk-text-bold uk-text-center mb-2">Guardian Information (Mother)</h1>
        <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
            <div>
                <h5 class="uk-text-bold mb-2"> Full Name *</h5>
                <input type="text" name="mother_full_name" id="mother_full_name" class="uk-input text_boxes uk-text-uppercase" readonly value="{{ $mother_full_name ?? ''}}">
                <div class="uk-text-danger" id="mother_full_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> First Name *</h5>
                <input type="text" name="mother_first_name" id="mother_first_name" class="uk-input text_boxes_uppercase" placeholder="First Name" onkeyup="completeFull_name('mother_first_name*mother_middle_name*mother_last_name', 'mother_full_name')" value="{{ $mother_first_name ?? ''}}" >
                <div class="uk-text-danger" id="mother_first_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Middle Name</h5>
                <input type="text" name="mother_middle_name" id="mother_middle_name" class="uk-input text_boxes_uppercase" placeholder="Middle Name"  onkeyup="completeFull_name('mother_first_name*mother_middle_name*mother_last_name', 'mother_full_name')" value="{{ $mother_middle_name ?? ''}}" >
                <div class="uk-text-danger" id="mother_middle_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Last Name</h5>
                <input type="text" name="mother_last_name" id="mother_last_name" onkeyup="completeFull_name('mother_first_name*mother_middle_name*mother_last_name', 'mother_full_name')" class="uk-input text_boxes_uppercase" placeholder="Last Name" value="{{ $mother_last_name ?? ''}}" >
                <div class="uk-text-danger" id="mother_last_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Address *</h5>
                <textarea class="uk-textarea text_boxes" rows="1" name="mother_address"  placeholder="Address">{{$mother_address??''}}</textarea>
                <div class="uk-text-danger" id="mother_address"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Profession *</h5>
                <div class="uk-form-controls">
                    @php
                        $mother_profession = isset($mother_profession)?$mother_profession:"";
                    @endphp
                    {!!createDropDownUiKit( "mother_profession","", $professionArray,"", 1, "-- Select --","$mother_profession", "",0,0 )!!}
                </div>
                <div class="uk-text-danger" id="mother_profession_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Religion *</h5>
                <div class="uk-form-controls">
                    @php
                        $mother_religion = isset($mother_religion)?$mother_religion:"";
                    @endphp
                    {!!createDropDownUiKit( "mother_religion","", $religionArray,"", 1, "-- Select --","$mother_religion", "",0,0 )!!}
                </div>
                <div class="uk-text-danger" id="mother_religion_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Mobile *</h5>
                <div class="phone-input-container">
                    <span class="phone-prefix">+88</span>
                    <input type="text" name="mother_mobile" class="uk-input phone-input" placeholder="01XXXXXXXXX" value="{{ $mother_mobile ?? ''}}" >
                </div>
                <div class="uk-text-danger" id="mother_mobile_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> E-mail *</h5>
                <input type="email" name="mother_email" class="uk-input email-input" placeholder="E-mail" value="{{ $mother_email ?? ''}}" >
                <div class="uk-text-danger" id="mother_email_error"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                <h5 class="uk-text-bold mb-2"> NID OR DOB Certificate *</h5>
                <input type="file" name="mother_nid_or_dob[]" accept=".jpg,.jpeg" multiple>
                <input class="uk-input uk-form-width-large" type="text" placeholder="Upload File" disabled="">
                <div class="uk-text-danger" id="mother_nid_or_dob_error"></div>
            </div>
        </div>
        <h1 class="uk-text-bold uk-text-center mb-2">Emergency Contact Person</h1>
        <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
            <div>
                <h5 class="uk-text-bold mb-2"> Full Name *</h5>
                <input type="text" name="emergency_full_name" id="emergency_full_name" class="uk-input text_boxes uk-text-uppercase" readonly value="{{ $emergency_full_name ?? ''}}" >
                <div class="uk-text-danger" id="emergency_full_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> First Name *</h5>
                <input type="text" name="emergency_first_name" id="emergency_first_name" class="uk-input text_boxes_uppercase" placeholder="First Name"  onkeyup="completeFull_name('emergency_first_name*emergency_middle_name*emergency_last_name', 'emergency_full_name')" value="{{ $emergency_first_name ?? ''}}">
                <div class="uk-text-danger" id="emergency_first_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Middle Name</h5>
                <input type="text" name="emergency_middle_name" id="emergency_middle_name" class="uk-input text_boxes_uppercase" placeholder="Middle Name"  onkeyup="completeFull_name('emergency_first_name*emergency_middle_name*emergency_last_name', 'emergency_full_name')" value="{{ $emergency_middle_name ?? ''}}">
                <div class="uk-text-danger" id="emergency_middle_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Last Name</h5>
                <input type="text" name="emergency_last_name" id="emergency_last_name" class="uk-input text_boxes_uppercase" placeholder="Last Name"  onkeyup="completeFull_name('emergency_first_name*emergency_middle_name*emergency_last_name', 'emergency_full_name')" value="{{ $emergency_last_name ?? ''}}" >
                <div class="uk-text-danger" id="emergency_last_name_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Relation *</h5>
                <input type="text" name="emergency_relation" class="uk-input text_boxes" placeholder="Relation" value="{{ $emergency_relation ?? ''}}" >
                <div class="uk-text-danger" id="emergency_relation_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Address *</h5>
                <textarea class="uk-textarea text_boxes" rows="1" name="emergency_address"  placeholder="Address">{{$emergency_address??''}}</textarea>
                <div class="uk-text-danger" id="emergency_address"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Profession *</h5>
                <div class="uk-form-controls">
                    @php
                        $emergency_profession = isset($emergency_profession)?$emergency_profession:"";
                    @endphp
                    {!!createDropDownUiKit( "emergency_profession","", $professionArray,"", 1, "-- Select --","$emergency_profession", "",0,0 )!!}
                </div>
                <div class="uk-text-danger" id="emergency_profession_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Religion *</h5>
                <div class="uk-form-controls">
                    @php
                        $emergency_religion = isset($emergency_religion)?$emergency_religion:"";
                    @endphp
                    {!!createDropDownUiKit( "emergency_religion","", $religionArray,"", 1, "-- Select --","$emergency_religion", "",0,0 )!!}
                    <div class="uk-text-danger" id="emergency_religion_error"></div>
                </div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> Mobile *</h5>
                <div class="phone-input-container">
                    <span class="phone-prefix">+88</span>
                    <input type="text" name="emergency_mobile" class="uk-input phone-input" placeholder="01XXXXXXXXX" value="{{ $emergency_mobile ?? ''}}">
                </div>
                <div class="uk-text-danger" id="emergency_mobile_error"></div>
            </div>
            <div>
                <h5 class="uk-text-bold mb-2"> E-mail *</h5>
                <input type="email" name="emergency_email" class="uk-input email-input" placeholder="E-mail" value="{{ $emergency_email ?? ''}}">
                <div class="uk-text-danger" id="emergency_email_error"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                <h5 class="uk-text-bold mb-2"> NID OR DOB Certificate *</h5>
                <input type="file" name="emergency_nid_or_dob[]" accept=".jpg,.jpeg" multiple>
                <input class="uk-input uk-form-width-large" type="text" placeholder="Upload File" disabled="">
                <div class="uk-text-danger" id="emergency_nid_or_dob_error"></div>
            </div>
        </div>
        <div class="uk-flex uk-flex-between p-4">
            <a class="button soft-primary" id="back-button" onclick="preventDefault()">Previous</a>
            <button class="button primary" type="submit">Next</button>
        </div>
    </form>
</div>
