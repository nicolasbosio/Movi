<?php


namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class trasbordoTest extends TestCase {
	public function testTrasbordoNoche(){
		$tarjeta = new Sube("001");
		$colectivo1 = new Colectivo("145", "Rosario Bus");
		$colectivo1 = new Colectivo("115", "Empresa Mixta de Transporte Rosario");

		$tarjeta->recargar(20);
  		$tarjeta->pagar($colectivo1, "2016-11-10 03:12:44");
  		$tarjeta->pagar($colectivo2, "2016-11-10 04:22:44");
   		$this->assertEquals($tarjeta->saldo(), 8.86, "Al pagar dos viajes con $20, deberia quedarme $8.86");
	}
	public function testTrasbordoSabado(){
		$tarjeta = new Sube("001");
		$colectivo1 = new Colectivo("145", "Rosario Bus");
		$colectivo1 = new Colectivo("115", "Empresa Mixta de Transporte Rosario");

		$tarjeta->recargar(20);
  		$tarjeta->pagar($colectivo1, "2016-11-12 15:12:44");
  		$tarjeta->pagar($colectivo2, "2016-11-12 16:22:44");
   		$this->assertEquals($tarjeta->saldo(), 8.86, "Al pagar dos viajes con $20, deberia quedarme $8.86");
	}
	public function testNoTrasbordoSabado(){
		$tarjeta = new Sube("001");
		$colectivo1 = new Colectivo("145", "Rosario Bus");
		$colectivo1 = new Colectivo("115", "Empresa Mixta de Transporte Rosario");

		$tarjeta->recargar(20);
  		$tarjeta->pagar($colectivo1, "2016-11-12 10:12:44");
  		$tarjeta->pagar($colectivo2, "2016-11-12 11:22:44");
   		$this->assertEquals($tarjeta->saldo(), 3, "Al pagar dos viajes con $20, deberia quedarme $3");
	}
	public function testTrasbordoDomingo(){
		$tarjeta = new Sube("001");
		$colectivo1 = new Colectivo("145", "Rosario Bus");
		$colectivo1 = new Colectivo("115", "Empresa Mixta de Transporte Rosario");

		$tarjeta->recargar(20);
  		$tarjeta->pagar($colectivo1, "2016-11-13 10:12:44");
  		$tarjeta->pagar($colectivo2, "2016-11-13 11:22:44");
   		$this->assertEquals($tarjeta->saldo(), 8.86, "Al pagar dos viajes con $20, deberia quedarme $8.86");
	}
}