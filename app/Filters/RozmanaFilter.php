<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;
use App\Models\Rozmana;
use Illuminate\Support\Arr;

class RozmanaFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function status($term)
    {
        return $this->builder->where('status', $term);
    }

    public function date($term)
    {
        return $this->builder->where('date', $term);
    }

    public function interest_id($term): void
    {
        $this->builder->whereRelation('interests','id','=',$term);
    }

    public function interests($term): void
    {
        $this->builder->whereHas('interests',fn($query)=>$query->whereIntegerInRaw('interests.id',Arr::wrap($term)));
    }

    public function therapist_id($term)
    {
        return $this->builder->where('therapist_id', $term);
    }
}
