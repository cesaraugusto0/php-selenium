<?php

namespace Tests\Selenium;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;
use Tests\PageObject\PaginaCadastroUsuario;

class ResistroTest extends TestCase
{
    private static WebDriver $driver;

    public static function setUpBeforeClass(): void
    {
        // Arrange
        $serverUrl = 'http://localhost:4444';
        self::$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
    }

    protected function setUp(): void
    {
        self::$driver->get('http://localhost:8000/novo-usuario');        
    }

    public function testQuandoRegistrarNovoUsuarioDeveRedirecionarParaListaDeSeries()
    {
        // Act
        $paginaCadastro = new PaginaCadastroUsuario(self::$driver);
        $paginaCadastro->preencheNome('Nome Teste')
            ->preencheEmail(md5(time()).'email@example.com')
            ->preencheSenha('123')
            ->enviarFormulario();

        // Assert
        self::assertSame('http://localhost:8000/series', self::$driver->getCurrentURL());
        self::assertinstanceOf(
            RemoteWebElement::class,
            self::$driver->findElement(WebDriverBy::linkText('Sair'))
        );
    }

    public static function tearDownAfterClass(): void
    {
        self::$driver->close();
    }

}
