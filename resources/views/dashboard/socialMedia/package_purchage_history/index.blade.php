@php
    $payment_for_array = array(0=> '',1=> 'new package',2=> 'Renewal Fees');
@endphp
@extends('dashboard.layout.dashboard')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="page-title-box">
            <div class="container-fluid">
             <div class="row align-items-center">
                 <div class="col-sm-6">
                     <div class="page-title">
                         <h4>Purchase History</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Purchase List</a></li>
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
                                <h2 class="header-title mb-4">Purchase List</h2>
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-centered table-nowrap mb-0" width="710">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="30">SL</th>
                                                <th width="40">Payment Method</th>
                                                <th width="40">Purchase For</th>
                                                <th width="40">Cust. Acc. No</th>
                                                <th width="40">Trnx Id	</th>
                                                <th width="40">Com. Acc</th>
                                                <th width="40">Payment Status</th>
                                                <th width="40">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ( $history as $v)
                                                @php
                                                    $payment_status_array   = array(0=>'pending',1=>'Confirmed',2=>'Reject');
                                                    $badge_color_array      = array(0=>'info',1=>'success',2=>'danger');
                                                    $payment_method_badge   = array(0=>'info',1=>'success',2=>'info');
                                                    $payment_method_array   = array(1=>'Online',2=>'Offline');
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td> <span class="badge bg-{{$payment_method_badge[$v->payment_method]}}"> {{$payment_method_array[$v->payment_method]}} </span></td>
                                                    <td>{{ $payment_for_array[$v->payment_for] }}</td>
                                                    <td>{{ $v->account_no }}</td>
                                                    <td>{{ $v->transaction_id }}</td>
                                                    <td>{{ $v->company_account_no }}</td>
                                                    <td> <span class="badge bg-{{$badge_color_array[$v->payment_status]}}"> {{$payment_status_array[$v->payment_status]}} </span></td>
                                                    <td>
                                                        <a href="{{route('packagePurchage.details',Crypt::encrypt($v->id))}}" class="btn btn-primary"> Details </a>
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
</div>
@endsection

@section('javacript')
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"> </script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
