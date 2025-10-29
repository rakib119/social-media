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

        <h1 c> Setting </h1>
        <div class="uk-position-relative" uk-grid>
            @include('socialMedia.commonFile.settings.rightPannel')
            <div class="uk-width-2-3@m mt-sm-3 pl-sm-0 p-sm-4">

                <div class="uk-card-default rounded">
                    <div class="p-3">
                        <h5 class="mb-0"> Contact info </h5>
                    </div>
                    <hr class="m-0">
                    <form class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
                        <div>
                            <h5 class="uk-text-bold mb-2"> First Name </h5>
                            <input type="text" class="uk-input" placeholder="Your name">
                        </div>
                        <div>
                            <h5 class="uk-text-bold mb-2"> Seccond Name </h5>
                            <input type="text" class="uk-input" placeholder="Your seccond">
                        </div>
                        <div>
                            <h5 class="uk-text-bold mb-2"> Your email address </h5>
                            <input type="text" class="uk-input" placeholder="eliedaniels@gmail.com">
                        </div>
                        <div>
                            <h5 class="uk-text-bold mb-2"> Phone </h5>
                            <input type="text" class="uk-input" placeholder="+1 555 623 568 ">
                        </div>
                    </form>

                    <div class="uk-flex uk-flex-right p-4">
                        <button class="button soft-primary mr-2">Cancle</button>
                        <button class="button primary">Save Changes</button>
                    </div>
                </div>

                <div class="uk-card-default rounded mt-4">
                    <div class="p-3">
                        <h5 class="mb-0"> Billing address </h4>
                    </div>
                    <hr class="m-0">
                    <form class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
                        <div>
                            <h5 class="uk-text-bold mb-2"> Number </h5>
                            <input type="text" class="uk-input" placeholder="23, Block C2 ">
                        </div>
                        <div>
                            <h5 class="uk-text-bold mb-2"> Street </h5>
                            <input type="text" class="uk-input" placeholder="Street Number">
                        </div>
                        <div>
                            <h5 class="uk-text-bold mb-2"> City </h5>
                            <input type="text" class="uk-input" placeholder="City Name">
                        </div>
                        <div>
                            <h5 class="uk-text-bold mb-2"> Postal Code </h5>
                            <input type="text" class="uk-input" placeholder="Postal Code">
                        </div>
                        <div>
                            <h5 class="uk-text-bold mb-2"> State </h5>
                            <input type="text" class="uk-input" placeholder="State">
                        </div>
                        <div>
                            <h5 class="uk-text-bold mb-2"> Country </h5>
                            <input type="text" class="uk-input" placeholder="Your Country">
                        </div>
                        <div>
                            <h5 class="uk-text-bold mb-2"> Gender </h5>
                            <select class="uk-select">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                    </form>
                    <div class="uk-flex uk-flex-right p-4">
                        <button class="button soft-primary mr-2">Cancle</button>
                        <button class="button primary">Save Changes</button>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
