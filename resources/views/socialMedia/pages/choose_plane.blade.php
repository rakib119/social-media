@php
    $selected_package_info = session('package_info')??array();
    extract($selected_package_info);
    // print_r($selected_package_info); die;
    $payment_type_array = array(
        1=>"Bank",
        2=>"Mobile Banking"
    );
@endphp
@extends('socialMedia.commonFile.socialLayouts1')
@section('topBar')
    @include('socialMedia.commonFile.topBar')
@endsection

@section('leftBar')
    @include('socialMedia.commonFile.leftBarV1')
@endsection
@section('mainContent')
   <!-- contents -->
   <div class="main_content">
        <div class="main_content_inner p-sm-0 ml-sm-4">
            <h1> Upgrade To Premium </h1>
            <div id="main_payment_container">

            </div>
            <div id="package_container" style="display: none">
                <div class="uk-position-relative" uk-grid>
                    <div class="uk-width-1-2@m mt-sm-3 pl-sm-0 p-sm-4">
                        <div class="uk-container uk-margin-top">
                            <div class="uk-card uk-card-default uk-card-body uk-border-rounded">
                            <!-- Hosting Plan Header -->
                            <h2 class="uk-text-bold">{{$package->package_name}}</h2>

                            <!-- Period Selection -->
                            <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-small-top">
                                <label for="period" class="uk-text-bold">Package</label>
                                @php
                                    $data ="'".route('social.load_subtotal')."',this.value,'subtotal_container'";
                                @endphp
                                <select id="period" onChange="loadHtmlElement({{$data}})" class="uk-select uk-width-small" style="width:200px;">
                                    <option value="0"> --Select Package--</option>
                                    @foreach ($package_break_down as $row)
                                        <option value="{{$row->id}}" {{ isset($selected_package_id) ? ($selected_package_id==$row->id ?'selected':''):"" }} > {{$row->sub_package_name." (৳".$row->discounted_amount.")"}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-2@m mt-sm-3 pl-sm-0 p-sm-4">
                        <div id="subtotal_container">
                            {{-- DATA COME FROM AJAX REQUEST --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
   </div>
@endsection

@section('javaScript')
    @if (count($selected_package_info))
        @if (isset($payment_method) && $payment_method)
            <script>
                package_id  = {{isset($selected_package_id)?$selected_package_id:""}};
                route       = '{{route('social.load_payment_method')}}';
                method_id   = {{$payment_method}};

                $( document ).ready(function() {
                    $('#package_container').css('display', 'none');
                    getPaymentComponent(method_id,route,package_id,'main_payment_container',true);
                });
            </script>
        @else
            <script>
                    route = '{{route('social.load_subtotal')}}';
                    package_id = {{isset($selected_package_id)?$selected_package_id:""}};
                    $( document ).ready(function() {
                        loadHtmlElement(route,package_id,'subtotal_container');
                    });
            </script>
        @endif
        @else
        <script>
            $( document ).ready(function() {
                $('#package_container').css('display', 'block');
            });
        </script>
    @endif
@endsection
