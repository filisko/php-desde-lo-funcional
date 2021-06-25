<?php

require_once __DIR__.'/../vendor/autoload.php';

// D: si hablamos sobre los limones estamos ya muy cerca de la limonada,
// a lo mejor está fría, es decir, muy bien resfriada con el verano andaluz!
// F: valee! pero no hablamos de programación? no me cuadra nada!
// D: ay! es verdad, pero es cierto que desde una buena limonada en verano estamos
// ya muy cerca de esto! habia un buen libro sobre un musico muy famoso, que se mudó a sierra alpujarra a jubilarse
// F: (filis muestra la cara del libro con la pantalla ya compartida)
// D: ay! este este, oye, tienes un parser de PHP y hacemos un par de funciones?
// F: claroo! mira, ya incluso tenemos algunos capitulos del libro dentro de la memoria

// D: perfe, pero antes de esto, creamos una clase Limon con una property,
// bueno, con dos! un esta limpio y esta pelado, y los dos booleans.

class Limon
{
    public bool $estaLimpio = false;
    public bool $estaPelado = false;
}

// D: vale, muy bien! bueno, pues ahora creamos una lista con 7 limones y las limpiamos y pelamos para hacer una buena limonada!

$sieteLimones = [
    new Limon(),
    new Limon(),
    new Limon(),
    new Limon(),
    new Limon(),
    new Limon(),
    new Limon(),
];

// F: vale, perfecto, pues ahora voy a coger y las voy a limpiar y las voy a pelar
//foreach ($sieteLimones as $unLimon) {
//    $unLimon->estaLimpio = true;
//    $unLimon->estaPelado = true;
//
////    echo 'limon limpio y pelado! ';
//}

// F: listo!
// D: hmmm, y este foreach qué hace? ah, vale vale! limpia y pela, no?
// F: cooorrecto! los dejo limpios y pelados, para la limonada!!
// D: hmm, interesante! esto se llama un efecto secundario que nos puede eventualmente traer estados incorrectos, además si estuviesemos tu y yo en la cocina pelando limones y por cada limon q terminamos se lo decimos a nuetra abuela... seria un coñazo! q te parece si en vez de dar x saco a la abuela cuando todavia no hay limonada, la avisamos cuando esté listo!
// F: hmmm, no te entiendo.
// D: como q coño no me entiendes!
// D: si usamos funciones de primer orden con funciones de orden superior conseguimos resultados finales sin tener q molestar a nadie!
// F: vamos a ello!

//$limpiar = function(Limon $unLimon): Limon {
//    $unLimon->estaLimpio = true;
//    return $unLimon;
//};
//
//$pelar = function(Limon $unLimon): Limon {
//    $unLimon->estaPelado = true;
//    return $unLimon;
//};
//
//$limonesLimpiados = array_map($limpiar, $sieteLimones);
//$limonesPeladosYlimpios = array_map($pelar, $limonesLimpiados);

// D: ah mira! estamos copiando un patrón que se puede extraer, no? entonces imagínate si hubiese una opción de olvidar semi-resultados de cada una de nuestras funciones y componerlas para obtener el resultado final.
// F: es verdad! así ahorramos no solo memoria en ordenador sino también ahorramos escribir tanto.
// D: exacto! esto se llama operador de composición de funciones


//$limpiar = function(Limon $unLimon): Limon {
//    $limonPelado = clone $unLimon;
//    $limonPelado->estaLimpio = true;
//    return $limonPelado;
//};
//
//$pelar = function(Limon $unLimon): Limon {
//    $limonPelado = clone $unLimon;
//    $limonPelado->estaPelado = true;
//    return $limonPelado;
//};
//
//$compose = function(callable $a, callable $b) {
//    return function($args) use($a, $b) {
//        return $b($a($args));
//    };
//};
//
//$limpiarYpelar = $compose($limpiar, $pelar);
//
//$limonesLimpiosYpelados = array_map($limpiarYpelar, $sieteLimones);

// D: esto ya, no sólo tiene una buena pinta, pero es un pintazo de su semantica que te dice claramente
// que esta haciendo, además con immutability hemos ganado un estado correcto en cada tiempo del applicacion -
//  aseguramos que entre la ejecucion entre una funcion y la otra no existe ningun intermediario que nos podria calentar cabeza con sus engaños del estado en cualquier momento - que no quieremos esto!!!


