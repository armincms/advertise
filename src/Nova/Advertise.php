<?php

namespace Armincms\Advertise\Nova;
 
use Illuminate\Support\Facades\Date; 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\Trix; 
use Laravel\Nova\Fields\Code; 
use Laravel\Nova\Fields\Number; 
use Laravel\Nova\Fields\Select;  
use Laravel\Nova\Fields\Datetime;  
use Inspheric\Fields\Url;
use Armincms\RawData\Common;
use Armincms\Fields\BelongsToMany; 
use OwenMelbz\RadioField\RadioButton; 


class Advertise extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\Advertise\\Advertise';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'names', 'label', 'type'
    ]; 

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 25;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()
                ->sortable(),  

            RadioButton::make(__('Advertise Type'), 'type')
                ->options([
                    'text' => __('Text'),
                    'code' => __('Code'),
                    'image' => __('Image'),
                ])
                ->toggle([
                    'image' => ['text', 'code'],
                    'code' => ['text', 'image', 'placeholder'],
                    'text' => ['code', 'image', 'placeholder']
                ])
                ->default('text'),

            Select::make(__('Advertise Language'), 'language')
                ->options(Common::generalLocales()->pluck('native', 'locale')->sort())
                ->displayUsingLabels(),

            Datetime::make(__('Start Date'), 'start_date')
                ->required()
                ->rules('required')
                ->onlyOnForms(),

            Datetime::make(__('End Date'), 'end_date')
                ->required()
                ->rules('required')
                ->onlyOnForms(),

            Text::make(__('Start Date'), function() {
                    if (! is_null($this->start_date)) {
                        return $this->start_date."[{$this->start_date->diffForHumans()}] "; 
                    }
                }),

            Text::make(__('End Date'), function() {
                    if (! is_null($this->end_date)) {
                        return $this->end_date."[{$this->end_date->diffForHumans()}] "; 
                    }
                }),
            
            Text::make(__('Title'), 'title')
                ->required()
                ->rules('required'),   

            Url::make(__('URL address'), 'url')
                ->hideFromIndex()
                ->clickable()
                ->required()
                ->rules('url', 'required'), 
            
            Text::make(__('Placeholder'), 'placeholder') 
                ->fillUsing([$this, 'contentFillUsing'])  
                ->resolveUsing([$this, 'contentResolveUsing'])
                ->hideFromIndex(),  

            Number::make(__('Advertise Width'), 'width')
                ->min(0)
                ->required()
                ->rules('required'),

            Number::make(__('Advertise Height'), 'height')
                ->min(0)
                ->required()
                ->rules('required'),

            BelongsToMany::make(__('Tags'), 'tags', Tag::class) 
                ->hideFromIndex()
                ->fillUsing(function($pivots) {
                    return array_merge($pivots, [
                        'taggable_type' => static::newModel()->getMorphClass() 
                    ]);
                }),

            BelongsToMany::make(__('Categories'), 'categories', Category::class) 
                ->hideFromIndex()
                ->fillUsing(function($pivots) {
                    return array_merge($pivots, [
                        'categorizable_type' => static::newModel()->getMorphClass() 
                    ]);
                }),

            Trix::make(__('Advertise Text'), 'text')
                ->fillUsing([$this, 'contentFillUsing'])
                ->resolveUsing([$this, 'contentResolveUsing'])
                ->hideFromIndex(),

            Code::make(__('Advertise Code'), 'code')
                ->language('javascript')
                ->fillUsing([$this, 'contentFillUsing'])
                ->resolveUsing([$this, 'contentResolveUsing'])
                ->hideFromIndex(),

            $this->imageField()->hideFromIndex(), 
        ];
    }  

    public function contentFillUsing($request, $model, $attribute, $requestAttribute)
    {
        $model->content = $request->get($requestAttribute);
    }

    public function contentResolveUsing($value, $resource, $attribute)
    {
        return $resource->content;
    } 

    /**
     * Get the filters available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [ 
        ];
    }
}
