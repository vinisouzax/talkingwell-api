<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeTrain extends Model
{
    protected $table = 'type_train';

    protected $fillable = [
        'id', 'name', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];
}
