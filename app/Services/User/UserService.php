<?php


namespace App\Services\User;


use App\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUser($validatedRequest)
    {
        try {
            if ($user = $this->user->create(['name' => $validatedRequest['name'], 'email' => $validatedRequest['email'],
                'password' => bcrypt($validatedRequest['password'])])) {
                return $user->assignRole(Role::findByName($validatedRequest['role'],'api')) ?
                    response()->json(['message' => trans('messages.201_CREATE_USER')], 201) :
                    response()->json(['message' => trans('messages.400_SYNC_ROLE')], 400);
            } else {
                return response()->json(['message' => trans('messages.400_CREATE_USER')], 400);
            }
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $validatedRequest
     * @param $id
     * @return JsonResponse
     */
    public function updateUser($validatedRequest, $id)
    {
        try {
            $validatedRequest['password'] = bcrypt($validatedRequest['password']);
            $user = $this->user->findOrFail($id);
            if ($user->fill($validatedRequest)->save()) {
                return $user->syncRoles([Role::findByName($validatedRequest['role'],'api')]) ?
                    response()->json(['message' => trans('messages.200_UPDATE_USER')], 200) :
                    response()->json(['message' => trans('messages.400_SYNC_ROLE')], 400);
            } else {
                response()->json(['message' => trans('messages.400_UPDATE_USER')], 400);
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_USER_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteUser($id)
    {
        try {
            return $this->user->findOrFail($id)->delete() ?
                response()->json(['message' => trans('messages.200_DELETE_USER')], 200) :
                response()->json(['message' => trans('messages.400_DELETE_USER')], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_USER_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function restoreUser($id)
    {
        try {
            return $this->user->withTrashed()->findOrFail($id)->restore() ?
                response()->json(['message' => trans('messages.200_RESTORE_USER')], 200) :
                response()->json(['message' => trans('messages.400_RESTORE_USER')], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_USER_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $value
     * @return JsonResponse
     */
    public function showUser($value)
    {
        try {
            $user = $this->user->withoutTrashed()->with('roles:id,name')->find($value);
            return $user != null ?
                response()->json(['user' => $user], 200) :
                response()->json(['message' => trans('messages.404_USER_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function getAllUsers($itemsPerPage)
    {
        try {
            return $this->user->withTrashed()->latest()->paginate($itemsPerPage);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }
}
