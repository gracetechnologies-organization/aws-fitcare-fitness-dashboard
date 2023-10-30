<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Exercise;
use App\Models\Level;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $total_employees = User::totalEmployees();
        $total_backups = count(Storage::drive('local')->files('fitcare-dashboard-backups'));
        $total_categories = Category::count();
        $total_levels = Level::count();
        $total_programs = Program::count();
        $total_exercises = Exercise::count();
        return view('livewire.admin.dashboard', [
            'total_employees' => $total_employees,
            'total_backups' => $total_backups,
            'total_categories' => $total_categories,
            'total_levels' => $total_levels,
            'total_programs' => $total_programs,
            'total_exercises' => $total_exercises
        ]);
    }
}
