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
        echo json_encode($request);

        echo "test";

        /* $passwordService = new PasswordService($this->mysqli);
      $data = $passwordService->createPassword(1, 'Github', 'Guitoons', '16');
      echo $data; */

        //$template = $this->templater->load("login.html");

        //return $template->render();
    }

}

?>