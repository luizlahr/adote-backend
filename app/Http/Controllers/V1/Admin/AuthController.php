<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ResponseTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $credentials = $this->validate($request, $this->getRules());
        $user = User::where('email', $credentials['email'])->first();

        // Revoke any valid token before authenticating again
        $user->revokeTokens();

        if (!$user || $user->checkPassword($credentials['password'])) {
            return $this->sendError(trans('auth.failed'), Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('Admin Token', ['access-admin'])->accessToken;

        return $this->sendResponse([
            'token' => $token,
            'user'  => $user,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(): JsonResponse
    {
        request()->user()->revokeTokens();
        return $this->sendResponse(trans('auth.logout'), Response::HTTP_NO_CONTENT);
    }

    /**
     * Returns the validation rules for a given id
     *
     * @return array
     */
    public function getRules() : array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required']
        ];
    }
}
