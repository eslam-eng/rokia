<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;

class LecturesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }
    public function status($term)
    {
        return $this->builder->where('status',$term);
    }
    public function type($term)
    {
        return $this->builder->where('type',$term);
    }

}
