<?php

include dirname(__FILE__).'/../model/services/UserService.php';
include dirname(__FILE__).'/../model/services/PasswordService.php';
include dirname(__FILE__).'/../model/connection.php';

$mysqli = getConnection();

$userService = new UserService($mysqli);
$data = $userService->getUsers();

while ($obj = $data->fetch_object()) {
    printf("Label => %s, Password => (%s)\n", $obj->mail, $obj->master_password);
}

$passwordService = new PasswordService($mysqli);
$data = $passwordService->getPasswords(1);

while ($obj = $data->fetch_object()) {
    printf("Label => %s, Password => (%s)\n", $obj->label, $obj->password);
}

