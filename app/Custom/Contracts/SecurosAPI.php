<?php
declare(strict_types=1);

namespace App\Custom\Contracts;
  
Interface SecurosAPI
{
    public function requestFile($camId, $time, $path);

    public function getCameras();
}