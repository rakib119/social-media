@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
@endsection
@section('javacript')
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"> </script>
    <script>
        $(document).ready( function () {
           $('#myTable').DataTable();
        } );
    </script>
@endsection
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
                            <li class="breadcrumb-item active">Information Setup</li>
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
                                        <h2 class=" mb-4">Information List</h2>
                                    </div>
                                    {{-- <div class="float-end d-none d-sm-block">
                                        <form action="{{route('info-setup.publish')}}" method="post">
                                            @csrf
                                            <button class="btn btn-warning" type="submit">Publish</button>
                                        </form>
                                    </div> --}}
                                </div>
                                @if (session('error'))
                                        <h4 class="text-danger">Error: {{ session('error') }} ** </h4>
                                @endif
                                <table id="myTable" class="table table-centered table-nowrap mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Field Name </th>
                                            <th>Value </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $informations as $v)
                                            <tr>
                                                <td>{{$loop->index+1}}</td>
                                                <td>{{ Str::substr($v->field_name, 0, 50)}}</td>
                                                <td>
                                                    @if (isset($dimentions[$v?->field_name]) )
                                                        <img src="{{ asset('assets/images/info/'.$v->value) }}" alt="{{$v->value}}" height="30">
                                                    @else
                                                        {!! Str::substr($v->value, 0, 30) !!}
                                                    @endif
                                                </td>

                                                <td >
                                                    <a class="btn btn-primary" href="{{route('info-setup.edit', Crypt::encrypt($v->id))}}">Edit</a>
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
