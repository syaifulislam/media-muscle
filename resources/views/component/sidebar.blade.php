<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href={{ url("/dashboard") }} class="brand-link">
        <img src={{ asset("img/AdminLTELogo.png") }} alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Media Muscle</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src={{ asset("img/user_default.png") }} class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview {{ Route::currentRouteName() === "member" ?  "menu-open" : ""}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Member<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href={{ url("/member/personal") }} class="nav-link" style="padding-left:30px">
                            <i class="fas fa-user-friends nav-icon"></i>
                            <p>Personal</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href={{ url("/member/company") }} class="nav-link" style="padding-left:30px">
                            <i class="fas fa-building nav-icon"></i>
                            <p>Company</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ Route::currentRouteName() === "configuration" ?  "menu-open" : ""}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Configuration<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href={{ url("/configuration/city") }} class="nav-link" style="padding-left:30px">
                            <i class="fas fa-city nav-icon"></i>
                            <p>City</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ Route::currentRouteName() === "services" ?  "menu-open" : ""}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-ethernet"></i>
                        <p>Services<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href={{url('/services/television')}} class="nav-link" style="padding-left:30px">
                            <i class="fas fa-tv nav-icon"></i>
                            <p>Television</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" style="padding-left:30px">
                            <i class="fas fa-broadcast-tower nav-icon"></i>
                            <p>Radio</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" style="padding-left:30px">
                            <i class="fas fa-newspaper nav-icon"></i>
                            <p>Newspaper</p>
                            <i class="fas fa-angle-left right"></i>
                            </a>
                            <ul class="nav nav-treeview" style="padding-left:30px">
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                    <i class="fas fa-ad nav-icon"></i>
                                    <p>Brand</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" style="padding-left:30px">
                            <i class="fas fa-flag nav-icon"></i>
                            <p>Out of Home</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::currentRouteName() === "user" ?  "menu-open" : ""}}">
                    <a href={{ url("/user") }} class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href={{ url("auth/logout") }} class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>