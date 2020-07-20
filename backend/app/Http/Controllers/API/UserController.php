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
     * /**
     * @OA\Get(
     *     path="/profile",
     *     tags={"profile"},
     *     summary="Get user profile",
     *     description="Get user profile",
     *     operationId="getUserProfile",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     *
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
     * Register user
     * @OA\Post(
     *     path="/profile",
     *     tags={"profile"},
     *     summary="Users profile update",
     *     description="User profile update",
     *     operationId="profile update",
     *     @OA\Parameter(
     *         name="first_name",
     *         description="User first name",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="second_name",
     *         description="User second name",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="patronymic",
     *         description="User patronymic",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="birthday",
     *         description="User birthday",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="birthday",
     *         description="User birthday",
     *         in="query",
     *         @OA\Schema(
     *             type="date"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     *
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
