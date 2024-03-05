<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;

class ClientPlansSubscriptionFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function therapist_id($term)
    {
        return $this->builder->where('therapist_id', $term);
    }

    public function status($term)
    {
        return $this->builder->where('status', $term);
    }

}
