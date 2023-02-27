<?php

namespace App\Services;

use App\Contracts\RolePermissionContract;

/**
 * Class RolePermissionService
 * @package App\Services
 */
class RolePermissionService
{
    /**
     * Class RolePermissionService
     * @var RolePermissionContract
     */
    protected $RolePermissionRepository;

    public function __construct(RolePermissionContract $RolePermissionRepository)
    {
        $this->RolePermissionRepository = $RolePermissionRepository;
    }

    /**
     * Return all model rows
     * @return array
     */
    public function getAllPermissions()
    {
        return $this->RolePermissionRepository->getAllPermissions();
    }

    /**
     * Find all roles along with their permission
     *
     * @return array
     */
    public function getRoleWithPermssion()
    {
        return $this->RolePermissionRepository->getRoleWithPermssion();
    }

    /**
     * To Create a record
     *
     * @param array $attributes
     */
    public function storeRoleWithPermssion($request)
    {
        return $this->RolePermissionRepository->storeRole($request);
    }
    /**
     * To edit a record
     *
     * @param $id
     * @return $value
     */
    public function editRoleWithPermssion($id)
    {
        return $this->RolePermissionRepository->editRole($id);
    }
    /**
     * To update a record
     *
     * @param $request, $id
     */
    public function updateRoleWithPermssion($request, $id)
    {
        return $this->RolePermissionRepository->updateRole($request, $id);
    }
    /**
     * To Delete a record
     *
     * @param $id
     */
    public function deleteRoleWithPermssion($id)
    {
        return $this->RolePermissionRepository->deleteRole($id);
    }

    /**
     * Find all role without user
     *
     * @param $id
     */
    public function getAdminRole()
    {
        return $this->RolePermissionRepository->getAdminRole();
    }
}
