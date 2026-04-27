<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Application extends Model
{
//    use Sluggable;
//
//    /**
//     * Return the sluggable configuration array for this model.
//     *
//     * @return array
//     */
//    public function sluggable()
//    {
//        return [
//            'slug' => [
//                'source' => 'title'
//            ]
//        ];
//    }
   // protected  $primaryKey = 'appid';
    protected $fillable = [
        'appid',
        'cover',
        'score',
        'price',
        'developer',
        'installs',
        'five',
        'four',
        'three',
        'two',
        'one',
        'releasedTimestamp',
        'updatedTimestamp',
        'numberVoters',
        'url',
        'category',
        'screenshots',
        'votes'
    ];
    function appsinfo()
    {
        return $this->hasOne("App\AppsInfo", "appid", "appid");
    }
}
