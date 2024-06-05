<?php
require_once __DIR__ . '/vendor/autoload.php';

class PDFGenerator {
    private $pdfFilePath;
    private $qrFilePath;

    public function __construct($pdfFilePath,$qrFilePath) {
        $this->pdfFilePath = $pdfFilePath;
        $this->qrFilePath = $qrFilePath; 
    }

    public function getPDFFilePath() {
        return $this->pdfFilePath;
    }

    public function getQRFilePath() {
        return $this->qrFilePath;
    }

    public function generatePDF($items, $args) {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Invoice ' . $args);
        $pdf->SetSubject('Invoice PDF');
        $pdf->SetKeywords('TCPDF, PDF, invoice');

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Add title
        $pdf->Write(0, 'Invoice ' . $args, '', 0, 'C', true, 0, false, false, 0);

        // Add table headers
        $html = '<h2>Invoice Details</h2>
                 <table border="1" cellspacing="3" cellpadding="4">
                     <thead>
                         <tr>
                             <th>Name</th>
                             <th>Quantity</th>
                             <th>Price</th>
                             <th>Total Price</th>
                         </tr>
                     </thead>
                     <tbody>';

        $totalInvoicePrice = 0;

        foreach ($items as $item) {
            $quantity = $item['quantity'];
            $price = $item['price'];
            $totalPrice = $quantity * $price;
            $totalInvoicePrice += $totalPrice;

            $html .= '<tr>
                          <td>' . $item['nameviv'] . '</td>
                          <td>' . $quantity . '</td>
                          <td>' . $price . '</td>
                          <td>' . $totalPrice . '</td>
                      </tr>';
        }

        $html .= '</tbody>
                  </table>';

        // Add the total price at the end
        $html .= '<h3>Total Price: ' . $totalInvoicePrice . '</h3>';

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        // $pdf->SetFont('helvetica', '', 10);
        // $pdf->SetXY(15, 200); // Establecer la posición del texto
        // $pdf->Write(0, 'QR code added:', '', 0, 'L', true, 0, false, false, 0);

        // Add the QR code image
        $pdf->Image($this->qrFilePath, 15, 140, 50, 50, 'PNG');

        // Save the PDF to the file path
        $pdf->Output($this->pdfFilePath, 'F');

        return $this->pdfFilePath; // Return the path to the generated PDF
    }
}
?>
