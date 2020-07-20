<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class News extends Model
{
    use Searchable;

    protected $table='news';

    protected $fillable=[
        'category_id',
        'title',
        'description',
        'content',
        'urlToImage'
    ];

    public function category(): HasOne
    {
        return $this->hasOne(NewsCategory::class, 'id', 'category_id');
    }
}
