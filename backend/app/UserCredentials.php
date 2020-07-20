<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCredentials extends Model
{
    protected $table='users_credentials';

    protected $fillable=[
        'first_name',
        'second_name',
        'patronymic',
        'birthday'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
