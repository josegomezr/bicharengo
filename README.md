# bicharengo
PHP Micro-framework compatible con php >= 5.2

## [API](API.md)

## Uso

```php
<?php 

require('../vendor/autoload.php');

$vaina = Bicharengo::instancia();

function manejador_ab($app)
{
    echo $app->entrada('get', 'a', 'no hay naida');
}

$vaina->ruta('GET', '/ab', 'manejador_ab');

$vaina->run();