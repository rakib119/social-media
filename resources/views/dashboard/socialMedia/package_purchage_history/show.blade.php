@php
    $payment_for_array = array(0=> '',1=> 'new package',2=> 'Renewal Fees');
    $encrypt_id        = Crypt::encrypt($data->id);
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Purchase Details</a></li>
                        </ol>
                     </div>
                 </div>
             </div>
            </div>
         </div>
         <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between" >
                                    <h4 class="header-title mb-4">Purchase Details</h4>
                                    <div>
                                        <a class="btn btn-info" target="blank" href="{{route('packagePurchage.history')}}">Back</a>

                                        <a class="btn btn-primary" target="blank" href="{{route('packagePurchase.invoice',$encrypt_id)}}">Print <i class="fa fa-print"></i> </a>

                                    </div>

                                </div>
                                @if ($data)
                                    @php
                                        $img_link               = asset('social-media/assets/images/package_purchase_img/'.$data->image);
                                        $payment_status_array   = array(0=>'Pending',1=>'Success',2=>'Reject');
                                        $badge_color_array      = array(0=>'info',1=>'success',2=>'danger');
                                        $update_route           = route('packagePurchage.status-update',$encrypt_id);
                                    @endphp
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <div class="product-detail">
                                                <div class="row">
                                                    <div class="col-md-8 col-9">
                                                        <div class="tab-content" id="v-pills-tabContent">
                                                            <div class="tab-pane fade show active" id="product-1" role="tabpanel">
                                                                <div class="product-img">
                                                                    <a target="_blank" href="{{$img_link}}"><img src="{{$img_link}}" alt="not found" class="img-fluid mx-auto d-block"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-7">
                                            <div class="mt-4 mt-xl-3">
                                                <div class="row d-flex">
                                                    <div>
                                                        <h4 class="mt-1 text-primary"> TRNX ID: {{$data->transaction_id}}</h4>
                                                    </div>
                                                </div>
                                                <hr class="my-4">
                                                <div class="mt-4">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td width="40%"><h3>Payment</h3></td>
                                                                <td width="60%">
                                                                    <h2 class="text-primary">: ৳ {{$data->payment_amount}} </h2>
                                                                    <span class="badge bg-{{$badge_color_array[$data->payment_status]}}"> {{$payment_status_array[$data->payment_status]}} </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b>Purchase For</b> </td>
                                                                <td> : {{$payment_for_array[$data->payment_for]}} </td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b> Purchase By </b></td>
                                                                <td> : {{ $data->purchase_by }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b> Package Name </b></td>
                                                                <td> : {{ $data->package_name }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b> Sub Package Name </b></td>
                                                                <td> : {{ $data->package_name }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b> Package Value </b></td>
                                                                <td> : ৳ {{$data->package_value}} </td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b> Discount </b></td>
                                                                <td> : {{$data->discount_per}} % </td>
                                                            </tr>
                                                            @if ($data->payment_method==2) {{-- Offline Payment --}}
                                                                <tr>
                                                                    <td> <b> Acount No </b></td>
                                                                    <td> : {{$data->account_no}} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <b> Acount Holder </b></td>
                                                                    <td> : {{$data->account_holder}} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <b> Comp. Acount </b> </td>
                                                                    <td> : {{ $bank_array[$data->company_bank_id] ?? ""}} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <b> Comp. Acount No </b> </td>
                                                                    <td> : {{$data->company_account_no}} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"> <b> Remarks </b> </td>
                                                                    <td valign="top"> <p>: {{$data->remarks}}</p> </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mt-4 d-flex gap-4">
                                                <div>
                                                    <a class="btn btn-info waves-effect waves-light mt-2" href="javascript:{}" onclick="document.getElementById('pending-form').submit();">Pending</a>
                                                </div>
                                                <div>
                                                    <a class="btn btn-success waves-effect waves-light mt-2" href="javascript:{}" onclick="document.getElementById('success-form').submit();">Success</a>
                                                </div>
                                                <div>
                                                    <a class="btn btn-danger waves-effect waves-light mt-2" href="javascript:{}" onclick="document.getElementById('cancel-form').submit();">Reject</a>
                                                </div>
                                            </div>

                                            @if ($data->payment_method!=1)
                                                <form id="success-form" action="{{$update_route}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="status" value="1">
                                                </form>

                                                <form id="cancel-form" action="{{$update_route}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="status" value="2">
                                                </form>

                                                <form id="pending-form" action="{{$update_route}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="status" value="0">
                                                </form>
                                            @endif

                                        </div>
                                    </div>
                                @else
                                    <h3 class='text-danger text-center'>Data not found</h3>;
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       {{-- <div class="container-fluid">
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
                                                <th width="40">Img</th>
                                                <th width="40">Purchase For</th>
                                                <th width="40">Purchase By</th>
                                                <th width="40">Pkg Name</th>
                                                <th width="40">Sub Pkg Name</th>
                                                <th width="40">Pkg Value</th>
                                                <th width="40">Dist. %</th>
                                                <th width="40">Payment</th>
                                                <th width="40">Bank Name</th>
                                                <th width="40">Branch</th>
                                                <th width="40">Acc. Holder</th>
                                                <th width="40">Acc. No</th>
                                                <th width="40">Trnx Id	</th>
                                                <th width="40">Com. Acc</th>
                                                <th width="40">Payment Status</th>
                                                <th width="40">Remarks</th>
                                                <th width="40">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @php
                                                        $img_link = asset('social-media/assets/images/package_purchase_img/'.$data->image);
                                                        $payment_status_array = array(0=>'pending',1=>'Confirmed',2=>'Reject');
                                                        $badge_color_array = array(0=>'info',1=>'success',2=>'danger');
                                                    @endphp
                                                    <a target="_blank" href="{{$img_link}}">
                                                        <img width="30" src="{{$img_link}}" alt="not found">
                                                    </a>
                                                </td>
                                                <td>{{ $payment_for_array[$data->payment_for] }}</td>
                                                <td>{{ $data->purchase_by}}</td>
                                                <td>{{ $data->package_name	}}</td>
                                                <td>{{ $data->sub_package_name	}}</td>
                                                <td>{{ $data->package_value }}</td>
                                                <td>{{ $data->discount_per }}%</td>
                                                <td>{{ $data->payment_amount }}</td>
                                                <td>{{ $data->bank_name }}</td>
                                                <td>{{ $data->branch }}</td>
                                                <td>{{ $data->account_holder }}</td>
                                                <td>{{ $data->account_no }}</td>
                                                <td>{{ $data->transaction_id }}</td>
                                                <td>{{ $data->company_account_no }}</td>
                                                <td> <span class="badge bg-{{$badge_color_array[$data->payment_status]}}"> {{$payment_status_array[$data->payment_status]}} </span></td>
                                                <td>{{ $data->remarks }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary has-arrow dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Action <i class="fas fa-angle-down"></i> </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('success-form').submit();">Success</a></li>
                                                                <li><a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('cancel-form').submit();">Reject</a></li>
                                                                <li><a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('pending-form').submit();">Pending</a></li>

                                                                <form id="success-form" action="{{route('packagePurchage.status-update',$data->id)}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="1">
                                                                </form>

                                                                <form id="cancel-form" action="{{route('packagePurchage.status-update',$data->id)}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="2">
                                                                </form>

                                                                <form id="pending-form" action="{{route('packagePurchage.status-update',$data->id)}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="0">
                                                                </form>
                                                            </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div> --}}
    </div>
</div>
@endsection


