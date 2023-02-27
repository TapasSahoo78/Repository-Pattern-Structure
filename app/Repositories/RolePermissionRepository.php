<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Contracts\RolePermissionContract;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class Post Repository
 *
 * @package \App\Repositories
 */
class RolePermissionRepository extends BaseRepository implements RolePermissionContract
{
    /**
     * @package \App\Repositories
     * Class RolePermissionRepository.
     */

    protected $roleModel;
    protected $permissionModel;

    public function __construct(Role $roleModel, Permission $permissionModel)
    {
        $this->roleModel = $roleModel;
        $this->permissionModel = $permissionModel;
    }

    /**
     * Return all model rows
     * @return array
     */
    public function getAllRoles()
    {
        return $this->roleModel->all();
    }
    /**
     * Return all model rows
     * @return array
     */
    public function getAllPermissions()
    {
        return $this->permissionModel->all();
    }
    /**
     * Find all roles along with their permission
     *
     * @return array
     */
    public function getRoleWithPermssion()
    {
        return $this->roleModel->with('permissions')->get();
    }
    /**
     * To Create a record
     *
     * @param array $attributes
     */
    public function storeRole($attributes)
    {
        $collection = collect($attributes);

        $role =  $this->roleModel->create([
            'name' => $collection['name'],
            'slug' => Str::slug($collection['name']),
        ]);

        /** Get Last Insert Id **/
        $role_id = $role->id;

        foreach ($collection['permissions'] as $key => $value) {
            $role_permission = DB::table('roles_permissions')->insert(
                [
                    'role_id' => $role_id,
                    'permission_id' => $value
                ]
            );
        }

        if (isset($role_permission) && !empty($role_permission)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * To edit a record
     *
     * @param array $id
     */
    public function editRole($id)
    {
        return $this->roleModel::with('permissions')->find($id);
    }
    /**
     * To update a record
     *
     * @param array $attributes,$id
     */
    public function updateRole($attributes, $id)
    {
        $collection = collect($attributes);

        $role = $this->roleModel::find($id);
        $role->update([
            'name' => $collection['name'],
            'slug' => Str::slug($collection['name']),
        ]);
        if (isset($collection['permissions']) && !empty($collection['permissions'])) {
            DB::table('roles_permissions')
                ->where('role_id', $id)
                ->delete();

            foreach ($collection['permissions'] as $key => $value) {
                $role_permission = DB::table('roles_permissions')->insert(
                    [
                        'role_id' => $id,
                        'permission_id' => $value
                    ]
                );
            }
        }
        if (isset($role_permission) && !empty($role_permission)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * To delete a record
     *
     * @param array $id
     */
    public function deleteRole($id)
    {
        if (isset($id) && !empty($id)) {
            DB::table('roles_permissions')
                ->where('role_id', $id)
                ->delete();
        }
        Role::where('id', $id)->delete();
        if (isset($result) && !empty($result)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * To delete a record
     *
     * @param array $id
     */
    public function getAdminRole()
    {
        return $this->roleModel::whereNot('slug', 'user')->get();
    }
}
