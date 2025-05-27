<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PermissionManager extends Component
{
    public $departamento;
    public $allPermissions;
    public $currentPermissions;

    public function __construct($departamento, $allPermissions, $currentPermissions)
    {
        $this->departamento = $departamento;
        $this->allPermissions = $allPermissions;
        $this->currentPermissions = $currentPermissions;
    }

    public function render()
    {
        return view('components.permission-manager');
    }
}
