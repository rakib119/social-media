<?php

namespace App\Http\Controllers\socialMedia;

use App\Models\Contact;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GenarelInfo;
use App\Models\SocialPhotos;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SocialMediaController extends Controller
{
    public function __construct()
    {

        // $this->middleware('auth');
    }

    public function social_home()
    {
        
        $web_info   = Session::get('web_field_info', []);
        // return $web_info['logo'];
        $user       = auth()->id();
        return view('socialMedia.pages.home', compact('user','web_info'));
    }
    public function my_account()
    {
        $web_info   = Session::get('web_field_info', []);
        $user       = auth()->id();
        return view('socialMedia.pages.myAccount', compact('user','web_info'));
    }

    public function social_profile()
    {
        $web_info   = Session::get('web_field_info', []);
        $user       = auth()->id();
        return view('socialMedia.pages.profile', compact('user','web_info'));
    }
    public function upload_photo(Request $request)
    {
        // return response()->json( ['data' => $request->all()]);

        try
        {
            DB::beginTransaction();
            $msg_str        = uploadImage('public/social-media/assets/images/uploaded_img/',$request,'original_image'); //Custom Helpers
            $thumb_str      = uploadImage('public/social-media/assets/images/uploaded_img/',$request,'thumbnail',1); //Custom Helpers
            $msgArr         = explode('*',$msg_str);
            $thumbArr       = explode('*',$thumb_str);

            if($msgArr[0] == 1 && $thumbArr[0] == 1 )
            {
                try
                {
                    DB::table('social_photos')
                    ->where('user_id',auth()->id())
                    ->where('photo_gallery',$request->photo_gallery)
                    ->update
                    (
                        [
                            'is_current' => 0,
                            'updated_by' => auth()->id(),
                            'updated_at' => Carbon::now(),
                        ]
                    );

                    SocialPhotos::insert([
                        'original_photo'        =>  $msgArr[1],
                        'thumbnail'             =>  $thumbArr[1],
                        'photo_gallery'         =>  $request->photo_gallery,
                        'user_id'               =>  auth()->id(),
                        'created_by'            =>  auth()->id(),
                        'created_at'            =>  Carbon::now(),
                    ]);

                    DB::commit();
                    store_social_media_info();
                    // Return success JSON response
                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Photo uploaded successfully',
                        'data'    => [
                            'original_photo_url' => asset('social-media/assets/images/uploaded_img/' . $msgArr[1]), // Adjust the URL path if needed
                            'thumbnail_url'      => asset('social-media/assets/images/uploaded_img/' . $thumbArr[1]),
                        ]
                    ], 200);

                }
                catch (Exception $e)
                {
                    DB::rollBack();
                    return response()->json([
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ], 400);
                }
            }
            else
            {
                DB::rollBack();
                return response()->json([
                    'status'  => 'error',
                    'message' => $msg_str,
                ], 400);
            }
        }
        catch (Exception $e)
        {
            DB::rollBack();

            // Return error JSON response
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500); // HTTP 500 Internal Server Error
        }
    }
    public function store_user_info(Request $request)
    {
        // return response()->json( ['data' => $request->all()]);

        try
        {
            DB::beginTransaction();
            $msg_str        = uploadImage('public/social-media/assets/images/uploaded_img/',$request,'original_image'); //Custom Helpers
            $thumb_str      = uploadImage('public/social-media/assets/images/uploaded_img/',$request,'thumbnail',1); //Custom Helpers
            $msgArr         = explode('*',$msg_str);
            $thumbArr       = explode('*',$thumb_str);

            if($msgArr[0] == 1 && $thumbArr[0] == 1 )
            {
                try
                {
                    DB::table('social_photos')
                    ->where('user_id',auth()->id())
                    ->where('photo_gallery',$request->photo_gallery)
                    ->update
                    (
                        [
                            'is_current' => 0,
                            'updated_by' => auth()->id(),
                            'updated_at' => Carbon::now(),
                        ]
                    );

                    SocialPhotos::insert([
                        'original_photo'        =>  $msgArr[1],
                        'thumbnail'             =>  $thumbArr[1],
                        'photo_gallery'         =>  $request->photo_gallery,
                        'user_id'               =>  auth()->id(),
                        'created_by'            =>  auth()->id(),
                        'created_at'            =>  Carbon::now(),
                    ]);

                    DB::commit();
                    store_social_media_info();
                    // Return success JSON response
                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Photo uploaded successfully',
                        'data'    => [
                            'original_photo_url' => asset('social-media/assets/images/uploaded_img/' . $msgArr[1]), // Adjust the URL path if needed
                            'thumbnail_url'      => asset('social-media/assets/images/uploaded_img/' . $thumbArr[1]),
                        ]
                    ], 200);

                }
                catch (Exception $e)
                {
                    DB::rollBack();
                    return response()->json([
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ], 400);
                }
            }
            else
            {
                DB::rollBack();
                return response()->json([
                    'status'  => 'error',
                    'message' => $msg_str,
                ], 400);
            }
        }
        catch (Exception $e)
        {
            DB::rollBack();

            // Return error JSON response
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500); // HTTP 500 Internal Server Error
        }
    }

}
