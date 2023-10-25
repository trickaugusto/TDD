<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Service\Avaliador;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private static $leiloeiro;

    /**
     * Esse método executa primeiro de tudo, é basicamente um constructor
     */
    public function setUp(): void
    {
        self::$leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public static function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        self::$leiloeiro->avalia($leilao);

        $maiorValor = self::$leiloeiro->getMaiorValor();
        self::assertEquals(2500, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public static function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        self::$leiloeiro->avalia($leilao);

        $menorValor = self::$leiloeiro->getMenorValor();
        self::assertEquals(1700, $menorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public static function testAvaliadorDeveBuscarOsTresMaioresValores(Leilao $leilao)
    {
        self::$leiloeiro->avalia($leilao);

        $maiores = self::$leiloeiro->getMaioresLances();
        static::assertCount(3, $maiores);
        static::assertEquals(2500, $maiores[0]->getValor());
        static::assertEquals(2000, $maiores[1]->getValor());
        static::assertEquals(1700, $maiores[2]->getValor());
    }

    /** ------------------------ DATA PROVIDERS ------------------------ */
    public static function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Fiat 147');

        $maria = new Usuario('Maria');
        $joao = new Usuario('joao');
        $ana = new Usuario('ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            'ordem-crescente' => [
                $leilao
            ]
        ];
    }

    public static function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat 147');

        $maria = new Usuario('Maria');
        $joao = new Usuario('joao');
        $ana = new Usuario('ana');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return [
            'ordem-decrescente' => [
                $leilao
            ]
        ];
    }

    public static function leilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Fiat 147');

        $maria = new Usuario('Maria');
        $joao = new Usuario('joao');
        $ana = new Usuario('ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));

        return [
            'ordem-aleatoria' => [
                $leilao
            ]
        ];
    }
}
