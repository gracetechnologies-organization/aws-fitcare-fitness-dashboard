 <!-- Layout wrapper -->
 <div class="layout-wrapper layout-content-navbar">
     <div class="layout-container">
         <!-- Menu -->
         <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
             <div class="app-brand demo">
                 <a href="{{ route('emp.index') }}" class="app-brand-link">
                     <span class="app-brand-logo demo">
                         <img src="{{ asset(config('constants.LOGO_LOCATION')) }}" alt="logo" class="img-thumbnail" width="90px">
                     </span>
                 </a>

                 <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                     <i class="bx bx-chevron-left bx-sm align-middle"></i>
                 </a>
             </div>

             <div class="menu-inner-shadow"></div>

             <ul class="menu-inner py-1">
                 <!-- Dashboard -->
                 <li class="menu-item @if (Route::current()->uri == 'emp/dashboard') active @endif">
                     <a href="{{ route('emp.index') }}" class="menu-link">
                         <i class="menu-icon fa-solid fa-house-chimney fa-bounce"></i>
                         <div>Dashboard</div>
                     </a>
                 </li>

                 {{-- <li class="menu-item @if (Route::current()->uri == 'emp/categories') active @endif">
                     <a href="{{ route('emp.categories') }}" class="menu-link">
                         <i class="menu-icon fa-solid fa-shapes fa-bounce"></i>
                         <div>Manage Categories (Apps)</div>
                     </a>
                 </li> --}}

                 <li class="menu-item @if (Route::current()->uri == 'emp/levels') active @endif">
                     <a href="{{ route('emp.levels') }}" class="menu-link">
                         <i class="menu-icon fa-solid fa-layer-group fa-bounce"></i>
                         <div>Manage Levels</div>
                     </a>
                 </li>

                 <li class="menu-item @if (Route::current()->uri == 'emp/programs') active @endif">
                     <a href="{{ route('emp.programs') }}" class="menu-link">
                         <i class="menu-icon fa-solid fa-sitemap fa-bounce"></i>
                         <div>Manage Programs</div>
                     </a>
                 </li>

                <li class="menu-item @if (Route::current()->uri == 'emp/weeks') active @endif">
                    <a href="{{ route('emp.weeks') }}" class="menu-link">
                        <i class="menu-icon fa-brands fa-weebly fa-bounce"></i>
                        <div>Manage Weeks</div>
                    </a>
                </li>

                 <li class="menu-item">
                     <a href="#" class="menu-link">
                         <i class="menu-icon fa-solid fa-book fa-bounce"></i>
                         <div>Manage Workouts</div>
                         <i class="ms-auto fa-solid fa-angle-down"></i>
                     </a>
                     <ul class="menu-inner menu-sub-items" style="display:none;">
                         <li class="menu-item ms-4 @if (Route::current()->uri == 'emp/focused-areas') active @endif">
                             <a href="{{ route('emp.focused_areas') }}" class="menu-link">
                                 <i class="menu-icon fa-solid fa-person-rays fa-beat-fade"></i>
                                 <div>Focused Areas</div>
                             </a>
                         </li>
                         <li class="menu-item ms-4 @if (Route::current()->uri == 'emp/workouts') active @endif">
                             <a href="{{ route('emp.workouts') }}" class="menu-link">
                                 <i class="menu-icon fa-solid fa-book fa-beat-fade"></i>
                                 <div>Workouts</div>
                             </a>
                         </li>
                     </ul>
                 </li>

                 <li class="menu-item">
                     <a href="#" class="menu-link">
                         <i class="menu-icon fa-solid fa-dumbbell fa-bounce"></i>
                         <div>Manage Exercises</div>
                         <i class="ms-auto fa-solid fa-angle-down"></i>
                     </a>
                     <ul class="menu-inner menu-sub-items" style="display:none;">
                         <li class="menu-item ms-4 @if (Route::current()->uri == 'emp/exercises/active') active @endif">
                             <a href="{{ route('emp.exercises.active') }}" class="menu-link">
                                <i class="menu-icon fa-regular fa-sun fa-beat-fade"></i>
                                 <div>Active</div>
                             </a>
                         </li>
                         <li class="menu-item ms-4 @if (Route::current()->uri == 'emp/exercises/archived') active @endif">
                             <a href="{{ route('emp.exercises.archived') }}" class="menu-link">
                                <i class="menu-icon fa-solid fa-box-archive fa-beat-fade"></i>
                                 <div>Archived</div>
                             </a>
                         </li>
                     </ul>
                 </li>
             </ul>
         </aside>
         <!-- / Menu -->

         <!-- Layout container -->
         <div class="layout-page">
             <!-- Navbar -->
             <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
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
                             <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                 <div class="avatar avatar-online">
                                     <i class="bx bx-lg bx-user text-success" style="background: aliceblue; border-radius: 50%;"></i>
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
                                                 <small class="text-muted">Employee</small>
                                             </div>
                                         </div>
                                     </a>
                                 </li>
                                 <li>
                                     <div class="dropdown-divider"></div>
                                 </li>
                                 <li>
                                     <a class="dropdown-item" href="{{ route('emp.profile') }}">
                                         <i class="bx bx-user me-2"></i>
                                         <span class="align-middle">My Profile</span>
                                     </a>
                                 </li>
                                 <li>
                                     <div class="dropdown-divider"></div>
                                 </li>
                                 <li>
                                     <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout').submit();">
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
                 @if (session()->has('error'))
                     <div class="bs-toast toast toast-placement-ex m-2 fade bg-danger top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
                         <div class="toast-header">
                             <i class="bx bx-bell me-2"></i>
                             <div class="me-auto fw-semibold">Error</div>
                             <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                         </div>
                         <div class="toast-body">
                             {{ session()->get('error') }}
                         </div>
                     </div>
                 @endif
                 @if (session()->has('success'))
                     <div class="bs-toast toast toast-placement-ex m-2 fade bg-success top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
                         <div class="toast-header">
                             <i class="bx bx-bell me-2"></i>
                             <div class="me-auto fw-semibold">Success</div>
                             <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                         </div>
                         <div class="toast-body">
                             {{ session()->get('success') }}
                         </div>
                     </div>
                 @endif
