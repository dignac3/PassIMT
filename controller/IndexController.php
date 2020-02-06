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
    }

    public function getLogin()
    {

        $template = $this->templater->load("login.html");

        return $template->render();
    }

    public function getRegister()
    {

        $template = $this->templater->load("register.html");

        return $template->render();
    }
}

?>