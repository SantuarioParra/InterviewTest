<?php


namespace App\Services\Role;


use Exception;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleService
{

    /**
     * @var Role
     */
    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function showAllRoles()
    {
        $roles = $this->role->select('id', 'name')->get();
        return response()->json(['roles' => $roles],200);
    }

    public function createRole($validateRequest)
    {
        try {
            return $this->role->create($validateRequest) ?
                response()->json(['message' => trans('messages.201_CREATE_ROLE')], 201) :
                response()->json(['message' => trans('messages.400_CREATE_ROLE')], 400);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    public function showRole($id)
    {
        try {
            if (is_numeric($id)) {
                $role = $this->role->findById($id);
            } else {
                $role = $this->role->findByName($id);
            }
            return $role != null ?
                response()->json(['role' => $role], 200) :
                response()->json(['message' => trans('messages.404_NOT_FOUND_ROLE')], 404);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    public function updateRole($validateRequest, $id)
    {
        try {
            if (is_numeric($id)) {
                $role = $this->role->findById($id);
            } else {
                $role = $this->role->findByName($id);
            }
            if ($role != null) {
                $role->fill($validateRequest);
                return $role->save($validateRequest) ?
                    response()->json(['message' => trans('messages.200_UPDATE_ROLE')], 200) :
                    response()->json(['message' => trans('messages.400_UPDATE_ROLE')], 400);
            } else {
                return response()->json(['message' => trans('messages.404_NOT_FOUND_ROLE')], 404);
            }

        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    public function deleteRole($id)
    {
        try {
            if (is_numeric($id)) {
                $role = $this->role->findById($id);
            } else {
                $role = $this->role->findByName($id);
            }
            if ($role != null) {
                return $role->delete() ?
                    response()->json(['message' => trans('messages.200_DELETE_ROLE')], 200) :
                    response()->json(['message' => trans('messages.400_DELETE_ROLE')], 400);
            } else {
                return response()->json(['message' => trans('messages.404_NOT_FOUND_ROLE')], 404);
            }

        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }


}
