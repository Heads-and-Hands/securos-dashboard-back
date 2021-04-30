<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    /** @var Request */
    protected $request;

    /** @var Builder */
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->fields() as $field => $value) {
            $method = $this->getMethodName($field);
            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $value);
            }
        }
    }

    public function getRequest() {
        return $this->request;
    }

    protected function fields(): array
    {
        return $this->request->all();
    }

    protected function getMethodName($field): string
    {
        return $field;
    }
}
