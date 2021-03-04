<?php

namespace App\Custom\Contracts;
  
Interface SecurosAPI
{
    public function requestFile($cam_id, $time, $path);

    public function getCameras();
}