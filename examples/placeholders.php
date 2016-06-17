<?php 

require('../vendor/autoload.php');

$app = Bicharengo::build();


function hello_hdl($app)
{
    $segments = $app->get('uri_segments');

    echo "You're looking for php file: " . $segments[0];
}

$app->route('GET', ':any:.php', 'hello_hdl');

$app->run();