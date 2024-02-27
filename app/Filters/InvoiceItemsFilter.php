<?php

namespace App\Filters;

use App\Abstracts\QueryFilter;

class InvoiceItemsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }
    public function invoice_id($term)
    {
        return $this->builder->where('invoice_id',$term);
    }

    public function type($term)
    {
        return $this->builder->where('relatable_type',$term);
    }
}
