<?php

namespace Tests\PageObject;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;

class PaginaCadastroUsuario
{
    private WebDriver $driver;

    function __construct(WebDriver $driver)
    {
        $this->driver = $driver;
    }

    public function preencheNome(string $nome): self
    {
        $this->driver->findElement(WebDriverBy::id('name'))->sendKeys($nome);
        return $this;
    }

    public function preencheEmail(string $email): self
    {
        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys($email);
        return $this;
    }

    public function preencheSenha(string $senha): self
    {
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys($senha);
        return $this;
    }
    
    public function enviarFormulario(): void
    {
        $this->driver
            ->findElement(WebDriverBy::cssSelector('button[type="submit"]'))
            ->click();
    }

}
