# API
## Métodos
### + <ins>build()</ins>
Obtiene la instancia de `Bicharengo`.

### + route($method, $uri, $handler)
Registra una ruta en la app.

**$method** `string` el verbo HTTP que manejar.  
**$uri** `string` la URI que concordar.  
**$handler** `callable` el handler que será ejecutado.

`$handler` puede ser especificado de las siguientes formas:
* Callable Simple, ex: `'nombre_funcion'`
* Callable estático, ex: `'Clase::metodo_estatico'`
* Callable Instanciado, ex: `'Clase->metodo_instancia'`

Para el caso de instancias, se instanciará la clase automaticamente antes de
llamar al método. 

### + set($key, $value)
Guarda un valor dentro de la app, este *almacenamiento* es global y solo se
mantiene durante una consulta.

**$key** `string` nombre de la key.  
**$value** `mixed` valor para guardar.  

### + get($key)
Obtiene un valor guardado en la app.

**$key** `callable` el handler que será ejecutado.

### + input($superglobal, $key, $default = null)
Obtiene `$key` de la superglobal `$superglobal` (GET, POST, REQUEST, ...) 
y si no existe devuelve `$default`.

**$superglobal** `string` superglobal que será usada.
**$key** `string` key para buscar dentro de la superglobal.
**$default** `mixed` valor por defecto en caso que `$key` no exista en 
`$superglobal`

### + run()
Pone en marcha el framework. Ejecuta el enroutedor y llama al handler 
correspondiente.


@todo implementar errores bonitos.