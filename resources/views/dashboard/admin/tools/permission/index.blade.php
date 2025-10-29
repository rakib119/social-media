@extends('dashboard.layout.dashboard')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">DashBoard</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                <li class="breadcrumb-item active">Menu & Permission</li>
                            </ol>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="page-content-wrapper">
                    <div>
                        <h1 class="text-light">Update menu name if needed.</h1>
                    </div>
                    <div class="accordion" id="accordionExample">
                        @foreach ($menues as $root_id=> $menuData)
                            @php
                                $main_menu = isset($menu_name_array[$root_id]) ? $menu_name_array[$root_id] : "yy";
                            @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{$root_id}}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$root_id}}" aria-expanded="true" aria-controls="collapse{{$root_id}}">
                                        {{ $main_menu }}
                                    </button>
                                </h2>
                                <div id="collapse{{$root_id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$root_id}}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table id="myTable" class="table table-centered table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Route Name</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($menuData as $id => $v)

                                                    @php
                                                        $menu_name  = isset($menu_name_array[$id] ) ? $menu_name_array[$id] : "";
                                                        $route      = isset($v['route_name'])   ? $v['route_name']   : "";
                                                    @endphp
                                                    <tr>
                                                        <td>{{$loop->index+1}}</td>
                                                        <td>{{ $route}}</td>
                                                        <td> {{ $menu_name }} </td>
                                                        <td >
                                                            <a class="btn btn-primary" href="{{route('permission.edit', Crypt::encrypt($id))}}">Edit</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-content-wrapper">
                    {{-- CHANGE ROLE --}}
                    {{-- CHANGE ROLE --}}
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class=" mt-4">Change Role</h2>
                                        </div>
                                    </div>
                                    <div class="form py-3">
                                        <form action="{{ route('role.update')  }}"  method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="user_id">User Name
                                                            <span class="text-danger">*</span></label>
                                                            <select id="user_id" class="form-select" aria-label="Default select example" name="user_id">
                                                                <option value="">--Select User--</option>
                                                                @foreach ($users as $user)
                                                                    <option value="{{$user->id}}">{{$user->name."-".$user->verification_code}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('user')
                                                                <h6 class="text-danger"> {{ $message }}</h6>
                                                            @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="role">Role
                                                            <span class="text-danger">*</span></label>
                                                            <select disabled id="role" class="form-select" aria-label="Default select example" name="role" >
                                                                <option value="">--Select Role--</option>
                                                            </select>
                                                            @error('role')
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
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class=" mb-4">Permissions</h2>
                                        </div>
                                    </div>
                                    <div class="form py-3">
                                        <form action="{{ route('permission.store')  }}"  method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="user">User Name
                                                            <span class="text-danger">*</span></label>
                                                            <select id="user" class="form-select" aria-label="Default select example" name="user">
                                                                <option value="">--Select User--</option>
                                                                @foreach ($users as $user)
                                                                    @php
                                                                        if($user->role_id != 2){
                                                                            continue;
                                                                        }
                                                                    @endphp
                                                                    <option value="{{$user->id}}">{{$user->name."-".$user->verification_code}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('user')
                                                                <h6 class="text-danger"> {{ $message }}</h6>
                                                            @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="menu">Menu
                                                            <span class="text-danger">*</span></label>
                                                            <select disabled id="menu" class="form-select" aria-label="Default select example" name="menu" >
                                                                <option value="">--Select Menu--</option>
                                                                @foreach ($menu_name_array as $id=> $menu_name)
                                                                    <option value="{{$id}}">{{$menu_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('menu')
                                                                <h6 class="text-danger"> {{ $message }}</h6>
                                                            @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="permission">Permission
                                                            <span class="text-danger">*</span></label>
                                                            <select disabled id="permission" class="form-select" aria-label="Default select example" name="permission[]" multiple="multiple">

                                                            </select>
                                                            @error('menu')
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
    </div>
@endsection
@section('javacript')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#permission').select2();
            $('#user').select2();
            $('#menu').select2();
            $('#role').select2();
            $('#user_id').select2();
        });
        $('#user').change(function(){

            if($('#user').val() !=''){
                $('#menu').prop('disabled', false);
                // $('#permission').prop('disabled', false);
            }
            else
            {
                $('#menu').val('');
                $('#permission').val('');
                $('#menu').prop('disabled', true);
                $('#permission').prop('disabled', true);
            }
        });


        $('#menu').change(function(){
            let user_id = $('#user').val();
            let menu_id = $('#menu').val();
            if(menu_id !=''){
                $('#permission').prop('disabled', false);
            }
            else
            {
                $('#permission').html('');
                $('#permission').prop('disabled', true);
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('permission.getOptions') }}",
                data: {
                    user_id  : user_id,
                    menu_id : menu_id
                },
                success: function(data) {
                    $('#permission').html(data);
                    // Initialize or re-initialize Select2 if needed
                    $('#permission').select2();
                },
            });
        });


        $('#user_id').change(function(){
            let user_id = $('#user_id').val();
            if(user_id !=''){
                $('#role').prop('disabled', false);
            }
            else
            {
                $('#role').html('');
                $('#role').prop('disabled', true);
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('permission.getRole') }}",
                data: {
                    user_id  : user_id
                },
                success: function(data) {
                    $('#role').html(data);
                    // Initialize or re-initialize Select2 if needed
                    $('#role').select2();
                },
            });
        });

    </script>
@endsection
