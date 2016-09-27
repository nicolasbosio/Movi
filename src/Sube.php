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
      $this->pagarBici($transporte, $fecha_y_hora);
    }
  }

  protected function pagarBici(Transporte $transporte, $fecha_y_hora){
    $trasbordo = FALSE;
    if (count($this->viajes) > 0) {
      if (end($this->viajes)->tiempo() - strtotime($fecha_y_hora) < 3600) {
        $trasbordo = TRUE;
      }
    }
    if($trasbordo == FALSE){
      $this->viajes[] = new Viaje($transporte->tipo(), 12, $transporte, strtotime($fecha_y_hora));
      $this->saldo -= 12;
    }
    else{
      $this->viajes[] = new Viaje($transporte->tipo(), 0, $transporte, strtotime($fecha_y_hora));
    }

  }

  protected function pagarColectivo(Transporte $transporte, $fecha_y_hora) {
    if ($this->saldo() >= 0){
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
    else if ($this->saldo() == -8.5){
      $monto = 8.5 * $this->descuento;
      $this->viajes[] = new Viaje($transporte->tipo(), $monto, $transporte, strtotime($fecha_y_hora));
      $this->saldo -= $monto;
    }
    else{

    }
  }

  public function recargar($monto) {
    if ($monto == 290) {
      $this->saldo += 340;
    }
    else if ($monto == 544) {
      $this->saldo += 680;
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

