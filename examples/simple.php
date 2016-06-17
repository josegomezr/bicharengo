<?php 

require('../vendor/autoload.php');

$app = Bicharengo::build();

function home_hdl($app)
{
    echo 'home!';
}

$app->route('GET', '/', 'home_hdl');

$app->run();