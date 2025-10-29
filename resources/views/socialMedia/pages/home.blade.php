@php
    $social_media_user_data = session()->get('social_media_user_data');
    if (!$social_media_user_data)
    {
        store_social_media_info();
        $social_media_user_data = session()->get('social_media_user_data');
    }
    extract($social_media_user_data);
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

        <div class="main_content_inner">

            <div class="uk-grid-large" uk-grid>

                <div class="uk-width-2-3@m fead-area">

                    <div class="section-small pt-0">
                        <div class="uk-position-relative" uk-slider="finite: true">

                            <div class="uk-slider-container pb-3">

                                <ul
                                    class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-3 story-slider uk-grid">
                                    <li>
                                        <a href="#" uk-toggle="target: body ; cls: is-open">
                                            <div class="story-card" data-src="{{ asset('social-media/assets/images/avatars/avatar-lg-1.jpg')}}"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4> {{auth()->user()->name}} </h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
                                    <li>
                                        <a href="#" uk-toggle="target: body ; cls: is-open">
                                            <div class="story-card" data-src="{{ asset('social-media/assets/images/events/listing-5.jpg')}}"
                                                uk-img>
                                                <img src="{{ asset('social-media/assets/images/avatars/avatar-5.jpg')}}" alt="">
                                                <div class="story-card-content">
                                                    <h4> Jonathan </h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
                                    <li>
                                        <a href="#" uk-toggle="target: body ; cls: is-open">
                                            <div class="story-card" data-src="{{ asset('social-media/assets/images/avatars/avatar-lg-3.jpg')}}"
                                                uk-img>
                                                <img src="{{ asset('social-media/assets/images/avatars/avatar-6.jpg')}}" alt="">
                                                <div class="story-card-content">
                                                    <h4> Stella </h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
                                    <li>

                                        <a href="#" uk-toggle="target: body ; cls: is-open">
                                            <div class="story-card" data-src="{{ asset('social-media/assets/images/avatars/avatar-lg-4.jpg')}}"
                                                uk-img>
                                                <img src="{{ asset('social-media/assets/images/avatars/avatar-4.jpg')}}" alt="">
                                                <div class="story-card-content">
                                                    <h4> Alex </h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
                                    <li>

                                        <a href="#" uk-toggle="target: body ; cls: is-open">
                                            <div class="story-card" data-src="{{ asset('social-media/assets/images/avatars/avatar-lg-2.jpg')}}"
                                                uk-img>
                                                <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                                <div class="story-card-content">
                                                    <h4> Adrian </h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
                                    <li>

                                        <a href="#" uk-toggle="target: body ; cls: is-open">
                                            <div class="story-card" data-src="{{ asset('social-media/assets/images/avatars/avatar-lg-5.jpg')}}"
                                                uk-img>
                                                <img src="{{ asset('social-media/assets/images/avatars/avatar-5.jpg')}}" alt="">
                                                <div class="story-card-content">
                                                    <h4> {{auth()->user()->name}} </h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>

                                </ul>

                                <div class="uk-visible@m">
                                    <a class="uk-position-center-left-out slidenav-prev" href="#"
                                        uk-slider-item="previous"></a>
                                    <a class="uk-position-center-right-out slidenav-next" href="#"
                                        uk-slider-item="next"></a>
                                </div>
                                <div class="uk-hidden@m">
                                    <a class="uk-position-center-left slidenav-prev" href="#"
                                        uk-slider-item="previous"></a>
                                    <a class="uk-position-center-right slidenav-next" href="#"
                                        uk-slider-item="next"></a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="post-newer">

                        <div class="post-new" uk-toggle="target: body ; cls: post-focus">
                            <div class="post-new-media">
                                <div class="post-new-media-user">
                                    <img src="{{ asset('social-media/assets/images/uploaded_img/'.$thumbnail_profile)}}" alt="">
                                </div>
                                <div class="post-new-media-input">
                                    <input type="text" class="uk-input" placeholder="What's Your Mind ? {{auth()->user()->name}}!">
                                </div>
                            </div>
                            <hr>
                            <div class="post-new-type">

                                <a href="#">
                                    <img src="{{ asset('social-media/assets/images/icons/photo.png')}}" alt="">
                                    Photo/Video
                                </a>

                                <a href="#" class="uk-visible@s">
                                    <img src="{{ asset('social-media/assets/images/icons/tag-friend.png')}}" alt="">
                                    Tag Friend
                                </a>

                                <a href="#"><img src="{{ asset('social-media/assets/images/icons/reactions_wow.png')}}" alt="">
                                    Fealing /Activity
                                </a>

                            </div>
                        </div>

                        <div class="post-pop">

                            <div class="post-new-overyly" uk-toggle="target: body ; cls: post-focus"></div>

                            <div class="post-new uk-animation-slide-top-small">


                                <div class="post-new-header">

                                    <h4> Create new post</h4>

                                    <!-- close button-->
                                    <span class="post-new-btn-close" uk-toggle="target: body ; cls: post-focus"
                                        uk-tooltip="title:Close; pos: left "></span>

                                </div>

                                <div class="post-new-media">
                                    <div class="post-new-media-user">
                                        <img src="{{ asset('social-media/assets/images/uploaded_img/'.$thumbnail_profile)}}" alt="">
                                    </div>
                                    <div class="post-new-media-input">
                                        <input type="text" class="uk-input"
                                            placeholder="What's Your Mind ? {{auth()->user()->name}}!">
                                    </div>
                                </div>
                                <div class="post-new-tab-nav">
                                    <a href="#" uk-tooltip="title:Close"> <i class="uil-image"></i> </a>
                                    <a href="#"> <i class="uil-user-plus"></i> </a>
                                    <a href="#"> <i class="uil-video"></i> </a>
                                    <a href="#"> <i class="uil-record-audio"></i> </a>
                                    <a href="#"> <i class="uil-file-alt"></i> </a>
                                    <a href="#"> <i class="uil-emoji"></i> </a>
                                    <a href="#"> <i class="uil-gift"></i> </a>
                                    <a href="#"> <i class="uil-shopping-basket"></i> </a>
                                    <a href="#"> <i class="uil-check"></i> </a>
                                    <a href="#"> <i class="uil-graph-bar"></i> </a>
                                </div>
                                <div class="uk-flex uk-flex-between">


                                    <button class="button outline-light circle" type="button" style="
                                    border-color: #e6e6e6;  border-width: 1px;  ">Hover</button>
                                    <div uk-dropdown>
                                        <ul class="uk-nav uk-dropdown-nav">
                                            <li class="uk-active"><a href="#">Only me</a></li>
                                            <li><a href="#">Every one</a></li>
                                            <li><a href="#"> People I Follow </a></li>
                                            <li><a href="#">I People Follow Me</a></li>
                                        </ul>
                                    </div>

                                    <a href="#" class="button primary px-6"> Share </a>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="post">
                        <div class="post-heading">
                            <div class="post-avature">
                                <img src="{{ asset('social-media/assets/images/avatars/avatar-6.jpg')}}" alt="">
                            </div>
                            <div class="post-title">
                                <h4> Mariah Ali </h4>
                                <p> 5 <span> hrs</span> <i class="uil-users-alt"></i> </p>
                            </div>
                            <div class="post-btn-action">
                                <span class="icon-more uil-ellipsis-h"></span>
                                <div class="mt-0 p-2" uk-dropdown="pos: bottom-right;mode:hover ">
                                    <ul class="uk-nav uk-dropdown-nav">
                                        <li><a href="#"> <i class="uil-share-alt mr-1"></i> Share</a> </li>
                                        <li><a href="#"> <i class="uil-edit-alt mr-1"></i> Edit Post </a></li>
                                        <li><a href="#"> <i class="uil-comment-slash mr-1"></i> Disable comments
                                            </a></li>
                                        <li><a href="#"> <i class="uil-favorite mr-1"></i> Add favorites </a></li>
                                        <li><a href="#" class="text-danger"> <i class="uil-trash-alt mr-1"></i>
                                                Delete </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="post-description">
                            <div class="fullsizeimg">
                                <img src="{{ asset('social-media/assets/images/post/img-1.jpg')}}" alt="">
                            </div>

                            <div class="post-state-details">
                                <div>
                                    <img src="{{ asset('social-media/assets/images/icons/reactions_like.png')}}" alt="">
                                    <img src="{{ asset('social-media/assets/images/icons/reactions_love.png')}}" alt="">
                                    <p> 13 </p>
                                </div>
                                <p> 24 Comments</p>
                            </div>

                        </div>

                        <div class="post-state">
                            <div class="post-state-btns"> <i class="uil-thumbs-up"></i> 126<span> Liked </span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-heart"></i> 18 <span> Coments</span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-share-alt"></i> 193 <span> Shared </span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-bookmark"></i> 13 <span> Saved </span>
                            </div>
                        </div>

                        <!-- post comments -->
                        <div class="post-comments">
                            <a href="#" class="view-more-comment"> Veiw 8 more Comments</a>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-5.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6> Alex Dolgove</h6>
                                        <p> Ut wisi enim ad minim laoreet dolore magna aliquam erat </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-danger mr-1"> <i class="uil-heart"></i> Love </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 1d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6>Stella Johnson</h6>
                                        <p> Ut wisi enim ad minim laoreet dolore <strong> David !</strong> </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-primary mr-1"> <i class="uil-thumbs-up"></i> Like
                                        </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 2d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-3.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6> Jonathan Madano </h6>
                                        <p> sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam
                                            erat
                                            volutpat.<strong> David !</strong> </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-danger mr-1"> <i class="uil-heart"></i> Love </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 3d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>


                            <a href="#" class="view-more-comment"> Veiw 8 more Comments</a>

                            <div class="post-add-comment">
                                <div class="post-add-comment-avature">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="post-add-comment-text-area">
                                    <input type="text" placeholder="Write your comment...">
                                    <div class="icons">
                                        <span class="uil-link-alt"></span>
                                        <span class="uil-grin"></span>
                                        <span class="uil-image"></span>
                                    </div>
                                </div>

                            </div>

                        </div>



                    </div>

                    <div class="post">
                        <div class="post-heading">
                            <div class="post-avature">
                                <img src="{{ asset('social-media/assets/images/avatars/avatar-3.jpg')}}" alt="">
                            </div>
                            <div class="post-title">
                                <h4> Erica Jones </h4>
                                <p> 5 <span> hrs</span> <i class="uil-users-alt"></i> </p>
                            </div>
                            <div class="post-btn-action">
                                <span class="icon-more uil-ellipsis-h"></span>
                                <div class="mt-0 p-2" uk-dropdown="pos: bottom-right;mode:hover ">
                                    <ul class="uk-nav uk-dropdown-nav">
                                        <li><a href="#"> <i class="uil-share-alt mr-1"></i> Share</a> </li>
                                        <li><a href="#"> <i class="uil-edit-alt mr-1"></i> Edit Post </a></li>
                                        <li><a href="#"> <i class="uil-comment-slash mr-1"></i> Disable comments
                                            </a></li>
                                        <li><a href="#"> <i class="uil-favorite mr-1"></i> Add favorites </a></li>
                                        <li><a href="#" class="text-danger"> <i class="uil-trash-alt mr-1"></i>
                                                Delete </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="post-description">
                            <div class="uk-grid-small" uk-grid>
                                <div class="uk-width-1-1@m">
                                    <img src="{{ asset('social-media/assets/images/post/img-4.jpg')}}" class="rounded" alt="">
                                </div>
                                <div class="uk-width-1-2@m uk-width-1-2">
                                    <img src="{{ asset('social-media/assets/images/post/img-2.jpg')}}" class="rounded" alt="">
                                </div>
                                <div class="uk-width-1-2@m uk-width-1-2 uk-position-relative">
                                    <img src="{{ asset('social-media/assets/images/post/img-3.jpg')}}" class="rounded" alt="">
                                    <div class="uk-position-center uk-light">
                                        <a href="#">
                                            <h3> + 15 more </h3>
                                        </a></div>
                                </div>
                            </div>

                            <div class="post-state-details">
                                <div>
                                    <img src="{{ asset('social-media/assets/images/icons/reactions_like.png')}}" alt="">
                                    <img src="{{ asset('social-media/assets/images/icons/reactions_love.png')}}" alt="">
                                    <p> 13 </p>
                                </div>
                                <p> <span class="mr-2"> <i class="uil-eye"></i> Veiws </span> 212 Comments </p>
                            </div>

                        </div>

                        <div class="post-state">
                            <div class="post-state-btns"> <i class="uil-thumbs-up"></i> 126<span> Liked </span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-heart"></i> 18 <span> Coments</span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-share-alt"></i> 193 <span> Shared </span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-bookmark"></i> 13 <span> Saved </span>
                            </div>
                        </div>


                        <!-- post comments -->
                        <div class="post-comments">
                            <a href="#" class="view-more-comment"> Veiw 8 more Comments</a>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-5.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6> Alex Dolgove</h6>
                                        <p> Ut wisi enim ad minim laoreet dolore magna aliquam erat </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-danger mr-1"> <i class="uil-heart"></i> Love </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 3d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6>Stella Johnson</h6>
                                        <p> Ut wisi enim ad minim laoreet dolore <strong> David !</strong> </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-primary mr-1"> <i class="uil-thumbs-up"></i> Like
                                        </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 3d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-3.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6> Jonathan Madano </h6>
                                        <p> sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam
                                            erat
                                            volutpat.<strong> David !</strong> </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-danger mr-1"> <i class="uil-heart"></i> Love </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 3d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>


                            <a href="#" class="view-more-comment"> Veiw 8 more Comments</a>

                            <div class="post-add-comment">
                                <div class="post-add-comment-avature">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="post-add-comment-text-area">
                                    <input type="text" placeholder="Write your comment...">
                                    <div class="icons">
                                        <span class="uil-link-alt"></span>
                                        <span class="uil-grin"></span>
                                        <span class="uil-image"></span>
                                    </div>
                                </div>

                            </div>

                        </div>



                    </div>


                    <div class="post">
                        <div class="post-heading">
                            <div class="post-avature">
                                <img src="{{ asset('social-media/assets/images/avatars/avatar-4.jpg')}}" alt="">
                            </div>
                            <div class="post-title">
                                <h4> Stella Johnson </h4>
                                <p> 5 <span> hrs</span> <i class="uil-users-alt"></i> </p>
                            </div>
                            <div class="post-btn-action">
                                <span class="icon-more uil-ellipsis-h"></span>
                                <div class="mt-0 p-2" uk-dropdown="pos: bottom-right;mode:hover ">
                                    <ul class="uk-nav uk-dropdown-nav">
                                        <li><a href="#"> <i class="uil-share-alt mr-1"></i> Share</a> </li>
                                        <li><a href="#"> <i class="uil-edit-alt mr-1"></i> Edit Post </a></li>
                                        <li><a href="#"> <i class="uil-comment-slash mr-1"></i> Disable comments
                                            </a></li>
                                        <li><a href="#"> <i class="uil-favorite mr-1"></i> Add favorites </a></li>
                                        <li><a href="#" class="text-danger"> <i class="uil-trash-alt mr-1"></i>
                                                Delete </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="post-description">

                            <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh
                                euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                Ut wisi enim ad minim laoreet dolore magna aliquam erat volutpat</p>
                            <div class="post-state-details">
                                <div>
                                    <img src="{{ asset('social-media/assets/images/icons/reactions_like.png')}}" alt="">
                                    <img src="{{ asset('social-media/assets/images/icons/reactions_love.png')}}" alt="">
                                    <p> 13 </p>
                                </div>
                                <p> 24 Comments</p>
                            </div>

                        </div>

                        <div class="post-state">
                            <div class="post-state-btns"> <i class="uil-thumbs-up"></i> 126<span> Liked </span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-heart"></i> 18 <span> Coments</span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-share-alt"></i> 193 <span> Shared </span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-bookmark"></i> 13 <span> Saved </span>
                            </div>
                        </div>

                        <!-- post comments -->
                        <div class="post-comments">
                            <a href="#" class="view-more-comment"> Veiw 8 more Comments</a>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-5.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6> Alex Dolgove</h6>
                                        <p> Ut wisi enim ad minim laoreet dolore magna aliquam erat </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-danger mr-1"> <i class="uil-heart"></i> Love </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 1d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6>Stella Johnson</h6>
                                        <p> Ut wisi enim ad minim laoreet dolore <strong> David !</strong> </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-primary mr-1"> <i class="uil-thumbs-up"></i> Like
                                        </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 2d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>

                            <div class="post-add-comment">
                                <div class="post-add-comment-avature">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="post-add-comment-text-area">
                                    <input type="text" placeholder="Write your comment...">
                                    <div class="icons">
                                        <span class="uil-link-alt"></span>
                                        <span class="uil-grin"></span>
                                        <span class="uil-image"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="post">
                        <div class="post-heading">
                            <div class="post-avature">
                                <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                            </div>
                            <div class="post-title">
                                <h4> {{auth()->user()->name}} </h4>
                                <p> 5 <span> hrs</span> <i class="uil-users-alt"></i> </p>
                            </div>
                            <div class="post-btn-action">
                                <span class="icon-more uil-ellipsis-h"></span>
                                <div class="mt-0 p-2" uk-dropdown="pos: bottom-right;mode:hover ">
                                    <ul class="uk-nav uk-dropdown-nav">
                                        <li><a href="#"> <i class="uil-share-alt mr-1"></i> Share</a> </li>
                                        <li><a href="#"> <i class="uil-edit-alt mr-1"></i> Edit Post </a></li>
                                        <li><a href="#"> <i class="uil-comment-slash mr-1"></i> Disable comments
                                            </a></li>
                                        <li><a href="#"> <i class="uil-favorite mr-1"></i> Add favorites </a></li>
                                        <li><a href="#" class="text-danger"> <i class="uil-trash-alt mr-1"></i>
                                                Delete </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="post-description">

                            <div class="fullsizevid">
                                <div class="embed-video">
                                    <iframe src="https://www.youtube.com/embed/pQN-pnXPaV g " frameborder="0"
                                        uk-video="automute: true" allowfullscreen uk-responsive></iframe>
                                </div>
                            </div>

                            <div class="post-state-details">
                                <div>
                                    <img src="{{ asset('social-media/assets/images/icons/reactions_like.png')}}" alt="">
                                    <img src="{{ asset('social-media/assets/images/icons/reactions_love.png')}}" alt="">
                                    <p> 13 </p>
                                </div>
                                <p> <span class="mr-2"> <i class="uil-eye"></i> 38 Veiws </span> 212 Comments </p>
                            </div>

                        </div>

                        <div class="post-state">
                            <div class="post-state-btns"> <i class="uil-thumbs-up"></i> 126<span> Liked </span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-heart"></i> 18 <span> Coments</span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-share-alt"></i> 193 <span> Shared </span>
                            </div>
                            <div class="post-state-btns"> <i class="uil-bookmark"></i> 13 <span> Saved </span>
                            </div>
                        </div>


                        <!-- post comments -->
                        <div class="post-comments">
                            <a href="#" class="view-more-comment"> Veiw 8 more Comments</a>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-5.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6> Alex Dolgove</h6>
                                        <p> Ut wisi enim ad minim laoreet dolore magna aliquam erat </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-danger mr-1"> <i class="uil-heart"></i> Love </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 3d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>
                            <div class="post-comments-single">
                                <div class="post-comment-avatar">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="post-comment-text">
                                    <div class="post-comment-text-inner">
                                        <h6>Stella Johnson</h6>
                                        <p> Ut wisi enim ad minim laoreet dolore <strong> David !</strong> </p>
                                    </div>
                                    <div class="uk-text-small">
                                        <a href="#" class="text-primary mr-1"> <i class="uil-thumbs-up"></i> Like
                                        </a>
                                        <a href="#" class=" mr-1"> Replay </a>
                                        <span> 3d</span>
                                    </div>
                                </div>
                                <a href="#" class="post-comment-opt"></a>
                            </div>

                            <div class="post-add-comment">
                                <div class="post-add-comment-avature">
                                    <img src="{{ asset('social-media/assets/images/avatars/avatar-2.jpg')}}" alt="">
                                </div>
                                <div class="post-add-comment-text-area">
                                    <input type="text" placeholder="Write your comment...">
                                    <div class="icons">
                                        <span class="uil-link-alt"></span>
                                        <span class="uil-grin"></span>
                                        <span class="uil-image"></span>
                                    </div>
                                </div>

                            </div>

                        </div>



                    </div>
                </div>
                @include('socialMedia.commonFile.rightBarV1')
            </div>

        </div>
    </div>
@endsection
