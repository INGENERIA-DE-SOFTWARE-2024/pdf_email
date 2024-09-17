<?php

namespace Controllers;

use Model\ActiveRecord;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use MVC\Router;

class ReporteController
{
    public static function pdf(Router $router)
    {
        $mpdf = new Mpdf(
            [
                "default_font_size" => "12",
                "default_font" => "arial",
                "orientation" => "P",
                "margin_top" => "30",
                "format" => "Letter"
            ]
        );
        // $productos = ActiveRecord::fetchArray("SELECT * FROM productos");
        // $html = $router->load('pdf/reporte', [
        //    'productos' => $productos
        //  ]);
        $html = $router->load('pdf/reporte'); //Se agreagó esta línea ya que el pdf se quiere sin conssulta a la bd
        $mpdf->AliasNbPages('[pagetotal]');
        $css = $router->load('pdf/styles');
        $css = file_get_contents(__DIR__ . '/../views/pdf/styles.css');
        $header = $router->load('pdf/header');
        $footer = $router->load('pdf/footer');
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($css, HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
        $mpdf->AddPage("L");
        // $mpdf->SetProtection();
        $archivo = $mpdf->Output("reporte.pdf", "I");
        echo base64_encode($archivo);
    }

}