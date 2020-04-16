<?php

namespace Armincms\Advertise\Nova;

use Armincms\Taggable\Nova\Tag as Resource;
use Illuminate\Http\Request;

class Tag extends Resource
{  
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Advertise';  

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [ 
            $this->resourceField(__("Category"), 'tag'), 
        ]; 
    }  

    public function taggables() : array
    {
        return [
            AdvertiseTag::class,
        ];
    }
}
