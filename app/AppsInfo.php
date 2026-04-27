<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class AppsInfo extends Model
{
    public $table = 'apps_info';
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

    protected $fillable = [
        'title',
        'description',
        'slug',
        'appid',
        'summary',
        'recentChange',
        'size',
        'appVersion',
        'androidVersion',
        'locale',
        'country',
    ];

}
