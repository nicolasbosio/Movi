<?php


namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

  public function testCargaSaldo() {
    $tarjeta = new Sube;
    $tarjeta->recargar(272);
    $this->assertEquals($tarjeta->saldo(), 320, "Cuando cargo 272 deberia tener finalmente 320");
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
