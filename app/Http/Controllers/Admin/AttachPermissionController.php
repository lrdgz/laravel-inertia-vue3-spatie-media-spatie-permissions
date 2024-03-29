<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class AttachPermissionController extends Controller
{
    public function __invoke(Request $request)
    {
        $permission = Permission::findById($request->permissionId);
        $permission->assignRole($request->roleId);
        return redirect()->back()->with('success', 'Permission attached successfully.');
    }
}
