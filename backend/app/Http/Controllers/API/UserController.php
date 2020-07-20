<?php

namespace App\Http\Controllers\API;

use App\User;
use App\UserCredentials;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function getProfile(Request $request): JsonResponse
    {
        $user = User::where('id', $request->user()->id)->with('credentials')->first();
        if ($user) {
            return $this->sendResponse($user, 'Successfully.');
        }
        return $this->sendError('User not found');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->credentials()->updateOrCreate(['user_id' => $user->id], $request->all());

        return $this->sendResponse($user->with('credentials')->first(), 'Successfully.');
    }
}
