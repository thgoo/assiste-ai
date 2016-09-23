<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExternalId extends Model
{

    protected $table = 'external_ids';

    protected $fillable = [
        'name',
        'external_id',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

}
