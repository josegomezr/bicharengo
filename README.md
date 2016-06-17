# bicharengo
PHP Micro-framework compatible con php >= 5.2

## [API](API.md)

## Uso

```php
<?php 

require('../vendor/autoload.php');

$vaina = Bicharengo::build();

function home_hdl($app)
{
    echo 'home!';
}

class Greater{
    public function hello_foo($app)
    {
        $name = $app->input('get', 'name', 'foo');
        echo 'Hello ' . $name . '!';
    }

    public static function hello_static ($app){
        $name = $app->input('get', 'name', 'foo');
        echo 'STATIC HELLO: ' . $name . '!!!';
    } 
}


$vaina->route('GET', '/', 'home_hdl');
$vaina->route('GET', '/hello', 'Greater->hello_foo');
$vaina->route('GET', '/static_hello', 'Greater::hello_static');

$vaina->run();