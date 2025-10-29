<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\MainMenu;
use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{

    public $roleArray = array(1=>'Admin',2=>'Team Member',3=>'User');
    public function index()
    {
        // return storeMenuIntoSession();
        // return  session('permission_route');
        $main_menu_array=$menu_name_array=array();
        $menues = MainMenu::select('id','route_name','root_menu_id','menu_name')->orderBy('route_name','asc')->get();
        $users  = User::select('id','name','role_id','verification_code')->get();
        foreach ($menues as $v)
        {
            $root_menu_id = $v->root_menu_id ?? $v->id;
            $id = $v->id;
            $main_menu_array[$root_menu_id][$id]['route_name'] =  $v->route_name;
            $menu_name_array[$id]= $v->menu_name;
        }

        // return $main_menu_array; die;
        return view('dashboard.admin.tools.permission.index',[
            'menues' =>$main_menu_array,
            'menu_name_array' =>$menu_name_array,
            'users' =>$users,
            'roles' =>$this->roleArray
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'user'=>'required',
            'menu'=>'required',
            'permission'=>'nullable'
        ]);
        $permission = $request->permission;

        $permission_string = "";
        if ($permission)
        {
            $permission_string = implode(',',$permission);
        }

        $permission = Permission::where([ 'user_id'=>$request->user, 'menu_id'=>$request->menu])->first();
        if ($permission?->id)
        {
            $permission->permission_string  = $permission_string;
            $permission->updated_by         = auth()->id();
            $permission->save();
            return back()->with('success','Updated successfully');
        }
        else{
            Permission::insert([
                'user_id'=>$request->user,
                'menu_id'=>$request->menu,
                'permission_string'=>$permission_string,
                'created_by'=>auth()->id(),
                'created_at'=> Carbon::now()
            ]);
            return back()->with('success','Added successfully');
        }


    }
    public function get_options(Request $request)
    {
        $user_id = $request->user_id;
        $menu_id = $request->menu_id;

        $permission = Permission::select('permission_string')->where([ 'user_id'=>$user_id, 'menu_id'=>$menu_id])->first();
        $permissionArr = explode(',',$permission?->permission_string);
        $html = '<option value="">-- Select Permissions --</option>';
        foreach (routeType() as $id=> $type)
        {
            $select_status  = in_array($id,$permissionArr) ? 'selected' : '';
            $html .= "<option $select_status value=\"$id\">$type</option>";
        }

        return $html;
    }

    public function edit($enId){
        $id = decrypt($enId);
        $menu   =  MainMenu::find($id);
        return view('dashboard.admin.tools.permission.edit',[
            'menu' => $menu
        ]);
    }

    public function update(Request $request,$id){
       $menu                =  MainMenu::find($id);
       $menu->menu_name     = $request->menu_name;
       $menu->updated_by    = auth()->id();
       $menu->save();
       return redirect()->route('permission.index')->with('success','update successfully');
    }


    public function get_role(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::select('role_id')->where('id',$user_id)->first();

        $html = '<option value="">--Select Role--</option>';
        foreach ($this->roleArray as $id => $role)
        {
            $select_status  = ( $user->role_id == $id ) ? 'selected' : '';
            $html .= "<option $select_status value=\"$id\">$role</option>";
        }

        return $html;
    }
    public function update_role(Request $request){

       $user                =  User::find($request->user_id);
       $user->role_id       =  $request->role;
    //    $user->updated_by    =  auth()->id();
       $user->save();
       return redirect()->route('permission.index')->with('success','update successfully');
    }


}
