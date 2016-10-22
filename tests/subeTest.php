<?php


namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class subeTest extends TestCase {

  public function testCargaSaldo() {
    $tarjeta = new Sube;

    $tarjeta->recargar(290);
    $this->assertEquals($tarjeta->saldo(), 340, "Cuando cargo $290 deberia tener finalmente $340");
  }

  public function testCargaSaldo1() {
    $tarjeta = new Sube;

    $tarjeta->recargar(544);
    $this->assertEquals($tarjeta->saldo(), 680, "Cuando cargo $544 deberia tener finalmente $680");
  }

  public function testCargaSaldo2() {
    $tarjeta = new Sube;

    $tarjeta->recargar(50);
    $this->assertEquals($tarjeta->saldo(), 50, "Cuando cargo $50 deberia tener finalmente $50");
  }

  public function testViajes() {
    $tarjeta = new Sube;
    $tarjeta->recargar(50);
    $colectivo1 = new Colectivo("145", "Rosario Bus");

    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    foreach ($tarjeta->viajesRealizados() as $viaje) {
      $this->assertEquals($viaje->tipo(), "colectivo", "Tipo Colectivo");
      $this->assertEquals($viaje->monto(), 8.5, "Precio del Viaje");
      $this->assertEquals($viaje->transporte()->nombre(), 145, "Nombre Colectivo");
      $this->assertEquals($viaje->tiempo(), strtotime("2016-09-27 03:12:44"), "Tiempo del Viaje");
    }
  }

  public function testCPagarViaje() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");

    $tarjeta->recargar(20);
    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $this->assertEquals($tarjeta->saldo(), 11.5, "Al pagar un viaje con $20, deberia quedarme $11.5");
  }

  public function testCPagarViajeSinSaldo() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");

    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $this->assertEquals($tarjeta->saldo(),0, "Al pagar un viaje sin saldo, no debería descontarme dinero");
    $this->assertEquals($tarjeta->plus(),1, "Al pagar un viaje sin saldo, debería sumarme un plus");
  }

  public function testCTransbordo() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");
    $colectivo2 = new Colectivo("115", "Empresa Mixta de Transporte Rosario");

    $tarjeta->recargar(20);
    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $tarjeta->pagar($colectivo2, "2016-09-27 04:05:44");
    $this->assertEquals($tarjeta->saldo(), 8.86, "Al pagar dos viajes(trasbordo) con $20, deberia quedarme $8.86");
  }

  public function testCNoTransbordo() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");
    $colectivo2 = new Colectivo("115", "Empresa Mixta de Transporte Rosario");

    $tarjeta->recargar(20);
    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $tarjeta->pagar($colectivo2, "2016-09-28 03:12:44");
    $this->assertEquals($tarjeta->saldo(), 3, "Al pagar dos viajes viaje con $20, deberia quedarme $3");
  }

  public function testCPagoPlus() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");

    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $tarjeta->recargar(20);
    $tarjeta->pagar($colectivo1, "2016-09-28 03:12:44");
    $this->assertEquals($tarjeta->saldo(), 3, "Tengo un plus, cargo tarjeta, realizo otro viaje");
  }

  public function testCPagoPlusTransbordo() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");

    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $tarjeta->recargar(20);
    $tarjeta->pagar($colectivo1, "2016-09-28 03:12:44");
    $this->assertEquals($tarjeta->saldo(), 8.86, "Tengo un plus, cargo tarjeta, realizo otro viaje");
  }

  public function testCImposibleViajar() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");

    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $tarjeta->pagar($colectivo1, "2016-09-28 03:12:44");
    $tarjeta->pagar($colectivo1, "2016-09-29 03:12:44");

    $this->expectOutputString('No se ha podido realizar el viaje solicitado');
  }

  public function testBPrimerPago() {
    $tarjeta = new Sube;
    $bici1 = new Bici("00164");
    $bici2 = new Bici("00165");
    $tarjeta->recargar(50);

    $tarjeta->pagar($bici1, "2016-09-27 03:12:44");
    $tarjeta->pagar($bici2, "2016-09-28 03:12:44");

    $this->assertEquals($tarjeta->saldo(), 25, "Pago Bici en días diferentes");
  }

  public function testBPagoMismoDia() {
    $tarjeta = new Sube;
    $bici1 = new Bici("00164");
    $bici2 = new Bici("00165");
    $tarjeta->recargar(50);

    $tarjeta->pagar($bici1, "2016-09-27 03:12:44");
    $tarjeta->pagar($bici2, "2016-09-27 04:12:44");

    $this->assertEquals($tarjeta->saldo(), 37.5, "Pago Bici en un mismo día");
  }

  public function testBImposibleViajar() {
    $tarjeta = new Sube;
    $bici1 = new Bici("00164");

    $tarjeta->pagar($bici1, "2016-09-27 03:12:44");

    $this->expectOutputString('No se ha podido realizar el viaje solicitado');
  }
}
