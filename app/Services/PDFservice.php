<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class PDFservice {
    public function generatePDF($view, $data, $fileName = 'document.pdf', $paperSize = 'f4', $orientation = 'landscape') {
        $pdf = Pdf::loadView($view, $data)
            ->setPaper($paperSize, $orientation)
            ->setOption('margin-bottom', 0);
        
        return $pdf->download($fileName);
    }
}