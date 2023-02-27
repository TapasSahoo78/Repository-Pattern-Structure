<?php

namespace App\Contracts;

interface RolePermissionContract
{
    public function getAllRoles();
    public function getAllPermissions();
    public function getRoleWithPermssion();
    public function storeRole($request);
    public function editRole($id);
    public function updateRole($request, $id);
    public function deleteRole($id);
    public function getAdminRole();
}
