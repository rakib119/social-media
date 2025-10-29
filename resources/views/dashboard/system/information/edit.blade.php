@extends('dashboard.layout.dashboard')
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">DashBoard</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                            <li class="breadcrumb-item active">Edit Information</li>
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
                                        <h2 class=" mb-4">Edit Information</h2>
                                    </div>
                                    <div>
                                        <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
                                    </div>
                                </div>
                                <div class="form py-3">
                                    @php
                                        $id = $information->id;
                                    @endphp

                                    @if ($dimentions != 0)   {{-- Only Images --}}
                                        <form action="{{ route('info-setup.photo-update',$id) }}" enctype="multipart/form-data" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="photo"> Photo <span class="text-danger">*(w={{$dimentions['w']}}px, h:{{$dimentions['h']}}px)</span> </label>
                                                        <input id="photo" type="file"  class="form-control" name="photo" onchange="loadFile(event,'imgOutput')">
                                                        @error('photo')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                            <img id="imgOutput" src="{{ asset('assets/images/info/'.$information->value) }}" height="60">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-success">Update Photo</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('info-setup.update',$id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="value">Value
                                                            <span class="text-danger">*</span></label>
                                                        <input id="value" type="text" class="form-control"
                                                            value="{{ $information->value }}" name="value" autofocus>
                                                        @error('value')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
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
