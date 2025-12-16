<?php

use App\Models\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

if (!function_exists('uploadImage')) {
    function uploadImage($basepath,$request,$field_name,$isBase64=0)
    {
        try {
            if ($isBase64==1)
            {
                //Image From Base64
                $imageData = $request->input($field_name);

                // Extract the image extension and data
                if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
                    $extension = $matches[1];
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                    $imageData = base64_decode($imageData);

                    // Generate a unique filename
                    $image_name = Str::random(25) . '.' . $extension;

                    // Save image to public folder
                    $path = base_path($basepath . $image_name);
                    file_put_contents($path, $imageData);
                    // return $image_name;
                    return "1*".$image_name;
                }
                else{
                    return "1*0";
                }
            }
            else
            {
                //Image From File
                if ($request->hasFile($field_name))
                {
                    $manager    = new ImageManager(new Driver());
                    $image_file = $request->file($field_name);
                    $image_name = Str::random(25).'.'.$image_file->getClientOriginalExtension();
                    $image      = $manager->read($image_file);
                    $path       = base_path($basepath . $image_name);
                    $image->save($path);
                    return "1*".$image_name;
                }
                else{
                    return "1*0";
                }
            }


        } catch (Exception $e)
        {
            return $e->getMessage();
        }
    }
}
if (!function_exists('uploadMultiImage')) {
    function uploadMultiImage($basepath,$request,$field_name)
    {
        try {
            $image_name_array = array();
            if ($request->hasFile($field_name))
            {
                $manager      = new ImageManager(new Driver());
                $image_files  = $request->file($field_name);
                foreach ($image_files as $image_file)
                {
                    $image_name = Str::random(15).'.'.$image_file->getClientOriginalExtension();
                    $image      = $manager->read($image_file);
                    $path       = base_path($basepath . $image_name);
                    $image->save($path);
                    $image_name_array[] = $image_name;
                }
                return "1*".implode("##",$image_name_array);
            }
            else{
                return "1*0";
            }
        } catch (Exception $e)
        {
            return $e->getMessage();
        }
    }
}
if (!function_exists('changeStatus')) {
    function changeStatus($table_name, $idArray,$status_id=0)
    {
        try {
            DB::table($table_name)
                ->whereIn('id',$idArray)
                ->update
                (
                    [
                        'status_active' => $status_id,
                        'updated_by' => auth()->id(),
                        'updated_at' => Carbon::now(),
                    ]
                );

            return 1;
        } catch (Exception $e)
        {
            return $e->getMessage();
        }
    }
}
if (!function_exists('returnArray')) {
    function returnArray($table_name,$columns,$key,$value, $cond='')
    {
        try {

           return $data = DB::raw("select $columns form $table_name  $cond");

        } catch (Exception $e)
        {
            return $e->getMessage();
        }


    }
}
if (!function_exists('storeMenuIntoSession')) {
    function storeMenuIntoSession()
    {
        // return auth()->user()->role_id;
        $main_menu_array = $permission_route = array();
        if (auth()->user())
        {
            if (auth()->user()->role_id == 2) //TEAM MEMBERS
            {
                $user_id = auth()->id();
                $submenus=DB::table('permissions','a')
                    ->join('main_menus as b', 'b.id', '=', 'a.menu_id')
                    ->select('b.menu_name','b.route_name','a.permission_string','b.root_menu_id','a.id','a.menu_id')
                    ->where('a.user_id',$user_id)
                    ->where(['b.status_active'=>1])
                    ->orderBy('b.sequence')
                    ->get();
                // return $submenus;
                $sub_menu_array=$permission_route_type=array();
                foreach ($submenus as $v)
                {
                    $sub_menu_array[$v->root_menu_id][$v->id]['name'] = $v->menu_name;
                    $sub_menu_array[$v->root_menu_id][$v->id]['route'] = $v->route_name;
                    $permission_route_type[$v->menu_id] = $v->permission_string;
                    $permission_menu[$v->menu_id] = $v->menu_id;
                }
                // return $permission_menu;
                $menues= DB::table('main_menus')->select('menu_name', 'id')->where(['status_active'=>1,'root_menu_id'=>null])
                ->orderBy('sequence')
                ->get();
                $main_menu_array= array();

                foreach ($menues as $v)
                {
                    if(isset($sub_menu_array[$v->id]))
                    {
                        foreach ($sub_menu_array[$v->id] as $root_menu_id=>$r)
                        {
                            $main_menu_array[$v->menu_name][$root_menu_id]['name'] = $r['name'];
                            $main_menu_array[$v->menu_name][$root_menu_id]['route'] = $r['route'];
                        }
                    }

                }


                $routes = Route::select('id','route','route_type','menu_id')->whereIn('menu_id', $permission_menu)->orderBy('id')->get();
                $permission_route = array();
                foreach ($routes as $v)
                {
                    $route      = $v->route;
                    $route_type = $v->route_type;
                    $menu_id    = $v->menu_id;
                    $str_id     = isset($permission_route_type[$menu_id])?$permission_route_type[$menu_id]:'';
                    $type_arr   = explode(',',$str_id);
                    $type_arr2  = array();
                    foreach ($type_arr as $type)
                    {
                        $type_arr2[$type]= $type;
                    }
                    // echo $route."\n";
                    if (isset($type_arr2[$route_type])) {
                        $permission_route[$route]=$route;
                    }

                }
            }
            if (auth()->user()->role_id == 1) // ADMIN
            {
                $submenus = DB::table('main_menus','b')
                    ->select('b.menu_name','b.route_name','b.root_menu_id','b.id')
                    ->where(['b.status_active'=>1])
                    ->where('route_name','!=',null)
                    ->orderBy('b.sequence')
                    ->get();
                // return $submenus;
                $sub_menu_array=array();
                foreach ($submenus as $v)
                {
                    $sub_menu_array[$v->root_menu_id][$v->id]['name'] = $v->menu_name;
                    $sub_menu_array[$v->root_menu_id][$v->id]['route'] = $v->route_name;
                }
                // return $sub_menu_array;
                $menues= DB::table('main_menus')->select('menu_name', 'id')->where(['status_active'=>1,'root_menu_id'=>null])
                ->orderBy('sequence')
                ->get();
                $main_menu_array= array();
                foreach ($menues as $v)
                {
                    if(isset($sub_menu_array[$v->id]))
                    {
                        foreach ($sub_menu_array[$v->id] as $menu_id=>$r)
                        {
                            $main_menu_array[$v->menu_name][$menu_id]['name'] = $r['name'];
                            $main_menu_array[$v->menu_name][$menu_id]['route'] = $r['route'];
                        }
                    }
                }
                // return $main_menu_array;

                $routes = Route::select('route')->get();
                $permission_route = array();
                foreach ($routes as $v)
                {
                    $permission_route[$v->route]=$v->route;
                }
            }
        }
        $web_info = DB::table('genarel_infos')->select('field_name','value')->get();
        $dataArray = array();
        foreach ($web_info as $v)
        {
            $dataArray[$v?->field_name] = $v?->value;
        }
        store_social_media_info();
        // return $permission_route;
        Session::put('main_menu_array', $main_menu_array);
        Session::put('permission_route', $permission_route);
        Session::put('web_info', $web_info);
        Session::put('web_field_info', $dataArray);
    }
}
if (!function_exists('routeType')) {
    function routeType()
    {
        return $route_type_array = [1=>'Menu',2=>'Save',3=>'Update',4=>'Delete',5=>'Details',6=>'Published'];
    }
}
if (!function_exists('asteriskSeparate')) {
    function asteriskSeparate($inputText='',$tag='strong')
    {
        $position = strpos($inputText, '**');
        if ($position !== false) {
            $beforeAsterisk = substr($inputText, 0, $position);
            $afterAsterisk = substr($inputText, $position + 2);
            $formattedAfterAsterisk = str_replace('**', '**', $afterAsterisk, $count);
            $outputText = "<$tag>" . $beforeAsterisk . "</$tag>" . $formattedAfterAsterisk;
        } else {
            $outputText = $inputText;
        }
        return $outputText;
    }
}
if (!function_exists('store_social_media_info')) {
    function store_social_media_info()
    {
        $social_info = DB::table('social_photos')->select('thumbnail','original_photo','photo_gallery')
        ->where([
            'user_id'    =>  auth()->id(),
            'is_current' => 1,
        ])
        ->whereIn('photo_gallery',[1,2])
        ->get();

        $social_data_array = array();
        $social_data_array ['original_profile']     = 'default_profile.jpg';
        $social_data_array ['thumbnail_profile']    = 'avatar.jpg';
        $social_data_array ['original_cover']       = 'profile-cover.jpg';
        $social_data_array ['thumbnail_cover']      = 'profile-cover.jpg';

        foreach ($social_info as $v)
        {
            if ($v->photo_gallery==1) {
                $social_data_array ['original_profile'] = $v->original_photo;
                $social_data_array ['thumbnail_profile'] = $v->thumbnail;
            }
            if ($v->photo_gallery==2) {
                $social_data_array ['original_cover'] = $v->original_photo;
                $social_data_array ['thumbnail_cover'] = $v->thumbnail;
            }
        }
        Session::put('social_media_user_data', $social_data_array);
    }
}
if (!function_exists('createDropDownUiKit')) {

    function createDropDownUiKit($fieldId, $fieldWidth, $query, $fieldList, $showSelect = true, $selectTextMsg = "", $selectedIndex = [], $onChangeFunc = "", $isDisabled = false, $multiSelect = false, $arrayIndex = "", $fixedOptions = "", $fixedValues = "", $notShowArrayIndex = "", $tabIndex = "", $fieldName = "", $additionalClass = "", $additionalAttributes = "")
    {
        $isDisabledAttr = $isDisabled ? 'disabled' : '';
        $multiSelectAttr = $multiSelect ? 'multiple' : '';
        $tabIndexAttr = $tabIndex ? 'tabindex="' . $tabIndex . '"' : '';
        $fieldList = explode(",", $fieldList);
        $addAttr = explode(",", $additionalAttributes);
        $selectedIndex = is_array($selectedIndex) ? $selectedIndex : [$selectedIndex]; // Handle array for multiple selections

        // Begin dropdown select tag
        $style = $fieldWidth ? 'style="width:' . $fieldWidth . 'px"' : '';
        $dropDown = '<select ' . $tabIndexAttr . ' name="' . ($fieldName ?: $fieldId) . ($multiSelect ? '[]' : '') . '" id="' . $fieldId . '" class="uk-select ' . $additionalClass . '" ' . $isDisabledAttr . ' ' . $multiSelectAttr . ' onchange="' . $onChangeFunc . '"'. $style.'>';

        // "Select" option
        if ($showSelect && !$multiSelect) {
            $dropDown .= '<option value="0">' . $selectTextMsg . '</option>';
        }

        // Fixed options
        if ($fixedOptions) {
            $fixedOptionsArray = explode("*", $fixedOptions);
            $fixedValuesArray = explode("*", $fixedValues);

            foreach ($fixedOptionsArray as $index => $option) {
                $value = $fixedValuesArray[$index] ?? $option;
                $isSelected = in_array($value, $selectedIndex) ? 'selected' : '';
                $dropDown .= '<option value="' . $value . '" ' . $isSelected . '>' . $option . '</option>';
            }
        }

        // Database-driven options
        if (is_string($query)) {
            $results = DB::select($query);

            foreach ($results as $result) {
                $attData = [];
                foreach ($addAttr as $attr) {
                    if ($attr!='')
                    {
                        $attData[] = $result->{$fieldList[$attr] ?? ''};
                    }
                }

                $value = $result->{$fieldList[0]} ?? '';
                $label = $result->{$fieldList[1]} ?? '';
                $isSelected = in_array($value, $selectedIndex) ? 'selected' : '';

                $dropDown .= '<option value="' . $value . '" ' . $isSelected . ' data-attr="' . implode("**", $attData) . '">' . $label . '</option>';
            }
        } else {
            // Array-driven options
            $arrayIndex = $arrayIndex ? explode(",", $arrayIndex) : [];
            $notShowArrayIndex = $notShowArrayIndex ? explode(",", $notShowArrayIndex) : [];

            foreach ($query as $key => $value) {
                if ((!$arrayIndex || in_array($key, $arrayIndex)) && (!$notShowArrayIndex || !in_array($key, $notShowArrayIndex))) {
                    $isSelected = in_array($key, $selectedIndex) ? 'selected' : '';
                    $dropDown .= '<option value="' . $key . '" ' . $isSelected . '>' . $value . '</option>';
                }
            }
        }

        // Close select tag
        $dropDown .= '</select>';

        return $dropDown;
    }

}
if (!function_exists('createDropDownBootstrap'))
{
    function createDropDownBootstrap($fieldId, $fieldWidth, $query, $fieldList, $showSelect = true, $selectTextMsg = "", $selectedIndex = [], $onChangeFunc = "", $isDisabled = false, $multiSelect = false, $arrayIndex = "", $fixedOptions = "", $fixedValues = "", $notShowArrayIndex = "", $tabIndex = "", $fieldName = "", $additionalClass = "", $additionalAttributes = "")
    {
        $isDisabledAttr = $isDisabled ? 'disabled' : '';
        $multiSelectAttr = $multiSelect ? 'multiple' : '';
        $tabIndexAttr = $tabIndex ? 'tabindex="' . $tabIndex . '"' : '';
        $fieldList = explode(",", $fieldList);
        $addAttr = explode(",", $additionalAttributes);
        $selectedIndex = is_array($selectedIndex) ? $selectedIndex : [$selectedIndex]; // Handle array for multiple selections

        // Begin dropdown select tag
        $style = $fieldWidth ? 'style="width:' . $fieldWidth . 'px"' : '';
        $dropDown = '<select ' . $tabIndexAttr . ' name="' . ($fieldName ?: $fieldId) . ($multiSelect ? '[]' : '') . '" id="' . $fieldId . '" class="form-select ' . $additionalClass . '" ' . $isDisabledAttr . ' ' . $multiSelectAttr . ' onchange="' . $onChangeFunc . '" ' . $style . '>';

        // "Select" option
        if ($showSelect && !$multiSelect) {
            $dropDown .= '<option value="0">' . $selectTextMsg . '</option>';
        }

        // Fixed options
        if ($fixedOptions) {
            $fixedOptionsArray = explode("*", $fixedOptions);
            $fixedValuesArray = explode("*", $fixedValues);

            foreach ($fixedOptionsArray as $index => $option) {
                $value = $fixedValuesArray[$index] ?? $option;
                $isSelected = in_array($value, $selectedIndex) ? 'selected' : '';
                $dropDown .= '<option value="' . $value . '" ' . $isSelected . '>' . $option . '</option>';
            }
        }

        // Database-driven options
        if (is_string($query)) {
            $results = DB::select($query);

            foreach ($results as $result) {
                $attData = [];
                foreach ($addAttr as $attr) {
                    if ($attr != '') {
                        $attData[] = $result->{$fieldList[$attr] ?? ''};
                    }
                }

                $value = $result->{$fieldList[0]} ?? '';
                $label = $result->{$fieldList[1]} ?? '';
                $isSelected = in_array($value, $selectedIndex) ? 'selected' : '';

                $dropDown .= '<option value="' . $value . '" ' . $isSelected . ' data-attr="' . implode("**", $attData) . '">' . $label . '</option>';
            }
        } else {
            // Array-driven options
            $arrayIndex = $arrayIndex ? explode(",", $arrayIndex) : [];
            $notShowArrayIndex = $notShowArrayIndex ? explode(",", $notShowArrayIndex) : [];

            foreach ($query as $key => $value) {
                if ((!$arrayIndex || in_array($key, $arrayIndex)) && (!$notShowArrayIndex || !in_array($key, $notShowArrayIndex))) {
                    $isSelected = in_array($key, $selectedIndex) ? 'selected' : '';
                    $dropDown .= '<option value="' . $key . '" ' . $isSelected . '>' . $value . '</option>';
                }
            }
        }

        // Close select tag
        $dropDown .= '</select>';

        return $dropDown;
    }

}
if (!function_exists('return_library_array')) {

    function return_library_array($query, $id_fld_name, $data_fld_name)
    {
        $nameArray =  DB::select($query);
        $new_array = array();
        foreach ($nameArray as $v) {
            $new_array[$v?->$id_fld_name] = $v->$data_fld_name;
        }
        return $new_array;
    }
}
if (!function_exists('store_notification')) {

    function store_notification($message, $user_id)
    {
        try {
            DB::table('notifications')->insert([
                'message' => $message,
                'user_id' => $user_id,
                'created_by' => auth()->id(),
                'created_at' => Carbon::now(),
            ]);

            return 1;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
if (!function_exists('send_sms')) {

    function send_sms($phnNmbr,$msg) {
        $url = env('SMS_GETWAY_API_URL');
        $data = [
          "api_key" => env('SMS_GETWAY_API_KEY'),
          "type" => "text/unicode",
          "contacts" => "$phnNmbr",
          "senderid" => env('SMS_GETWAY_API_SENDER_ID'),
          "purpose" => "OTP",
          "msg" => "$msg",
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
?>
