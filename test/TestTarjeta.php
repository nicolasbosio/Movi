<?php


namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {
  protected $tarjeta, $colectivo1, $colectivo2;
  public function setup(){
    $tarjeta = new Sube;
    $colectivo1 = new Colectivo("145", "Rosario Bus");
    $colectivo2 = new Colectivo("115", "Empresa Mixta de Transporte Rosario");
  }

  public function testCargaSaldo() {
    $tarjeta->recargar(272);
    $this->assertEquals($tarjeta->saldo(), 320, "Cuando cargo $272 deberia tener finalmente $320");
  }
  public function testCargaSaldo1() {
    $tarjeta->recargar(600);
    $this->assertEquals($tarjeta->saldo(), 720, "Cuando cargo $600 deberia tener finalmente $720");
  }
  public function testCargaSaldo2() {
    $tarjeta->recargar(50);
    $this->assertEquals($tarjeta->saldo(), 50, "Cuando cargo $50 deberia tener finalmente $50");
  }


  public function testPagarViaje() {
    $tarjeta->recargar(20);
    $tarjeta->pagarColectivo($colectivo1, "2016-09-27 03:12:44");
    $this->assertEquals($tarjeta->saldo(), 11.5, "Al pagar un viaje con $20, deberia quedarme $11.5")
  }

  public function testPagarViajeSinSaldo() {
    $tarjeta->pagarColectivo($colectivo1, "2016-09-27 03:12:44");
    $this->assertEquals($tarjeta->saldo(),-8.5, "Al pagar un viaje sin saldo, debería descontarme $8.5")
  }

  public function testTransbordo() {
    $tarjeta->recargar(20);
    $tarjeta->pagarColectivo($colectivo1, "2016-09-27 03:12:44");
    $tarjeta->pagarColectivo($colectivo2, "2016-09-27 04:05:44");
    $this->assertEquals($tarjeta->saldo(), 8.86, "Al pagar dos viajes(trasbordo) con $20, deberia quedarme $8.86")
  }

  public function testNoTransbordo() {
    $tarjeta->recargar(20);
    $tarjeta->pagarColectivo($colectivo1, "2016-09-27 03:12:44");
    $tarjeta->pagarColectivo($colectivo2, "2016-09-28 03:12:44");
    $this->assertEquals($tarjeta->saldo(), 3, "Al pagar dos viajes viaje con $20, deberia quedarme $3")
  }

}
