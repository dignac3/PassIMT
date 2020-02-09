<?php

include dirname(__FILE__).'/../model/services/UserService.php';
include dirname(__FILE__).'/../model/services/PasswordService.php';
include dirname(__FILE__).'/../model/connection.php';

class IndexController
{

    private $mysqli;
    private $userService;
    private $passwordService;
    private $templater;

    /**
     * IndexController constructor.
     * @param $templater
     */
    public function __construct($templater)
    {
        $this->templater = $templater;
        $this->mysqli = getConnection();
        $this->userService = new UserService($this->mysqli);
        $this->passwordService = new PasswordService($this->mysqli);
    }


    public function getIndex()
    {

        $template = $this->templater->load("index.php");

        return $template->render();
    }

    public function getLogin()
    {

        $template = $this->templater->load("login.php");

        return $template->render();
    }

    public function postLogin($request) {
        $connected = 0;
        $uuid = bin2hex(random_bytes(16));
        $data  = $this->userService->login($request['i_email'], $request['i_pwd']);
        $granted = $data['authenticated'];

        if ($granted) {
            $connected = $this->userService->updateUUID($uuid, $request['i_email']);

            $_SESSION["session_id"] = $uuid;
        }


        if ($connected) {
            $this->templater->addGlobal('session', $_SESSION);
            $template = $this->templater->load("index.php");
            return $template->render(['connected' => $connected]);
        } else {
            $template = $this->templater->load("login.php");
            return $template->render(['connected' => false]);
        }
    }

    public function getRegister() {
        $template = $this->templater->load("register.php");

        return $template->render();

    }

    public function postRegister($request)
    {
        $created = $this->userService->register($request['i_email'], $request['i_pwd']);

        if ($created) {
            $template = $this->templater->load("login.php");
            return $template->render(['created' => $created]);
        } else {
            $template = $this->templater->load("register.php");
            return $template->render(['error' => true]);
        }

    }

    public function getPasswordList()
    {
        $passwords = $this->passwordService->getPasswords(1);
        $template = $this->templater->load("list_passwords.php");
        return $template->render(['passwords' => $passwords]);
    }

    public function getPasswordForm() {
        $template = $this->templater->load("add_password.html");
        return $template->render();
    }

    public function postPassword($request) {
        $this->passwordService->createPassword(1, $_POST['i_label'], $_POST['i_login'], $_POST['i_password']);
        $template = $this->templater->load("index.php");
        return $template->render();
    }
}

?>