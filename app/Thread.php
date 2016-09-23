<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thread extends Model
{
    use SoftDeletes;

    protected $table = 'threads';

    protected $fillable = [
        'rating',
        'comment',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static $rules = [
        'rating'       => 'required',
        'external_url' => 'required',
    ];

    public static function verifyIfExists($movie)
    {
        $movies_count = Thread::where('user_id', '=', \Auth::user()->id)->whereHas('movie', function ($query) use ($movie) {
            $query->where('id', '=', $movie->id);
        })->count();

        if($movies_count > 0) {
            throw new \Exception('Esse filme já foi indicado por você.');
        }
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
