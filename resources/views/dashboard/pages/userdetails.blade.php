@extends('dashboard.layout.dashboard')
@php
    $userinfo = DB::table('user_infos')->where('user_id',$user_id)->first();
    $user = DB::table('users')->select('verification_code')->where('id',$user_id)->first();
    $userinfoArray = (array)$userinfo;
    extract($userinfoArray); //Array to variable
    $verification_type_arr  = explode(',',$verification_type);
    $religionArray      = session('religionArray');
    $professionArray    = session('professionArray');
    $country_arr        = session('country_arr');
    $division_arr       = session('division_arr');
    $district_arr       = session('district_arr');
    $upazila_arr        = session('upazila_arr');
@endphp
@section('content')
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h4>User Information</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item "><a href="javascript:void(0)">Information</a>
                                <li class="breadcrumb-item active">User Information</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between" >
                                    <h4 class="header-title mb-4">User Info</h4>
                                    <div>
                                        <a class="btn btn-info" target="blank" href="{{route('userInfoList')}}">Back </a>
                                        @if ($user->verification_code)
                                            <a class="btn btn-primary" target="blank" href="{{route('generatePDF',$user_id)}}">Print <i class="fa fa-print"></i> </a>
                                        @endif
                                    </div>

                                </div>
                                <!-- Step 1 -->
                                <div class="row p-4">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <h5 class="fw-bold mb-2 me-3">Verification Type: </h5>
                                        <div class="form-check me-3">
                                            <input readonly class="form-check-input" value="1" type="checkbox"
                                                {{ in_array(1, $verification_type_arr) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckedDisabled1">Employee</label>
                                        </div>
                                        <div class="form-check">
                                            <input readonly class="form-check-input" id="flexCheckedDisabled2" name="verification_type[]" value="2" type="checkbox"
                                            {{ in_array(2, $verification_type_arr) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckedDisabled2">Freelancer</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Step 2 -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Full Name *</label>
                                        <input type="text" name="full_name" class="form-control" id="full_name" value="{{ $full_name ?? '' }}" placeholder="Full Name" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">First Name *</label>
                                        <input type="text" name="first_name" class="form-control"  value="{{ $first_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Middle Name</label>
                                        <input type="text" class="form-control" value="{{ $middle_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Last Name *</label>
                                        <input type="text"  class="form-control" value="{{ $last_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Gender *</label>
                                        <div class="d-flex">
                                            <div class="form-check ">
                                                <input class="form-check-input" type="radio" value="1" {{ isset($gender) && $gender == 1 ? 'checked' : '' }} disabled>
                                                <label class="form-check-label">Male</label>
                                            </div>
                                            <div class="form-check px-5">
                                                <input class="form-check-input" type="radio" value="2" {{ isset($gender) && $gender == 2 ? 'checked' : '' }} disabled>
                                                <label class="form-check-label">Female</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="3" {{ isset($gender) && $gender == 3 ? 'checked' : '' }} disabled>
                                                <label class="form-check-label">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Country *</label>
                                        <div id="country-container">
                                            {!! createDropDownBootstrap( "country", "", $country_arr, "", 1, "-- Select --", 20, "", 1, 0 ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Division *</label>
                                        <div id="division-container">
                                            @php $division = isset($division) ? $division : ""; @endphp
                                            {!! createDropDownBootstrap( "division", "", $division_arr, "", 1, "-- Select --", "$division", "", 1, 0 ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">District *</label>
                                        <div id="district-container">
                                            @php $district = isset($district) ? $district : ""; @endphp
                                            {!! createDropDownBootstrap( "district", "", $district_arr, "", 1, "-- Select --", "$district", "", 1, 0 ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Upazila *</label>
                                        <div id="upazila-container">
                                            @php $upazila = isset($upazila) ? $upazila : ""; @endphp
                                            {!! createDropDownBootstrap( "upazila", "", $upazila_arr, "", 1, "-- Select --", "$upazila", "", 1, 0 ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Postal Code *</label>
                                        <input type="text" class="form-control" value="{{ $postcode ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Address *</label>
                                        <textarea readonly class="form-control" rows="1">{{ $address ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Profession *</label>
                                        @php $profession = isset($profession) ? $profession : ""; @endphp
                                        {!! createDropDownBootstrap( "profession", "", $professionArray, "", 1, "-- Select --", "$profession", "", 1, 0 ) !!}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Religion *</label>
                                        <div class="form-group">
                                            @php $religion = isset($religion) ? $religion : ""; @endphp
                                            {!! createDropDownBootstrap( "religion", "", $religionArray, "", 1, "-- Select --", "$religion", "", 1, 0 ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Mobile *</label>
                                        <input type="text" class="form-control" value="{{ $mobile ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">E-mail *</label>
                                        <input type="email" class="form-control" value="{{ $email ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">NID OR DOB Certificate *</label>
                                        @php
                                            $nid_or_dob_arr = explode('##',$nid_or_dob);
                                        @endphp
                                        <div class="d-flex">
                                            @foreach ($nid_or_dob_arr as $img_name)
                                                @php
                                                    $img_path = asset('social-media/assets/images/user_documents/'.$img_name);
                                                @endphp
                                                <div style="padding-right:5px;">
                                                    <a href="{{ $img_path }}" target="_blank">
                                                        <img src="{{ $img_path }}" style="height:30px">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Document *</label>
                                        @php
                                            $documents_arr = explode('##',$documents);
                                        @endphp
                                        <div class="d-flex">
                                            @foreach ($documents_arr as $img_name)
                                                @php
                                                    $img_path = asset('social-media/assets/images/user_documents/'.$img_name);
                                                @endphp
                                                <div style="padding-right:5px;">
                                                    <a href="{{ $img_path }}" target="_blank">
                                                        <img src="{{ $img_path }}" style="height:30px">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="{{ !in_array(1, $verification_type_arr) ? 'd-none' : '' }}">
                                    <h3 class="fw-bold text-center my-4">Employee Verification</h3>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Audio Verification Code *</label>
                                            <input type="text" name="audio_verification_code" class="form-control" placeholder="Audio Verification Code" value="{{ $audio_verification_code ?? '' }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Video Verification Code *</label>
                                            <input type="text" name="video_verification_code" class="form-control" placeholder="Video Verification Code" value="{{ $video_verification_code ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                    <!-- Step 3 -->
                                <div class="row">
                                    <h3 class="fw-bold text-center my-4">Guardian Information (Father)</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Full Name *</label>
                                        <input type="text" name="full_name" class="form-control" id="full_name" value="{{ $father_full_name ?? '' }}" placeholder="Full Name" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">First Name *</label>
                                        <input type="text" name="first_name" class="form-control"  value="{{ $father_first_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Middle Name</label>
                                        <input type="text" class="form-control" value="{{ $father_middle_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Last Name *</label>
                                        <input type="text"  class="form-control" value="{{ $father_last_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Address *</label>
                                        <textarea readonly class="form-control" rows="1">{{ $father_address ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Profession *</label>
                                        @php $profession = isset($profession) ? $profession : ""; @endphp
                                        {!! createDropDownBootstrap( "profession", "", $professionArray, "", 1, "-- Select --", "$father_profession", "", 1, 0 ) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Religion *</label>
                                        <div class="form-group">
                                            @php $religion = isset($religion) ? $religion : ""; @endphp
                                            {!! createDropDownBootstrap( "religion", "", $religionArray, "", 1, "-- Select --", "$father_religion", "", 1, 0 ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Mobile *</label>
                                        <input type="text" class="form-control" value="{{ $father_mobile ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">E-mail *</label>
                                        <input type="email" class="form-control" value="{{ $father_email ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">NID OR DOB Certificate *</label>
                                        @php
                                            $father_nid_or_dob_arr = explode('##',$father_nid_or_dob);
                                        @endphp
                                        <div class="d-flex">
                                            @foreach ($father_nid_or_dob_arr as $img_name)
                                                @php
                                                    $img_path = asset('social-media/assets/images/user_documents/'.$img_name);
                                                @endphp
                                                <div style="padding-right:5px;">
                                                    <a href="{{ $img_path }}" target="_blank">
                                                        <img src="{{ $img_path }}" style="height:30px">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <h3 class="fw-bold text-center my-4">Guardian Information (Mother)</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Full Name *</label>
                                        <input type="text" name="full_name" class="form-control" id="full_name" value="{{ $mother_full_name ?? '' }}" placeholder="Full Name" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">First Name *</label>
                                        <input type="text" name="first_name" class="form-control"  value="{{ $mother_first_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Middle Name</label>
                                        <input type="text" class="form-control" value="{{ $mother_middle_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Last Name *</label>
                                        <input type="text"  class="form-control" value="{{ $mother_last_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Address *</label>
                                        <textarea readonly class="form-control" rows="1">{{ $mother_address ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Profession *</label>
                                        @php $profession = isset($profession) ? $profession : ""; @endphp
                                        {!! createDropDownBootstrap( "profession", "", $professionArray, "", 1, "-- Select --", "$mother_profession", "", 1, 0 ) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Religion *</label>
                                        <div class="form-group">
                                            @php $religion = isset($religion) ? $religion : ""; @endphp
                                            {!! createDropDownBootstrap( "religion", "", $religionArray, "", 1, "-- Select --", "$mother_religion", "", 1, 0 ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Mobile *</label>
                                        <input type="text" class="form-control" value="{{ $mother_mobile ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">E-mail *</label>
                                        <input type="email" class="form-control" value="{{ $mother_email ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">NID OR DOB Certificate *</label>
                                        @php
                                            $mother_nid_or_dob_arr = explode('##',$mother_nid_or_dob);
                                        @endphp
                                        <div class="d-flex">
                                            @foreach ($mother_nid_or_dob_arr as $img_name)
                                            @php
                                                $img_path = asset('social-media/assets/images/user_documents/'.$img_name);
                                            @endphp
                                            <div style="padding-right:5px;">
                                                <a href="{{ $img_path }}" target="_blank">
                                                    <img src="{{ $img_path }}" style="height:30px">
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <h3 class="fw-bold text-center my-4">Emergency Contact Person</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Full Name *</label>
                                        <input type="text" name="full_name" class="form-control" id="full_name" value="{{ $emergency_full_name ?? '' }}" placeholder="Full Name" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">First Name *</label>
                                        <input type="text" name="first_name" class="form-control"  value="{{ $emergency_first_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Middle Name</label>
                                        <input type="text" class="form-control" value="{{ $emergency_middle_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Last Name *</label>
                                        <input type="text"  class="form-control" value="{{ $emergency_last_name ?? '' }}" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Relation *</label>
                                        <input type="text"  class="form-control" value="{{ $emergency_relation ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Address *</label>
                                        <textarea readonly class="form-control" rows="1">{{ $emergency_address ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Profession *</label>
                                        @php $profession = isset($profession) ? $profession : ""; @endphp
                                        {!! createDropDownBootstrap( "profession", "", $professionArray, "", 1, "-- Select --", "$emergency_profession", "", 1, 0 ) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Religion *</label>
                                        <div class="form-group">
                                            @php $religion = isset($religion) ? $religion : ""; @endphp
                                            {!! createDropDownBootstrap( "religion", "", $religionArray, "", 1, "-- Select --", "$emergency_religion", "", 1, 0 ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Mobile *</label>
                                        <input type="text" class="form-control" value="{{ $emergency_mobile ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">E-mail *</label>
                                        <input type="email" class="form-control" value="{{ $emergency_email ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">NID OR DOB Certificate *</label>
                                        @php
                                            $emergency_nid_or_dob_arr = explode('##',$emergency_nid_or_dob);
                                        @endphp
                                        <div class="d-flex">
                                            @foreach ($emergency_nid_or_dob_arr as $img_name)
                                                @php
                                                    $img_path = asset('social-media/assets/images/user_documents/'.$img_name);
                                                @endphp
                                                <div style="padding-right:5px;">
                                                    <a href="{{ $img_path }}" target="_blank">
                                                        <img src="{{ $img_path }}" style="height:30px">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                                <form action="{{route('userInfoVerify')}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Varification Code</label>
                                            <input type="text" name="varification_code" class="form-control" value="{{$user->verification_code}}">
                                            <input type="hidden" name="user_id" class="form-control" value="{{$user_id}}">
                                            <input type="hidden" name="user_info_id" class="form-control" value="{{$id}}">
                                            @error('varification_code')
                                                <h6 class="text-danger"> {{ $message }}</h6>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6 d-flex">
                                            <div style="padding-right: 20px;">
                                                <button class="btn btn-primary text_boxes_numeric" type="submit"> Verify And Submit</button>
                                            </div>
                                            <div>
                                                <a class="btn btn-warning" href="{{route('userInfoReject')}}" onclick="event.preventDefault(); document.getElementById('reject_form').submit();"> Reject </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form id="reject_form" action="{{route('userInfoReject')}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="user_id" class="form-control" value="{{$user_id}}">
                                    <input type="hidden" name="user_info_id" class="form-control" value="{{$id}}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
