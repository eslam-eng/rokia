<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;
use App\Enums\LecturesTypeEnum;
use Carbon\Carbon;

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
    public function is_paid($term)
    {
        return $this->builder->where('is_paid',$term);
    }

    public function therapist_id($term)
    {
        return $this->builder->where('therapist_id',$term);
    }

    public function upcomming()
    {
        return $this->builder->where('type',LecturesTypeEnum::LIVE->value)->where('publish_date','>=',Carbon::now()->format('Y-m-d H:i:s'));
    }
}
