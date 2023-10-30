<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="py-3 mb-4">Dashboard</h1>
    <!-- Basic Bootstrap Table -->
    <div class="row gap-5">
        <div id="cms-block-b" class="cms-block cms-block-element col-md-3">
            <div class="small-box small-box-custom-styles">
                <div class="inner">
                    <h3>{{ $total_employees }}</h3>
                    <p>Total Employees</p>
                </div>
                <div class="icon">
                    <i class="bx bx-lg bx bxs-user-badge text-success"></i>
                </div>
            </div>
        </div>
        <div id="cms-block-b" class="cms-block cms-block-element col-md-3">
            <div class="small-box small-box-custom-styles">
                <div class="inner">
                    <h3>{{ $total_backups }}</h3>
                    <p>Total Backups</p>
                </div>
                <div class="icon">
                    <i class="bx bx-lg bx bx-hdd text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <div class="row gap-5">
        <div id="cms-block-b" class="cms-block cms-block-element col-md-3">
            <div class="small-box small-box-custom-styles">
                <div class="inner">
                    <h3>{{ $total_categories }}</h3>
                    <p>Total Categories (Apps)</p>
                </div>
                <div class="icon">
                    <i class="bx bx-lg bx bx-category-alt text-success"></i>
                </div>
            </div>
        </div>
        <div id="cms-block-b" class="cms-block cms-block-element col-md-3">
            <div class="small-box small-box-custom-styles">
                <div class="inner">
                    <h3>{{ $total_levels }}</h3>
                    <p>Total Levels</p>
                </div>
                <div class="icon">
                    <i class="bx bx-lg bx bx-coin-stack text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <div class="row gap-5">
        <div id="cms-block-b" class="cms-block cms-block-element col-md-3">
            <div class="small-box small-box-custom-styles">
                <div class="inner">
                    <h3>{{ $total_programs }}</h3>
                    <p>Total Programs</p>
                </div>
                <div class="icon">
                    <i class="bx bx-lg bx bx-slideshow text-success"></i>
                </div>
            </div>
        </div>
        <div id="cms-block-b" class="cms-block cms-block-element col-md-3">
            <div class="small-box small-box-custom-styles">
                <div class="inner">
                    <h3>{{ $total_exercises }}</h3>
                    <p>Total Exercises</p>
                </div>
                <div class="icon">
                    <i class="bx bx-lg bx bx-dumbbell text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>