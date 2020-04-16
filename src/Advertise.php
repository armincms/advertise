<?php

namespace Armincms\Advertise;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Armincms\Concerns\IntractsWithMedia; 
use Spatie\MediaLibrary\HasMedia\HasMedia; 
use Armincms\Taggable\Taggable;
use Armincms\Categorizable\Categorizable;

class Advertise extends Model implements HasMedia
{
    use SoftDeletes, IntractsWithMedia, Taggable, Categorizable; 

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];


    protected $medias = [
        'image' => [
            'multiple' => false,
            'disk' => 'armin.image',
            'schemas' => ['*'],
        ], 
    ];    
}

