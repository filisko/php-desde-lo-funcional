<?php

require_once __DIR__.'/../vendor/autoload.php';

class Limon
{
    public bool $estaLimpio = false;
    public bool $estaPelado = false;
}

$sieteLimons = [
    new Limon(),
    new Limon(),
    new Limon(),
    new Limon(),
    new Limon(),
    new Limon(),
    new Limon(),
];


$limpiar = function(Limon $limon): Limon {
    $limonLimpiado = clone $limon;
    $limonLimpiado->estaLimpio = true;
    return $limonLimpiado;
};

$pelar = function(Limon $limon): Limon {
    $limonPelado = clone $limon;
    $limonPelado->estaPelado = true;
    return $limonPelado;
};

function compose(callable $a, callable $b) {
    return function($arg) use($a, $b) {
        return $b($a($arg));
    };
};

class Jugo
{
    public function __construct(private int $cantidad) {}

    public function cantidad(): int
    {
        return $this->cantidad;
    }

    public static function vacio(): self
    {
        return new self(0);
    }
}

$exprimir = function(Limon $unLimon): Jugo {
    return new Jugo(50);
};

$limpiarYpelar = compose($limpiar, $pelar);
$limpiarYpelarYexprimir = compose($limpiarYpelar, $exprimir);

// D. pero Dawid.. ahora tenemos un problema! tenemos jugos por separado
$jugosPorSeparado = array_map($limpiarYpelarYexprimir, $sieteLimons);

// D. Perooo... cómo junto ahora... Jugo, con Jugo para que me devuelva otro Jugo!???
//$todoElJugo = 'limon 1' . 'limon 2';

$sumarJugos = fn(Jugo $j1, Jugo $j2): Jugo => new Jugo(
    cantidad: $j1->cantidad() + $j2->cantidad()
);

$todoElJugo = array_reduce(
    $jugosPorSeparado,
    fn(Jugo $jugoAcumulado, Jugo $jugo) => $sumarJugos($jugoAcumulado, $jugo),
    Jugo::vacio()
);


class Limonada
{
    public Jugo $base;
    public Agua $agua;
    public bool $tieneAzucar = false;
    public int $cubosHielo = 0;
    public bool $hierbaBuena = false;

    public function __construct(Jugo $base, bool $tieneAzucar, int $cubosHielo, bool $hierbaBuena)
    {
        $this->agua = new Agua(cantidad: 100);
        $this->base = $base;
        $this->tieneAzucar = $tieneAzucar;
        $this->cubosHielo = $cubosHielo;
        $this->hierbaBuena = $hierbaBuena;
    }
}

class Agua
{
    public function __construct(private int $cantidad) {}

    public function cantidad(): int
    {
        return $this->cantidad;
    }
}

var_dump(new Limonada($todoElJugo, false, 2, true));
//echo "limón limpiado y pelado" . PHP_EOL;
