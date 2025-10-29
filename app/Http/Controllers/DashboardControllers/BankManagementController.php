<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\PackagePurchaseMst;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class BankManagementController extends Controller
{
    protected $bank_types = array(
        '1' => 'Bank',
        '2' => 'Mobile Banking'
    );
    protected $status_array = array(
        '0' => 'Inactive',
        '1' => 'Active',
    );
    protected $yes_no_array = array(
        '0' => 'No',
        '1' => 'yes'
    );

    public function __construct()
    {

    }

    public function index()
    {
        $banks = Bank::all();
        $bank_types     = $this->bank_types;
        $status_array   = $this->status_array;
        return  view('dashboard.banks.index',compact('banks', 'bank_types', 'status_array'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_type'=>'required|in:1,2',
            'bank_name'=>'required|max:150'
        ]);

        try
        {
            Bank::insert([
                'bank_type'  => $request->bank_type,
                'name'       => $request->bank_name,
                'created_by' => auth()->id(),
                'created_at' => Carbon::now(),
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
            $bank = Bank::findOrFail($id);
        } catch (Exception $e) {
            return back()->with('page_error', $e->getMessage());
        }

        $bank_types     = $this->bank_types;
        $status_array   = $this->status_array;
        $yes_no_array   = $this->yes_no_array;

        return view('dashboard.banks.edit', compact('bank', 'bank_types', 'status_array', 'yes_no_array'));
    }

    public function update(Request $request, string $crypent_id)
    {
        try {
            $id = decrypt($crypent_id);
        } catch (Exception $e) {
            return back()->with('page_error', 'Invalid URL.');
        }
        $request->validate([
            'bank_type'     => 'required|in:1,2',
            'bank_name'     => 'required|max:150',
            'status_active' => 'required|in:0,1',
            'is_deleted'    => 'required|in:0,1'
        ]);
        try {

            $is_bank_used = PackagePurchaseMst::where('bank_name', $id)->where('is_deleted',0)->where('status_active',1)->first()?->bank_name;
            $is_bank_used = $is_bank_used ?? 0;

            if ($is_bank_used) {
                return back()->with('page_error', 'This bank is used in a purchase table. You cannot update it.');
            }

            $bank = Bank::findOrFail($id);
            $bank->bank_type    = $request->bank_type;
            $bank->name         = $request->bank_name;
            $bank->status_active= $request->status_active;
            $bank->is_deleted   = $request->is_deleted;
            $bank->updated_by   = auth()->id();
            $bank->updated_at   = Carbon::now();
            $bank->save();

            return back()->with('success', 'Updated successfully');
        } catch (Exception $e) {
            return back()->with('page_error', $e->getMessage());
        }
    }


}
