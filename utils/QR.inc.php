<?php
 require __DIR__ . '/vendor/autoload.php';

use BaconQrCode\Renderer\Image\Png;
//use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

// class QR {
//     private $renderer;
//     private $writer;

//     public function __construct() {
//       //  $rendererStyle = new RendererStyle(256); // Set size to 256x256
//         $this->renderer = new Png($rendererStyle);
//         $this->writer = new Writer($this->renderer);
//     }

//     /**
//      * Generate a QR code from the given data and save it to the specified file path.
//      *
//      * @param string $data The data to encode in the QR code.
//      * @param string $filePath The file path where the QR code image will be saved.
//      * @return string The file path where the QR code image is saved.
//      */
//     public function generateToFile($data, $filePath) {
//         $this->writer->writeFile($data, $filePath);
//         return $filePath;
//     }

//     /**
//      * Generate a QR code from the given data and return the image binary.
//      *
//      * @param string $data The data to encode in the QR code.
//      * @return string The QR code image binary.
//      */
//     public function generate($data) {
//         return $this->writer->writeString($data);
//     }
// }

class QR {
    private $renderer;
    private $writer;

    public function __construct() {
        // Crear una instancia de Png sin estilo personalizado
        $this->renderer = new Png();
        $this->writer = new Writer($this->renderer);
    }

    /**
     * Generar un código QR a partir de los datos dados y guardarlo en el camino de archivo especificado.
     *
     * @param string $data Los datos para codificar en el código QR.
     * @param string $filePath El camino de archivo donde se guardará la imagen del código QR.
     * @return string El camino de archivo donde se guarda la imagen del código QR.
     */
    public function generateToFile($data, $filePath) {
        $this->writer->writeFile($data, $filePath);
        return $filePath;
    }

    /**
     * Generar un código QR a partir de los datos dados y devolver el binario de la imagen.
     *
     * @param string $data Los datos para codificar en el código QR.
     * @return string El binario de la imagen del código QR.
     */
    public function generate($data) {
        return $this->writer->writeString($data);
    }
}



?>
