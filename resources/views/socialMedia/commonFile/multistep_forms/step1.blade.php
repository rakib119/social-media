@php
    $userinfo = DB::table('user_infos')->select('verification_type')->where('user_id',auth()?->id())->first();
    $verification_types     = $userinfo?->verification_type;
    $verification_type_arr  = array();
    if ($verification_types) {
        $verification_type_arr  = explode(',',$verification_types);
    }
@endphp
<div class="p-3">
    <div class="p-4">
        <h2>Verification type</h2>
    </div>
    <hr class="m-0">
    <p> Verification type <i class="icon-material-outline-arrow-forward"></i> Personal Information  <i class="icon-material-outline-arrow-forward"></i> Documents <i class="icon-material-outline-arrow-forward"></i> Guardian Information <i class="icon-material-outline-arrow-forward"></i> Review & Submit </p>
</div>
<div>
    <div class="uk-container uk-margin-top">
        <form id="step1-form" data-step="1">
            @csrf
            <div uk-grid class="uk-child-width-1-2@s uk-grid-small p-4">
                <div>
                    <h5 class="uk-text-bold mb-2"> Verification Type </h5>
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input name="verification_type[]" value="1" class="uk-checkbox" type="checkbox" {{in_array(1, $verification_type_arr)?'checked':''}} > Employee</label>
                        <label><input name="verification_type[]" value="2" class="uk-checkbox" type="checkbox" {{in_array(2, $verification_type_arr)?'checked':''}}> Freelancer</label>
                    </div>
                    <div class="uk-text-danger" id="verification_type_error"></div>
                </div>
            </div>
            <div class="uk-flex uk-flex-right p-4">
                <button class="button soft-primary uk-margin-right" uk-switcher-item="next" type="submit">Next</button>
            </div>
        </form>
    </div>
</div>

