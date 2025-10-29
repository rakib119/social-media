
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
            <h1> Renewal Fees Payment </h1>
            <div class="uk-position-relative" uk-grid>
                @include('socialMedia.commonFile.settings.rightPannel')
                <div class="uk-width-2-3@m mt-sm-3 pl-sm-0 p-sm-4">
                        <div class="uk-child-width-2-2@m uk-grid-small uk-grid-match" uk-grid>
                            @foreach ($package as $v)
                                <div>
                                    <div class="uk-card uk-card-default  uk-card-body rounded">
                                        <!-- Card Title -->
                                        <h3 class="uk-card-title uk-text-bold uk-margin-remove">{{ $v?->package_name}}</h3>
                                        <p class="uk-text-meta uk-margin-remove-top">{{ $v?->short_desc}}</p>

                                        <!-- Pricing Section -->

                                        <div>
                                            <div class="uk-text-large uk-text-bold" style="font-size: 2.5rem;">৳ {{$v?->renewal_fee}} <span class="uk-text-meta uk-margin-small-top">Renewal Fee</span></div>
                                        </div>
                                        <!-- Choose Plan Button -->
                                        <div>
                                            <a class="uk-button uk-button-secondary uk-border-rounded uk-margin-small-top" href="{{route('pay.renewal_fees',Crypt::encrypt($v->id))}}">Online Payment</a>
                                            <a class="uk-button uk-button-primary uk-border-rounded uk-margin-small-top" href="{{route('social.offline_renewal_fees',Crypt::encrypt($v->id))}}" >Offline Payment</a>
                                        </div>


                                        <ul class="uk-list uk-list-bullet uk-margin-top uk-text-small">
                                            @foreach ($package_features->where('mst_id', $v->id) as $list)
                                                <li>
                                                    <span uk-tooltip="{{ $list?->short_desc}}" class="uk-text-bold">{{ $list?->feature}} </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
   </div>
@endsection

@section('javaScript')

@endsection
