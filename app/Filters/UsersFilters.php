<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;
use Illuminate\Support\Arr;

class UsersFilters extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function ids($term)
    {
        return $this->builder->whereIntegerInRaw('id',Arr::wrap($term));
    }

    public function email($term)
    {
        return $this->builder->where('email',$term);
    }
    public function phone($term)
    {
        return $this->builder->where('phone',$term);
    }
    public function status($term)
    {
        return $this->builder->where('status',$term);
    }
    public function type($term)
    {
        return $this->builder->whereIn('type',Arr::wrap($term));
    }


    public function keyword($term)
    {
        return $this->builder->where(function ($query) use ($term){
            $query->where('name','LIKE',"%$term%")->orWhere('phone',"$term");
        });
    }
}
