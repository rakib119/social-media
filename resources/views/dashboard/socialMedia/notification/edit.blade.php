@extends('dashboard.layout.dashboard')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="page-title-box">
            <div class="container-fluid">
             <div class="row align-items-center">
                 <div class="col-sm-6">
                     <div class="page-title">
                         <h4>DashBoard</h4>
                         <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">DashBoard</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home Management</a></li>
                            <li class="breadcrumb-item active">Service Edit</li>
                        </ol>
                     </div>
                 </div>
             </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h2 class=" mb-4">Update Service</h2>
                                    </div>
                                    <div>
                                        <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
                                    </div>
                                </div>
                                <div class="form py-3">
                                    @if (session('error'))
                                        <h4 class="text-danger">Error: {{ session('error') }} ** </h4>
                                    @endif
                                    <form action="{{ route('homeS4.update',$service->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="section_id" value="6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="title"> Title <span class="text-danger">*</span></label>
                                                    <input id="title" type="text" class="form-control" value="{{ $service->title  }}" name="title" placeholder="Enter title" autofocus>
                                                    @error('title')
                                                        <h6 class="text-danger"> {{ $message }}</h6>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="thumbnail"> Thumbnail <span class="text-danger">*(w=220px, h:220px)</span> </label>
                                                    <input id="thumbnail" type="file"  class="form-control" name="thumbnail" onchange="loadFile(event,'imgOutput')">
                                                    <input id="thumbnail_hidden" type="hidden"  class="form-control" name="thumbnail_hidden">
                                                    @error('thumbnail')
                                                        <h6 class="text-danger"> {{ $message }}</h6>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                        <img id="imgOutput" src="{{asset('assets/images/services/'.$service->thumbnail)}}" height="80">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="button_name">Button Name <span class="text-danger">*</span></label>
                                                    <input id="button_name" type="text" class="form-control" value="{{ $service->button_name  }}" name="button_name" placeholder="Enter button name" >
                                                    @error('button_name')
                                                        <h6 class="text-danger"> {{ $message }}</h6>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="icon">Icon <span class="text-danger">*(w=30px, h:30px)</span></label>
                                                    <input id="icon" type="file" class="form-control" value="{{ old('icon') }}" name="icon" onchange="loadFile(event,'imgOutput2')" accept="png">
                                                    @error('icon')
                                                        <h6 class="text-danger"> {{ $message }}</h6>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                        <img id="imgOutput2" height="80" src="{{asset('assets/images/services/icon/'.$service->icon)}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="short_description">Short Description <span class="text-danger">*&nbsp;&nbsp;NB: max 350 characters</span></label>

                                                    <textarea  id="short_description" type="text" class="form-control" name="short_description" placeholder="Enter short_description" cols="30" rows="2">{{ $service->short_description  }}</textarea>
                                                    @error('short_description')
                                                        <h6 class="text-danger"> {{ $message }}</h6>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="is_displayed_in_home">Is displayed in home page?</label>
                                                    <input type="checkbox" name="is_displayed_in_home" id="is_displayed_in_home" {{$service->is_displayed_in_home==1 ? 'checked' : '1' }}>
                                                    @error('is_displayed_in_home')
                                                        <h6 class="text-danger"> {{ $message }}</h6>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mt-3">
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-success">Update </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
