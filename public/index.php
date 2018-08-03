<?php

require ('../bootstrap/app.php');

require ('../routes/Routes.php');

$route = $router->getView($_GET['pg']);

require_once ($route);
