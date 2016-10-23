<?php

namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class boletoTest extends TestCase {
	
	public function testBoleto(){
		$colectivo1 = new Colectivo("145", "Rosario Bus");
		$a = new Boleto("001", "2016-09-27 03:12:44", $colectivo1, 20, 8.5, "Normal");

		$this->assertEquals($a->id(), "001", "Id tarjeta");
		$this->assertEquals($a->fecha(), "2016-09-27 03:12:44", "Fecha del boleto");
		$this->assertEquals($a->transporte(), "145", "Numero del colectivo");
		$this->assertEquals($a->saldo(), 20, "Saldo que figura en el boleto");
		$this->assertEquals($a->monto(), 8.5, "Monto del viaje");
		$this->assertEquals($a->tipo(), "Normal", "Tipo del viaje del boleto");
	}
}