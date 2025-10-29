@php
    $web_info = session()->get('web_info');
    if (!$web_info) {
        $web_info = DB::table('genarel_infos')->select('field_name','value')->get();
        session()->put('web_info', $web_info);
    }
    $dataArray = array();
    foreach ($web_info as $v)
    {
        $dataArray[$v->field_name] = $v->value;
    }
    extract($dataArray);
    $favicon       = asset('assets/images/info/'.$favicon);
    $logo          = asset('assets/images/info/'.$logo);
    $logo_white    = asset('assets/images/info/'.$logo_white);

    $social_media_user_data = session()->get('social_media_user_data');
    if (!$social_media_user_data)
    {
        store_social_media_info();
        $social_media_user_data = session()->get('social_media_user_data');
    }
    extract($social_media_user_data);
   $is_package_purchase = DB::table('package_purchase_mst')->where(['user_id'=>auth()->id(),'payment_for'=>1,'payment_status'=>1,'status_active'=>1,'is_deleted'=>0])->exists();

@endphp
<!-- header -->
<div id="main_header">
    <header>
        <div class="header-innr">


            <!-- Logo-->
            <div class="header-btn-traiger" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible">
                <span></span></div>

            <!-- Logo-->
            <div id="logo">
                <a href="{{ route('home')}}"> <img src="{{ $logo }}" alt="{{ $web_title }}"></a>
                <a href="{{ route('home')}}"> <img src="{{ $logo_white }}" class="logo-inverse"
                        alt="{{ $web_title }}"></a>
            </div>

            <!-- form search-->
            <div class="head_search">
                <form>
                    <div class="head_search_cont">
                        <input value="" type="text" class="form-control"
                            placeholder="Search for Friends , Videos and more.." autocomplete="off">
                        <i class="s_icon uil-search-alt"></i>
                    </div>

                    <!-- Search box dropdown -->
                    <div uk-dropdown="pos: top;mode:click;animation: uk-animation-slide-bottom-small"
                        class="dropdown-search">
                        <!-- User menu -->

                        <ul class="dropdown-search-list">
                            <li class="list-title"> Recent Searches </li>
                            <li> <a href="#"> <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt=""> Erica Jones
                                </a> </li>
                            <li> <a href="#"> <img src="{{ asset('social-media/assets/images/group/group-2.jpg')}}" alt=""> Coffee
                                    Addicts</a> </li>
                            <li> <a href="#"> <img src="{{ asset('social-media/assets/images/group/group-4.jpg')}}" alt=""> Mountain Riders
                                </a> </li>
                            <li> <a href="#"> <img src="{{ asset('social-media/assets/images/group/group-5.jpg')}}" alt=""> Property Rent
                                    And Sale </a> </li>
                            <li class="menu-divider"></li>
                            <li class="list-footer"> <a href="{{ route('home')}}"> Searches History </a>
                            </li>
                        </ul>

                    </div>


                </form>
            </div>

            <!-- user icons -->
            <div class="head_user">


                {{-- <a href="{{ route('home')}}" class="opts_icon_link uk-visible@s"> Home </a>
                <a href="{{ route('home')}}" class="opts_icon_link uk-visible@s"> Dennis Han </a> --}}


                <!-- browse apps  -->
                <a href="#" class="opts_icon uk-visible@s" uk-tooltip="title: Apps ; pos: bottom ;offset:7">
                    <i class="uil-apps"></i>
                </a>

                <!-- browse apps dropdown -->
                <div uk-dropdown="mode:click ; pos: bottom-center ; animation: uk-animation-scale-up"
                    class="icon-browse">
                    <a href="https://ascentaverse.com/services" target="_blank" class="icon-menu-item"> <i class="uil-shop"></i> Services </a>
                    <a href="#" class="icon-menu-item"> <i class="uil-envelope-alt"></i> Messages </a>
                    <a href="#" class="icon-menu-item"> <i class="uil-bookmark"></i> Bookmark </a>
                    <a href="#" class="icon-menu-item"> <i class="uil-users-alt"></i> Groups </a>
                    <a href="#" class="icon-menu-item"> <i class="uil-calendar-alt"></i> Events </a>
                    <a href="#" class="icon-menu-item"> <i class="uil-file-alt"></i> Forum </a>
                    <a href="#" class="icon-menu-item"> <i class="uil-question-circle"></i> Questions </a>
                    <a href="#" class="icon-menu-item"> <i class="uil-bolt-alt"></i> Upgrade </a>
                    <a href="#" class="icon-menu-item"> <i class="uil-user-circle"></i> Account </a>
                    <a href="#" class="more-app"> More Apps</a>
                </div>


                <!-- Message  notificiation dropdown -->
                <a href="#" class="opts_icon" uk-tooltip="title: Messages ; pos: bottom ;offset:7">
                    <i class="uil-envelope"></i> <span>4</span>
                </a>

                <!-- Message  notificiation dropdown -->
                <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small"
                    class="dropdown-notifications">

                    <!-- notification contents -->
                    <div class="dropdown-notifications-content" data-simplebar>

                        <!-- notivication header -->
                        <div class="dropdown-notifications-headline">
                            <h4>Messages</h4>
                            <a href="#">
                                <i class="icon-feather-settings"
                                    uk-tooltip="title: Message settings ; pos: left"></i>
                            </a>

                            <input type="text" class="uk-input" placeholder="Search in Messages">
                        </div>

                        <!-- notiviation list -->
                        <ul>
                            <li>
                                <a href="#">
                                    <span class="notification-avatar status-online">
                                        <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                    </span>
                                    <div class="notification-text notification-msg-text">
                                        <strong>Jonathan Madano</strong>
                                        <p>Thanks for The Answer ... <span class="time-ago"> 2 h </span> </p>

                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="notification-avatar">
                                        <img src="{{ asset('social-media/assets/images/avatars/avatar-3.jpg')}}" alt="">
                                    </span>
                                    <div class="notification-text notification-msg-text">
                                        <strong>Stella Johnson</strong>
                                        <p> Alex will explain you how ... <span class="time-ago"> 3 h </span>
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="notification-avatar status-online">
                                        <img src="{{ asset('social-media/assets/images/avatars/avatar-1.jpg')}}" alt="">
                                    </span>
                                    <div class="notification-text notification-msg-text">
                                        <strong>Alex Dolgove</strong>
                                        <p> Alia just joined Messenger! <span class="time-ago"> 3 h </span> </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="notification-avatar status-online">
                                        <img src="{{ asset('social-media/assets/images/avatars/avatar-4.jpg')}}" alt="">
                                    </span>
                                    <div class="notification-text notification-msg-text">
                                        <strong>Adrian Mohani</strong>
                                        <p>Thanks for The Answer ... <span class="time-ago"> 2 h </span> </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="notification-avatar">
                                        <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                    </span>
                                    <div class="notification-text notification-msg-text">
                                        <strong>Jonathan Madano</strong>
                                        <p>Thanks for The Answer ... <span class="time-ago"> 2 h </span> </p>

                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="notification-avatar">
                                        <img src="{{ asset('social-media/assets/images/avatars/avatar-3.jpg')}}" alt="">
                                    </span>
                                    <div class="notification-text notification-msg-text">
                                        <strong>Stella Johnson</strong>
                                        <p> Alex will explain you how ... <span class="time-ago"> 3 h </span>
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="notification-avatar">
                                        <img src="{{ asset('social-media/assets/images/avatars/avatar-1.jpg')}}" alt="">
                                    </span>
                                    <div class="notification-text notification-msg-text">
                                        <strong>Alex Dolgove</strong>
                                        <p> Alia just joined Messenger! <span class="time-ago"> 3 h </span> </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="notification-avatar">
                                        <img src="{{ asset('social-media/assets/images/avatars/avatar-4.jpg')}}" alt="">
                                    </span>
                                    <div class="notification-text notification-msg-text">
                                        <strong>Adrian Mohani</strong>
                                        <p>Thanks for The Answer ... <span class="time-ago"> 2 h </span> </p>
                                    </div>
                                </a>
                            </li>
                        </ul>

                    </div>
                    <div class="dropdown-notifications-footer">
                        <a href="#"> See all in Messages</a>
                    </div>


                </div>


                <!-- notificiation icon  -->
                <a href="#" onclick="readNotification()" class="opts_icon" uk-tooltip="title: Notifications ; pos: bottom ;offset:7">
                    <i class="uil-bell"></i>
                    <span id="unread_notification">0</span>
                </a>


                <!-- notificiation dropdown -->
                <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small"
                    class="dropdown-notifications">

                    <!-- notification contents -->
                    <div class="dropdown-notifications-content" data-simplebar>

                        <!-- notivication header -->
                        <div class="dropdown-notifications-headline">
                            <h4>Notifications </h4>
                            <a href="#">
                                <i class="icon-feather-settings"
                                    uk-tooltip="title: Notifications settings ; pos: left"></i>
                            </a>
                        </div>

                        <!-- notiviation list -->
                        <ul id="notification_list">

                        </ul>

                    </div>


                </div>


                <!-- profile -image -->
                <a class="opts_account" href="#"> <img src="{{ asset('social-media/assets/images/uploaded_img/'.$thumbnail_profile)}}" alt=""></a>

                <!-- profile dropdown-->
                <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small"
                    class="dropdown-notifications rounded-lg">

                    <!-- User Name / Avatar -->
                    <a href="{{route('social.profile')}}">

                        <div class="dropdown-user-details">
                            <div class="dropdown-user-avatar">
                                <img src="{{ asset('social-media/assets/images/uploaded_img/'.$thumbnail_profile)}}" alt="">
                            </div>
                            <div class="dropdown-user-name" style="display: flex; justify-content:center; align-items:center;">
                                <div>
                                    {{auth()->user()->name}}
                                </div>
                                <div style="margin-left: 5px;">
                                    @if (auth()->user()->is_verified==1)
                                        <img style="height: 25px !important;" src="{{ asset('social-media/assets/images/verify.png') }}" class="verified-badge" uk-tooltip="title: Verified Account ; pos: bottom ;offset:7">
                                    @endif
                                </div>
                                {{-- {{auth()->user()->name}}
                                @if (auth()->user()->is_verified==1)
                                    <span style="color: #1a73e8;" class="verified-badge" uk-tooltip="title: Verified Account ; pos: bottom ;offset:7">
                                        <i class="icon-feather-check-circle"></i>
                                    </span>
                                @endif --}}
                            </div>
                        </div>

                    </a>

                    <!-- User menu -->

                    <ul class="dropdown-user-menu">
                        {{-- <li><a href="{{ route('social.myAccount')}}"> <i class="uil-user"></i> My Account </a> </li> --}}
                        {{-- <li><a href="#"> <i class="uil-thumbs-up"></i> Liked Pages </a></li> --}}
                        {{-- <li><a href="#"> <i class="uil-cog"></i> Account Settings</a></li> --}}
                        <li><a href="{{ route('social.makePayment')}}"> <i class="icon-feather-dollar-sign"></i> Make Payment</a>
                        @if ($is_package_purchase)
                            <li><a href="{{ route('social.pay_renewal_fees')}}"> <i class="icon-material-outline-autorenew"></i> Pay Renewal Fees</a></li>
                        @else
                            <li><a href="{{ route('social.upgrade')}}"> <i class="icon-feather-package"></i> Upgrade To Premium</a></li>
                        @endif
                        <li><a href="{{ route('social.myInfo')}}"> <i class="icon-material-outline-check-circle"></i> Verify Account</a>
                        </li>
                        <li>
                            <a href="#" id="night-mode" class="btn-night-mode">
                                <i class="uil-moon"></i> Night mode
                                <span class="btn-night-mode-switch">
                                    <span class="uk-switch-button"></span>
                                </span>
                            </a>
                        </li>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> <i class="uil-sign-out-alt"></i>Sign Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>


                </div>


            </div>

        </div> <!-- / heaader-innr -->
    </header>

</div>
