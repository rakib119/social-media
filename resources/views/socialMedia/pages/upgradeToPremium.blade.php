@php
    $userinfo = DB::table('user_infos')->select('is_final_submited')->where('user_id',auth()?->id())->first();
    $is_final_submited     = $userinfo?->is_final_submited;

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

            <h1 c> Upgrade To Premium </h1>
            <div class="uk-position-relative" uk-grid>
                @include('socialMedia.commonFile.settings.rightPannel')
                <div class="uk-width-2-3@m mt-sm-3 pl-sm-0 p-sm-4">
                        <div class="uk-child-width-1-2@m uk-grid-small uk-grid-match" uk-grid>
                            @foreach ($package as $v)
                                <div>
                                    <div class="uk-card uk-card-default  uk-card-body rounded">
                                        <!-- Card Title -->
                                        <h3 class="uk-card-title uk-text-bold uk-margin-remove">{{ $v?->package_name}}</h3>
                                        <p class="uk-text-meta uk-margin-remove-top">{{ $v?->short_desc}}</p>

                                        <!-- Pricing Section -->
                                        <div class="uk-margin">
                                            <span class="uk-text-meta" style="text-decoration: line-through;">৳ {{ number_format($v?->price,0) }} </span>
                                            <span style="background-color: #f0506e!important;color: #fff!important;" class="uk-label uk-margin-small-left" style="font-size: 0.8rem;">{{ number_format($v?->discount_per,0) }}% OFF</span>
                                        </div>
                                        <div>
                                            <div class="uk-text-large uk-text-bold" style="font-size: 2.5rem;">৳ {{number_format($v?->discounted_amount,0)}}<span style="font-size: 1rem;">(One Time)
                                            </span></div>
                                        </div>

                                        <!-- Choose Plan Button -->
                                        <div class="uk-margin">
                                            <a class="uk-button uk-button-default uk-border-rounded uk-width-1-1" style="border: 2px solid #6a00ff; color: #6a00ff;" href="{{route('social.choose_plane',Crypt::encrypt($v->id))}}">Choose plan</a>
                                            <div class="uk-text-meta uk-margin-small-top">৳ {{$v?->renewal_fee .'/'.$v?->renewable_message}}</div>
                                        </div>

                                        <!-- Features List with Tooltips -->
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
