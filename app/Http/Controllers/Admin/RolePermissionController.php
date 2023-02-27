<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\RolePermissionRequest;
use App\Services\RolePermissionService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends BaseController
{
    protected $RolePermissionService;
    protected $status = false;
    protected $message;

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
        return view('roles.index', compact('role_with_permission'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->setPageTitle('Create Role', '');
        $permissions = $this->RolePermissionService->getAllPermissions();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RolePermissionRequest $request)
    {
        DB::beginTransaction();
        try {
            $store = $this->RolePermissionService->storeRoleWithPermssion($request);

            if (isset($store) && !empty($store)) {
                DB::commit();
                return redirect()->route('roles.index')->with('message', config('custom.MSG_RECORD_INSERT_SUCCESS'));
            } else {
                return $this->responseRedirectBack('We are facing some Technical issue at this moment', 'message', true, true);
            }
        } catch (Exception $e) {
            DB::rollBack();
            logger($e->getCode() . '->' . $e->getLine() . '->' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit_id = Crypt::decrypt($id);
        $permissions = $this->RolePermissionService->getAllPermissions();
        $edit_role = $this->RolePermissionService->editRoleWithPermssion($edit_id);
        return view('roles.create', compact('permissions', 'edit_role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|max:100|unique:roles,name,' . $id
            ], [
                'name.requried' => 'Please give a role name'
            ]);
            $update = $this->RolePermissionService->updateRoleWithPermssion($request, $id);
            if (isset($update) && !empty($update)) {
                DB::commit();
                return redirect()->route('roles.index')->with('message', config('custom.MSG_RECORD_UPDATE_SUCCESS'));
            } else {
                return $this->responseRedirectBack('We are facing some Technical issue at this moment', 'error', true, true);
            }
        } catch (Exception $e) {
            DB::rollBack();
            logger($e->getCode() . '->' . $e->getLine() . '->' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->message = config('custom.MSG_ERROR_TRY_AGAIN');
        try {
            $delete = $this->RolePermissionService->deleteRoleWithPermssion($id);
            if (isset($delete) && !empty($delete)) {
                $this->status = true;
                $this->message = config('custom.MSG_RECORD_DELETE_SUCCESS');
            } else {
                $this->status = false;
                $this->message = config('custom.MSG_RECORD_DELETE_FAILED');
            }
        } catch (Exception $e) {
            logger($e->getCode() . '->' . $e->getLine() . '->' . $e->getMessage());
        }
        return $this->responseJson($this->status, 200, $this->message);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function assignRole()
    {
        $this->setPageTitle('User Role', '');

        $roles = $this->RolePermissionService->getAdminRole();
        return $roles;
        return view('admin.roles.role_with_user', compact('roles'));
    }
}
