<?php


namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

  public function testCargaSaldo() {
    $tarjeta = new Sube;
    $tarjeta->recargar(272);
    $this->assertEquals($tarjeta->saldo(), 320, "Cuando cargo 272 deberia tener finalmente 320");
  }
  public function testCargaSaldo1() {
    $tarjeta = new Sube;
    $tarjeta->recargar(600);
    $this->assertEquals($tarjeta->saldo(), 720, "Cuando cargo 600 deberia tener finalmente 720");
  }
  public function testCargaSaldo2() {
    $tarjeta = new Sube;
    $tarjeta->recargar(50);
    $this->assertEquals($tarjeta->saldo(), 50, "Cuando cargo 50 deberia tener finalmente 50");
  }


  public function testPagarViaje() {

  }

  public function testPagarViajeSinSaldo() {

  }

  public function testTransbordo() {

  }

  public function testNoTransbordo() {

  }

}
