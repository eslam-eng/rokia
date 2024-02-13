<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;

class TherapistScheduleFilters extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function id($term)
    {
        return $this->builder->where('id',$term);
    }
    public function day_id($term)
    {
        return $this->builder->where('day_id',$term);
    }
    public function therapist_id($term)
    {
        return $this->builder->where('therapist_id',$term);
    }

}
