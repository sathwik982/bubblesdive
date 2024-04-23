<?php
require_once '../app/action/action.php';
require_once '../app/controllers/auth.php';

$action = new Action($_POST);

/*********** */
// only for the post request, cannot load views,can only redirect in the controllers
// models does not exists
// this is not a framework, it was built here for better file organisation only
// *********

//            action   ,  class   , methodname
// $action->run(action, [class,  methodname]); ------>>>>>>   Example
$action->run('login', [new Auth(), 'login']);
$action->run('logout', [new Auth(), 'logout']);
