@php
    $payment_type_array = array(
        1=>"Bank",
        2=>"Mobile Banking"
    );
    $banks              = array();
    $load_img_onchange  = 'onchange="loadFile(event,'."'imgOutput'".')"';


@endphp
@extends('socialMedia.commonFile.socialLayouts1')
@section('topBar')
    @include('socialMedia.commonFile.topBar')
@endsection

@section('leftBar')
    @include('socialMedia.commonFile.leftBarV1')
@endsection
@section('mainContent')
   <!-- contents -->
   <div class="main_content">
        <div class="main_content_inner p-sm-0 ml-sm-4">
            <h1>Make Payment </h1>
            <div class="uk-container uk-margin-large-top">
                <div id="bank-details">

                </div>
                <form class="uk-form-stacked" id="payment-form" action="{{route('submitManualPaymentV2')}}">
                    @csrf
                    <div class="uk-grid-small uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s" uk-grid>
                        <div>
                            <label class="uk-form-label" for="payment_type">Payment Type</label>
                            <div id="payment-type-container" class="uk-form-controls">
                                {!! createDropDownUiKit( "payment_type","", $payment_type_array,"", 1, "-- Select --","", "loadDropDown('".route('loadBankName')."', this.value, 'bank-name-container');loadDropDown('".route('loadDropdownCompanyBank')."', this.value, 'company-bank-container');$('#company_account_no').val('');controlBankBranch(this.value);",0,0 ) !!}
                            </div>
                                <div class="uk-text-danger uk-margin-small-top" id="payment_type_error"></div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="company_bank">Company Bank Name</label>
                            <div id="company-bank-container" class="uk-form-controls">
                               {!! createDropDownUiKit( "company_bank_name","", array(),"", 1, "-- Select --","", "",0,0 ) !!}
                            </div>
                                <div class="uk-text-danger uk-margin-small-top" id="company_bank_error"></div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="company_account_no">Company Account No</label>
                            <div class="uk-form-controls" id="company-account-container">
                                <input class="uk-input" name="company_account_no" id="company_account_no" type="text" placeholder="Company Account No">
                                <input class="uk-input" name="company_account_id" id="company_account_id" type="hidden">
                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="company_account_no_error"></div>
                        </div>
                        <div class="only-for-bank" style="display: none;">
                            <label class="uk-form-label" for="branch_code">Branch Code</label>
                            <div class="uk-form-controls">
                                <input readonly class="uk-input" id="branch_code" type="text" name="branch_code">
                            </div>
                        </div>
                        <div class="only-for-bank" style="display: none;">
                            <label class="uk-form-label" for="routing_no">Routing No</label>
                            <div class="uk-form-controls">
                                <input readonly class="uk-input" id="routing_no" type="text" name="routing_no">
                            </div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="bank-name">Bank Name</label>
                            <div id="bank-name-container" class="uk-form-controls">
                                {!! createDropDownUiKit( "bank_name","", $banks,"", 1, "-- Select --","", "",0,0 ) !!}
                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="bank_name_error"></div>
                        </div>

                        <div class="only-for-bank" style="display: none;">
                            <label class="uk-form-label" for="account_holder">Account Holder</label>
                            <div class="uk-form-controls">
                                <input name="account_holder" class="uk-input" id="account_holder" type="text" placeholder="Enter Account Holder Name">
                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="account_holder_error"></div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="account_no">Account No</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" name="account_no" id="account_no" type="text" placeholder="Enter Account No">
                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="account_no_error"></div>
                        </div>
                        <div class="only-for-bank" style="display: none;">
                            <label class="uk-form-label" for="branch">Branch</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="branch" type="text" name="branch"  placeholder="Enter branch Name">
                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="branch_error"></div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="amount">Amount</label>
                            <div class="uk-form-controls">
                                <input class="uk-input text_boxes_numeric" id="amount " name="amount" type="text" value="" placeholder="Enter Amount">

                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="amount_error"></div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="transaction-id">Transaction ID</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="transaction-id" name="transaction_id" type="text" placeholder="Enter Transaction ID Name">
                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="transaction_id_error"></div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="image">Image or Screen Shot</label>
                            <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                                <input id="image" type="file" name="image">
                                <input class="uk-input uk-form-width-large" type="text" placeholder="Upload File" disabled="">
                                {{-- onchange="loadFile(event,'imgOutput')" --}}
                                <div class="uk-text-danger uk-margin-small-top" id="image_error"></div>
                            </div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="image">Remarks</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="remarks" type="text" name="remarks"  placeholder="Enter payment reason">

                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="remarks_error"></div>
                        </div>
                    </div>
                    <div class="uk-text-center ">
                        <button style="cursor:pointer;" class="button primary" type="button" id="submit-payment" onclick="submitPayment()" >Submit</button>
                    </div>
                </form>
            </div>
        </div>
   </div>
@endsection

@section('javaScript')

@endsection
