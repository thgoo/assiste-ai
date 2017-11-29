<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Movie extends Model
{
    use SoftDeletes;

    protected $table = 'movies';

    protected $fillable = [
        'title',
        'original_title',
        'year',
        'slug',
        'category',
        'genre',
        'description',
        'poster_path',
        'backdrop_path',
    ];

    private static $imdb_id = null;
    private static $tmdb_id = null;
    private static $external_provider;
    private static $category;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function externalIds()
    {
        return $this->hasMany(ExternalId::class);
    }

    /**
     * @param string $external_url
     * @return Movie
     * @throws \Exception
     */
    public static function getOrCreate($external_url)
    {
        if (self::prepare($external_url) === false) {
            throw new \Exception('Link IMDb/TMDb inválido.');
        }

        try {
            $external_id = ExternalId::whereIn('external_id', [self::$tmdb_id, self::$imdb_id])->firstOrFail();

            return $external_id->movie;
        } catch (ModelNotFoundException $e) {
            $movie_data = self::getMovieData();
            $genres = [];

            foreach ($movie_data->genres as $genre) {
                $genres[] = $genre->name;
            }

            if (isset($movie_data->release_date)) {
                $year = explode('-', $movie_data->release_date)[0];
            } else {
                $year = explode('-', $movie_data->first_air_date)[0];
            }

            if (isset($movie_data->original_title)) {
                $slug = Str::slug($movie_data->original_title);
                if ($slug === '') {
                    $slug = Str::slug($movie_data->title);
                }
            } else {
                $slug = Str::slug($movie_data->original_name);
                if ($slug === '') {
                    $slug = Str::slug($movie_data->name);
                }
            }

            $movie = new Movie([
                'title' => (isset($movie_data->title)) ? $movie_data->title : $movie_data->name,
                'original_title' => (isset($movie_data->original_title)) ? $movie_data->original_title : $movie_data->original_name,
                'year' => $year,
                'slug' => $slug,
                'category' => self::$category,
                'genre' => implode(',', $genres),
                'description' => $movie_data->overview,
                'poster_path' => (isset($movie_data->poster_path)) ? $movie_data->poster_path : null,
                'backdrop_path' => (isset($movie_data->backdrop_path)) ? $movie_data->backdrop_path : null,
            ]);
            $movie->save();

            $external_ids = [];
            if (self::$tmdb_id !== null) {
                $external_ids[] = ['name' => 'tmdb', 'external_id' => self::$tmdb_id, 'movie_id' => $movie->id];
            }

            if (self::$imdb_id !== null) {
                $external_ids[] = ['name' => 'imdb', 'external_id' => self::$imdb_id, 'movie_id' => $movie->id];
            }

            DB::table('external_ids')->insert($external_ids);

            return $movie;
        }
    }

    /**
     * @param $external_url
     * @return bool
     */
    private static function prepare($external_url)
    {
        if (preg_match('/(tt\d{7})/', $external_url, $matches) !== 0) {
            self::$imdb_id = $matches[1];
            self::$external_provider = 'imdb';

            return true;
        }

        if (preg_match('/(movie|tv)\/(\d{1,6})/', $external_url, $matches) !== 0) {
            self::$category = $matches[1];
            self::$tmdb_id = $matches[2];
            self::$external_provider = 'tmdb';

            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    private static function getMovieData()
    {
        /**
         * Necessary if user uses IMDb URL.
         */
        if (self::$external_provider === 'imdb') {
            $imdb_result = self::callCurl('https://api.themoviedb.org/3/find/' . self::$imdb_id . '?external_source=imdb_id&api_key=' . env('TMDB_API_KEY'));

            if (count($imdb_result->movie_results) > 0) {
                self::$category = 'movie';
                self::$tmdb_id = $imdb_result->movie_results[0]->id;
            } else {
                self::$category = 'tv';
                self::$tmdb_id = $imdb_result->tv_results[0]->id;
            }
        }

        /**
         * TMDb
         * Portuguese data
         */
        $tmdb_result_pt = self::callCurl('http://api.themoviedb.org/3/' . self::$category . '/' . self::$tmdb_id . '?language=pt&api_key=' . env('TMDB_API_KEY'));
        unset($tmdb_result_pt->poster_path, $tmdb_result_pt->backdrop_path);

        // English data
        $tmdb_result_en = self::callCurl('http://api.themoviedb.org/3/' . self::$category . '/' . self::$tmdb_id . '?api_key=' . env('TMDB_API_KEY'));

        // Merging data
        return (object) array_merge(array_filter((array) $tmdb_result_en), array_filter((array) $tmdb_result_pt));
    }

    /**
     * @param $url
     * @return mixed
     */
    public static function callCurl($url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => false,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        return $result;
    }
}
