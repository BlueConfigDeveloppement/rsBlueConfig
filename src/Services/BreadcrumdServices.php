<?php
namespace App\Services;

class BreadcrumdServices
{
    protected array $infoRoute = [];
    protected $infoPage;
    protected $infoTitle;

    public function createdRouteLibelle($array_pages_libelle, $nom_de_la_page = null, $title = null)
    {
        $this->infoPage = $nom_de_la_page;
        if ($array_pages_libelle) {
            $infoRoute = $this->infoRoute;
            array_push($infoRoute, $array_pages_libelle);
            $this->infoRoute = $infoRoute;
        }
        $this->infoTitle = $title;
    }

    public function createdBreadcrumbAdmin()
    {

        $html = '<div class="py-4">';
        $html .= '<nav aria-label="breadcrumb"  id="breadcrumb" class="rounded-1">';
        $html .= '<ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">';
        $html .= '<li class="breadcrumb-item"><a href="https://' . $_SERVER['SERVER_NAME'] . '/back_office"><span class="fas fa-home"></span></a></li>';
        foreach ($this->infoRoute as $route) {
            $html .= '<li class="breadcrumb-item"><a href="https://' . $_SERVER['SERVER_NAME'] . '/back_office/' . $route[0] . '">' . $route[1] . '</a></li>';
        }
        $html .= '<li class="breadcrumb-item active" aria-current="page">' . $this->infoPage . '</li>';
        $html .= '</ol>';
        $html .= '</nav>';
        $html .= '<div class="d-flex justify-content-between w-100 flex-wrap">';
        $html .= '<div class="mb-3 mb-lg-0">';
        $html .= '<h1 class="h4">' . $this->infoTitle . '</h1>';
        $html .= '<p class="mb-0"></p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return (object)[
            'html' => $html,
            'infoPage' => $this->infoPage,
            'infoTitle' => $this->infoTitle
        ];
    }

    public function createdBreadcrumbFournisseur()
    {

        $html = '<div class="breadcrump-widget my-3">';
        $html .= '<nav aria-label="breadcrumb" class="ms-5">';
        $html .= '<ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">';
        $html .= '<li class="breadcrumb-item"><a href="https://' . $_SERVER['SERVER_NAME'] . '/backoffice"><span class="fas fa-home"></span></a></li>';
        foreach ($this->infoRoute as $route) {
            $html .= '<li class="breadcrumb-item"><a href="https://' . $_SERVER['SERVER_NAME'] . '/backoffice/' . $route[0] . '">' . $route[1] . '</a></li>';
        }
        $html .= '<li class="breadcrumb-item active" aria-current="page">' . $this->infoPage . '</li>';
        $html .= '</ol>';
        $html .= '</nav>';
        $html .= '</div>';

        return (object)[
            'html' => $html,
            'infoPage' => $this->infoPage,
            'infoTitle' => $this->infoTitle
        ];
    }

    public function createdBreadcrumbFront()
    {

        $html = '<div class="p-2">';
        $html .= '<nav aria-label="breadcrumb p-0 m-0">';
        $html .= '<ol class="breadcrumb breadcrumb-dark p-0 m-0 breadcrumb-transparent">';
        $html .= '<li class="breadcrumb-item"><a href="https://' . $_SERVER['SERVER_NAME'] . '/public/"><span class="fas fa-home"></span></a></li>';
        foreach ($this->infoRoute as $route) {
            $html .= '<li class="breadcrumb-item"><a href="https://' . $_SERVER['SERVER_NAME'] . '/public/' . $route[0] . '">' . $route[1] . '</a></li>';
        }
        $html .= '<li class="breadcrumb-item active" aria-current="page">' . $this->infoPage . '</li>';
        $html .= '</ol>';
        $html .= '</nav>';
        $html .= '</div>';

        return (object)[
            'html' => $html,
            'infoPage' => $this->infoPage,
            'infoTitle' => $this->infoTitle
        ];
    }
}
