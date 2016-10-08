<?php

namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class viajeTest extends TestCase {
	public function testFuncionesViaje(){
		$colectivo1 = new Colectivo("145", "Rosario Bus");

		$a = new Viaje($colectivo1->tipo, 8.5, $colectivo1, "2016-09-27 03:12:44");

		$this->assertEquals($a->tipo(), "colectivo", "es un colectivo");
		$this->assertEquals($a->monto(), "8.5", "el monto del viaje es 8.5");
		$this->assertEquals($a->transporte(), $colectivo1, "un 145 de Rosario Bus");
		$this->assertEquals($a->tiempo(), "2016-09-27 03:12:44", "el viaje se efectuo a las 2016-09-27 03:12:44");
	}
}