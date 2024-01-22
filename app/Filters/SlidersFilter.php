<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;

class SlidersFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function status($term)
    {
        return $this->builder->where('status', $term);
    }

    public function order($term)
    {
        return $this->builder->where('order', $term);
    }
}
