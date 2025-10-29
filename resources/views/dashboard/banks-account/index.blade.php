
@extends('dashboard.layout.dashboard')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('javacript')
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#bankTable').DataTable();
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
                                    <li class="breadcrumb-item active">Bank Account List</li>
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
                                            <h2 class=" mb-4">Bank Account Management</h2>
                                        </div>
                                        <div>
                                            <a href="{{ route('bank-account.index') }}" class="btn btn-warning">Back</a>
                                        </div>
                                    </div>
                                    <div class="form py-3">
                                        <form action="{{ route('bank-account.store') }}" method="post" >
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="bank_name">Bank Name <span class="text-danger">*</span></label>
                                                        <select id="bank_name" type="text" class="form-control" name="bank_name">
                                                            <option value="" {{old('bank_name') ? "" : "selected"}}>Select Bank</option>
                                                            @foreach ($banks as  $bank)
                                                                <option  value="{{$bank->id}}" {{old('bank_name') ==$bank->id ? "selected" : ""}}>{{$bank->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('bank_name')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="account_number">Account Number <span class="text-danger">*</span></label>
                                                        <input id="account_number" type="text" class="form-control"
                                                            value="{{  old('account_number')??"" }}" name="account_number"
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
                                                            value="{{  old('branch_name')??"" }}" name="branch_name"
                                                            placeholder="Enter Branch Name" >
                                                        @error('branch_name')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="branch_code">Branch Code</label>
                                                        <input id="branch_code" type="text" class="form-control" value="{{  old('branch_code')??"" }}" name="branch_code" placeholder="Enter Routing No" >
                                                        @error('branch_code')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="routing_no">Routing No</label>
                                                        <input id="routing_no" type="text" class="form-control" value="{{  old('routing_no')??"" }}" name="routing_no" placeholder="Enter Routing No" >
                                                        @error('routing_no')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="account_holder">Account holder</label>
                                                        <input id="account_holder" type="text" class="form-control"
                                                            value="{{  old('account_holder')??"" }}" name="account_holder"
                                                            placeholder="Enter Account Holder Name" >
                                                        @error('account_holder')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-success">Save </button>
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
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-content-wrapper">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class=" mb-4">Bank Account List</h2>
                                        </div>
                                    </div>
                                    <table id="bankTable" class="table table-centered table-nowrap mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Bank Name </th>
                                                <th>Branch</th>
                                                <th>Account Holder</th>
                                                <th>Account Number</th>
                                                <th>Status </th>
                                                <th>Is Deleted </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @php
                                                $status_badge = array(1 => 'badge bg-success', 2 => 'badge bg-danger');
                                                $yes_no_badge = array(0 => 'badge bg-success', 1 => 'badge bg-danger');
                                            @endphp
                                            @foreach ( $bank_accounts as $row)
                                                @php
                                                    $updated_id = Crypt::encrypt($row->id);
                                                @endphp
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td>{{ $row->bank_name }}</td>
                                                    <td>{{ $row->branch_name }}</td>
                                                    <td>{{ $row->account_holder}}</td>
                                                    <td>{{ $row->account_number}}</td>
                                                    <td> <span class="{{$status_badge[$row->status_active]}}"> {{ $status_array[$row->status_active]}}</span></td>
                                                    <td> <span class="{{$yes_no_badge[$row->is_deleted]}}"> {{ $yes_no_array[$row->is_deleted]}}</span></td>
                                                    <td>
                                                        <a class="btn btn-danger" href="{{route('bank-account.edit',$updated_id)}}">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

