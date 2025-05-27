<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class PermissionCheck extends Component
{
    public $permission;

    public function __construct($permission)
    {
        $this->permission = $permission;
    }

    public function render()
    {
        $user = Auth::user();
        if ($user && $user->hasPermission($this->permission)) {
            return view('components.permission-check');
        }

        return '';
    }
}
