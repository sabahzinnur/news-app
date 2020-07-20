<?php

namespace App\Http\Controllers\API;

use App\NewsCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsCategoryController extends ApiController
{
     /**
     * @OA\Get(
     *     path="/categories",
     *     tags={"news categories"},
     *     summary="Get news categories",
     *     description="Get news categories",
     *     operationId="getCategoriesList",     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid ID supplier"
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     */

    public function list(Request $request): JsonResponse
    {

        $newsCategories = NewsCategory::all();

        return $this->sendResponse($newsCategories, 'Successfully');
    }
}
