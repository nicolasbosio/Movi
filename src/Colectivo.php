<?php

namespace Poli\Tarjeta;

class Colectivo extends Transporte {

  private $nombre;

  private $linea;

  public function __construct($nombre, $linea) {
    $this->tipo = "colectivo";
    $this->nombre = $nombre;
    $this->linea = $linea;
  }

  public function Nombre() {
    return $this->nombre;
  }
}
