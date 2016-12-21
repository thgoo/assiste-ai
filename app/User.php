<?php

namespace App;

use Facebook\GraphNodes\GraphNode;
use Facebook\GraphNodes\GraphObject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;

class User extends Authenticatable
{
    use SoftDeletes, SyncableGraphNodeTrait, Notifiable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['remember_token', 'access_token'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['provider', 'provider_id', 'access_token', 'name', 'username', 'email', 'avatar', 'last_login_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Mapping the facebook fields to database columns
     *
     * @var array
     */
    protected static $graph_node_field_aliases = [
        'id' => 'provider_id',
        'picture.is_silhouette' => null,
        'picture.url' => 'avatar',
    ];

    public function posts()
    {
        $this->hasMany(Post::class);
    }

    public function threads()
    {
        $this->hasMany(Thread::class);
    }

    /**
     * {@inheritdoc}
     */
    public static function createOrUpdateGraphNode($data)
    {
        if ($data instanceof GraphObject || $data instanceof GraphNode) {
            $data = array_dot($data->asArray());
        }
        $fields = ['id', 'name', 'email', 'gender', 'picture.url'];
        $wanted_data = [];
        foreach ($fields as $field) {
            $wanted_data[$field] = $data[$field];
        }

        $wanted_data['provider'] = 'Facebook';
        $wanted_data['access_token'] = \Session::get('fb_user_access_token');
        $wanted_data['last_login_at'] = date('Y-m-d H:i:s');

        $wanted_data = static::convertGraphNodeDateTimesToStrings($wanted_data);

        if (!isset($wanted_data['id'])) {
            throw new \InvalidArgumentException('Graph node id is missing');
        }

        $attributes = [static::getGraphNodeKeyName() => $wanted_data['id']];

        $graph_node = static::firstOrNewGraphNode($attributes);

        static::mapGraphNodeFieldNamesToDatabaseColumnNames($graph_node, $wanted_data);

        $graph_node->save();

        return $graph_node;
    }
}
