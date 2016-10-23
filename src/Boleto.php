<?php

namespace Poli\Tarjeta;

class Boleto{

	private $id;
	private $fecha_y_hora;
	private $transporte;
	private $saldo;
	private $monto;
	private $tipo;

	public function __construct($id, $fecha_y_hora, Transporte $transporte, $saldo, $monto, $tipo) {
		$this->id = $id;
		$this->fecha_y_hora = $fecha_y_hora;
		$this->transporte = $transporte;
		$this->saldo = $saldo;
		$this->monto = $monto;
		$this->tipo = $tipo;
	}

	public function id() {
		return $this->id;
	}

	public function fecha() {
		return $this->fecha_y_hora;
	}

	public function transporte() {
		return $this->transporte->nombre();
	}

	public function saldo() {
		return $this->saldo;
	}

	public function monto() {
		return $this->monto;
	}

	public function tipo() {
		return $this->tipo;
	}
}