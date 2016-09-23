<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function thread()
    {
        $this->belongsTo(Thread::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
