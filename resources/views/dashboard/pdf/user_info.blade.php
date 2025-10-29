@php
    $userinfo   = DB::table('user_infos')->where('user_id',$user_id)->first();
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

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $full_name ?? '&nbsp;' }} Pdf</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .pagenum:before {
            content: counter(page);
        }
        h2 {
            text-align: left;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        td {
            width: 49%; /* Each column takes 48% */
            padding-right: 30px; /* Add 2% gap on the right of the first column */
            vertical-align: top;
        }
        td:last-child {
            padding-right: 0; /* Remove right padding from the last column */
        }
        td input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        td label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        select {
            width: 96%; /* Adjust to fit the container/table width */
            padding: 10px 15px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            background-color: #f4f6f8; /* Light gray background */
            font-size: 14px;
            color: #374151; /* Text color */
            appearance: none; /* Removes default styling for dropdown */
            -webkit-appearance: none;
            -moz-appearance: none;
            position: relative;
        }
        select:focus {
            outline: none;
            border-color: #3b82f6; /* Add focus border color */
        }
        .select-container {
            position: relative;
        }
        .select-container:after {
            content: '\\25BC'; /* Downward arrow symbol */
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280; /* Arrow color */
            pointer-events: none;
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 2px solid #ccc; /* Optional divider for the header */
        }
        .header img {
            width: 80px; /* Adjust logo size */
            height: auto;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0 5px;
        }
        .document-number {
            font-size: 14px;
            color: #555;
        }
        td input[type="checkbox"],td input[type="radio"] {
            vertical-align: middle;
            margin-right: 5px;
        }

        td span {
            vertical-align: middle;
            display: inline-block;
        }
    </style>

</head>

<body>
    <header>
        <div class="header">
            <img src="{{$logo}}" width="100" alt="Ascentaverse">
            <div class="company-name">User Verification form</div>
            <div class="document-number">Verification Code: {{$user->verification_code}}</div>
        </div>
    </header>

    <table style="margin-top: 20px;">
        <tr>
            <td>
                <label>Verification Type</label>
                <input  type="checkbox" {{ in_array(1, $verification_type_arr) ? 'checked' : '' }}> <span>Employee</span>

                <input  type="checkbox" {{ in_array(2, $verification_type_arr) ? 'checked' : '' }}> <span >Freelancer</span>
            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <h3 >Personal Information</h3>
            </td>
        </tr>
        <tr>
            <td>
                <label>Full Name</label>
                <input type="text" value="{{ $full_name ?? '&nbsp;' }}" >
            </td>
            <td>
                <label>First Name</label>
                <input type="text" value="{{ $first_name ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td>
                <label>Middle Name</label>
                <input type="text" value="{{ $middle_name ?? '&nbsp;' }}" >
            </td>
            <td>
                <label>Last Name</label>
                <input type="text" value="{{ $last_name ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td>
                <label>Gender</label>
                <div>
                    <input  type="radio" {{ isset($gender) && $gender == 1 ? 'checked' : '' }}> <span>Male</span>
                    <input  type="radio" {{ isset($gender) && $gender == 2 ? 'checked' : '' }}> <span>Female</span>
                    <input  type="radio" {{ isset($gender) && $gender == 3 ? 'checked' : '' }}> <span>Other</span>

                </div>
            </td>
            <td>
                <label>Country</label>
                <div>
                    {!! createDropDownBootstrap( "country", "", $country_arr, "", 1, "-- Select --", 20, "", 1, 0 ) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label >Division</label>
                @php $division = isset($division) ? $division : ""; @endphp
                {!! createDropDownBootstrap( "division", "", $division_arr, "", 1, "-- Select --", "$division", "", 1, 0 ) !!}
            </td>
            <td>
                <label >District</label>
                <div id="district-container">
                    @php $district = isset($district) ? $district : ""; @endphp
                    {!! createDropDownBootstrap( "district", "", $district_arr, "", 1, "-- Select --", "$district", "", 1, 0 ) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label >Upazila</label>
                <div id="upazila-container">
                    @php $upazila = isset($upazila) ? $upazila : ""; @endphp
                    {!! createDropDownBootstrap( "upazila", "", $upazila_arr, "", 1, "-- Select --", "$upazila", "", 1, 0 ) !!}
                </div>
            </td>
            <td>
                <label >Profession</label>
                @php $profession = isset($profession) ? $profession : ""; @endphp
                {!! createDropDownBootstrap( "profession", "", $professionArray, "", 1, "-- Select --", "$profession", "", 1, 0 ) !!}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label >Address</label>
                <input type="text" value="{{ $address ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td>
                <label >Religion</label>
                <div class="select-container">
                    @php $religion = isset($religion) ? $religion : ""; @endphp
                    {!! createDropDownBootstrap( "religion", "", $religionArray, "", 1, "-- Select --", "$religion", "", 1, 0 ) !!}
                </div>
            </td>
            <td>
                <label >Mobile</label>
                <input type="text" value="{{ $mobile ?? '&nbsp;' }}" >
            </td>

        </tr>
        <tr>
            <td>
                <label >E-mail</label>
                <input type="text" value="{{ $father_email ?? '&nbsp;' }}" >
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
        {{-- <tr>
            <td>
                <label >NID OR DOB Certificate</label>
                <input  type="checkbox" checked> <span>Verified</span>
            </td>
            <td>
                <label >Document</label>
                <input  type="checkbox" checked> <span>Verified</span>
            </td>
        </tr> --}}
        <tr>
            <td colspan="2" align="center">
                <h3 >Guardian Information (Father)</h3>
            </td>
        </tr>
        <tr>
            <td>
                <label>Full Name</label>
                <input type="text" value="{{ $father_full_name ?? '&nbsp;' }}" >
            </td>
            <td>
                <label>First Name</label>
                <input type="text" value="{{ $father_first_name ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td>
                <label>Middle Name</label>
                <input type="text" value="{{ $father_middle_name ?? '&nbsp;' }}" >
            </td>
            <td>
                <label>Last Name</label>
                <input type="text" value="{{ $father_last_name ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label >Address</label>
                <input type="text" value="{{ $father_address ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td>
                <label >Profession</label>
                @php $father_profession = isset($father_profession) ? $father_profession : ""; @endphp
                {!! createDropDownBootstrap( "profession", "", $professionArray, "", 1, "-- Select --", "$father_profession", "", 1, 0 ) !!}
            </td>
            <td>
                <label >Religion</label>
                <div class="select-container">
                    @php $father_religion = isset($father_religion) ? $father_religion : ""; @endphp
                    {!! createDropDownBootstrap( "religion", "", $religionArray, "", 1, "-- Select --", "$father_religion", "", 1, 0 ) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label >Mobile</label>
                <input type="text" value="{{ $father_mobile ?? '&nbsp;' }}" >
            </td>
            <td>
                <label >E-mail</label>
                <input type="text" value="{{ $father_email ?? '&nbsp;' }}" >
            </td>
        </tr>
        {{-- <tr>
            <td>
                <label >NID OR DOB Certificate</label>
                <input type="text" value="verified">
            </td>
            <td></td>
        </tr> --}}
        <tr>
            <td colspan="2" align="center">
                <h3 >Guardian Information (Mother)</h3>
            </td>
        </tr>
        <tr>
            <td>
                <label>Full Name</label>
                <input type="text" value="{{ $mother_full_name ?? '&nbsp;' }}" >
            </td>
            <td>
                <label>First Name</label>
                <input type="text" value="{{ $mother_first_name ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td>
                <label>Middle Name</label>
                <input type="text" value="{{ $mother_middle_name ?? '&nbsp;' }}" >
            </td>
            <td>
                <label>Last Name</label>
                <input type="text" value="{{ $mother_last_name ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label >Address</label>
                <input type="text" value="{{ $mother_address ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td>
                <label >Profession</label>
                @php $mother_profession = isset($mother_profession) ? $mother_profession : ""; @endphp
                {!! createDropDownBootstrap( "profession", "", $professionArray, "", 1, "-- Select --", "$mother_profession", "", 1, 0 ) !!}
            </td>
            <td>
                <label >Religion</label>
                <div class="select-container">
                    @php $mother_religion = isset($mother_religion) ? $mother_religion : ""; @endphp
                    {!! createDropDownBootstrap( "religion", "", $religionArray, "", 1, "-- Select --", "$mother_religion", "", 1, 0 ) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label >Mobile</label>
                <input type="text" value="{{ $mother_mobile ?? '&nbsp;' }}" >
            </td>
            <td>
                <label >E-mail</label>
                <input type="text" value="{{ $mother_email ?? '&nbsp;' }}" >
            </td>
        </tr>
        {{-- <tr>
            <td colspan="2">
                <label >NID OR DOB Certificate</label>
                <input  type="checkbox" checked> <span>Verified</span>
            </td>

        </tr> --}}
        <tr>
            <td colspan="2" align="center">
                <h3 >Emergency Contact Person</h3>
            </td>
        </tr>
        <tr>
            <td>
                <label>Full Name</label>
                <input type="text" value="{{ $emergency_full_name ?? '&nbsp;' }}" >
            </td>
            <td>
                <label>First Name</label>
                <input type="text" value="{{ $emergency_first_name ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td>
                <label>Middle Name</label>
                <input type="text" value="{{ $emergency_middle_name ?? '&nbsp;' }}" >
            </td>
            <td>
                <label>Last Name</label>
                <input type="text" value="{{ $emergency_last_name ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label >Address</label>
                <input type="text" value="{{ $emergency_address ?? '&nbsp;' }}" >
            </td>
        </tr>
        <tr>
            <td>
                <label>Relation</label>
                <input type="text"  value="{{ $emergency_relation ?? '&nbsp;' }}">
            </td>
            <td>
                <label>Profession</label>
                @php $emergency_profession = isset($emergency_profession) ? $emergency_profession : ""; @endphp
                {!! createDropDownBootstrap( "profession", "", $professionArray, "", 1, "-- Select --", "$emergency_profession", "", 1, 0 ) !!}
            </td>
        </tr>
        <tr>
            <td>
                <label >Religion</label>
                <div class="select-container">
                    @php $emergency_religion = isset($emergency_religion) ? $emergency_religion : ""; @endphp
                    {!! createDropDownBootstrap( "religion", "", $religionArray, "", 1, "-- Select --", "$emergency_religion", "", 1, 0 ) !!}
                </div>
            </td>
            <td>
                <label >Mobile</label>
                <input type="text" value="{{ $emergency_mobile ?? '&nbsp;' }}" >
            </td>

        </tr>
        <tr>
            <td>
                <label >E-mail</label>
                <input type="text" value="{{ $emergency_email ?? '&nbsp;' }}" >
            </td>
            {{-- <td>
                <label >NID OR DOB Certificate</label>
                <input  style="margin-top: 15px;"  type="checkbox" checked> <span style="margin-top: 15px;">Verified</span>
            </td> --}}
        </tr>
    </table>
    <aside>
        <hr />
        <b>Terms &amp; Conditions</b>
        <p>
          <!--Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod scelerisque pellentesque. Nullam at urna cursus, efficitur sapien vitae, porttitor tellus. Aliquam quis semper nisi. Morbi euismod scelerisque pellentesque. Nullam at urna cursus, efficitur sapien vitae, porttitor tellus.-->
        </p>
      </aside>
</body>
</html>
