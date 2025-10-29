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
@endphp
<!-- sidebar -->
 <div class="main_sidebar">
    <div class="side-overlay" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"></div>

    <!-- sidebar header -->
    <div class="sidebar-header">
        <h4> Navigation</h4>
        <span class="btn-close" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"></span>
    </div>

    <!-- sidebar Menu -->
    <div class="sidebar">
        <div class="sidebar_innr" data-simplebar>

            <div class="sections">
                <ul>
                    <li class="active">
                        <a href="{{ route('home')}}"> <img src="{{ asset('social-media/assets//images/icons/home.png')}}" alt="">
                            <span> Feed </span>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/chat.png')}}" alt="">
                            <span> Chats </span>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/flag.png')}}" alt="">
                            <span> Pages </span>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/video.png')}}" alt="">
                            <span> Videos </span>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/group.png')}}" alt="">
                            <span> Groups </span> </a>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/pen.png')}}" alt="">
                            <span> Courses </span>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/info.png')}}" alt="">
                            <span> Questions </span>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/bag.png')}}" alt="">
                            <span> jobs </span>
                        </a>
                    </li>
                    <li id="more-veiw" hidden>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/book.png')}}" alt="">
                            <span> Books </span>
                        </a>
                    </li>
                    <li id="more-veiw" hidden>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/friends.png')}}" alt="">
                            <span> Friends </span>
                        </a>
                    </li>
                    <li id="more-veiw" hidden>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/document.png')}}" alt="">
                            <span> Blogs </span>
                        </a>
                    </li>
                    <li id="more-veiw" hidden>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/market.png')}}" alt="">
                            <span> Services </span>
                        </a>
                    </li>
                    <li id="more-veiw" hidden>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/photo.png')}}" alt="">
                            <span> Gallery </span>
                        </a>
                    </li>
                    <li id="more-veiw" hidden>
                        <a href="#"> <img src="{{ asset('social-media/assets/images/icons/events.png')}}" alt="">
                            <span> Events </span>
                        </a>
                    </li>
                </ul>

                <a href="#" class="button secondary px-5 btn-more"
                    uk-toggle="target: #more-veiw; animation: uk-animation-fade">
                    <span id="more-veiw">See More <i class="icon-feather-chevron-down ml-2"></i></span>
                    <span id="more-veiw" hidden>See Less<i class="icon-feather-chevron-up ml-2"></i> </span>
                </a>

            </div>


            <div class="sections">
                <h3> Shortcut </h3>
                <ul>
                    <li> <a href="#"> <img src="{{ asset('social-media/assets/images/avatars/avatar-1.jpg')}}" alt="">
                            <span> Stella Johnson </span> <span class="dot-notiv"></span></a></li>
                    <li> <a href="#"> <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                            <span> Alex Dolgove </span> <span class="dot-notiv"></span></a></li>
                    <li> <a href="#"> <img src="{{ asset('social-media/assets/images/avatars/avatar-7.jpg')}}" alt="">
                            <span> Adrian Mohani </span> </a>
                    </li>
                    <li id="more-veiw-2" hidden> <a href="#">
                            <img src="{{ asset('social-media/assets/images/avatars/avatar-4.jpg')}}" alt="">
                            <span> Erica Jones </span> <span class="dot-notiv"></span></a>
                    </li>
                    <li> <a href="group-#"> <img src="{{ asset('social-media/assets/images/group/group-3.jpg')}}" alt="">
                            <span> Graphic Design </span> </a>
                    </li>
                    <li> <a href="group-#"> <img src="{{ asset('social-media/assets/images/group/group-4.jpg')}}" alt="">
                            <span> Mountain Riders </span> </a>
                    </li>
                    <li id="more-veiw-2" hidden> <a href="#"> <img
                                src="{{ asset('social-media/assets/images/avatars/avatar-5.jpg')}}" alt="">
                            <span> Alex Dolgove </span> <span class="dot-notiv"></span></a>
                    </li>
                    <li id="more-veiw-2" hidden> <a href="#"> <img
                                src="{{ asset('social-media/assets/images/avatars/avatar-7.jpg')}}" alt="">
                            <span> Adrian Mohani </span> </a>
                    </li>
                </ul>

                <a href="#" class="button secondary px-5 btn-more"
                    uk-toggle="target: #more-veiw-2; animation: uk-animation-fade">
                    <span id="more-veiw-2">See More <i class="icon-feather-chevron-down ml-2"></i></span>
                    <span id="more-veiw-2" hidden>See Less<i class="icon-feather-chevron-up ml-2"></i> </span>
                </a>
            </div>
        </div>
    </div>
</div>
