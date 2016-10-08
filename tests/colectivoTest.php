<?php


namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class colectivoTest extends TestCase {
	public function testNombre(){
		$a = new Colectivo("145", "Rosario Bus");

		$this->assertEquals($a->Nombre(), "145", "El nombre del colectivo creado es 145");
	}
}
