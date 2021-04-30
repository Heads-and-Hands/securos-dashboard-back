<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;


abstract class BaseReport
{
    protected ReportParams $params;

    public function __construct(ReportParams $params)
    {
        $this->params = $params;
    }

    public abstract function getResult();
}
