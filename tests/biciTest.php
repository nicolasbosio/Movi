<?php


namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class biciTest extends TestCase {
	public function testNombre(){
		$a = new Bici("00164");

		$this->assertEquals($a->Nombre(), "00164", "La patente de la bici es 00164");
	}
}