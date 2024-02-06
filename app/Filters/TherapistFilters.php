<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;

class TherapistFilters extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
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

    public function keyword($term)
    {
        return $this->builder->where(function ($query) use ($term){
            $query->where('name','LIKE',"%$term%")->orWhere('phone',"$term");
        });
    }
}
