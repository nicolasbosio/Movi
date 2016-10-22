<?php

namespace Poli\Tarjeta;

class Sube implements InterfaceTarjeta {

  private $viajes = [];
  private $last_bike = NULL;

  private $saldo = 0;
  private $plus = 0;
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
    if($this->saldo() >= 12 && $this->plus()==0){
      if(date("Y-m-d", strtotime($this->ultimabici())) == date("Y-m-d", strtotime($fecha_y_hora))) {
        $this->viajes[] = new Viaje($transporte->tipo(), 12, $transporte, strtotime($fecha_y_hora));
      }
      else{
        $last_bike = strtotime($fecha_y_hora);
        $this->viajes[] = new Viaje($transporte->tipo(), 12, $transporte, strtotime($fecha_y_hora));
        $this->saldo -= 12;
      }
    }
    else{
      echo ("No se ha podido realizar el viaje solicitado");
    }
  }

  protected function pagarColectivo(Transporte $transporte, $fecha_y_hora) {
    if ($this->saldo() >= 8.5 && $this->plus() == 0 || $this->descuento == 0){
      $trasbordo = FALSE;
      if (count($this->viajes) > 0) {
        if (strtotime($fecha_y_hora) - end($this->viajes)->tiempo() < 3600) {
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
    else if($this->saldo() >= 8.5 * ($this->plus()+1)) {
      $monto = 0;
      $monto = 8.5 * $this->plus();
      $trasbordo = FALSE;
      if (count($this->viajes) > 0) {
        if (strtotime($fecha_y_hora) - end($this->viajes)->tiempo() < 3600) {
          $trasbordo = TRUE;
        }
      }
      $this->plus = 0;
      if ($trasbordo) {
        $monto += 2.64 * $this->descuento;
      }
      else {
        $monto += 8.5 * $this->descuento;
      }
      $this->viajes[] = new Viaje($transporte->tipo(), $monto, $transporte, strtotime($fecha_y_hora));
      $this->saldo -= $monto;
    }
    else if ($this->saldo() < 8.5 && $this->plus() < 2){
      $this->plus += 1;
      $this->viajes[] = new Viaje($transporte->tipo(), "Plus ".$this->plus, $transporte, strtotime($fecha_y_hora));
    }
    else{
      echo ("No se ha podido realizar el viaje solicitado");
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
  
  public function plus() {
    return $this->plus;
  }

  public function ultimabici() {
    return $this->last_bike;
  }

  public function viajesRealizados() {
    return $this->viajes;
  }
}

