<?php

namespace App\Dashboard\Export\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

#TODO: Удалить

class VideoCameraExport implements FromCollection
{
    protected $videoCameraCollection;

    public function __construct($videoCameraCollection)
    {
        $this->videoCameraCollection = $videoCameraCollection;
    }

    public function collection()
    {
        $data = [];
        foreach ($this->videoCameraCollection as $item) {
            if ($item->id) {
                $data[] = [
                    'id' => $item->id,
                    'ip' => $item->ip,
                    'name' => $item->name,
                    'type' => $item->type,
                    'ip_server' => $item->ip_server,
                    'status' => $item->status,
                    'status_exploitation' => $item->status_exploitation,
                ];
            }
        }

        return new Collection($data);
    }

    public function headings()
    {
        return ['#', 'IP', 'Название', 'Тип', 'IP Server', 'Статус', 'Статус эксплуатации'];
    }
}
