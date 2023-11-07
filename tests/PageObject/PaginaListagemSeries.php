<?php

namespace Tests\PageObject;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class PaginaListagemSeries
{
    private WebDriver $driver;

    public function __construct(WebDriver $driver)
    {
        $this->driver = $driver;
    }

    public function visita(): self
    {
        $this->driver->get('http://localhost:8000/series');

        return $this;
    }

    public function titulo():string
    {
        return $this->driver
            ->findElement(WebDriverBy::tagName('h1'))
            ->getText();
    }

    public function clicaEmEditarSerieComId(int $idSeriado): self
    {
        $elementoLi = $this->driver->findElement(WebDriverBy::cssSelector("li[data-serie-id='$idSeriado'"));
        $elementoLi->findElement(WebDriverBy::cssSelector('button.btn-info'))->click();

        return $this;
    }

    public function defineNomeDaSerieComId(int $idSeriado, string $nomeSeriadoAlterado): self
    {
        $elementoLi = $this->driver->findElement(WebDriverBy::cssSelector("li[data-serie-id='$idSeriado'"));
        $elementoLi->findElement(WebDriverBy::cssSelector("#input-nome-serie-$idSeriado input"))
            ->clear()
            ->sendKeys($nomeSeriadoAlterado);

        return $this;
    }

    public function finalizaEdicaoDaSerieComId(int $idSeriado): void
    {
        $elementoLi = $this->driver->findElement(WebDriverBy::cssSelector("li[data-serie-id='$idSeriado'"));
        $elementoLi->findElement(WebDriverBy::cssSelector("#input-nome-serie-$idSeriado button"))->click();
    }

    public function nomeSeriado(int $idSeriado)
    {
        $nomeSeriadoLocator = WebDriverBy::id("nome-serie-$idSeriado");
        $elementoNomeSeriado = $this->driver->findElement($nomeSeriadoLocator);
        $this->driver->wait()->until(
            WebDriverExpectedCondition::visibilityOf($elementoNomeSeriado)
        );

        return $elementoNomeSeriado->getText();
    }
}
