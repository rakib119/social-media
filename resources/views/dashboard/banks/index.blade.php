
@extends('dashboard.layout.dashboard')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
@endsection
@section('javacript')
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"> </script>
    <script>
        $(document).ready( function () {
           $('#bankTable').DataTable();
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Bank Management</a></li>
                                <li class="breadcrumb-item active">Bank List</li>
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
                                        <h2 class=" mb-4">Bank Management</h2>
                                    </div>
                                    <div>
                                        <a href="{{ route('bank.index') }}" class="btn btn-warning">Back</a>
                                    </div>
                                </div>
                                <div class="form py-3">
                                    <form action="{{ route('bank.store') }}" method="post" >
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="bank_type">Bank Type <span class="text-danger">*</span></label>
                                                    <select id="bank_type" type="text" class="form-control" name="bank_type">
                                                        <option value="" {{old('bank_type') ? "" : "selected"}}>Select Bank Type</option>
                                                        @foreach ($bank_types as $id => $type)
                                                            <option  value="{{$id}}" {{old('bank_type') ==$id ? "selected" : ""}}>{{$type}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('bank_type')
                                                        <h6 class="text-danger"> {{ $message }}</h6>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="title">Bank Name <span class="text-danger">*</span></label>
                                                    <input id="bank_name" type="text" class="form-control"
                                                        value="{{  old('bank_name')??"" }}" name="bank_name"
                                                        placeholder="Enter Bank Name" >
                                                    @error('bank_name')
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
                                        <h2 class=" mb-4">Bank List</h2>
                                    </div>
                                </div>
                                <table id="bankTable" class="table table-centered table-nowrap mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Bank Type </th>
                                            <th>Name </th>
                                            <th>Status </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @php
                                            $status_badge = array(1 => 'badge bg-success', 2 => 'badge bg-danger');
                                        @endphp
                                        @foreach ( $banks as $bank)
                                            @php
                                                $updated_id = Crypt::encrypt($bank->id);
                                            @endphp
                                            <tr>
                                                <td>{{$loop->index+1}}</td>
                                                <td>{{ $bank_types[$bank->bank_type]}}</td>
                                                <td>{{ $bank->name}}</td>
                                                <td > <span class="{{$status_badge[$bank->status_active]}}"> {{ $status_array[$bank->status_active]}}</span></td>
                                                <td >
                                                    <!-- Example single danger button -->
                                                    <div class="btn-group">
                                                    <button type="button" class="btn btn-primary has-arrow dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action <i class="fas fa-angle-down"></i>
                                                    </button>
                                                        <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{route('bank.edit',$updated_id)}}">Edit</a>
                                                        <li>
                                                                <form id="deleteData{{$updated_id}}" action="{{ route('bank.destroy', $updated_id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <a style="cursor: pointer;"  class="dropdown-item" onclick="deleteData({{$updated_id}})">Delete</a>
                                                                </form>
                                                        </li>
                                                        </ul>
                                                    </div>
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

