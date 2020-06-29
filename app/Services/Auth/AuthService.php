<?php


namespace App\Services\Auth;


use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\StreamInterface;

class AuthService
{
    private $user;
    private $http;

    /**
     * AuthService constructor.
     * @param User $user
     * @param Client $http
     */
    public function __construct(User $user, Client $http)
    {
        ;
        $this->user = $user;
        $this->http = $http;

    }

    /**
     * @param $validatedRequest
     * @return JsonResponse
     */
    public function userRegister($validatedRequest)
    {
        try {
            return $this->user->create([
                'name' => $validatedRequest['name'],
                'email' => $validatedRequest['email'],
                'password' => bcrypt($validatedRequest['password']),
            ]) ?
                response()->json(['message' => trans('messages.201_CREATE_USER')], 201) :
                response()->json(['message' => trans('messages.400_CREATE_USER')], 400);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $validatedRequest
     * @return StreamInterface
     */

    public function logIn($validatedRequest)
    {
        try {
            $response = $this->http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $validatedRequest['email'],
                    'password' => $validatedRequest['password'],
                ]
            ]);
            return $response->getBody();
        } catch (BadResponseException $exception) {
            switch ($exception->getCode()) {
                case 400:
                    return response()->json(['message' => trans('messages.400_LOG_IN_USER')], 400);
                    break;
                case 401:
                    return response()->json(['message' => trans('messages.401_UNAUTHORIZED_USER')], 401);
                    break;
            }
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logOut()
    {
        try {
            auth()->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return response()->json(['message' => trans('messages.200_LOG_OUT_USER')], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function user()
    {
        try {
            $user = auth()->user();
            return response()->json(['user' => $user], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }
}
