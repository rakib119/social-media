<?php

namespace App\Http\Controllers;

use App\Models\PackagePurchaseMst;
use App\Models\SocialPackageMst;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;

class AamarPayController extends Controller
{

    public function payment()
    {

        if (Session::get('package_info') == null || empty(Session::get('package_info'))) {
            return back()->with('page_error' ,'Something went wrong, please try again after some time.');
        }

        $payment_debug = env('PAYMENT_DEBUG', false);
        if($payment_debug)
        {
            $store_id       = env('SANDBOX_STORE_ID');
            $signature_key  = env('SANDBOX_SIGNATURE_KEY');
            $url            = env('SANDBOX_URL');
        }
        else
        {
            $store_id       = env('AAMARPAY_STORE_ID');
            $signature_key  = env('AAMARPAY_SIGNATURE_KEY');
            $url            = env('AAMARPAY_URL');
        }

        $package_info = session('package_info');
        //UNIQUE TRX ID of 10 characters munber and letter
        //You can use any unique id generator, here we are using a simple method to generate
        $rand_str       =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
        $transaction_id = 'AP-'.auth()->id()."-".$package_info['selected_package_id']."-".time()."-".$rand_str;
        PackagePurchaseMst::insert([
            'package_mst_id'        => $package_info['package_id'],
            'package_break_down_id' => $package_info['selected_package_id'],
            'user_id'               => auth()->id(),
            'package_value'         => $package_info['package_value'],
            'discount_per'          => $package_info['discount_per'],
            'payment_amount'        => $package_info['payable_amount'],
            'payment_method'        => 1,//online payment
            'payment_status'        => 0, //0=unpaid, 1=paid
            'payment_for'           => 1, //new package purchase
            'sys_trnx_id'           => $transaction_id,
            'created_by'            => auth()->id(),
            'created_at'            => Carbon::now(),
        ]);

        $amount         = $package_info['payable_amount'];




        //USER INFO

        $user_info = DB::table('users','a')
            ->leftJoin('user_infos as b','a.id','=','b.user_id')
            ->leftJoin('countries as c','c.id','=','b.country')
            ->leftJoin('districts as d','d.id','=','b.district')
            ->leftJoin('divisions as e','e.id','=','b.division')
            ->select('a.name','a.email','a.phone_number','b.address','d.name as district','b.postcode','c.name as country','e.name as division')
            ->where('a.id',auth()->id())
            ->first();
        $add2 = $user_info->address.','.$user_info->district.','.$user_info->division.','.$user_info->postcode.','.$user_info->country;
        $phone = $user_info->phone_number ?? '1704';
        $phone = '+880'. $phone;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL             => $url,
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_ENCODING        => '',
        CURLOPT_MAXREDIRS       => 10,
        CURLOPT_TIMEOUT         => 0,
        CURLOPT_FOLLOWLOCATION  => true,
        CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST   => 'POST',
        CURLOPT_POSTFIELDS      =>'{
            "store_id"      : "'.$store_id.'",
            "tran_id"       : "'.$transaction_id.'",
            "success_url"   : "'.route('pay.success').'",
            "fail_url"      : "'.route('pay.fail').'",
            "cancel_url"    : "'.route('pay.cancel').'",
            "amount"        : "'.$amount.'",
            "currency"      : "BDT",
            "signature_key" : "'.$signature_key.'",
            "desc"          : "Package Purchase",
            "cus_name"      : "'.$user_info->name.'",
            "cus_email"     : "'.$user_info->email.'",
            "cus_add1"      : "'.$user_info->address.'",
            "cus_add2"      : "'.$add2.'",
            "cus_city"      : "'.$user_info->district.'",
            "cus_state"     : "'.$user_info->division.'",
            "cus_postcode"  : "'.$user_info->postcode.'",
            "cus_country"   : "'.$user_info->country.'",
            "cus_phone"     : "'.$phone.'",
            "type"          : "json"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // dd($response);

        $responseObj = json_decode($response);
        Session::forget('package_info');
        if(isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {

            $paymentUrl = $responseObj->payment_url;
            // dd($paymentUrl);
            return redirect()->away($paymentUrl);

        }else{
            return back()->with('page_error','something went wrong');
        }



    }

    public function submitRenewalFees(string $crypent_id)
    {


        try {
            $id = decrypt($crypent_id);
        } catch (Exception $e) {
            return back()->with('page_error', 'Invalid URL.');
        }

        try {
            $package = SocialPackageMst::findOrFail($id);
        } catch (Exception $e) {
            return back()->with('page_error', 'somnething went wrong, please try again after some time.');
        }

        $payment_debug = env('PAYMENT_DEBUG', false);
        if($payment_debug)
        {
            $store_id       = env('SANDBOX_STORE_ID');
            $signature_key  = env('SANDBOX_SIGNATURE_KEY');
            $url            = env('SANDBOX_URL');
        }
        else
        {
            $store_id       = env('AAMARPAY_STORE_ID');
            $signature_key  = env('AAMARPAY_SIGNATURE_KEY');
            $url            = env('AAMARPAY_URL');
        }

        $rand_str       =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
        $transaction_id = 'AP-'.auth()->id()."-".$package->id."-".time()."-".$rand_str;

        $renewal_fee    = $package->renewal_fee;

        PackagePurchaseMst::insert([
            'package_mst_id'        => $package->id,
            'user_id'               => auth()->id(),
            'payment_amount'        => $renewal_fee,
            'payment_method'        => 1,//online payment
            'payment_status'        => 0, //0=unpaid, 1=paid
            'payment_for'           => 2, // renewal fee
            'sys_trnx_id'           => $transaction_id,
            'created_by'            => auth()->id(),
            'created_at'            => Carbon::now(),
        ]);

        //USER INFO

        $user_info = DB::table('users','a')
            ->leftJoin('user_infos as b','a.id','=','b.user_id')
            ->leftJoin('countries as c','c.id','=','b.country')
            ->leftJoin('districts as d','d.id','=','b.district')
            ->leftJoin('divisions as e','e.id','=','b.division')
            ->select('a.name','a.email','a.phone_number','b.address','d.name as district','b.postcode','c.name as country','e.name as division')
            ->where('a.id',auth()->id())
            ->first();
        $add2 = $user_info->address.','.$user_info->district.','.$user_info->division.','.$user_info->postcode.','.$user_info->country;
        $phone = $user_info->phone_number ?? '1704';
        $phone = '+880'. $phone;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL             => $url,
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_ENCODING        => '',
        CURLOPT_MAXREDIRS       => 10,
        CURLOPT_TIMEOUT         => 0,
        CURLOPT_FOLLOWLOCATION  => true,
        CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST   => 'POST',
        CURLOPT_POSTFIELDS      =>'{
            "store_id"      : "'.$store_id.'",
            "tran_id"       : "'.$transaction_id.'",
            "success_url"   : "'.route('pay.success').'",
            "fail_url"      : "'.route('pay.fail').'",
            "cancel_url"    : "'.route('pay.cancel').'",
            "amount"        : "'.$renewal_fee.'",
            "currency"      : "BDT",
            "signature_key" : "'.$signature_key.'",
            "desc"          : "Package Purchase",
            "cus_name"      : "'.$user_info->name.'",
            "cus_email"     : "'.$user_info->email.'",
            "cus_add1"      : "'.$user_info->address.'",
            "cus_add2"      : "'.$add2.'",
            "cus_city"      : "'.$user_info->district.'",
            "cus_state"     : "'.$user_info->division.'",
            "cus_postcode"  : "'.$user_info->postcode.'",
            "cus_country"   : "'.$user_info->country.'",
            "cus_phone"     : "'.$phone.'",
            "type"          : "json"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // dd($response);

        $responseObj = json_decode($response);
        Session::forget('package_info');
        if(isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {

            $paymentUrl = $responseObj->payment_url;
            // dd($paymentUrl);
            return redirect()->away($paymentUrl);

        }else{
            return back()->with('page_error','something went wrong');
        }


    }

    public function success(Request $request)
    {

        $request_id     = $request->mer_txnid;

        $payment_debug = env('PAYMENT_DEBUG', false);
        if($payment_debug)//testing environment
        {
            $store_id       = env('SANDBOX_STORE_ID');
            $signature_key  = env('SANDBOX_SIGNATURE_KEY');
            $trxcheck_url   = env('SANDBOX_TRXCHECK_URL');
        }
        else //production environment
        {
            $store_id       = env('AAMARPAY_STORE_ID');
            $signature_key  = env('AAMARPAY_SIGNATURE_KEY');
            $trxcheck_url   = env('AAMARPAY_TRXCHECK_URL');
        }


        //verify the transection using Search Transection API

        $url = "$trxcheck_url?request_id=$request_id&store_id=$store_id&signature_key=$signature_key&type=json";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'GET',
        ));

        $response   = curl_exec($curl);
        $response   = json_decode($response);
        $info       = PackagePurchaseMst::where('sys_trnx_id', $request_id)->first();
        if(!$info){
            return redirect()->route('home')->with('page_error','Payment request not found, please try again later.');
        }
        $info->payment_status   = 1;
        $info->transaction_id   = $response->bank_trxid;
        $info->updated_at       = Carbon::now();
        $info->save();

        $message= 'Payment request verified successfully';
        store_notification($message,$info->user_id);
        curl_close($curl);

        return redirect()->route('home', ['payment_status' => 'success']);

    }

    public function fail(Request $request)
    {
        $request_id             = $request->mer_txnid;
        $info                   = PackagePurchaseMst::where('sys_trnx_id', $request_id)->first();
        $info->payment_status   = 2;
        $info->updated_at       = Carbon::now();
        $info->save();
        Session::forget('package_info');
        return redirect()->route('home')->with('page_error','Payment failed, please try again later.');
    }

    public function cancel()
    {
        Session::forget('package_info');
        return redirect()->route('home')->with('page_error','Payment cancled, please try again later.');
    }
}
