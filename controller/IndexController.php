<?php

include dirname(__FILE__).'/../model/services/UserService.php';
include dirname(__FILE__).'/../model/services/PasswordService.php';
include dirname(__FILE__).'/../model/connection.php';

class IndexController
{

    private $mysqli;
    private $templater;

    /**
     * IndexController constructor.
     * @param $templater
     */
    public function __construct($templater)
    {
        $this->templater = $templater;
        $this->mysqli = getConnection();
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

    public function getRegister() {
        $template = $this->templater->load("register.html");

        return $template->render();

    }

    public function postRegister($request)
    {
        $userService = new UserService($this->mysqli);
        $created = $userService->register($request['i_email'], $request['i_pwd']);

        if ($created) {
            $template = $this->templater->load("login.html");
            return $template->render(['created' => $created]);
        } else {
            $template = $this->templater->load("register.html");
            return $template->render(['error' => true]);
        }

    }

}

?>