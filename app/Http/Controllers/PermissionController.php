<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class PermissionController extends BaseController
{
    public function permisos(string $resourceName){
        $this->middleware("permission:view {$resourceName}")->only(['index', 'show']);
        $this->middleware("permission:create {$resourceName}")->only(['store']);
        $this->middleware("permission:edit {$resourceName}")->only(['update']);
        $this->middleware("permission:delete {$resourceName}")->only(['destroy']);
    }

}
