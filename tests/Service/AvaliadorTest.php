<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Service\Avaliador;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    /** @var Avaliador */
    private $leiloeiro;

    /**
     * Esse método executa primeiro de tudo, é basicamente um constructor
     */
    public function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();
        $this->assertEquals(2500, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();
        $this->assertEquals(1700, $menorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public function testAvaliadorDeveBuscarOsTresMaioresValores(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getMaioresLances();
        $this->assertCount(3, $maiores);
        $this->assertEquals(2500, $maiores[0]->getValor());
        $this->assertEquals(2000, $maiores[1]->getValor());
        $this->assertEquals(1700, $maiores[2]->getValor());
    }

    public function testLeilaoVazioNaoPodeSerAvaliado()
    {
        $leilao = new Leilao('Fusca Azul');
        
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Não é possível avaliar um leilão vazio');

        $this->leiloeiro->avalia($leilao);
    }

    public function testLeilaoFinalizadoNaoPodeSerAvaliado() 
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Leilão já finalizado');

        $leilao = new Leilao('Fusca Azul');
        $leilao->recebeLance(new Lance(new Usuario('Teste'), 2000));
        $leilao->finaliza();

        $this->leiloeiro->avalia($leilao);
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
