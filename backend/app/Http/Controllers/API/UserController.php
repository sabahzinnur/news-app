<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    /**
     * @param Request $request
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'string|nullable',
            'second_name' => 'required|email',
            'patronymic' => 'string|nullable',
            'birthday' => 'date|nullable'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();
        $user->credentials()->updateOrCreate(['user_id' => $user->id], $request->all());

        return $this->sendResponse($user->with('credentials')->first(), 'Successfully.');
    }
}
