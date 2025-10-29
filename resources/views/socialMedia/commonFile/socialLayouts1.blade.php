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

@endphp
<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>{{ $web_title }}</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $web_title }}">
    <link rel="icon" href="{{ $favicon }}">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('social-media/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('social-media/assets/css/night-mode.css')}}">
    <link rel="stylesheet" href="{{ asset('social-media/assets/css/framework.css')}}">
    <link href="{{ asset('dashboard/assets/css/cropper-1.5.6.css') }}" rel="stylesheet">
    <link href="{{ asset('social-media/assets/css/select2.min.css') }}" rel="stylesheet" />
    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('social-media/assets/css/icons.css')}}">

    <!-- Google font
    ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@latest/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@latest/dist/ionicons/ionicons.js"></script>




</head>

<body>

    <!-- Wrapper -->
    <div id="wrapper">
        @yield('leftBar')
        @yield('topBar')

        <div class="story-pop uk-animation-slide-bottom-small">
            <div class="story-side uk-width-1-4@s">

                <!--
                <div class="story-side-search">
                    <input type="text" class="uk-input" placeholder="Search user....">
                    <i class="submit uil-search-alt"></i>
                </div> -->

                <div class="uk-flex uk-flex-between uk-flex-middle mb-2">
                    <h2 class="mb-0" style="font-weight: 700">All Story</h2>
                    <a href="#" class="text-primary"> Setting</a>
                </div>

                <div class="story-side-innr" data-simplebar>
                    <h4 class="mb-1"> Your Story</h4>
                    <ul class="story-side-list">
                        <li>
                            <a href="#">
                                <div class="story-user-media">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-1.jpg')}}" alt="">
                                </div>
                                <div class="story-user-innr">
                                    <h5> Stella Johnson </h5>
                                    <p>  Share a photo or video</p>
                                </div>
                                <div class="add-story-btn">
                                    <i class="uil-plus"></i>
                                </div>
                            </a>

                        </li>
                    </ul>

                    <div class="uk-flex uk-flex-between uk-flex-middle my-3">
                        <h4 class="m-0"> Friends Story</h4>
                        <a href="#" class="text-primary"> See all</a>
                    </div>
                    <ul class="story-side-list"
                        uk-switcher="connect: #story-slider-switcher ; animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">

                        <li>
                            <a href="#">
                                <div class="story-user-media">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-1.jpg')}}" alt="">
                                </div>
                                <div class="story-user-innr">
                                    <h5>  Dennis Han   </h5>
                                    <p> <span class="story-count"> 2 new </span> <span class="story-time-ago"> 4hr ago
                                        </span></p>
                                </div>
                            </a>

                        </li>
                        <li>
                            <a href="#">
                                <div class="story-user-media">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="story-user-innr">
                                    <h5> Stella Johnson </h5>
                                    <p> <span class="story-count"> 3 new </span> <span class="story-time-ago"> 1hr ago
                                        </span></p>
                                </div>
                            </a>

                        </li>
                        <li>
                            <a href="#">
                                <div class="story-user-media">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-4.jpg')}}" alt="">
                                </div>
                                <div class="story-user-innr">
                                    <h5>  Erica Jones  </h5>
                                    <p> <span class="story-count"> 2 new </span> <span class="story-time-ago"> 3hr ago
                                        </span></p>
                                </div>
                            </a>

                        </li>
                        <li>
                            <a href="#">
                                <div class="story-user-media">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-7.jpg')}}" alt="">
                                </div>
                                <div class="story-user-innr">
                                    <h5> Adrian Mohani </h5>
                                    <p> <span class="story-count"> 1 new </span> <span class="story-time-ago"> 4hr ago
                                        </span></p>
                                </div>
                            </a>

                        </li>
                        <li>
                            <a href="#">
                                <div class="story-user-media">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-5.jpg')}}" alt="">
                                </div>
                                <div class="story-user-innr">
                                    <h5>   Alex Dolgove   </h5>
                                    <p> <span class="story-count"> 3 new </span> <span class="story-time-ago"> 7hr ago
                                        </span></p>
                                </div>
                            </a>

                        </li>
                        <li>
                            <a href="#">
                                <div class="story-user-media">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-1.jpg')}}" alt="">
                                </div>
                                <div class="story-user-innr">
                                    <h5> Stella Johnson </h5>
                                    <p> <span class="story-count"> 2 new </span> <span class="story-time-ago"> 8hr ago
                                        </span></p>
                                </div>
                            </a>

                        </li>
                        <li>
                            <a href="#">
                                <div class="story-user-media">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="story-user-innr">
                                    <h5>  Erica Jones </h5>
                                    <p> <span class="story-count"> 3 new </span> <span class="story-time-ago"> 10hr ago
                                        </span></p>
                                </div>
                            </a>

                        </li>
                        <li>
                            <a href="#">
                                <div class="story-user-media">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-5.jpg')}}" alt="">
                                </div>
                                <div class="story-user-innr">
                                    <h5>  Alex Dolgove  </h5>
                                    <p> <span class="story-count"> 3 new </span> <span class="story-time-ago"> 14hr ago
                                        </span></p>
                                </div>
                            </a>

                        </li>

                    </ul>

                </div>

            </div>
            <div class="story-content">

                <!-- close button-->
                <span class="story-btn-close" uk-toggle="target: body ; cls: is-open"
                    uk-tooltip="title:Close story ; pos: left "></span>

                <div class="story-content-innr">

                    <ul id="story-slider-switcher" class="uk-switcher">

                        <li>

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>

                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/post/img-1.jpg')}}" alt="">
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-1.jpg')}}" alt="">
                                        </div>
                                    </li>
                                </ul>


                            </div>


                        </li>

                        <li>

                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>

                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div class="story-slider-image">
                                            <img src="{{ asset('social-media/assets/images/post/img-3.jpg')}}" alt="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="story-slider-image">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-3.jpg')}}" alt="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="story-slider-image">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-2.jpg')}}" alt="">
                                        </div>
                                    </li>
                                </ul>

                            </div>

                        </li>

                        <li>

                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}" alt="">
                                        </div>

                                    </li>
                                </ul>
                            </div>

                        </li>

                        <li>

                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}" alt="">
                                        </div>

                                    </li>
                                </ul>
                            </div>

                        </li>

                        <li>

                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}" alt="">
                                        </div>

                                    </li>
                                </ul>
                            </div>

                        </li>

                        <li>

                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}" alt="">
                                        </div>

                                    </li>
                                </ul>
                            </div>

                        </li>

                        <li>

                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}" alt="">
                                        </div>

                                    </li>
                                </ul>
                            </div>

                        </li>

                        <li>

                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}" alt="">
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}" alt="">
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}" alt="">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <!-- slider navigation -->

                            <a href="#" uk-switcher-item="previous"
                                class="uk-position-center-left-out uk-position-medium slidenav-prev"></a>
                            <a href="#" uk-switcher-item="next"
                                class="uk-position-center-right-out uk-position-medium slidenav-next"></a>

                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <!-- navigation -->
                                <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                                <!-- Story posted image -->
                                <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                                    <li>
                                        <div
                                            class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                            <img src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}" alt="">
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @yield('mainContent')
        <div id="payment-status-modal" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <h2 class="uk-modal-title" id="payment-status-title"></h2>
                <p id="payment-status-message"></p>
                <p class="uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Close</button>
                </p>
            </div>
        </div>
        @yield('rightBar')

    </div>


    <!-- For Night mode -->
    <script>
        (function (window, document, undefined) {
            'use strict';
            if (!('localStorage' in window)) return;
            var nightMode = localStorage.getItem('gmtNightMode');
            if (nightMode) {
                document.documentElement.className += ' night-mode';
            }
        })(window, document);


        (function (window, document, undefined) {

            'use strict';

            // Feature test
            if (!('localStorage' in window)) return;

            // Get our newly insert toggle
            var nightMode = document.querySelector('#night-mode');
            if (!nightMode) return;

            // When clicked, toggle night mode on or off
            nightMode.addEventListener('click', function (event) {
                event.preventDefault();
                document.documentElement.classList.toggle('night-mode');
                if (document.documentElement.classList.contains('night-mode')) {
                    localStorage.setItem('gmtNightMode', true);
                    return;
                }
                localStorage.removeItem('gmtNightMode');
            }, false);

        })(window, document);
    </script>


    <!-- javaScripts
                ================================================== -->
    <script src="{{ asset('social-media/assets/js/framework.js')}}"></script>
    <script src="{{ asset('social-media/assets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('social-media/assets/js/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('social-media/assets/js/simplebar.js')}}"></script>
    <script src="{{ asset('social-media/assets/js/main.js')}}"></script>
    <script src="{{ asset('dashboard/assets/js/cropper-1.5.6.js') }}"></script>
    <script src="{{ asset('social-media/assets/js/select2.min.js')}}"></script>
    <script src="{{ asset('dashboard/assets/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('social-media/assets/js/function.js') }}"></script> {{-- Always on Bottom --}}
    @yield('javaScript')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('payment_status');

            if (status === 'success' || status === 'fail') {
                const title = document.getElementById('payment-status-title');
                const message = document.getElementById('payment-status-message');

                if (status === 'success') {
                    title.innerText = "🎉 Payment Successful";
                    message.innerText = "Your payment was completed successfully.";
                } else {
                    title.innerText = "❌ Payment Failed";
                    message.innerText = "Your payment could not be completed. Please try again.";
                }

                UIkit.modal('#payment-status-modal').show();

                // Optional: Clean the URL
                const newUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>
    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            })
        </script>
    @endif

    @if (session('page_error'))
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ session('page_error') }}",
            });
        </script>
    @endif
</body>
</html>
