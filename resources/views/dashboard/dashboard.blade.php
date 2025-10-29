@extends('dashboard.layout.dashboard')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
@endsection
@section('javacript')
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"> </script>
    <script>
        $(document).ready( function () {
           $('#usersTable').DataTable();
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
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
                        <div class="row">
                            <div class="col-xl-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <p class="font-size-16">Total Users</p>
                                            <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                                <span class="avatar-title rounded-circle bg-soft-primary">
                                                        <i class="mdi mdi-account-multiple-outline text-primary font-size-20"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-22">{{$users->count()}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <p class="font-size-16"></p>
                                            <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                                <span class="avatar-title rounded-circle bg-soft-primary">
                                                    <i class="mdi mdi-account-multiple-outline text-primary font-size-20"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-22"></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <p class="font-size-16"></p>
                                            <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                                <span class="avatar-title rounded-circle bg-soft-primary">
                                                <i class="fas fa-envelope text-primary font-size-20"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-22"></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- USER LIST --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="header-title mb-4">Users</h2>
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-centered table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Verification Code</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $users as $user)
                                    <tr>
                                        <td>{{ $loop->index+1}}</td>
                                        <td>{{ Str::substr($user->name, 0, 40) }}</td>
                                        <td>{{ $user->email}}</td>
                                        <td>{{ $user->mobile}}</td>
                                        <td>{{ $user->verification_code}}</td>
                                        <td>
                                            @if ($user->user_id )
                                                <a class="btn btn-success" href="{{route('user.details',
                                                Crypt::encrypt($user->id))}}">Details</a>
                                            @else
                                                <span class="badge bg-warning">Not Available</span>
                                            @endif
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
@endsection
