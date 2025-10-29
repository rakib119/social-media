<ul class="metismenu list-unstyled" id="side-menu">
    <li class="menu-title">Menu</li>
    {{-- @if (auth()->user()->is_admin) --}}
    @php
        $main_menu_array = session('main_menu_array');
    @endphp
        <li>
            <a href="{{route('dashboard')}}" class="waves-effect">
                <i class="dripicons-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @foreach ($main_menu_array as $menu_name => $sub_menu_data)
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="fas fa-project-diagram"></i>
                    <span>{{$menu_name}}</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    @foreach ($sub_menu_data as $v)
                        @php
                            $route = $v['route'];
                        @endphp
                        <li><a href="{{route($route)}}"> {{$v['name']}} </a></li>
                    @endforeach
                </ul>
            <li>
        @endforeach

        @if(auth()->user()->role_id ==1)
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="fas fa-project-diagram"></i>
                    <span>Admin</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{route('permission.index')}}">Menu & Permissions</a></li>
                </ul>
            </li>
        @endIf

</ul>
