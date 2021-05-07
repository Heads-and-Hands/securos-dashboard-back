<?php
declare(strict_types=1);

namespace App\Dashboard\Export;

use App\Dashboard\Export\Contracts\ExportReportInterface;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\App;
//use Barryvdh\DomPDF\Facade as PDF;

class ExportToPdf implements ExportReportInterface
{
    public function parseData($data)
    {
        /*
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1>PDF Test</h1>');
        return $pdf->stream();
        */

        $pdf = App::make('dompdf.wrapper');
        $pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf->loadView('pdf.reports', ['data' => $data]);
        //$pdf = PDF::loadView('pdf.reports', $data);
        return $pdf->download('report.pdf');

        /*
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<h1>Title</h1>Text<br>Text');

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
        //dd($data);*/
    }
}
