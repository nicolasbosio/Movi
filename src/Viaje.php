<?php

namespace Poli\Tarjeta;

class Viaje {

  private $tipo;

  private $monto;

  private $transporte;

  private $tiempo;

  public function __construct($tipo, $monto, $transporte, $tiempo) {
    $this->tipo = $tipo;
    $this->monto = $monto;
    $this->transporte = $transporte;
  }

  public function tipo() {
    return $this->tipo;
  }

  public function monto() {
    return $this->monto;
  }

  public function transporte() {
    return $this->transporte;
  }

  public function tiempo() {
    return $this->tiempo;
  }
}
