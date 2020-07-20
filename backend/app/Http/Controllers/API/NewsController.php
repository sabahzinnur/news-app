<?php

namespace App\Http\Controllers\API;

use App\Repositories\NewsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends ApiController
{
    /**
     * /**
     * @OA\Get(
     *     path="/news",
     *     tags={"news "},
     *     summary="Get news articles",
     *     description="Get news articles",
     *     operationId="getNewsList",
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Limit value that needed to be considered for filter",
     *         @OA\Schema(
     *             type="number",
     *             default="12"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset value that needed to be considered for filter",
     *         @OA\Schema(
     *             type="number",
     *             default="0"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search value that needed to be considered for filter",
     *         @OA\Schema(
     *             type="string",
     *             default="0"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="NewsCategory->id value that needed to be considered for filter",
     *         @OA\Schema(
     *             type="number",
     *             default="0"
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
     * @param NewsRepository $repository
     * @return JsonResponse
     */
    public function list(Request $request, NewsRepository $repository): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'numeric|min:0',
            'offset' => 'numeric|min:0',
            'search' => 'string|nullable',
            'category' => 'numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        [$news, $total] = $repository->list($request);

        return $this->sendResponse(['news' => $news, 'total' => $total], 'Successfully');
    }

    /**
     * @OA\Get(
     *     path="/article/{id}",
     *     tags={"article"},
     *     summary="Get article by id",
     *     description="Get news article by News->id",
     *     operationId="getArticle",
     *     @OA\Parameter(
     *         name="id",
     *         description="News->id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Invalid ID supplier"
     *     )
     * )
     *
     * @param $id
     * @param NewsRepository $repository
     * @return JsonResponse
     */
    public function getArticle($id, NewsRepository $repository): JsonResponse
    {
        $article = $repository->getArticle($id);
        if ($article) {
            return $this->sendResponse($article, 'Successfully');
        }

        return $this->sendError('Article not found');
    }
}
