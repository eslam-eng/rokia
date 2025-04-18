<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;

class InterestsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function status($term)
    {
        return $this->builder->where('status', $term);
    }


}
