<?php

namespace App\Http\Controllers\socialMedia;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\CompanyBankDtls;
use App\Models\PackagePurchaseMst;
use App\Models\SocialPackageBreakDown;
use App\Models\SocialPackageFeatureDtls;
use App\Models\SocialPackageMst;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PackagePurchaseController extends Controller
{
    public function upgrade_to_premium()
    {
        Session::forget('package_info');
        $package = SocialPackageMst::select('id','package_name','short_desc','price','discount_per','discounted_amount','renewal_fee','renewable_message')->where('status_active',1)->where('is_deleted',0)->get();
        $package_features = SocialPackageFeatureDtls::select('id','mst_id','feature','short_desc')->where('status_active',1)->where('is_deleted',0)->get();
        return view('socialMedia.pages.upgradeToPremium', compact('package','package_features'));
    }
    public function choose_plane($crypt_id)
    {
        $package_id = decrypt($crypt_id);
        $package = SocialPackageMst::select('id','package_name')->where('id',$package_id)->first();

        $package_break_down = SocialPackageBreakDown::select('id','mst_id','sub_package_name','desc_link','price','discount_per','discounted_amount')->where('status_active',1)->where('is_deleted',0)->where('mst_id',$package_id)->get();
        return view('socialMedia.pages.choose_plane', compact('package_break_down','package'));
    }

    public function load_package_subtotal(Request $request)
    {

        $id = $request->data;
        if ($id)
        {
            $package_break_down = SocialPackageBreakDown::select('id','mst_id','sub_package_name','desc_link','price','discount_per','discounted_amount')->where('status_active',1)->where('is_deleted',0)->where('id',$id)->first();

            // return session()->all();
            $mst_id             = $package_break_down?->mst_id;
            $price              = $package_break_down?->price;
            $discounted_amount  = $package_break_down?->discounted_amount;
            $discount           = $price-$discounted_amount;
            $discount_per       = $package_break_down?->discount_per;
            $desc_link          = $package_break_down?->desc_link;
            $dist_msg           = $discount>0 ? '<span class="uk-text-muted"><del>৳'.$price.'</del></span>' : "";
            $dist_per_msg       = $discount_per>0 ? ' <p class="uk-text-success">Plan discount -'.$discount_per.'% <span class="uk-text-danger">-৳ '.$price.'</span></p>' :  "<p class='uk-text-success'>Plan discount $discount_per%";

            $onClickHtml = '';
            if ($desc_link)
            {
                $link_rows = explode('**', $desc_link);
                $i=0;
                foreach ($link_rows as $row) {
                    $parts = explode('!!', $row);
                    if (count($parts) === 2) {
                        $disc_link = trim($parts[0]);
                        $label_text = trim($parts[1]);
                        if ($i) $onClickHtml .= '<br>';
                        $i++;
                        $onClickHtml .= '<label style="font-size:12px;cursor:pointer;"> <input style="height:10px;width:10px;border-radius:2px;" id="cbox-'.$i.'" data-description-link="' . $disc_link . '" class="uk-checkbox link-checkbox " onclick="handleCheckboxClick(this)" type="checkbox"> ' . $label_text . ' </label>';

                    }
                }
            }

            $package_data_array = array(
                'package_id'            => $mst_id,
                'selected_package_id'   => $id,
                'description_link'      => $desc_link,
                'package_value'         => $price,
                'discount_per'          => $discount_per,
                'payable_amount'        => $discounted_amount,
            );
            Session::put('package_info',$package_data_array);
            $method_route ="'".route('social.load_payment_method')."'";
            $online_payment ="'".route('pay.online')."'";
            $html_container ="'main_payment_container'";
            return  $html ='<div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-text-center">
                <div>
                    <p class="uk-text-meta">Subtotal '.$dist_msg.'</p>
                    <p class="uk-text-lead uk-text-bold"> ৳'.$package_break_down?->discounted_amount.'</p>
                </div>
                '.$dist_per_msg.'
                <div class="uk-child-width-auto">
                    '.$onClickHtml.'
                </div>
                <div>
                    <h6 class="uk-text-danger uk-text-center" id="checkboxError"> </h6>
                    <button class="uk-button uk-button-secondary uk-border-rounded uk-margin-small-top" onclick=" getPaymentComponent(1,'.$online_payment.', '.$id.', '.$html_container.')">Online Payment</button>
                    <button class="uk-button uk-button-primary uk-border-rounded uk-margin-small-top" onclick="getPaymentComponent(2,'.$method_route.', '.$id.', '.$html_container.')"">Offline Payment</button>
                </div>

            </div>';
        }
        else
        {
            $package_data_array = array(
                'selected_package_id'=>'',
                'description_link'=>'',
            );
            Session::put('package_info',$package_data_array);
            return "";
        }



    }
    public function load_payment_method(Request $request)
    {

        $payment_type_array = array(
            1=>"Bank",
            2=>"Mobile Banking"
        );
        $data = explode("*", str_replace("'","",$request->data));

        if ($data[1])
        {
            $package_info = session('package_info')??array();
            $payment_info = array(
                'payment_method'=>$data[1]
            );

            $banks                  = array();
            $bank_type_drop_down    = createDropDownUiKit( "payment_type","", $payment_type_array,"", 1, "-- Select --","", "loadDropDown('".route('loadBankName')."', this.value, 'bank-name-container');loadDropDown('".route('loadDropdownCompanyBank')."', this.value, 'company-bank-container');$('#company_account_no').val('');controlBankBranch(this.value);",0,0 );
            $bank_list              = createDropDownUiKit( "bank_name","", $banks,"", 1, "-- Select --","", "",0,0 );
            $company_bank_list      = createDropDownUiKit( "company_bank_name","", $banks,"", 1, "-- Select --","", "",0,0 );
            $load_img_onchange      = 'onchange="loadFile(event,'."'imgOutput'".')"';
            $url                    = route('submitManualPayment');
            $package_data_array     = array_merge($package_info,$payment_info);
            Session::put('package_info',$package_data_array);


            return $html = '
            <div class="uk-container uk-margin-large-top">
                <div id="bank-details">

                </div>
                <form class="uk-form-stacked" id="payment-form" action="'.$url.'">
                    ' . csrf_field() . '
                    <div class="uk-grid-small uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s" uk-grid>
                        <div>
                            <label class="uk-form-label" for="payment_type">Payment Type</label>
                            <div id="payment-type-container" class="uk-form-controls">
                                '. $bank_type_drop_down.'
                            </div>
                                <div class="uk-text-danger uk-margin-small-top" id="payment_type_error"></div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="company_bank">Company Bank Name</label>
                            <div id="company-bank-container" class="uk-form-controls">
                                '. $company_bank_list.'
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
                                '. $bank_list.'
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
                            <label class="uk-form-label" for="transaction-id">Transaction ID</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="transaction-id" name="transaction_id" type="text" placeholder="Enter Transaction ID Name">
                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="transaction_id_error"></div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="image">Image or Screen Shot</label>
                            <div uk-form-custom="target: true" class="uk-form-custom uk-first-column">
                                <input id="image" type="file" name="image" '.$load_img_onchange.'>
                                <input class="uk-input uk-form-width-large" type="text" placeholder="Upload File" disabled="">
                                <div class="uk-text-danger uk-margin-small-top" id="image_error"></div>
                            </div>
                        </div>
                        <div>
                            <label class="uk-form-label" for="reference-no">Ref. Number</label>
                            <div class="uk-form-controls">
                                <input class="uk-input text-boxes-numeric" id="reference-no" name="reference_no" type="text" placeholder="Enter reference no" maxlength="11">
                            </div>
                            <div class="uk-text-danger uk-margin-small-top" id="reference_no_error"></div>
                        </div>
                        <div>
                            <img id="imgOutput" style="height:80px;" src="">
                        </div>
                    </div>
                    <div class="uk-text-center ">
                        <button style="cursor:pointer;" class="button primary" type="button" id="submit-payment" onclick="submitPayment()" >Submit</button>
                    </div>
                </form>
            </div>
            ';

        }
        /* else
        {
            $package_data_array = array(
                'selected_package_id'=>'',
                'description_link'=>'',
            );
            Session::put('package_info',$package_data_array);
            return "";
        } */



    }

    public function loadBankName(Request $request)
    {
        return createDropDownUiKit( "bank_name","", "SELECT id,name from banks where bank_type=$request->data and status_active=1 and is_deleted=0 order by name","id,name", 1, "-- Select --","", "",0,0 );
    }
    public function loadDropdownCompanyBank(Request $request)
    {

        return createDropDownUiKit( "company_bank_name","", "SELECT a.id,a.name from banks a,bank_accounts b where a.id=b.bank_id and a.bank_type=$request->data and a.status_active=1 and a.is_deleted=0  and b.status_active=1 and b.is_deleted=0 order by a.name","id,name", 1, "-- Select --","","loadHtmlElement_multiple('".route('loadBankDtls')."', this.value, 'company_account_no*company_account_id*branch_code*routing_no', 'account_number*id*branch_code*routing_no');",0,0 );
    }
    public function loadBankDtls(Request $request)
    {
        if (!$request->data) return "";

        $bank_dtls = BankAccount::select('id','account_number','branch_code','routing_no')->where('bank_id', $request->data)->first();
        return response()->json([
            'account_number' => $bank_dtls->account_number ?? '',
            'id'             => $bank_dtls->id ?? '',
            'branch_code'    => $bank_dtls->branch_code ?? '',
            'routing_no'     => $bank_dtls->routing_no ?? ''
        ]);

    }

    public function submitPayment(Request $request)
    {

        // Validation rules
        $request->validate([
            'payment_type'      => 'required|in:1,2|not_in:0',
            'bank_name'         => 'required|numeric|not_in:0',
            'company_bank_name' => 'required|numeric',
            'company_account_no'=> 'required|numeric',
            'account_holder'    => 'nullable|required_if:payment_type,1|string|max:255',
            'account_no'        => 'required|numeric',
            'branch'            => 'nullable|required_if:payment_type,1|string|max:255',
            'transaction_id'    => 'required|string|max:255',
            'image'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'reference_no'      => 'nullable|numeric||regex:/^\d{0,11}$/',
        ],
        [
            'payment_type.not_in'        => 'The payment type is required.',
            'branch.required_if'         => 'The branch name is required.',
            'account_holder.required_if' => 'The account holder field is required.',
            'bank_name.not_in'           => 'The bank name  is required.',
            'bank_name.numeric'          => 'Invalid bank name.',
            'company_account_no.numeric' => 'Invalid company account no.',
            'company_bank_name.numeric'  => 'Invalid company bank.',
            'account_no.numeric'         => 'Invalid account no.'
        ]);

        if (Session::get('package_info') == null || empty(Session::get('package_info'))) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again after some time.'
            ], 500);
        }
        $package_info = session('package_info');

        $msg_str = uploadImage( 'public/social-media/assets/images/package_purchase_img/',$request,'image'); //Custom Helpers
        $msgArr  = explode('*',$msg_str);
        PackagePurchaseMst::insert([
            'package_mst_id'        => $package_info['package_id'],
            'package_break_down_id' => $package_info['selected_package_id'],
            'user_id'               => auth()->id(),
            'package_value'         => $package_info['package_value'],
            'discount_per'          => $package_info['discount_per'],
            'payment_amount'        => $package_info['payable_amount'],
            'payment_method'        => $package_info['payment_method'],
            'payment_for'           => 1, //new package purchase
            'payment_type'          => $request->payment_type,
            'bank_name'             => $request->bank_name,
            'account_holder'        => $request->account_holder,
            'company_bank_id'       => $request->company_bank_name,
            'company_account_id'    => $request->company_account_id,
            'company_account_no'    => $request->company_account_no,
            'account_no'            => $request->account_no,
            'branch'                => $request->branch,
            'transaction_id'        => $request->transaction_id,
            'reference_no'          => $request->reference_no,
            'image'                 => $msgArr[1],
            'created_by'            => auth()->id(),
            'created_at'            => Carbon::now(),
        ]);
        $message ="Package purchase requested received and pending. It will be update soon";
        store_notification($message,auth()->id());
        // Logic to save the data or perform actions
        Session::forget('package_info');
        return response()->json(['success' => true, 'message' => 'Form submitted successfully']);
    }
    public function package_purchage_history()
    {
       $history = DB::table('package_purchase_mst','a')
        ->leftJoin('users as b', 'b.id', '=','a.user_id' )
        ->leftJoin('social_package_break_down as c', 'c.id', '=','a.package_break_down_id' )
        ->leftJoin('social_package_mst as d', 'd.id', '=','a.package_mst_id' )
        ->leftJoin('banks as e', 'e.id', '=','a.bank_name' )
        ->select('a.id','a.payment_method','a.payment_for','c.sub_package_name','d.package_name','b.name as purchase_by','a.package_value','a.discount_per','a.payment_amount','e.name as bank_name','a.account_holder','a.company_account_no','a.account_no','a.branch','a.transaction_id','a.image','a.payment_status','a.remarks' )
        ->orderBy('a.id','desc')
        ->get();

        return view('dashboard.socialMedia.package_purchage_history.index', compact('history'));
    }
    public function package_purchage_details(string $encrypt_id)
    {
        try {
            $id = Crypt::decrypt($encrypt_id);
        } catch (\Exception $e) {
            return back()->with('page_error', 'Invalid package purchase ID.');
        }
        $query = "SELECT id, name FROM banks WHERE status_active = 1 AND is_deleted = 0 ORDER BY name";
        $bank_array =  return_library_array($query,'id','name');
        $data = DB::table('package_purchase_mst','a')
        ->leftJoin('users as b', 'b.id', '=','a.user_id' )
        ->leftJoin('social_package_break_down as c', 'c.id', '=','a.package_break_down_id' )
        ->leftJoin('social_package_mst as d', 'd.id', '=','a.package_mst_id' )
        ->leftJoin('banks as e', 'e.id', '=','a.bank_name' )
        ->select('a.id','a.payment_method','a.payment_for','c.sub_package_name','d.package_name','b.name as purchase_by','a.package_value','a.discount_per','a.payment_amount','e.name as bank_name','a.account_holder','a.company_account_no','a.account_no','a.branch','a.transaction_id','a.image','a.payment_status','a.remarks','a.company_account_id','a.company_bank_id' )
        ->where('a.id', $id)
        ->orderBy('a.id','desc')
        ->first();
        if (!$data) {
            return back()->with('page_error', 'Data not found.');
        }

        return view('dashboard.socialMedia.package_purchage_history.show', compact('data','bank_array'));
    }
    public function update_purchage_status(Request $request, string $encrypt_id)
    {
        try {
            $id = Crypt::decrypt($encrypt_id);
        } catch (\Exception $e) {
            return back()->with('page_error', 'Invalid package purchase ID.');
        }

        $info = PackagePurchaseMst::findOrFail($id);
        $info->payment_status   = $request->status;
        $info->updated_by       = auth()->id();
        $info->updated_at       = Carbon::now();
        $info->save();

        $status = $request->status;
        $message= $status == 1 ? 'Payment request verified successfully' : ($status == 2 ? 'Payment request rejected' : 'Payment request pending');
        store_notification($message,$info->user_id);
        return back()->with('success','Updated successfully');
    }

    public function pay_renewal_fees()
    {
        $package_mst_id = DB::table('package_purchase_mst')->select('package_mst_id')->where(['user_id'=>auth()->id(),'payment_for'=>1,'payment_status'=>1,'status_active'=>1,'is_deleted'=>0])->first()->package_mst_id;

        $package = SocialPackageMst::select('id','package_name','short_desc','price','discount_per','discounted_amount','renewal_fee')->where(['status_active'=>1,'is_deleted'=>0,'id'=>$package_mst_id])->get();
        $package_features = SocialPackageFeatureDtls::select('id','mst_id','feature','short_desc')->where('status_active',1)->where('is_deleted',0)->get();
        return view('socialMedia.pages.renewal_fees', compact('package','package_features'));
    }
    public function offline_renewal_fees(Request $request ,string $package_id)
    {
        $package_mst_id = decrypt($package_id);
        $package        = SocialPackageMst::select('id','renewal_fee')->where('status_active',1)->where('id',$package_mst_id)->where('is_deleted',0)->first();

        return view('socialMedia.pages.offline_renewal_fees', compact('package'));
    }

    public function submitRenewalFees(Request $request)
    {
        // Validation rules
        $request->validate([
            'payment_type'      => 'required|in:1,2|not_in:0',
            'bank_name'         => 'required|numeric|not_in:0',
            'company_account_no'=> 'required|numeric',
            'account_holder'    => 'nullable|required_if:payment_type,1|string|max:255',
            'account_no'        => 'required|numeric',
            'branch'            => 'nullable|required_if:payment_type,1|string|max:255',
            'transaction_id'    => 'required|string|max:255',
            'image'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'amount'            => 'required',
        ],
        [
            'payment_type.not_in'        => 'The payment type is required.',
            'branch.required_if'         => 'The branch name is required.',
            'account_holder.required_if' => 'The account holder field is required.',
            'bank_name.not_in'           => 'The bank name  is required.',
            'bank_name.numeric'          => 'Invalid bank name.',
            'company_account_no.numeric' => 'Invalid company account no.',
            'account_no.numeric'         => 'Invalid account no.'
        ]);

        $package_mst_id = decrypt($request->package_id);
        $package        = SocialPackageMst::select('id','renewal_fee')->where('status_active',1)->where('id',$package_mst_id)->where('is_deleted',0)->first();

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again after some time.'
            ], 500);
        }

        $msg_str = uploadImage( 'public/social-media/assets/images/package_purchase_img/',$request,'image'); //Custom Helpers
        $msgArr  = explode('*',$msg_str);
        PackagePurchaseMst::insert([
            'package_mst_id'        => $package->id,
            'user_id'               => auth()->id(),
            'payment_amount'        => $package->renewal_fee,
            'payment_for'           => 2, // renewal fee
            'payment_method'        => 2,
            'payment_type'          => $request->payment_type,
            'bank_name'             => $request->bank_name,
            'account_holder'        => $request->account_holder,
            'company_bank_id'       => $request->company_bank_name,
            'company_account_id'    => $request->company_account_id,
            'company_account_no'    => $request->company_account_no,
            'account_no'            => $request->account_no,
            'branch'                => $request->branch,
            'transaction_id'        => $request->transaction_id,
            'image'                 => $msgArr[1],
            'created_by'            => auth()->id(),
            'created_at'            => Carbon::now(),
        ]);
        $message = "payment request of $request->amount BDT for renewal fee has been received and pending. It will be updated soon.";
        store_notification($message,auth()->id());
        return response()->json(['success' => true, 'message' => 'Form submitted successfully']);
    }
    public function submitPaymentV2(Request $request)
    {
        // Validation rules
        $request->validate([
            'payment_type'      => 'required|in:1,2|not_in:0',
            'bank_name'         => 'required|numeric|not_in:0',
            'company_account_no'=> 'required|numeric',
            'account_holder'    => 'nullable|required_if:payment_type,1|string|max:255',
            'account_no'        => 'required|numeric',
            'branch'            => 'nullable|required_if:payment_type,1|string|max:255',
            'transaction_id'    => 'required|string|max:255',
            'image'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'amount'            => 'required',
            'remarks'           => 'required',
        ],
        [
            'payment_type.not_in'        => 'The payment type is required.',
            'branch.required_if'         => 'The branch name is required.',
            'account_holder.required_if' => 'The account holder field is required.',
            'bank_name.not_in'           => 'The bank name  is required.',
            'bank_name.numeric'          => 'Invalid bank name.',
            'company_account_no.numeric' => 'Invalid company account no.',
            'account_no.numeric'         => 'Invalid account no.'
        ]);


        $msg_str = uploadImage( 'public/social-media/assets/images/package_purchase_img/',$request,'image'); //Custom Helpers
        $msgArr  = explode('*',$msg_str);
        PackagePurchaseMst::insert([
            'user_id'               => auth()->id(),
            'payment_for'           => 2, // renewal fee
            'payment_method'        => 2,
            'payment_type'          => $request->payment_type,
            'bank_name'             => $request->bank_name,
            'account_holder'        => $request->account_holder,
            'company_account_no'    => $request->company_account_no,
            'account_no'            => $request->account_no,
            'branch'                => $request->branch,
            'transaction_id'        => $request->transaction_id,
            'remarks'               => $request->remarks,
            'image'                 => $msgArr[1],
            'created_by'            => auth()->id(),
            'created_at'            => Carbon::now(),
        ]);
        $message = "Payment request of $request->amount BDT  has been received and pending. It will be updated soon.";
        store_notification($message,auth()->id());
        return response()->json(['success' => true, 'message' => 'Form submitted successfully']);
    }
    public function make_payment()
    {
        return view('socialMedia.pages.make_payment');
    }

    public function generatePDF(string $encrypt_id)
    {
        try {
            $id = Crypt::decrypt($encrypt_id);
        } catch (\Exception $e) {
            return back()->with('page_error', 'Invalid package purchase ID.');
        }

        $data = DB::table('package_purchase_mst','a')
        ->leftJoin('users as b', 'b.id', '=','a.user_id' )
        ->leftJoin('social_package_break_down as c', 'c.id', '=','a.package_break_down_id' )
        ->leftJoin('social_package_mst as d', 'd.id', '=','a.package_mst_id' )
        ->leftJoin('banks as e', 'e.id', '=','a.bank_name' )
        ->select('a.package_mst_id','a.id','a.payment_method','a.payment_for','c.sub_package_name','d.package_name','b.name as purchase_by','b.verification_code','b.email','b.phone_number','a.package_value','a.discount_per','a.payment_amount','e.name as bank_name','a.account_holder','a.company_account_no','a.account_no','a.branch','a.transaction_id','a.created_at','a.updated_at','a.remarks' )
        ->where('a.id', $id)
        ->where('a.payment_status', 1) // Only verified payments
        ->first();
        if (!$data) {
            return back()->with('page_error', 'Data not found. or payment request is not verified yet.');
        }

        try {
            $date        = Carbon::now();
            // return view('dashboard.pdf.purchase_invoice',compact('data','date'));
            $html        = view('dashboard.pdf.purchase_invoice',compact('data','date'))->render();
            $pdf         = Pdf::loadHTML($html);
            return $pdf->stream("invoice-".$date.'.pdf');
        } catch (\Exception $e) {
            return  back()->with('page_error', $e->getMessage());
        }
    }
}
