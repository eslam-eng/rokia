<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;
use App\Enums\LecturesTypeEnum;

class LecturesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function status($term)
    {
        return $this->builder->where('status', $term);
    }

    public function keyword($term)
    {
        return $this->builder->where(fn($query) => $query->where('title', "LIKE", "%$term%")->orWhere('description', 'LIKE', "%$term%"));
    }

    public function is_paid($term)
    {
        return $this->builder->where('is_paid', $term);
    }

    public function therapist_id($term)
    {
        return $this->builder->where('therapist_id', $term);
    }

    public function date_between($term)
    {
        $date = explode('To', $term);
        return $this->builder->whereDate('created_at', '>=', $date[0])
            ->whereDate('created_at', '<=', $date[1]);
    }

    public function upcoming($term)
    {
        if ($term)
            return $this->builder->where('type', LecturesTypeEnum::LIVE->value);
        return $this->builder->where('type', LecturesTypeEnum::RECORDED->value);
    }
}
