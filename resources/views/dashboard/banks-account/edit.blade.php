@extends('dashboard.layout.dashboard')
@php
    $updated_id = Crypt::encrypt($bank_account->id);
@endphp
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('javacript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#bank_name').select2();
        } );
    </script>
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="page-title-box">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="page-title">
                                <h4>DashBoard</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Settings</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Bank Account Management</a></li>
                                    <li class="breadcrumb-item active">Edit Bank Account</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="page-content-wrapper">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class=" mb-4">Bank Management</h2> <span class="text-danger"> NB: if Status is <b>Active<b> then other account of this bank will be <b>Inactive automatically <b></span>
                                        </div>
                                        <div>
                                            <a href="{{ route('bank-account.index') }}" class="btn btn-warning">Back</a>
                                        </div>
                                    </div>
                                    <div class="form py-3">
                                        <form action="{{ route('bank-account.update',$updated_id) }}" method="post" >
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="bank_name">Bank Name <span class="text-danger">*</span></label>
                                                        <select id="bank_name" type="text" class="form-control" name="bank_name">
                                                            <option value="">Select Bank</option>
                                                            @foreach ($banks as  $bank)
                                                                <option  value="{{$bank->id}}" {{$bank->id ==$bank_account->bank_id ? "selected" : ""}}>{{$bank->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('bank_name')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="account_number">Account Number</label>
                                                        <input id="account_number" type="text" class="form-control"
                                                            value="{{ $bank_account->account_number ?? "" }}" name="account_number"
                                                            placeholder="Enter Account Number" >
                                                        @error('account_number')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="branch_name">Branch Name</label>
                                                        <input id="branch_name" type="text" class="form-control"
                                                            value="{{  $bank_account->branch_name ?? "" }}" name="branch_name"
                                                            placeholder="Enter Branch Name" >
                                                        @error('branch_name')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="branch_code">Branch Code</label>
                                                        <input id="branch_code" type="text" class="form-control" value="{{ $bank_account->branch_code ?? "" }}" name="branch_code" placeholder="Enter Branch Code" >
                                                        @error('branch_code')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="routing_no">Routing No</label>
                                                        <input id="routing_no" type="text" class="form-control" value="{{ $bank_account->branch_code ?? "" }}" name="routing_no" placeholder="Enter Routing No" >
                                                        @error('routing_no')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="account_holder">Account holder</label>
                                                        <input id="account_holder" type="text" class="form-control"
                                                            value="{{  $bank_account->account_holder ?? "" }}" name="account_holder"
                                                            placeholder="Enter Account Holder Name" >
                                                        @error('account_holder')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="status_active">Status Active <span class="text-danger">*</span> </label>

                                                        <select id="status_active" type="text" class="form-control" name="status_active">
                                                            <option value="">Select Status</option>
                                                            @foreach ($status_array as $id => $status)
                                                                <option value="{{$id}}" {{$bank_account->status_active==$id ? "selected" : ""}}>{{$status}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('status_active')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="is_deleted">Is Deleted <span class="text-danger">*</span> </label>

                                                        <select id="is_deleted" type="text" class="form-control" name="is_deleted">

                                                            @foreach ($yes_no_array as $id => $status)
                                                                <option value="{{$id}}" {{$bank_account->is_deleted==$id ? "selected" : ""}}>{{$status}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('is_deleted')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-success">Update </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
