<?php


namespace App\Dashboard\Reports\Report;


class ModeTimeReport extends \App\Dashboard\Reports\BaseReport
{
    public const FORMAT_PROBLEM_TIME = 10;
    public const FORMAT_AVAILABLE_TIME = 20;
    public const FORMAT_AVAILABLE_PERCENT = 30;

    public function readData()
    {
        #TODO: Получить данные из API клиента с нужной разбивкой
    }

    public function getResult($format = self::FORMAT_PROBLEM_TIME)
    {
        #TODO: Вывести данные в нужном формате представления
        //return count($this->params->workingVideoCameraIds);
        return $this->params->intervalType;
    }
}
