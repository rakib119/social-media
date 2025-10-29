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

            <h1 c> Informations </h1>

            <div class="uk-position-relative" uk-grid>
                @include('socialMedia.commonFile.settings.rightPannel')
                <div class="uk-width-2-3@m mt-sm-3 pl-sm-0 p-sm-4">

                    <div class="uk-card-default rounded" id="multi-step-form-container">
                        @if ($is_final_submited==1)
                            @include('socialMedia.commonFile.multistep_forms.step4')
                        @else
                            @include('socialMedia.commonFile.multistep_forms.step1')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javaScript')

@endsection
