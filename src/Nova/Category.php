<?php

namespace Armincms\Advertise\Nova;

use Armincms\Categorizable\Nova\Category as Resource;
use Illuminate\Http\Request;

class Category extends Resource
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
            $this->resourceField(__("Category"), 'name'), 
        ]; 
    } 

    public function categorizables() : array
    {
        return [
            AdvertiseCategory::class,
        ];
    }  
}
