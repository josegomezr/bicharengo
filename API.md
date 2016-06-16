# API
## Métodos
### + <ins>instancia()</ins>
Genera la instancia de `Bicharengo`.

### + ruta($metodo, $uri, $manejador)
Registra una ruta para el enrutador.

**$metodo** `string` el verbo HTTP que manejar.  
**$uri** `string` la URI que concordar.  
**$manejador** `callable` el manejador que será ejecutado.


### + set($clave, $valor)
Guarda un valor dentro del framework, este *almacenamiento* es completamente volátil. Sólo estará disponible durante la consulta que está siendo guardado.

**$clave** `string` nombre de la clave.  
**$valor** `mixed` valor para guardar.  


### + get($clave)
Obtiene un valor guardado en el framework.

**$clave** `callable` el manejador que será ejecutado.

### + entrada($superglobal, $clave, $valor_defecto = null)
Obtiene `$clave` de las superglobal `$superglobal` 
y si no existe devuelve `$valor_defecto`.

**$superglobal** `string` superglobal que será usada. (valores posibles: GET, POST, REQUEST, SERVER, COOKIE, SERVER)
**$clave** `string` clave para buscar dentro de la superglobal.
**$valor_defecto** `mixed` valor por defecto en caso que `$clave` no exista en `$superglobal`

### + run()
Pone en marcha el framework. Ejecuta el enrutador y llama al manejador correspondiente.
Si no halla ninguno, imprime 404. 

@todo implementar errores bonitos.