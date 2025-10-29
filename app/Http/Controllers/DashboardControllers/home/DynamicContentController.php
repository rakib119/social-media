<?php

namespace App\Http\Controllers\DashboardControllers\home;
use App\Http\Controllers\Controller;
use App\Models\DynamicContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class DynamicContentController extends Controller
{
    public function __construct()
    {
    }
    public $page_list = array(1=>'Privecy',2=>'Terms And Conditions',3=>'Return Privecy',4=>'Notice');
    public function index()
    {
        return  view('dashboard.pages.home.dynamicContent.index',[
            'contents'=> DynamicContent::all(),
            'page_array'=> $this->page_list
        ]);
    }


    public function create()
    {
        return view('dashboard.pages.home.dynamicContent.create',['page_array'=> $this->page_list]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'content_id'=>'required',
            'content'=>'required'
        ]);
        DynamicContent::insert([
            'content_id'=>$request->content_id,
            'content'=>$request->content,
            'created_by'=>auth()->id(),
            'created_at'=> Carbon::now()
        ]);
        return redirect('content')->with('success','Content added successfully');
    }


    public function edit($id)
    {
        $DynamicContent = DynamicContent::find($id);
        $page_array = $this->page_list;
        return view('dashboard.pages.home.dynamicContent.edit',compact('DynamicContent','page_array'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'content_id'=>'required',
            'content'=>'required'
        ]);

        $DynamicContent = DynamicContent::find($id);
        $DynamicContent->content_id = $request->content_id;
        $DynamicContent->content = $request->content;
        $DynamicContent->updated_by = auth()->id();
        $DynamicContent->save();

        return redirect('content')->with('success','Updated successfully');
    }

}
