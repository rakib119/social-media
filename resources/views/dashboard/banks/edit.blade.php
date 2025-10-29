@extends('dashboard.layout.dashboard')
@php
    $updated_id = Crypt::encrypt($bank->id);
@endphp
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
                                    <li class="breadcrumb-item active">Edit Bank</li>
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
                                        <form action="{{ route('bank.update',$updated_id) }}" method="post" >
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="bank_type">Bank Type <span class="text-danger">*</span></label>
                                                        <select id="bank_type" type="text" class="form-control" name="bank_type">
                                                            <option value="" >Select Bank Type</option>
                                                            @foreach ($bank_types as $id => $type)
                                                                <option  value="{{$id}}" {{$bank->bank_type==$id ? "selected" : ""}}>{{$type}}</option>
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
                                                        <input id="bank_name" type="text" class="form-control" value="{{  $bank->name ?? "" }}" name="bank_name" placeholder="Enter Bank Name" >
                                                        @error('bank_name')
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
                                                                <option value="{{$id}}" {{$bank->status_active==$id ? "selected" : ""}}>{{$status}}</option>
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
                                                                <option value="{{$id}}" {{$bank->is_deleted==$id ? "selected" : ""}}>{{$status}}</option>
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
