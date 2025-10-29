<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\PackagePurchaseMst;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BankAccountController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $status_array   = config('arrays.status');
        $yes_no_array   = config('arrays.yes_no');

        $banks          = Bank::where('status_active',1)->where('is_deleted',0)->get();//select('id','name')->
        $bank_accounts  = DB::table('bank_accounts','a')->leftJoin('banks as b', 'b.id', '=','a.bank_id' )->select('a.id', 'b.name as bank_name', 'a.branch_name', 'a.account_number', 'a.account_holder', 'a.is_deleted', 'a.status_active')->get();

        return  view('dashboard.banks-account.index',compact('banks', 'status_array', 'yes_no_array', 'bank_accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name'      => 'required',
            'branch_name'    => 'nullable',
            'account_number' => ['required',
                Rule::unique('bank_accounts')->where(function ($query) use ($request) {
                    return $query->where('bank_id', $request->bank_name);
                }),
            ],
            'account_holder'    => 'nullable',
            'routing_no'        => 'nullable',
            'branch_code'       => 'nullable',
        ]);

        try
        {
            BankAccount::insert([
                'bank_id'           => $request->bank_name,
                'branch_name'       => $request->branch_name,
                'account_number'    => $request->account_number,
                'account_holder'    => $request->account_holder,
                'routing_no'        => $request->routing_no,
                'branch_code'       => $request->branch_code,
                'created_by'        => auth()->id(),
                'created_at'        => Carbon::now(),
            ]);
            return back()->with('success','Added successfully');
        }
        catch (Exception $e)
        {
            return back()->with('page_error',$e->getMessage());
        }
    }

    public function edit(string $crypent_id)
    {
        try {
            $id = decrypt($crypent_id);
        } catch (Exception $e) {
            return back()->with('page_error', 'Invalid URL.');
        }

        try {
            $bank_account = BankAccount::findOrFail($id);
            $banks        = Bank::where('status_active',1)->where('is_deleted',0)->get();
        } catch (Exception $e) {
            return back()->with('page_error', $e->getMessage());
        }

        $status_array   = config('arrays.status');
        $yes_no_array   = config('arrays.yes_no');

        return view('dashboard.banks-account.edit', compact('banks', 'bank_account', 'status_array', 'yes_no_array'));
    }

    public function update(Request $request, string $crypent_id)
    {
        try {
            $id = decrypt($crypent_id);
        } catch (Exception $e) {
            return back()->with('page_error', 'Invalid URL.');
        }

        $request->validate([
            'bank_name'      => 'required',
            'branch_name'    => 'nullable',
            'account_number' => ['required',
                Rule::unique('bank_accounts')->where(function ($query) use ($request,$id) {
                    return $query->where('bank_id', $request->bank_name)->where('id', '!=', $id);
                }),
            ],
            'account_holder' => 'nullable',
            'routing_no'     => 'nullable',
            'branch_code'    => 'nullable',
            'status_active'  => 'required|in:1,2',
            'is_deleted'     => 'required|in:0,1'
        ]);

        try {
            $success_status = '.';

            if ($request->is_deleted == 1)
            {
                $is_account_used = PackagePurchaseMst::where('company_bank_id', $id)->where('is_deleted',0)->where('status_active',1)->first()?->company_bank_id;

                if ($is_account_used)
                {
                    return back()->with('page_error', 'This account is used in a purchase table. You cannot delete it.');
                }
            }

            if ($request->status_active==1) //Active
            {
                $inactive_status = BankAccount::where('bank_id', $request->bank_name)
                    ->where('is_deleted', 0)
                    ->where('status_active', 1)
                    ->where('id', '!=', $id)
                    ->update(['status_active' => 0,'updated_by' => auth()->id(), 'updated_at' => Carbon::now()]);
                    if ($inactive_status) {
                        $success_status = ' and deactivated other accounts of this bank.';
                    }
            }


            $Bank_account = BankAccount::findOrFail($id);
            $Bank_account->bank_id          = $request->bank_name;
            $Bank_account->branch_name      = $request->branch_name;
            $Bank_account->account_number   = $request->account_number;
            $Bank_account->account_holder   = $request->account_holder;
            $Bank_account->routing_no       = $request->routing_no;
            $Bank_account->branch_code      = $request->branch_code;
            $Bank_account->status_active    = $request->status_active;
            $Bank_account->is_deleted       = $request->is_deleted;
            $Bank_account->updated_by       = auth()->id();
            $Bank_account->updated_at       = Carbon::now();
            $Bank_account->save();

            return back()->with('success', 'Updated successfully'. $success_status);
        } catch (Exception $e) {
            return back()->with('page_error', $e->getMessage());
        }
    }


}
