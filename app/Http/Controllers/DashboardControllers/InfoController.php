<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\GenarelInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class InfoController extends Controller
{
    public $dimentions = array(
        'logo'              =>[ 'h'=> 61, 'w'=> 150 ],
        'logo_white'        =>[ 'h'=> 61, 'w'=> 150 ],
        'favicon'           =>[ 'h'=> 30, 'w'=> 30 ],
        'about_background'  =>[ 'h'=> 1920, 'w'=> 1290 ],
        'service_background'=>[ 'h'=> 1920, 'w'=> 1290 ],
        'blog_background'   =>[ 'h'=> 1920, 'w'=> 1290 ],
        'contact_background'=>[ 'h'=> 1920, 'w'=> 1290 ],
        'team_background'   =>[ 'h'=> 1920, 'w'=> 1290 ],
        'call_icon_img'     =>[ 'h'=> 50, 'w'=> 55],
        'message_icon_img'  =>[ 'h'=> 50, 'w'=> 55],
        'address_icon_img'  =>[ 'h'=> 50, 'w'=> 55],
    );
    public function index()
    {
        return view('dashboard.system.information.index',[
            'informations' => GenarelInfo::all(),
            'dimentions' => $this->dimentions
        ]);
    }
    public function edit($enId){
        $id = decrypt($enId);
        $info = GenarelInfo::find($id);
        return view('dashboard.system.information.edit',[
            'information' => $info,
            'dimentions' => $this->dimentions[$info?->field_name] ?? 0
        ]);
    }

    public function update(Request $request,$id){
       $info        =  GenarelInfo::find($id);

       $info->value         = $request->value;
       $info->updated_by    = auth()->id();
       $info->save();
       return redirect()->route('info-setup.index')->with('success','update successfully');
    }


    public function image_update(Request $request,$id){
        $info       = GenarelInfo::findOrFail($id);

        $w = $this->dimentions[$info?->field_name]['w'];
        $h = $this->dimentions[$info?->field_name]['h'];
        // return "dimensions:width=$w,height=$h";
       $request->validate([
            'photo'=>"required|image|mimes:jpg,jpeg,png|dimensions:width=$w,height=$h"
        ]);
        try
        {


            $msg_str    = uploadImage('public/assets/images/info/',$request,'photo'); //Custom Helpers
            $msgArr     = explode('*',$msg_str);
            if($msgArr[0] == 1){


                if ($msgArr[1]!= 0) //IF uploaded image found
                {
                    $image_name = $msgArr[1];
                    $path   = base_path('public/assets/images/info/' . $info->value);
                    $msg    = insertDeleteLink($path,99); // Custom Function
                    if ($msg!=1)
                    {
                        return back()->with('error',$msg);
                    }
                    $info->value         = $image_name;
                    $info->updated_by    = auth()->id();
                    $info->save();
                }

                return  redirect()->route('info-setup.index')->with('success','Updated successfully');
            }else{
                return back()->with('error',$msg_str);
            }
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }

    public function published()
    {
        try
        {
            $data = GenarelInfo::select('field_name','value')->get();
            $dataArray = array();
            foreach ($data as $v)
            {
                $dataArray[$v['field_name']] = $v['value'];
            }

            $all_data = ['dataArray'=> $dataArray];
            $content  = View::make('fontend.setup.headLinkTemp',$all_data)->render();
            $content1 = View::make('fontend.setup.headerTemp',$all_data)->render();
            $content2 = View::make('fontend.setup.footerTemp',$all_data)->render();

            // Path to the new static Blade view file
            $path   = resource_path('views/fontend/setup/headLink.blade.php');
            $path1  = resource_path('views/fontend/setup/header.blade.php');
            $path2  = resource_path('views/fontend/setup/footer.blade.php');

            // Write the rendered content to the Blade view file
            file_put_contents($path, $content);
            file_put_contents($path1, $content1);
            file_put_contents($path2, $content2);

            $msg = deleteFile(99); //Custom helpers
            if($msg!=1){
                return back()->with('error',$msg);
            }
            return back()->with('success','Published Successfully');
        }
        catch(Exception $e)
        {
                $message = $e->getMessage();
                return back()->with('error',$message);
        }
    }
    public function uploadCkFile(Request $request)
    {
        /* if ($request->hasFile('upload'))
        {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('media'), $fileName);
            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);

        } */
               // Validate the uploaded file
               $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle the file upload
            $file = $request->file('file');
            $path = $file->store('public/images');

            // Return the URL to the image
            return response()->json(['location' => Storage::url($path)]);
    }
}
