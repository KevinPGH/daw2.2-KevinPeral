<?php

require('fpdf/fpdf.php');
$fpdf = new FPDF();
$fpdf ->AddPage();

class pdf extends FPDF{
    /*
    function Header() {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(1, 6, 'Centro administrativo San Juan');
        // To be implemented in your own inherited class
    }*/

    function Footer()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetY(-15);
        $this->Write(5, 'WatchFilm', '');
        $this->SetX(-15);
        $this->Write(5, $this->PageNo());
        // To be implemented in your own inherited class
    }
}
$fpdf ->Ln();
$fpdf->setFont('Arial','',18);
//Para crear lineas de texto
$fpdf ->Write(10,'Armageddon');
$fpdf->Ln();

$fpdf->setFont('Arial','',12);
$fpdf->Write(25,'Pelicula rodada en EEUU en 1998');
//Saltos de linea

$fpdf->SetTextColor(173, 173, 235);

$fpdf->setFont('Arial','',18);
$fpdf ->Write(10,'Sinopsis de la pelicula');

$fpdf->Ln();
$fpdf->SetTextColor(0, 0, 0);
$fpdf->setFont('Arial','',12);
$fpdf->Write(10,'
Un meteorito avanza hacia la Tierra y amenaza con su destruccion. El Gobierno de los Estados Unidos, en un intento desesperado por salvar el planeta, confia la mision de viajar al meteorito y destruirlo con explosivos a un grupo de expertos perforadores. El unico problema es que los elegidos no tienen ninguna experiencia en viajes espaciales.

Un filme con el inconfundible sello del productor Jerry Bruckheimer ("Piratas del Caribe"), pensado para convertirse en uno de los grandes exitos del verano de 1998. Y asi lo hizo, ya que amaso mas de 164 millones de euros solo en Estados Unidos, convirtiendose en el largometraje mas taquillero de la temporada. Y eso que fue estrenada despues de otro filme de tematica muy parecida, "Deep Impact", tambien de gran repercusion comercial.');
$fpdf->Ln();
$fpdf->Ln();

$fpdf->SetTextColor(230, 0, 0);
$fpdf->setFont('Arial','',18);
$fpdf->Write(5,'Actores principales');

$fpdf->Image('_img/_armageddon/bruce.jpg',10,170,35);
$fpdf->Image('_img/_armageddon/billy.jpg',60,170,35);
$fpdf->Image('_img/_armageddon/ben afleck.jpg',110,170,35);
$fpdf->Image('_img/_armageddon/liv.jpg',160,170,35);
$fpdf->Image('_img/_armageddon/steve.jpg',10,230,35);
$fpdf->Image('_img/_armageddon/will.jpg',60,230,35);

$fpdf->SetTextColor(0, 0, 0);

$fpdf ->AddPage();

$fpdf->setFont('Arial','B',16);
$fpdf->SetFillColor(255, 255, 230);
$fpdf ->Cell(80,5,'Nombre de los actores',1,0,'',true);

$fpdf ->SetFillColor(255, 255, 230);
$fpdf ->Cell(80,5,'Apellidos',1,1,'',true);
$fpdf->Ln(0);

$fpdf->setFont('Arial','',12);

$fpdf ->Cell(80,5,'Ben',1,0,false);
$fpdf ->Cell(80,5,'Afleck',1,0,false);
$fpdf->Ln(5);
$fpdf ->Cell(80,5,'Billy',1,0,false);
$fpdf ->Cell(80,5,'Bob Thornton',1,0,false);
$fpdf->Ln(5);
$fpdf ->Cell(80,5,'Bruce',1,0,false);
$fpdf ->Cell(80,5,'Willis',1,0,false);
$fpdf->Ln(5);
$fpdf ->Cell(80,5,'Liv',1,0,false);
$fpdf ->Cell(80,5,'Tyler',1,0,false);
$fpdf->Ln(5);
$fpdf ->Cell(80,5,'Steve',1,0,false);
$fpdf ->Cell(80,5,'Buscemi',1,0,false);
$fpdf->Ln(5);
$fpdf ->Cell(80,5,'Will',1,0,false);
$fpdf ->Cell(80,5,'Patton',1,0,false);









//$fpdf ->Footer(18,6,'Footer del pdf');
$fpdf ->Output();
