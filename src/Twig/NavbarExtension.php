<?php


namespace App\Twig;


use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavbarExtension extends AbstractExtension
{
    private Environment $twig;

    public function __construct(Environment $twig){

        $this->twig = $twig;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('navbarAdmin', [$this, 'getNavbarAdmin'], ['is_safe' => ['html']]),
            new TwigFunction('navbarFront', [$this, 'getNavbarFront'], ['is_safe' => ['html']])
        ];
    }

    public function getNavbarAdmin(){

        return $this->twig->render('partials/_navbarAdmin.html.twig');
    }
    public function getNavbarFront(){

        return $this->twig->render('partials/_navbarFront.html.twig');

    }
}