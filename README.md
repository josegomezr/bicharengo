# bicharengo
PHP Micro-framework compatible con php >= 5.2

## Uso

```php
<?php 

require('../vendor/autoload.php');

$vaina = Bicharengo::instance();

function handler_get_ab($app)
{
    echo $app->entrada('get', 'a', 'no hay naida');
}

$vaina->ruta('GET', '/ab', 'handler_get_ab');

$vaina->run();