<?php

namespace Poli\Tarjeta;

class Sube implements InterfaceTarjeta {

  private $viajes = [];

  private $saldo = 0;
  protected $descuento;

  public function __construct() {
    $this->descuento = 1;
  }

  public function pagar(Transporte $transporte, $fecha_y_hora) {
    if ($transporte->tipo() == "colectivo") {
      $this->pagarColectivo($transporte, $fecha_y_hora);
    }
    else if ($transporte->tipo() == "bici") {
      $this->viajes[] = new Viaje($transporte->tipo(), 12, $transporte, strtotime($fecha_y_hora));
      $this->saldo -= 12;
    }
  }

  protected function pagarColectivo(Transporte $transporte, $fecha_y_hora) {
    $trasbordo = FALSE;
    if (count($this->viajes) > 0) {
      if (end($this->viajes)->tiempo() - strtotime($fecha_y_hora) < 3600) {
        $trasbordo = TRUE;
      }
    }
    $monto = 0;
    if ($trasbordo) {
      $monto = 2.64 * $this->descuento;
    }
    else {
      $monto = 8.5 * $this->descuento;
    }

    $this->viajes[] = new Viaje($transporte->tipo(), $monto, $transporte, strtotime($fecha_y_hora));
    $this->saldo -= $monto;
  }

  public function recargar($monto) {
    if ($monto == 272) {
      $this->saldo += 320;
    }
    else if ($monto = 500) {
      $this->saldo += 640;
    }
    else {
      $this->saldo += $monto;
    }
  }

  public function saldo() {
    return $this->saldo;
  }

  public function viajesRealizados() {
    return $this->viajes;
  }
}

