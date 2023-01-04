<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionsRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{

    private $routeResourceName = 'permissions';

    public function __construct()
    {
        $this->middleware('can:view permissions list')->only('index');
        $this->middleware('can:create permission')->only(['create', 'store']);
        $this->middleware('can:edit permission')->only(['edit', 'update']);
        $this->middleware('can:delete permission')->only('destroy');
    }

    public function index(Request $request)
    {
        $roles = Permission::query()
            ->select(['id', 'name', 'created_at'])
            ->when($request->name, fn(Builder $builder, $name) => $builder->where('name', 'like', "%{$name}%"))
            ->latest('id')
            ->paginate(10);

        return Inertia::render('Admin/Permissions/Index', [
            'title' => 'Permissions',
            'items' => PermissionResource::collection($roles),
            'headers' => [
                [
                    'label' => 'Name',
                    'name' => 'name'
                ],
                [
                    'label' => 'Created At',
                    'name' => 'created_at'
                ],
                [
                    'label' => 'Actions',
                    'name' => 'actions'
                ]
            ],
            'filters' => (object) $request->all(),
            'routeResourceName' => $this->routeResourceName,
            'can' => [
                'create' => $request->user()?->can('create permission'),
            ]
        ]);
    }

    public function create() 
    {
        return Inertia::render('Admin/Permissions/Create', [
            'edit' => false,
            'title' => 'Add Permission',
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    public function store(PermissionsRequest $request) 
    {
        Permission::create($request->validated());
        return redirect()->route("admin.{$this->routeResourceName}.index")->with('success', 'Permission create successfully.');
    }

    
    public function edit(Permission $permission) 
    {
        return Inertia::render('Admin/Permissions/Create', [
            'edit' => true,
            'item' => new PermissionResource($permission),
            'title' => 'Edit Permission',
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    public function update(PermissionsRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return redirect()->route("admin.{$this->routeResourceName}.index")->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permission deleted successfully.');
    }
}