// F: Dawid pero requredas que todavía tenemos este libro en una variable en memoría
// D: Que sí, Filis, pero antes de esto, sería lo suyo monstrar librarias del PHP que estan
// dando esta funcionalidad out of the box
// F: Tú refieres al funcionalidad del compose y otras funciones del order superior?
// D: exacto

// estamos monstrando una lib concreta
// utlizamos ella para conseguir, filter, reduce, fold, map, count,


// puntos extensiónes
// p. function application y

//D: pero Filis, esos limones están sucios!!! te has olivado de la pandemia?? hay q limpiar los limones con agua!! de momento lo q veo q nuestro mecanismo de limpieza es un poco cutre,

$limpiar = function(Limon $unLimon): Limon {
    $limonPelado = clone $unLimon;
    $limonPelado->estaLimpio = true;
    return $limonPelado;
};

// funciones de primer orden
$pelar = function(Limon $unLimon): Limon {
    $limonPelado = clone $unLimon;
    $limonPelado->estaPelado = true;
    return $limonPelado;
};

// funcion de super order - combinador
// F: bueno, vamos a crear un combinador que nos permite componer dos funciones que para el caso, solo acepta un parametro, pero que nos sirve y ademas es muy simple.
function componer(callable $a, callable $b) {
    return function($parametro) use($a, $b) {
        return $b($a($parametro));
    };
};

// F: filis comenta version alterativa adhoc, esto es una función lambda que compone limpiar y pelar en una sola función pero no la ejecuta. Además en php8 nos ahorramos todo ese boilerplate que teniamos en php7.
//$limpiarYpelarAdHoc = fn(Limon $elLimon) => $pelar($limpiar($elLimon));
//$limpiarYpelarAdHoc = function(Limon $elLimon) use($pelar, $limpiar) {
//    return $pelar($limpiar($elLimon));
//};

$limpiarYpelar = componer($limpiar, $pelar);

// F: bueno Dawid, hemos limpiado y peleado, y ahora... lo vamos a exprimir??
// D: ¡Hombre! si queremos limonada, hay que darlo!

interface Unidad {};
final class Mililitro implements Unidad {};



$exprimir = function(Limon $unLimon): Jugo {
    return new Jugo(50, new Mililitro());
};

$limpiarYpelarYexprimir = componer($limpiarYpelar, $exprimir);

// ejeucion
$jugos = array_map($limpiarYpelarYexprimir, $sieteLimones);

$sumarJugos = fn(Jugo $j1, Jugo $j2): Jugo => new Jugo(
    cantidad: $j1->cantidad() + $j2->cantidad(),
    unidad:   $j1->unidad()
);

$todoElJugoDelLimones = array_reduce(
    $jugos,
    fn(Jugo $jugoAcumulado, Jugo $jugo) => $sumarJugos($jugoAcumulado, $jugo),
    Jugo::vacio(new Mililitro())
);

// F: ¿Quieres azúcar? D: noooo!
// F : Y hielo
// D : pues los dos cubos , porfa
// F: y hierba D: queee sí

$limonada = new Limonada(
    base: $todoElJugoDelLimones,
    tieneAzucar :false,
    cubosHielo : 2,
    hierbaBuena : true
);
var_dump($limonada);

// FIN.


abstract class Liquido
{
    private int $cantidad;
    private Unidad $unidad;

    public function __construct(int $cantidad, Unidad $unidad)
    {
        $this->cantidad = $cantidad;
        $this->unidad = $unidad;
    }

    public function cantidad(): int
    {
        return $this->cantidad;
    }

    public function unidad(): Unidad
    {
        return $this->unidad;
    }

    public static function vacio(Unidad $unidad): self // F: Dawid, y Monoid este ?
    {
        return new static(0, $unidad);
    }
}
final class Agua extends Liquido {}
final class Jugo extends Liquido {}


class Limonada
{
    public Jugo $base;
    public Agua $agua;
    public bool $tieneAzucar = false;
    public int $cubosHielo = 0;
    public bool $hierbaBuena = false;

    public function __construct(Jugo $base, bool $tieneAzucar, int $cubosHielo, bool $hierbaBuena)
    {
        $this->agua = new Agua(cantidad: 100, unidad: new Mililitro());
        $this->base = $base;
        $this->tieneAzucar = $tieneAzucar;
        $this->cubosHielo = $cubosHielo;
        $this->hierbaBuena = $hierbaBuena;
    }
}

