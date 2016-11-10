<?php

namespace Poli\Tarjeta;

class Sube implements InterfaceTarjeta {

  private $viajes = [];
  private $boletos = [];
  private $last_bike = NULL;
  private $id;
  private $tipo;

  private $saldo = 0;
  private $plus = 0;
  protected $descuento;

  public function __construct($id) {
    $this->descuento = 1;
    $this->id = $id;
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
      if(date("Y-m-d", strtotime($fecha_y_hora)) == date("Y-m-d", strtotime($this->ultimabici()))) {
        $this->viajes[] = new Viaje($transporte->tipo(), 0, $transporte, strtotime($fecha_y_hora));
        $this->boletos[] = new Boleto($this->id, $fecha_y_hora, $transporte, $this->saldo, 0, "Normal");
      }
      else{
        $this->last_bike = $fecha_y_hora;
        $this->viajes[] = new Viaje($transporte->tipo(), 12, $transporte, strtotime($fecha_y_hora));
        $this->saldo -= 12;
        $this->boletos[] = new Boleto($this->id, $fecha_y_hora, $transporte, $this->saldo, 12, "Normal");
      }
    }
    else{
      echo ("No se ha podido realizar el viaje solicitado");
    }
  }

  protected function pagarColectivo(Transporte $transporte, $fecha_y_hora) {
    $monto = 0;
    if ($this->saldo() >= 8.5 && $this->plus() == 0 || $this->descuento == 0){
      $trasbordo = $this->trasbordo($fecha_y_hora, $transporte);
      $monto = $this->costoViaje($trasbordo);

      $this->viajes[] = new Viaje($transporte->tipo(), $monto, $transporte, strtotime($fecha_y_hora));
      $this->saldo -= $monto;
      $this->boletos[] = new Boleto($this->id, $fecha_y_hora, $transporte, $this->saldo, $monto, $this->tipo);
    }
    else if($this->saldo() >= 8.5 * ($this->plus()+1)) {
      $monto = 8.5 * $this->plus();
      $trasbordo = $this->trasbordo($fecha_y_hora, $transporte);
      $monto += $this->costoViaje($trasbordo);
      
      $this->viajes[] = new Viaje($transporte->tipo(), $monto, $transporte, strtotime($fecha_y_hora));
      $this->saldo -= $monto;
      $this->boletos[] = new Boleto($this->id, $fecha_y_hora, $transporte, $this->saldo, $monto, $this->plus." Plus + ".$this->tipo);
    }
    else if ($this->saldo() < 8.5 && $this->plus() < 2){
      $this->plus += 1;
      $this->viajes[] = new Viaje($transporte->tipo(), "Plus ".$this->plus, $transporte, strtotime($fecha_y_hora));
      $this->boletos[] = new Boleto($this->id, $fecha_y_hora, $transporte, $this->saldo, 0, $this->plus." Plus");
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

  protected function costoViaje($trasbordo) {
    $costo = 0;
      $this->plus = 0;
      if ($trasbordo) {
        $costo += 2.64 * $this->descuento;
        $this->tipo = "Trasbordo";
      }
      else {
        $costo += 8.5 * $this->descuento;
        if($this->descuento == 0.5) $this->tipo = "Medio";
        else $this->tipo = "Normal";
      }
    return $costo;
  }

  protected function trasbordo($fecha_y_hora, $transporte){
    $trasbordo = FALSE;
      if (count($this->viajes) > 0 && end($this->viajes)->transporte() != $transporte && end($this->viajes)->tipo() != "Trasbordo") {
      $auxH = date("H", end($this->viajes)->tiempo());
      $auxN = date("N", end($this->viajes)->tiempo());
        if($auxH > 22 || $auxH < 6){
          if(strtotime($fecha_y_hora) - end($this->viajes)->tiempo() <= 5400)
              $trasbordo = TRUE;
        }
        else if($auxN == 6) {
          if($auxH < 22 && $auxH > 14){
            if(strtotime($fecha_y_hora) - end($this->viajes)->tiempo() <= 5400)
              $trasbordo = TRUE;
          }
          else
            if(strtotime($fecha_y_hora) - end($this->viajes)->tiempo() <= 3600)
              $trasbordo = TRUE;
        }
        else if($auxN == 7) {
          if(strtotime($fecha_y_hora) - end($this->viajes)->tiempo() <= 5400)
            $trasbordo = TRUE;
        }
        else{
          if(strtotime($fecha_y_hora) - end($this->viajes)->tiempo() <= 3600)
            $trasbordo = TRUE;
        }
      }
    return $trasbordo;
  }
}
