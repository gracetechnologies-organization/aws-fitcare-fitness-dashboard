 <!-- Layout wrapper -->
 <div class="layout-wrapper layout-content-navbar">
     <div class="layout-container">
         <!-- Menu -->
         <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
             <div class="app-brand demo">
                 <a href="{{ route('admin.index') }}" class="app-brand-link">
                     <span class="app-brand-logo demo">
                         <img src="{{ asset(config('constants.LOGO_LOCATION')) }}" alt="logo" class="img-thumbnail"
                             width="90px">
                     </span>
                 </a>
                 <a href="javascript:void(0);"
                     class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                     <i class="bx bx-chevron-left bx-sm align-middle"></i>
                 </a>
             </div>

             <div class="menu-inner-shadow"></div>

             <ul class="menu-inner py-1">
                 <!-- Dashboard -->
                 <li class="menu-item @if (Route::current()->uri == 'admin/dashboard') active @endif">
                     <a href="{{ route('admin.index') }}" class="menu-link">
                         <i class="menu-icon tf-icons bx bx-home-circle"></i>
                         <div data-i18n="Analytics">Dashboard</div>
                     </a>
                 </li>

                 <li class="menu-item @if (Route::current()->uri == 'admin/employees') active @endif">
                     <a href="{{ route('admin.employees') }}" class="menu-link">
                         <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                         <div data-i18n="Analytics">Employees</div>
                     </a>
                 </li>

                 <li class="menu-item @if (Route::current()->uri == 'admin/tokens') active @endif">
                     <a href="{{ route('admin.tokens') }}" class="menu-link">
                         <i class="menu-icon tf-icons bx bx-key"></i>
                         <div data-i18n="Analytics">App Tokens</div>
                     </a>
                 </li>

                 <li class="menu-item @if (Route::current()->uri == 'admin/backups') active @endif">
                     <a href="{{ route('admin.backups') }}" class="menu-link">
                         <i class="menu-icon tf-icons bx bx-hdd"></i>
                         <div data-i18n="Analytics">Backups</div>
                     </a>
                 </li>
             </ul>
         </aside>
         <!-- / Menu -->

         <!-- Layout container -->
         <div class="layout-page">
             <!-- Navbar -->
             <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                 id="layout-navbar">
                 <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                     <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                         <i class="bx bx-menu bx-sm"></i>
                     </a>
                 </div>

                 <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                     <h1 class="fw-bold mt-3 col-11 text-center h-custom">
                         GRACE <span class="text-black-custom">TECHNOLOGIES</span>
                     </h1>
                     <ul class="navbar-nav flex-row align-items-center ms-auto">
                         <!-- User -->
                         <li class="nav-item navbar-dropdown dropdown-user dropdown">
                             <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                 data-bs-toggle="dropdown">
                                 <div class="avatar avatar-online">
                                     <i class="bx bx-lg bx-user text-success"
                                         style="background: aliceblue; border-radius: 50%;"></i>
                                 </div>
                             </a>
                             <ul class="dropdown-menu dropdown-menu-end">
                                 <li>
                                     <a class="dropdown-item" href="javascript:void(0)">
                                         <div class="d-flex">
                                             <div class="flex-shrink-0 me-3">

                                             </div>
                                             <div class="flex-grow-1">
                                                 <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                                 <small class="text-muted">Admin</small>
                                             </div>
                                         </div>
                                     </a>
                                 </li>
                                 <li>
                                     <div class="dropdown-divider"></div>
                                 </li>
                                 <li>
                                     <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                         <i class="bx bx-user me-2"></i>
                                         <span class="align-middle">My Profile</span>
                                     </a>
                                 </li>
                                 <li>
                                     <div class="dropdown-divider"></div>
                                 </li>
                                 <li>
                                     <a class="dropdown-item" href="javascript:void(0)"
                                         onclick="event.preventDefault();document.getElementById('logout').submit();">
                                         <form method="POST" id="logout" action="{{ route('logout') }}">
                                             @csrf
                                             <i class="bx bx-power-off me-2"></i>
                                             <span class="align-middle">
                                                 {{ __('Log Out') }}
                                             </span>
                                         </form>
                                     </a>
                                 </li>
                             </ul>
                         </li>
                         <!--/ User -->
                     </ul>
                 </div>
             </nav>
             <div class="content-wrapper">
