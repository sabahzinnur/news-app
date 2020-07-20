<?php


namespace App\Repositories;

use App\News;
use Illuminate\Http\Request;

class NewsRepository
{
    /**
     * @param Request $request
     * @return array
     */
    public function list(Request $request): array
    {

        $limit = $request->input('limit', 12);
        $offset = $request->input('offset', 0);

        $page = $offset === 0 ? 1 : $offset / $limit;

        if ($request->input('search')) {
            $news = News::search($request->input('search'))->when($request->input('category'), function ($query) use ($request) {
                $query->where('category_id', $request->input('category'));
            })->paginate($limit, '', $page);
            $total = $news->total();
        } else {
            $news = News::when($request->input('category'), function ($query) use ($request) {
                $query->where('category_id', $request->input('category'));
            });
            $total = $news->get()->count();
            $news = $news->with('category')->limit($limit)->offset($offset)->get();
        }

        return [$news, $total];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getArticle($id): News
    {
        return News::find($id);
    }
}
