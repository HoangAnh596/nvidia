@auth
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('logoutUser') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logoutUser') }}" method="get" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">HNA_CMS <sup>3</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('home.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>HomePage</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Pages Categories Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('categories.index') }}" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="true" aria-controls="collapseNews">
                <i class="fa-solid fa-layer-group"></i>
                <span>Danh mục sản phẩm</span>
            </a>
            <div id="collapseCategories" class="collapse" aria-labelledby="headingCategories" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('categories.index') }}">Danh sách danh mục</a>
                    <a class="collapse-item" href="{{ route('categories.create') }}">Thêm mới danh mục</a>
                    <a class="collapse-item" href="{{ route('filter.index') }}">Danh sách bộ lọc</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Products Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('product.index') }}" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="true" aria-controls="collapseProducts">
                <i class="fa-solid fa-paw"></i>
                <span>Sản phẩm</span>
            </a>
            <div id="collapseProducts" class="collapse" aria-labelledby="headingProducts" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('product.index') }}">Danh sách sản phẩm</a>
                    <a class="collapse-item" href="{{ route('product.create') }}">Thêm mới sản phẩm</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Category News Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('cateNews.index') }}" data-toggle="collapse" data-target="#collapseCateNews" aria-expanded="true" aria-controls="collapseCateNews">
                <i class="fa-solid fa-newspaper"></i>
                <span>Danh mục tin tức</span>
            </a>
            <div id="collapseCateNews" class="collapse" aria-labelledby="headingCateNews" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('cateNews.index') }}">Danh sách</a>
                    <a class="collapse-item" href="{{ route('cateNews.create') }}">Thêm mới</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages News Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('news.index') }}" data-toggle="collapse" data-target="#collapseNews" aria-expanded="true" aria-controls="collapseNews">
                <i class="fa-solid fa-newspaper"></i>
                <span>Tin tức</span>
            </a>
            <div id="collapseNews" class="collapse" aria-labelledby="headingNews" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('news.index') }}">Danh sách</a>
                    <a class="collapse-item" href="{{ route('news.create') }}">Thêm mới</a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Pages Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseMenus" aria-expanded="true" aria-controls="collapseMenus">
                <i class="fa-solid fa-bars"></i>
                <span>Quản lý Menu, Footer</span>
            </a>
            <div id="collapseMenus" class="collapse" aria-labelledby="headingMenus" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('cateMenu.index') }}">Danh sách Menu</a>
                    <a class="collapse-item" href="{{ route('cateMenu.create') }}">Thêm mới Menu</a>
                    <a class="collapse-item" href="{{ route('cateFooter.index') }}">Danh sách Footer</a>
                    <a class="collapse-item" href="{{ route('cateFooter.create') }}">Thêm mới Footer</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Infors -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseInfors" aria-expanded="true" aria-controls="collapseInfors">
                <i class="fa-solid fa-phone-volume"></i>
                <span>Quản lý</span>
            </a>
            <div id="collapseInfors" class="collapse" aria-labelledby="headingInfors" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('infors.index') }}">Danh sách hotline</a>
                    <a class="collapse-item" href="{{ route('infors.create') }}">Thêm mới hotline</a>
                    <a class="collapse-item" href="{{ route('favicon.edit', ['favicon' => 1]) }}">Cập nhật favicon</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Users Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('users.index') }}" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
                <i class="fa-solid fa-users"></i>
                <span>Tài khoản</span>
            </a>
            <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('users.index') }}">Danh sách</a>
                    <a class="collapse-item" href="{{ route('users.create') }}">Thêm mới</a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Pages Infors -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseBottoms" aria-expanded="true" aria-controls="collapseBottoms">
                <i class="fa-solid fa-phone-volume"></i>
                <span>Quản lý footer</span>
            </a>
            <div id="collapseBottoms" class="collapse" aria-labelledby="headingInfors" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('bottoms.index') }}">Danh sách hotline</a>
                    <a class="collapse-item" href="{{ route('bottoms.create') }}">Thêm mới hotline</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter"></span>
                        </a>
                    </li>
                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span class="badge badge-danger badge-counter"></span>
                        </a>

                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle" src="{{ \App\Http\Helpers\Helper::getPath(Auth::user()->image) }}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            @endauth