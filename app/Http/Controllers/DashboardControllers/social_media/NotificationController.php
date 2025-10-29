<?php

namespace App\Http\Controllers\DashboardControllers\social_media;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users  = User::select('id','name','role_id')->get();
        $notifications = Notification::leftjoin('users','users.id','notifications.user_id')
            ->select('notifications.*','users.name as user_name')
            ->latest()
            ->get();
        return view('dashboard.socialMedia.notification.index', compact('notifications','users'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message'=>'required|max:255',
            'user_name'=>'required'
        ]);

        try
        {
            store_notification($request->message,$request->user_name);
            return back()->with('success','Added successfully');
        }
        catch (Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
    }


    public function get_notifications(Notification $notification)
    {
        $notifications = Notification::where('user_id',auth()->id())->latest()->take(10)->get();
        $html = '';
        $no_of_unread = 0;
        foreach ($notifications as $v)
        {
            if ($v->is_read == 0)
            {
                $no_of_unread++;
            }

            $time_diff  = Carbon::parse($v->created_at)->diffForHumans();
            $message    = $v->message;
            $img        = asset('social-media/assets/images/icons/info.png');
            $html .= ' <li>
                            <a href="#">
                                <span class="notification-avatar">
                                    <img src="'.$img.'" alt="">
                                </span>
                                <span class="notification-text">
                                     '.$message.' <br> <span class="time-ago"> '.$time_diff.' </span>
                                </span>
                            </a>
                        </li>';
        }
        // <strong>Ascentaverse.</strong>
        return $no_of_unread .'**'.$html;
    }
    public function read_notification(Notification $notification)
    {
        $notifications = Notification::where('user_id',auth()->id())->get();
        foreach ($notifications as $v)
        {
            $v->update(['is_read'=>1]);
        }
        return 'success';
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }


    public function destroy(Notification $notification)
    {
        //
    }
}
