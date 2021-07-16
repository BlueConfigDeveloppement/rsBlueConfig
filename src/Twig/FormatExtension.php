<?php


namespace App\Twig;


use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormatExtension extends AbstractExtension
{
    private Environment $twig;

    public function __construct(Environment $twig){

        $this->twig = $twig;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('telephone', [$this, 'telephone'], ['is_safe' => ['html']]),
            new TwigFunction('link', [$this, 'link'], ['is_safe' => ['html']]),
        ];
    }

    private function telFormat($tel){

        $str = '+33'. $tel;
        return $str;
    }
    private function telFormatTwig($tel){

        $str = '0'. $tel;
        $res = substr($str, 0, 2) .' ';
        $res .= substr($str, 2, 2) .' ';
        $res .= substr($str, 4, 2) .' ';
        $res .= substr($str, 6, 2) .' ';
        $res .= substr($str, 8, 2) .' ';
        $res .= substr($str, 10, 2) .' ';
        return $res;
    }
    public function telephone($tel){
        if($tel) {
            $vue = $this->telFormatTwig($tel);
            $data = $this->telFormat($tel);
            $res = "<a href='tel:$data'>$vue</a>";
        }else{
            $res = "<span title='Non Disponible'>N.D.</span>";
        }
        return $res;
    }
//    public function link($link, $action, $id = null){
////        <a href="{{ path('user_profil_show', {'id': user_profil.id}) }}">show</a>
//
//        $dataLink = "{{ path($link)}} ";
//        $html = "<a href='{{path(test)}}' class='btn btn-primary'>";
//        $html .= 'test';
//        $html .= '</a>';
//        return $html;
//    }
}