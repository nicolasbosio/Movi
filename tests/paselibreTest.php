<?php


namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class paselibreTest extends TestCase {

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

  public function testPagarViaje() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");

    $tarjeta->recargar(20);
    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $this->assertEquals($tarjeta->saldo(), 20, "Al pagar un viaje con $20, deberia quedarme $20");
  }

  public function testPagarViajeSinSaldo() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");

    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $this->assertEquals($tarjeta->saldo(),0, "Al pagar un viaje sin saldo, no me debería descontar");
  }

  public function testTransbordo() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");
    $colectivo2 = new Colectivo("115", "Empresa Mixta de Transporte Rosario");

    $tarjeta->recargar(20);
    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $tarjeta->pagar($colectivo2, "2016-09-27 04:05:44");
    $this->assertEquals($tarjeta->saldo(), 20, "Al pagar dos viajes(trasbordo) con $20, deberia quedarme $20");
  }

  public function testNoTransbordo() {
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");
    $colectivo2 = new Colectivo("115", "Empresa Mixta de Transporte Rosario");

    $tarjeta->recargar(20);
    $tarjeta->pagar($colectivo1, "2016-09-27 03:12:44");
    $tarjeta->pagar($colectivo2, "2016-09-28 03:12:44");
    $this->assertEquals($tarjeta->saldo(), 20, "Al pagar dos viajes viaje con $20, deberia quedarme $20");
  }

}