<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolePermissionRequest;
use App\Services\RolePermissionService;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    protected $RolePermissionService;

    public function __construct(RolePermissionService $RolePermissionService)
    {
        $this->RolePermissionService = $RolePermissionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('Roles', '');
        $role_with_permission = $this->RolePermissionService->getRoleWithPermssion();
        return view('', compact('role_with_permission'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->setPageTitle('Create Role', '');
        $permissions = $this->RolePermissionService->getAllPermissions();
        return view('', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RolePermissionRequest $request)
    {
        $store = $this->RolePermissionService->storeRoleWithPermssion($request);
        if (isset($store) && !empty($store)) {
            return $this->responseRedirectWithQueryString('user.list', ['name' => $request->name], $request->name . 'Added/Updated Successfully', 'success', false);
        } else {
            return $this->responseRedirectBack('We are facing some Technical issue at this moment', 'error', true, true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $all_permissions = $this->RolePermissionService->getAllPermissions();
        $edit_role = $this->RolePermissionService->editRoleWithPermssion($id);
        return view('', compact('all_permissions', 'edit_role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ], [
            'name.requried' => 'Please give a role name'
        ]);
        return $this->RolePermissionService->updateRoleWithPermssion($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->RolePermissionService->deleteRoleWithPermssion($id);
    }
}
