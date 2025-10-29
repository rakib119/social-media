
@extends('dashboard.layout.dashboard')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-content-wrapper">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card py-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class="text-primary mb-4">Notification Entry</h2>
                                        </div>
                                    </div>
                                    <div >

                                        @if (session('error'))
                                            <h4 class="text-danger">Error: {{ session('error') }} ** </h4>
                                        @endif
                                        <form action="{{ route('notification.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="section_id" value="6">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="user_name">User Name
                                                            <span class="text-danger">*</span></label>
                                                            <select id="user-name" class="form-select" aria-label="Default select example" name="user_name">
                                                                <option value="">--All User--</option>
                                                                @foreach ($users as $user)
                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('user_name')
                                                                <h6 class="text-danger"> {{ $message }}</h6>
                                                            @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="message">Message <span class="text-danger">*</span></label>
                                                        <input id="message" type="text" class="form-control" value="{{ old('message')  }}" name="message" placeholder="Enter message" autofocus>
                                                        @error('message')
                                                            <h6 class="text-danger"> {{ $message }}</h6>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-primary">Save </button>
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
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-content-wrapper">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class=" mb-4">Notification List</h2>
                                        </div>
                                    </div>
                                    <table id="myTable" class="table table-centered table-nowrap mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Message </th>
                                                <th>User</th>
                                                <th>Is Read </th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ( $notifications as $v)
                                            <tr>
                                                <td>{{$loop->index+1}}</td>
                                                <td>{{ Str::substr($v->message, 0, 50)}} {{ (Str::length($v->message)>50) ?"...":"" }}</td>
                                                <td>{{ Str::substr($v->user_name, 0, 50)}} {{ (Str::length($v->user_name)>50) ?"...":"" }}</td>
                                                <td> <span class="badge bg-{{ $v->is_read==1 ? 'primary' : 'warning' }}">{{ $v->is_read==1 ? 'Read' : 'Unread' }}</span> </td>
                                                <td>
                                                    <a href="" class="btn btn-primary" >Edit</a>
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


@section('javacript')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"> </script>
    <script>
        $(document).ready(function() {
            $('#user-name').select2();
            $('#myTable').DataTable();
        });
    </script>
@endsection
