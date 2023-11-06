<?php

namespace Tests\Selenium;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use PHPUnit\Framework\TestCase;

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
        $inputNome = self::$driver->findElement(WebDriverBy::id('name'));
        $inputEmail = self::$driver->findElement(WebDriverBy::id('email'));
        $inputSenha = self::$driver->findElement(WebDriverBy::id('password'));

        $inputNome->sendKeys('Nome Teste');
        $inputEmail->sendKeys(md5(time()).'email@example.com');
        $inputSenha->sendKeys('123');
        $inputSenha->submit();

        self::$driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::linkText('Sair'))
        );

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
