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
1. Commit Nota 03:
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
1. Abrir el proyecto **api.codersfree**.
2. Eliminar la ruta **auth:sanctum** del archivo de rutas **api.codersfree\routes\api-v1.php**.
3. Crear el controlador para registrar a los usuarios **RegisterController**:
    + $ php artisan make:controller Api/RegisterController
4. Crear ruta para el registro en el archivo de rutas **api.codersfree\routes\api-v1.php**:
    ```php
    Route::post('register', [RegisterController::class, 'store'])->name('api.v1.register');
    ```
    Importar la definición del controlador **RegisterController**:
    ```php
    use App\Http\Controllers\Api\RegisterController;
    ```
5. Crear el método **store** en el controlador **api.codersfree\app\Http\Controllers\Api\RegisterController.php**:
    ```php
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::create($request->all());
        return response($user, 200);
    }
    ```
    Importar la definición del controlador **User**:
    ```php
    use App\Models\User;
    ```
6. Crear la base de datos **api.codersfree** en nuestro adiministrador de bases de datos.
7. Ejecutar las migraciones:
    + $ php artisan migrate
8. Realizar petición http para probar endpoint:
    + Método: POST
    + URL: http://api.codersfree.test/v1/register
    + Body:
        + Form:
            + Field name: name                      | Value: Pedro Bazó
            + Field name: email                     | Value: bazo.pedro@gmail.com
            + Field name: password                  | Value: 12345678
            + Field name: password_confirmation     | Value: 12345678
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe enviar el registro a la tabla **users**.
9. Commit Video 06:
    + $ git add .
    + $ git commit -m "Commit 06: Registro de usuarios"
    + $ git push -u origin main

## Sección 3: Estructura del proyecto

### Viedo 07. Maquetar la bbdd
1. Crear un nuevo modelo y un nuevo diagrama para el proyecto **api.restful** en MySQL Workbench.
2. Guardar el archivo como **api.codersfree\api.restful.mwb**.
3. Crear la entidad **categories** con los campos:
    + id
    + name
    + slug
4. Crear la entidad **posts** con los campos:
    + id
    + name
    + slug
    + extract
    + body
    + status
5. Crear la entidad **users** con los campos:
    + id
    + name
    + email
    + password
6. Crear la entidad **tags** con los campos:
    + id
    + name
    + slug
7. Generar relación 1:n entre **categories** y **posts**.
8. Generar relación 1:n entre **users** y **posts**.
9. Crear tabla **post_tag** para generar una relación de n:m entre **posts** y **tags**.
10. Generar relación 1:n entre **posts** y **post_tag**.
11. Generar relación 1:m entre **tags** y **post_tag**.
12. Renombrar todas las llaves foráneas para seguir las convenciones de Laravel.
13. Commit Video 07:
    + $ git add .
    + $ git commit -m "Commit 07: Registro de usuarios"
    + $ git push -u origin main

### Viedo 08. Crear el modelo físcio
1. Crear tabla **image** en el diagrama **api.codersfree\api.restful.mwb** con los campos:
    + id
    + url
    + imageable_id
    + imageable_type
2. Abrir el proyecto **api.codersfree**.
3. Crear el modelo **Category** con sus migraciones:
    + $ php artisan make:model Category -m
4. Modificar el método **up** de la migración **api.codersfree\database\migrations\2021_09_18_202750_create_categories_table.php**:
    ```php
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
    }
    ```
5. Crear el modelo **Post** con sus migraciones:
    + $ php artisan make:model Post -m  
6. Modificar el método **up** de la migración **api.codersfree\database\migrations\2021_09_18_221132_create_posts_table.php**:
    ```php
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('extract');
            $table->longText('body');
            $table->enum('status', [Post::BORRADOR, Post::PUBLICADO])->default(Post::BORRADOR);
            /* $table->unsignedBigInteger('category_id'); */
            /* $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); */
            // Esta instrucción equivale a las dos comentadas anteriormente
            // Ya que estamos siguiendo las convenciones de Laravel
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    ```
    Importar la definición del modelo **Post**:
    ```php
    use App\Models\Post;
    ```
7. Definir las constantes BORRADOR y PUBLICADO en el modelo **api.codersfree\app\Models\Post.php**:
    ```php
    ≡
    class Post extends Model
    {
        ≡
        const BORRADOR = 1;
        const PUBLICADO = 2;
    }
    ```
8. Crear el modelo **Tag** con sus migraciones:
    + $ php artisan make:model Tag -m  
9. Modificar el método **up** de la migración **api.codersfree\database\migrations\2021_09_18_221132_create_posts_table.php**:
    ```php
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
    }
    ```
10. Crear la migración para la tabla pivote (intermedia) **post_tag**:
    + $ php artisan make:migration create_post_tag_table
11. Modificar el método **up** de la migración **api.codersfree\database\migrations\2021_09_18_223511_create_post_tag_table.php**:
    ```php
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    ```
12. Crear el modelo **Image** con sus migraciones:
    + $ php artisan make:model Image -m  
13. Modificar el método **up** de la migración **api.codersfree\database\migrations\2021_09_18_223833_create_images_table.php**:
    ```php
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            /* $table->unsignedBigInteger('imageable_id'); */
            /* $table->string('imageable_type'); */
            // Esta instrucción equivale a las dos comentadas anteriormente
            // Ya que estamos siguiendo las convenciones de Laravel           
            $table->morphs('imageable');
            $table->timestamps();
        });
    }
    ```
14. Reestablecer la base de datos **api.restful**:
    + $ php artisan migrate:fresh
15. Commit Video 08:
    + $ git add .
    + $ git commit -m "Commit 08: Crear el modelo físcio"
    + $ git push -u origin main

### Viedo 09. Generando relaciones
### Viedo 10. Introducir datos falsos
### Viedo 11. Solucionando posible error con faker
### Viedo 12. Generando endpoints para categorias

    ≡
    ```php
    ***
    ```

## Peticiones http que puede responder el proyecto api.restful:
1. Registrar un usuario:
    + Método: POST
    + URL: http://api.codersfree.test/v1/register
    + Body:
        + Form:
            + Field name: name                      | Value: Pedro Bazó
            + Field name: email                     | Value: bazo.pedro@gmail.com
            + Field name: password                  | Value: 12345678
            + Field name: password_confirmation     | Value: 12345678
    + Headers:
        + Header: Accept    | Value: application/json