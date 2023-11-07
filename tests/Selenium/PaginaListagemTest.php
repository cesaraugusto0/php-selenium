<?php

namespace Tests\Selenium;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use PHPUnit\Framework\TestCase;
use Tests\PageObject\PaginaListagemSeries;
use Tests\PageObject\PaginaLogin;

class PaginaListagemTest extends TestCase
{
    private WebDriver $driver;

    protected function setUp(): void
    {
        $serverUrl = 'http://localhost:4444';
        $this->driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
    }
    public function testAlterarNomeDeSeriado()
    {
        // Arrange
        $paginaLogin = new PaginaLogin($this->driver);
        $paginaLogin->realizaLoginCom('cesar@exemplo.com', '123');

        $paginaListagem = new PaginaListagemSeries($this->driver);
        $paginaListagem->visita();

        // Act
        $nomeSeriadoAlterado = 'Seriado alterado';
        $idSeriado = 2;
        $paginaListagem->clicaEmEditarSerieComId($idSeriado)
            ->defineNomeDaSerieComId($idSeriado, $nomeSeriadoAlterado)
            ->finalizaEdicaoDaSerieComId($idSeriado);

        // Assert
        self::assertSame($nomeSeriadoAlterado, $paginaListagem->nomeSeriado($idSeriado));
    }

    protected function tearDown(): void
    {
        $this->driver->close();
    }
}
