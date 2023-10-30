<?php

namespace App\Http\Livewire\Admin;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ManageBackups extends Component
{
    public function create()
    {
        try {
            /* Perform some operation */
            set_time_limit(0);
            Artisan::call('backup:run');
            /* Operation finished */
            sleep(1);
            session()->flash('success', config('messages.BACKUP_CREATION_SUCCESS'));
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.BACKUP_CREATION_FAILED'));
        }
    }

    public function delete(int $index)
    {
        try {
            /* Perform some operation */
            $files = $this->getBackupFiles();
            Storage::disk('local')->delete($files[$index]);
            /* Operation finished */
            sleep(1);
            session()->flash('success', config('messages.BACKUP_DELETION_SUCCESS'));
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.BACKUP_DELETION_FAILED'));
        }
    }

    public function getFilesBaseName(array $files)
    {
        return array_map('basename', $files);
    }

    public function getBackupFiles()
    {
        return Storage::disk('local')->files('fitcare-dashboard-backups');
    }

    public function render()
    {
        $data = $this->getFilesBaseName($this->getBackupFiles());
        return view('livewire.admin.manage-backups', ['data' => $data]);
    }
}
