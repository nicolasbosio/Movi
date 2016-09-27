<?php

namespace Poli\Tarjeta;

require __DIR__ . '/../vendor/autoload.php';




$tarjeta = new Sube;
$tarjeta->recargar(272);
echo $tarjeta->saldo() . "\n";
$colectivo144Negro = new Colectivo("144 Negro", "Rosario Bus");
$tarjeta->pagar($colectivo144Negro, "2016/06/30 22:50");
echo $tarjeta->saldo() . "\n";
$colectivo135 = new Colectivo("135", "Rosario Bus");
$tarjeta->pagar($colectivo135, "2016/06/30 23:10");
echo $tarjeta->saldo() . "\n";
$bici = new Bici(1234);
$tarjeta->pagar($bici, "2016/07/02 08:10");
foreach ($tarjeta->viajesRealizados() as $viaje) {
  echo $viaje->tipo() . "\n";
  echo $viaje->monto() . "\n";
  echo $viaje->transporte()->nombre() . "\n";
}
