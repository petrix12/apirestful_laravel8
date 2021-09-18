# Aprende a crear una API RESTful con Laravel
**URL**: https://www.udemy.com/course/aprende-a-crear-una-api-restful-con-laravel

## Antes de iniciar:
1. Crear proyecto en la página de [GitHub](https://github.com) con el nombre: **apirestful_laravel8**.
    + **Description**: Proyecto para seguir el curso de Aprende a crear una API RESTful con Laravel, de Víctor Arana en Udemy
    + **Public**.
2. En la ubicación raíz del proyecto en la terminal de la máquina local:
    + $ git init
    + $ git add .
    + $ git commit -m "Commit 00: Antes de iniciar"
    + $ git branch -M main
    + $ git remote add origin https://github.com/petrix12/apirestful_laravel8.git
    + $ git push -u origin main

## Sección 01: Introducción

### Viedo 01. ¿Qué es una API RESTful?
**Contenido**: explicación de una API RESTful.
1. Commit Video 01:
    + $ git add .
    + $ git commit -m "Commit 01: ¿Qué es una API RESTful?"
    + $ git push -u origin main

### Viedo 02. Programas necesarios
1. Programas requeridos:
    + [XAMPP](https://www.apachefriends.org/es/download.html)
    + [Node Js](https://nodejs.org)
    + [Composer](https://getcomposer.org)
    + [Visual Studio Code](https://code.visualstudio.com/download)
    + [Git](https://git-scm.com/downloads)
    + [MySQL Workbench](https://dev.mysql.com/downloads/workbench)
2. Otra opción podría ser Laragon ya que instala todos los programas mencionados anteriormente:
    + [Laragon](https://laragon.org/download/index.html)
        + Laragon Full (64-bit): Apache 2.4, Nginx, MySQL 5.7, PHP 7.4, Redis, Memcached, Node.js 14, npm, git, bitmana…
3. Instalar el instalador de Laravel:
    + $ composer global require laravel/installer
4. Commit Video 02:
    + $ git add .
    + $ git commit -m "Commit 02: Programas necesarios"
    + $ git push -u origin main

### Viedo 03. Repositorio del curso
**Repositorio**: api.codersfree: https://github.com/coders-free/api.codersfree
1. Commit Video 03:
    + $ git add .
    + $ git commit -m "Commit 03: Repositorio del curso"
    + $ git push -u origin main

## Sección 02: Configuración

### Viedo 04. Creación del proyecto
**URL**: https://codersfree.com/blog/como-generar-un-dominio-local-en-windows-xampp
1. Crear proyecto para la API RESTful:
    + $ laravel new api.codersfree
2. Abrir el archivo: **C:\Windows\System32\drivers\etc\hosts** como administrador y en la parte final del archivo escribir.
	```
	127.0.0.1     api.codersfree.test
	```
3. Guardar y cerrar.
4. Abri el archivo de texto plano de configuración de Apache **C:\xampp\apache\conf\extra\httpd-vhosts.conf**.
5. Ir al final del archivo y anexar lo siguiente:
	+ Si nunca has creado un virtual host agregar:
		```conf
		<VirtualHost *>
			DocumentRoot "C:\xampp\htdocs"
			ServerName localhost
		</VirtualHost>
		```
		**Nota**: Esta estructura se agrega una única vez.
	+ Luego agregar:
		```conf
		<VirtualHost *>
			DocumentRoot "C:\xampp\htdocs\cursos\24apirestful\api.codersfree\public"
			ServerName api.codersfree.test
			<Directory "C:\xampp\htdocs\cursos\24apirestful\api.codersfree\public">
				Options All
				AllowOverride All
				Require all granted
			</Directory>
		</VirtualHost>
		```
6. Guardar y cerrar.
7. Reiniciar el servidor Apache.
    **Nota 1**: ahora podemos ejecutar nuestro proyecto local en el navegador introduciendo la siguiente dirección: http://api.codersfree.test
    **Nota 2**: En caso de que no funcione el enlace, cambiar en el archivo **C:\xampp\apache\conf\extra\httpd-vhosts.conf** todos los segmentos de código **<VirtualHost \*>** por **<VirtualHost *:80>**.
8. Commit Video 04:
    + $ git add .
    + $ git commit -m "Commit 04: Creación del proyecto"
    + $ git push -u origin main

### Viedo 05. Configurando archivo de rutas
1. Abrir el proyecto **api.codersfree**.
2. Modificar el método **boot** del provider **api.codersfree\app\Providers\RouteServiceProvider.php**:
    ```php
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('v1')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api-v1.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }
    ```
3. Renombrar el archivo de rutas **api.codersfree\routes\api.php** a **api.codersfree\routes\api-v1.php**.
4. Commit Video 05:
    + $ git add .
    + $ git commit -m "Commit 05: Configurando archivo de rutas"
    + $ git push -u origin main

### Viedo 06. Registro de usuarios



    ```php
    ***
    ```