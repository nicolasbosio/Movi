<?php

namespace Poli\Tarjeta;

class Bici extends Transporte {
  private $patente;

  public function __construct($patente) {
    $this->tipo = "bici";
    $this->patente = $patente;
  }

  public function Nombre() {
    return $this->patente;
  }
}
