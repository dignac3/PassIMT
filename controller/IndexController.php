<?php

class IndexController
{

    private $templater;

    /**
     * IndexController constructor.
     * @param $templater
     */
    public function __construct($templater)
    {
        $this->templater = $templater;
    }


    public function getIndex()
    {


        $template = $this->templater->load("index.html");

        return $template->render();

//        //$template = $this->twig->load("index.html");
//
//        //return $template->render();
//
//        return <<<HTML
//<h1>LOL</h1>
//HTML;

    }
}

?>