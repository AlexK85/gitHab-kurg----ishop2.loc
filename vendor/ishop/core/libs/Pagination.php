<?php

namespace ishop\libs;


class Pagination
{

    public $currentPage;  // номер текущей страница
    public $perpage;  // знание о том, сколько записей выбирать на страницу
    public $total;  // общее количество записей. Получим из БД
    public $countPages;  // общее количество страниц, которое расчитывается исходя из $parpage и $total
    public $uri;
    // public $links = [
    //     'back' => '',  // ссылка НАЗАД
    //     'forward' => '',  // ссылка ВПЕРЁД
    //     'startpage' => '',  // ссылка В НАЧАЛО
    //     'endpage' => '',  // ссылка В КОНЕЦ
    //     'page2left' => '',  // вторая страница слева
    //     'page1left' => '',  // первая страница слева
    //     'page2right' => '',  // вторая страница справа
    //     'page1left' => '',  // первая страница справа
    // ];


    public function __construct($page, $perpage, $total)
    {
        $this->perpage = $perpage;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
        $this->uri = $this->getParams();
        // var_dump($this->uri);
    }

    // будет формировать ПАГИНАЦИЮ
    public function getHtml()
    {
        $back = null;  // ссылка НАЗАД
        $forward = null;  // ссылка ВПЕРЁД
        $startpage = null;  // ссылка В НАЧАЛО
        $endpage = null;  // ссылка В КОНЕЦ
        $page2left = null;  // вторая страница слева
        $page1left = null;  // первая страница слева
        $page2right = null;  // вторая страница справа
        $page1right = null;  // первая страница справа

        if ($this->currentPage > 1) {
            $back = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage - 1) . "'>&lt;</a></li>";
        }
        if ($this->currentPage < $this->countPages) {
            $forward = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage + 1) . "'>&gt;</a></li>";
        }
        if ($this->currentPage > 3) {
            $startpage = "<li><a class='nav-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }
        if ($this->currentPage < ($this->countPages - 2)) {
            $endpage = "<li><a class='nav-link' href='{$this->uri}page={$this->countPages}'>&raquo;</a></li>";
        }
        if ($this->currentPage - 2 > 0) {
            $page2left = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage - 2) . "'>" . ($this->currentPage - 2) . "</a></li>";
        }
        if ($this->currentPage - 1 > 0) {
            $page1left = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage - 1) . "'>" . ($this->currentPage - 1) . "</a></li>";
        }
        if ($this->currentPage + 1 <= $this->countPages) {
            $page1right = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage + 1) . "'>" . ($this->currentPage + 1) . "</a></li>";
        }
        if ($this->currentPage + 2 <= $this->countPages) {
            $page2right = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage + 2) . "'>" . ($this->currentPage + 2) . "</a></li>";
        }

        return '<ul class="pagination">' . $startpage . $back . $page2left . $page1left . '<li class="active"><a>' . $this->currentPage . '</a></li>' . $page1right . $page2right . $forward . $endpage . '</ul>';
    }


    //переведёт объект к строке
    public function __toString()
    {
        return $this->getHtml();
    }


    // получает общее количество страниц
    public function getCountPages()
    {
        return ceil($this->total / $this->perpage) ?: 1;
    }

    // получает текущую страницу
    public function getCurrentPage($page)
    {
        if (!$page || $page < 1) $page = 1;
        if ($page > $this->countPages) $page = $this->countPages;
        return $page;
    }

    public function getStart()
    {
        // берём номер текущей страницы вычитае от него 1 и умножаем $perpage
        return ($this->currentPage - 1) * $this->perpage;
    }

    // получает свойство $uri 
    public function getParams()
    {
        $url = $_SERVER['REQUEST_URI'];

        // выполним глобальный поиск в строке
        preg_match_all("#filter=[\d,&]#", $url, $matches);
        // если количество элементов массива больше чем 1 
        if (count($matches[0]) > 1) {
            $url = preg_replace("#filter=[\d,&]+#", "", $url, 1);
        }

        // нужны явные GET параметры. Разобьём строку на ? знаки
        $url = explode('?', $url);
        // debug($url);
        $uri = $url[0] . '?';
        if (isset($url[1]) && $url[1] != '') {
            $params = explode('&',  $url[1]);
            // debug($params); 
            foreach ($params as $param) {
                if (!preg_match("#page=#", $param)) $uri .= "{$param}&amp;";
            }
        }
        return urldecode($uri);
    }
}
