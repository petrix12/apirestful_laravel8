# Aprende a crear una API RESTful con Laravel
+ **URL Curso**: https://www.udemy.com/course/aprende-a-crear-una-api-restful-con-laravel
+ **URL Repositorio API**: https://github.com/coders-free/api.codersfree
+ **URL Repositorio Cliente**: https://github.com/coders-free/cliente1
+ **URL Repositorio General**: https://github.com/petrix12/apirestful_laravel8

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
+ **Contenido**: explicación de una API RESTful.
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
+ **Repositorio**: api.codersfree: https://github.com/coders-free/api.codersfree
1. Commit Nota 03:
    + $ git add .
    + $ git commit -m "Commit 03: Repositorio del curso"
    + $ git push -u origin main

## Sección 02: Configuración

### Viedo 04. Creación del proyecto
+ **URL**: https://codersfree.com/blog/como-generar-un-dominio-local-en-windows-xampp
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
		+ **Nota**: Esta estructura se agrega una única vez.
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
    + **Nota 1**: ahora podemos ejecutar nuestro proyecto local en el navegador introduciendo la siguiente dirección: http://api.codersfree.test
    + **Nota 2**: En caso de que no funcione el enlace, cambiar en el archivo **C:\xampp\apache\conf\extra\httpd-vhosts.conf** todos los segmentos de código **<VirtualHost \*>** por **<VirtualHost *:80>**.
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
            $table->string('slug')->unique();
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
            $table->string('slug')->unique();
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
            $table->string('slug')->unique();
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
14. Reestablecer la base de datos **api.codersfree**:
    + $ php artisan migrate:fresh
15. Commit Video 08:
    + $ git add .
    + $ git commit -m "Commit 08: Crear el modelo físcio"
    + $ git push -u origin main

### Viedo 09. Generando relaciones
1. Abrir el proyecto **api.codersfree**.
2. Implementar relaciones en el modelo **api.codersfree\app\Models\User.php**:
    ```php
    ≡
    class User extends Authenticatable
    {
        ≡
        // Relación 1:n entre **users** y **posts**
        public function posts(){
            return $this->hasMany(Post::class);
        }
    }
    ```
3. Implementar relaciones en el modelo **api.codersfree\app\Models\Category.php**:
    ```php
    ≡
    class Category extends Model
    {
        ≡
        // Relación 1:n entre **categories** y **posts**
        public function posts(){
            return $this->hasMany(Post::class);
        }
    }
    ```
4. Implementar relaciones en el modelo **api.codersfree\app\Models\Post.php**:
    ```php
    ≡
    class Post extends Model
    {
        ≡
        // Relación 1:n entre **users** y **posts** (inversa)
        public function user(){
            return $this->belongsTo(User::class);
        }

        // Relación 1:n entre **categories** y **posts** (inversa)
        public function category(){
            return $this->belongsTo(Category::class);
        }

        // Relación n:m entre **posts** y **tags**
        public function tags(){
            return $this->belongsToMany(Tag::class);
        }
    
        // Relación 1:n polimorfica 1:n entre **posts** y **images**
        public function images(){
            return $this->morphMany(Image::class, 'imageable');
        }
    }
    ```
5. Implementar relaciones en el modelo **api.codersfree\app\Models\Tag.php**:
    ```php
    ≡
    class Tag extends Model
    {
        ≡
        // Relación n:m entre **tags** y **posts**
        public function posts(){
            return $this->belongsToMany(Post::class);
        }
    }
    ```
6. Implementar relaciones en el modelo **api.codersfree\app\Models\Image.php**:
    ```php
    ≡
    class Image extends Model
    {
        ≡
        // Relación polimórfica entre **images** y otros modelos
        // El nombre de la función debe coincidir con el de su migración
        public function imageable(){
            return $this->morphTo();
        }
    }
    ```
7. Commit Video 09:
    + $ git add .
    + $ git commit -m "Commit 09: Generando relaciones"
    + $ git push -u origin main

### Viedo 10. Introducir datos falsos
1. Abrir el proyecto **api.codersfree**.
2. Crear factory para los modelos **Category**, **Post**, **Tag** e **Image**:
    + $ php artisan make:factory CategoryFactory
    + $ php artisan make:factory PostFactory
    + $ php artisan make:factory TagFactory
    + $ php artisan make:factory ImageFactory
3. Implementar el método **definition** del factory **api.codersfree\database\factories\CategoryFactory.php**:
    ```php
    public function definition()
    {
        $name = $this->faker->unique()->word(20);
        return [
            'name' => $name,
            'slug' => Str::slug($name)
        ];
    }
    ```
    Importar la definición de **Str**:
    ```php
    use Illuminate\Support\Str;
    ```
4. Implementar el método **definition** del factory **api.codersfree\database\factories\PostFactory.php**:
    ```php
    public function definition()
    {
        $name = $this->faker->unique()->word(20);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'extract' => $this->faker->text(250),
            'body' => $this->faker->text(2000),
            'status' => $this->faker->randomElement([Post::BORRADOR, Post::PUBLICADO]),
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id
        ];
    }
    ```
    Importar las definiciones de **Str** y de los modelos **Category** y **User**:
    ```php
    use App\Models\Category;
    use App\Models\User;
    use Illuminate\Support\Str;
    ```
5. Implementar el método **definition** del factory **api.codersfree\database\factories\TagFactory.php**:
    ```php
    public function definition()
    {
        $name = $this->faker->unique()->word(20);
        return [
            'name' => $name,
            'slug' => Str::slug($name)
        ];
    }
    ```
    Importar la definición de **Str**:
    ```php
    use Illuminate\Support\Str;
    ```
6. Implementar el método **definition** del factory **api.codersfree\database\factories\ImageFactory.php**:
    ```php
    public function definition()
    {
        return [
            'url' => 'posts/' . $this->faker->image('public/storage/posts', 640, 480, null, false)
        ];
    }
    ```
    Importar la definición de **Str**:
    ```php
    use Illuminate\Support\Str;
    ```
7. Modificar el valor de la siguiente variable de entorno del archivo **api.codersfree\\.env**:
    ```
    FILESYSTEM_DRIVER=public
    ```
8. Generar acceso directo a **api.codersfree\storage\app\public**:
    + $ php artisan storage:link
9.  Crear los seeders **UserSeeder** y **PostSeeder**:
    + $ php artisan make:seeder UserSeeder
    + $ php artisan make:seeder PostSeeder
10. Implementar el método **run** del seeder **api.codersfree\database\seeders\UserSeeder.php**:
    ```php
    public function run()
    {
        $user = User::create([
            'name' => 'Pedro Bazó',
            'email' => 'bazo.pedro@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        User::factory(99)->create();
    }
    ```
    Importar la definición del modelo **User**:
    ```php
    use App\Models\User;
    ```
11. Implementar el método **run** del seeder **api.codersfree\database\seeders\PostSeeder.php**:
    ```php
    public function run()
    {
        Post::factory(100)->create()->each(function(Post $post){
            Image::factory(4)->create([
                'imageable_id' => $post->id,
                'imageable_type' => Post::class
            ]);

            $post->tags()->attach([
                rand(1, 4),
                rand(5, 8)
            ]);
        });
    }
    ```
    Importar la definición de los modelos **Image** y **Post**:
    ```php
    use App\Models\Image;
    use App\Models\Post;
    ```
12. Implementar el método **run** del seeder **api.codersfree\database\seeders\DatabaseSeeder.php**:
    ```php
    public function run()
    {
        Storage::deleteDirectory('posts');
        Storage::makeDirectory('posts');

        $this->call(UserSeeder::class);

        Category::factory(4)->create();
        Tag::factory(8)->create();

        $this->call(PostSeeder::class);
    }
    ```
    Importar la definición de los modelos **Category** y **Tag** y el facade **Storage**:
    ```php
    use App\Models\Category;
    use App\Models\Tag;
    use Illuminate\Support\Facades\Storage;
    ```
13. Reestablecer la base de datos **api.codersfree** y ejecutar los seeders:
    + $ php artisan migrate:fresh --seed
14. Commit Video 10:
    + $ git add .
    + $ git commit -m "Video 10: Introducir datos falsos"
    + $ git push -u origin main

### Viedo 11. Solucionando posible error con faker
1. Modificar el método **image** del provider **api.codersfree\vendor\fakerphp\faker\src\Faker\Provider\Image.php**:
    ```php
    public static function image(
        ≡
    ) {
        ≡
        if (function_exists('curl_exec')) {
            ≡
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    // Nueva línea
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // Nueva línea
            ≡
        } elseif (ini_get('allow_url_fopen')) {
            ≡
        } else {
            ≡
        }
        ≡
    }
    ```
2. Commit Video 11:
    + $ git add .
    + $ git commit -m "Video 11: Solucionando posible error con faker"
    + $ git push -u origin main

### Viedo 12. Generando endpoints para categorias
1. Crear controlador **CategoryController** con todos los métodos necesarios para administrarlo:
    + $ php artisan make:controller Api\CategoryController --api --model=Category
2. Modificar el archivo de rutas **api.codersfree\routes\api-v1.php** para administrar las rutas del modelo **Category**:
    ```php
    /* Route::get('categories', [CategoryController::class, 'index'])->name('api.v1.categories.index'); */
    /* Route::post('categories', [CategoryController::class, 'store'])->name('api.v1.categories.store'); */
    /* Route::get('categories/{category}', [CategoryController::class, 'show'])->name('api.v1.categories.show'); */
    /* Route::put('categories/{category}', [CategoryController::class, 'update'])->name('api.v1.categories.update'); */
    /* Route::delete('categories/{category}', [CategoryController::class, 'delete'])->name('api.v1.categories.delete'); */
    // Esta isntrucción equivale a las 5 comentadas anteriormente
    Route::apiResource('categories', CategoryController::class)->names('api.v1.categories');
    ```
    Importar la definición del controlador CategoryController:
    ```php
    use App\Http\Controllers\Api\CategoryController;
    ```
3. Commit Video 12:
    + $ git add .
    + $ git commit -m "Video 12: Generando endpoints para categorias"
    + $ git push -u origin main

## Sección 4: Query Scopes

### Viedo 13. Recibir peticiones y generar respuestas para el recurso Category
1. Abrir el proyecto **api.codersfree**.
2. Implementar el método **index** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }
    ```
3. Implementar el método **store** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories',
        ]);
        $category = Category::create($request->all());
        return $category;
    }
    ```
4. Habilitar la asignación masiva en el modelo **api.codersfree\app\Models\Category.php**:
    ```php
    ≡
    class Category extends Model
    {
        use HasFactory;

        protected $fillable = ['name', 'slug'];
        ≡
    }
    ```
5. Realizar petición http para probar endpoint:
    + Método: GET
    + URL: http://api.codersfree.test/v1/categories
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe mostrar todos los registros a la tabla **categories**.
6. Realizar petición http para probar endpoint:
    + Método: POST
    + URL: http://api.codersfree.test/v1/categories
    + Body:
        + Form:
            + Field name: name  | Value: Categoría de prueba
            + Field name: slug  | Value: categoria-de-prueba
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe enviar el registro a la tabla **categories**.
7. Implementar el método **show** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function show(Category $category)
    {
        return $category;
    }
    ```
8. Realizar petición http para probar endpoint:
    + Método: GET
    + URL: http://api.codersfree.test/v1/categories/5
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe mostrar el registro con **id** = 5 de la tabla **categories**.
9. Implementar el método **update** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' . $category->id
        ]);
        $category->update($request->all());
        return $category;
    }
    ```
10. Realizar petición http para probar endpoint:
    + Método: PUT
    + URL: http://api.codersfree.test/v1/categories/5
    + Body:
        + Form-encode:
            + Field name: name  | Value: Categoría de prueba actualizada
            + Field name: slug  | Value: categoria-de-prueba-actualizada
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe actualizar el registro de la tabla **categories** con **id** = 5.
11. Implementar el método **destroy** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function destroy(Category $category)
    {
        $category->delete();
        return $category;
    }
    ```
12. Realizar petición http para probar endpoint:
    + Método: DELETE
    + URL: http://api.codersfree.test/v1/categories/5
        + Header: Accept    | Value: application/json
    + Acción: Debe eliminar el registro de la tabla **categories** con **id** = 5.
13. Commit Video 13:
    + $ git add .
    + $ git commit -m "Video 13: Recibir peticiones y generar respuestas para el recurso Category"
    + $ git push -u origin main

### Viedo 14. Incluir relaciones de los recursos
1. Modificar el método **show** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function show($id)
    {
        $category = Category::included()->findOrFail($id);

        // return CategoryResource::make($category);
        return $category;
    }
    ```
2. Crear el método Query Scope **scopeIncluded** en el modelo **api.codersfree\app\Models\Category.php**:
    ```php
    public function scopeIncluded(Builder $query){
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included')); //['posts','relacion2']
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }
        $query->with($relations);
    }
    ```
    Definir variable **allowIncluded** en la clase **Category**:
    ```php
    protected $allowIncluded = ['posts', 'posts.user'];
    ```
    Importar la definición de la clase **Builder**:
    ```php
    use Illuminate\Database\Eloquent\Builder;
    ```
3. Realizar petición http para probar endpoint:
    + Método: GET
    + URL: http://api.codersfree.test/v1/categories/1?included=posts
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe mostrar el registro con **id** = 1 de la tabla **categories** y su relación con los registros de la tabla **posts**.
4. Realizar petición http para probar endpoint:
    + Método: GET
    + URL: http://api.codersfree.test/v1/categories/1?included=posts.user
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe mostrar el registro con **id** = 1 de la tabla **categories** y su relación con los registros de la tabla **posts** y el usuario de la tabla **users** relacionado con el post.
5. Commit Video 14:
    + $ git add .
    + $ git commit -m "Video 14: Incluir relaciones de los recursos"
    + $ git push -u origin main

### Viedo 15. Filtrar recursos
1. Modificar el método **index** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function index()
    {
        $categories = Category::included()
                        ->filter()
                        ->get();
        return $categories;
    }
    ```
2. Crear el método Query Scope **scopeFilter** en el modelo **api.codersfree\app\Models\Category.php**:
    ```php
    public function scopeFilter(Builder $query){
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE' , '%' . $value . '%');
            }
        }
    }
    ```
    Definir variable **allowFilter** en la clase **Category**:
    ```php
    protected $allowFilter = ['id', 'name', 'slug'];
    ```
3. Realizar petición http para probar endpoint:
    + Método: GET
    + URL: http://api.codersfree.test/v1/categories?filter[name]=ne&filter[slug]=e
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe mostrar los registro de la tabla **categories** que contengan en el campo **name** el texto 'ne' y en el campo **slug** la letra 'n'.
4. Commit Video 15:
    + $ git add .
    + $ git commit -m "Video 15: Filtrar recursos"
    + $ git push -u origin main

### Viedo 16. Ordenar recursos
1. Modificar el método **index** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function index()
    {
        $categories = Category::included()
                        ->filter()
                        ->sort()
                        ->get();
        return $categories;
    }
    ```
2. Crear el método Query Scope **scopeSort** en el modelo **api.codersfree\app\Models\Category.php**:
    ```php
    public function scopeSort(Builder $query){
        if (empty($this->allowSort) || empty(request('sort'))) {
            return;
        }

        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach ($sortFields as $sortField) {
            
            $direction = 'asc';

            if (substr($sortField, 0, 1) == '-') {
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }

            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }
    ```
    Definir variable **allowSort** en la clase **Category**:
    ```php
    protected $allowSort = ['id', 'name', 'slug'];
    ```
3. Realizar petición http para probar endpoint:
    + Método: GET
    + URL: http://api.codersfree.test/v1/categories?sort=-name,id
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe ordenar los registro de la tabla **categories** por el campo **name** en forma descendente y luego por el campo **id** en forma ascendente. 
4. Commit Video 16:
    + $ git add .
    + $ git commit -m "Video 16: Ordenar recursos"
    + $ git push -u origin main

### Viedo 17. Paginar recursos
1. Modificar el método **index** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function index()
    {
        $categories = Category::included()
                        ->filter()
                        ->sort()
                        ->getOrPaginate();
        return $categories;
    }
    ```
2. Crear el método Query Scope **scopeGetOrPaginate** en el modelo **api.codersfree\app\Models\Category.php**:
    ```php
    public function scopeGetOrPaginate(Builder $query){
        if (request('perPage')) {
            $perPage = intval(request('perPage'));
            if ($perPage) {
                return $query->paginate($perPage);
            }
        }
        return $query->get();
    }
    ```
3. Realizar petición http para probar endpoint:
    + Método: GET
    + URL: http://api.codersfree.test/v1/categories?perPage=3&page=2
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe mostrar los registro de la tabla **categories** paginados de 3 en 3 y posicionado en la página 2.
4. Commit Video 17:
    + $ git add .
    + $ git commit -m "Video 17: Paginar recursos"
    + $ git push -u origin main

## Sección 5: Transformar respuestas

### Viedo 18. Crear clase de recurso
1. Crear el recurso **CategoryResource**:
    + $ php artisan make:resource CategoryResource
2. Modificar el método **show** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function show($id)
    {
        $category = Category::included()->findOrFail($id);
        return CategoryResource::make($category);
    }
    ```
    Importar la definición del recuros **CategoryResource**:
    ```php
    use App\Http\Resources\CategoryResource;
    ```
3. Redefinir el método **toArray** del recurso **api.codersfree\app\Http\Resources\CategoryResource.php**:
    ```php
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'posts' => PostResource::collection($this->whenLoaded('posts'))
        ];
    }
    ```
    Importar la definición del recurso **PostResource**:
    ```php
    use App\Http\Resources\PostResource;
    ```
4. Redefinir el método **index** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    public function index()
    {
        $categories = Category::included()
                        ->filter()
                        ->sort()
                        ->getOrPaginate();
        return CategoryResource::collection($categories);
    }
    ```
5. Crear el recurso **PostResource**:
    + $ php artisan make:resource PostResource
6. Redefinir el método **toArray** del recurso **api.codersfree\app\Http\Resources\PostResource.php**:
    ```php
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'extract' => $this->extract,
            'body' => $this->body,
            'status' => $this->status == 1 ? 'BORRADOR' : 'PUBLICADO',
            'user' => UserResource::make($this->whenLoaded('user')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
        ];
    }
    ```
7. Crear el recurso **UserResource**:
    + $ php artisan make:resource UserResource
8. Commit Video 18:
    + $ git add .
    + $ git commit -m "Video 18: Crear clase de recurso"
    + $ git push -u origin main

## Sección 6: Recurso Posts

### Viedo 19. Ampliar la funcionalidad con los query scopes con traits de PHP
1. Crear el trait **api.codersfree\app\Traits\ApiTrait.php**:
    ```php
    <?php

    namespace App\Traits;

    use Illuminate\Database\Eloquent\Builder;

    trait ApiTrait{
        public function scopeIncluded(Builder $query){
            if (empty($this->allowIncluded) || empty(request('included'))) {
                return;
            }

            $relations = explode(',', request('included')); //['posts','relacion2']
            $allowIncluded = collect($this->allowIncluded);

            foreach ($relations as $key => $relationship) {
                if (!$allowIncluded->contains($relationship)) {
                    unset($relations[$key]);
                }
            }
            $query->with($relations);
        }

        public function scopeFilter(Builder $query){
            if (empty($this->allowFilter) || empty(request('filter'))) {
                return;
            }

            $filters = request('filter');
            $allowFilter = collect($this->allowFilter);

            foreach ($filters as $filter => $value) {
                if ($allowFilter->contains($filter)) {
                    $query->where($filter, 'LIKE' , '%' . $value . '%');
                }
            }
        }

        public function scopeSort(Builder $query){
            if (empty($this->allowSort) || empty(request('sort'))) {
                return;
            }

            $sortFields = explode(',', request('sort'));
            $allowSort = collect($this->allowSort);

            foreach ($sortFields as $sortField) {
                
                $direction = 'asc';

                if (substr($sortField, 0, 1) == '-') {
                    $direction = 'desc';
                    $sortField = substr($sortField, 1);
                }

                if ($allowSort->contains($sortField)) {
                    $query->orderBy($sortField, $direction);
                }
            }
        }

        public function scopeGetOrPaginate(Builder $query){
            if (request('perPage')) {
                $perPage = intval(request('perPage'));
                if ($perPage) {
                    return $query->paginate($perPage);
                }
            }
            return $query->get();
        }    
    }
    ```
2. Eliminar todos los scope del modelo **api.codersfree\app\Models\Category.php** y la definición de **Builder**, y en su lugar llamar al trait **ApiTrait**:
    ```php
    <?php

    namespace App\Models;

    use App\Traits\ApiTrait;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Category extends Model
    {
        use HasFactory, ApiTrait;

        protected $fillable = ['name', 'slug'];

        protected $allowIncluded = ['posts', 'posts.user'];
        protected $allowFilter = ['id', 'name', 'slug'];
        protected $allowSort = ['id', 'name', 'slug'];

        // Relación 1:n entre **categories** y **posts**
        public function posts(){
            return $this->hasMany(Post::class);
        }
    }
    ```
3. Importar la definición y el uso del trait ApiTrait en los modelos **Image**, **Post**, **Tag** y **User**:
    ```php
     <?php

    namespace App\Models;

    use App\Traits\ApiTrait;
    ≡
    class {MODELO} extends Model
    {
        use ..., ApiTrait;

        ≡
    }
    ```
4. Modificar los métodos **store**, **update** y **destroy** del controlador **api.codersfree\app\Http\Controllers\Api\CategoryController.php**:
    ```php
    ≡
    class CategoryController extends Controller
    {
        ≡
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|max:255',
                'slug' => 'required|max:255|unique:categories',
            ]);
            $category = Category::create($request->all());

            return CategoryResource::make($category);
        }
        ≡
        public function update(Request $request, Category $category)
        {
            $request->validate([
                'name' => 'required|max:255',
                'slug' => 'required|max:255|unique:categories,slug,' . $category->id
            ]);

            $category->update($request->all());

            return CategoryResource::make($category);
        }
        ≡
        public function destroy(Category $category)
        {
            $category->delete();
            return CategoryResource::make($category);
        }
    }
    ```
5. Commit Video 19:
    + $ git add .
    + $ git commit -m "Video 19: Ampliar la funcionalidad con los query scopes con traits de PHP"
    + $ git push -u origin main

### Viedo 20. Recibir peticiones y generar respuestas para el recurso Post
1. Crear el controlador **PostController**:
    + $ php artisan make:controller Api\PostController --api --model=Post
2. Crar las rutas para **posts** en el archivo de rutas **api.codersfree\routes\api-v1.php**:
    ```php
    Route::apiResource('posts', PostController::class)->names('api.v1.posts');
    ```
    Importar la definición del controlador **dddd**:
    ```php
    use App\Http\Controllers\Api\PostController;
    ```
3. Definir el método **index** del controlador **api.codersfree\app\Http\Controllers\Api\PostController.php**:
    ```php
    public function index()
    {
        $posts = Post::included()
                        ->filter()
                        ->sort()
                        ->getOrPaginate();
        return PostResource::collection($posts);
    }
    ```
    Importar la definición del recurso **PostResource**:
    ```php
    use App\Http\Resources\PostResource;
    ```
4. Realizar petición http para probar endpoint:
    + Método: GET
    + URL: http://api.codersfree.test/v1/posts
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe mostrar los registro de la tabla **posts**.
5. Definir el método **store** del controlador **api.codersfree\app\Http\Controllers\Api\PostController.php**:
    ```php
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts',
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id'
        ]);
        $post = Post::create($request->all());
        return PostResource::make($post);
    }
    ```
6. Habilitar asignación masiva en el modelo **api.codersfree\app\Models\Post.php**:
    ```php
    ≡
    class Post extends Model
    {
        ≡
        const BORRADOR = 1;
        const PUBLICADO = 2;

        protected $fillable = ['name', 'slug', 'extract', 'body', 'status', 'category_id', 'user_id'];
        ≡
    }
    ```
7. Realizar petición http para probar endpoint:
    + Método: POST
    + URL: http://api.codersfree.test/v1/posts
    + Body:
        + Form:
            + Field name: name          | Value: Título de prueba
            + Field name: slug          | Value: titulo-de-prueba
            + Field name: extract       | Value: Cualquier cosa
            + Field name: body          | Value: Cualquier cosa
            + Field name: category_id   | Value: 1
            + Field name: user_id       | Value: 1
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe registrar un post en la tabla **posts**.
8. Definir el método **show** del controlador **api.codersfree\app\Http\Controllers\Api\PostController.php**:
    ```php
     public function show($id)
    {
        $post = Post::included()->findOrFail($id);
        return PostResource::make($post);
    }
    ```
9. Realizar petición http para probar endpoint:
    + Método: GET
    + URL: http://api.codersfree.test/v1/posts/2
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe mostrar el registro de la tabla **posts** con **id** = 2.
10. Definir el método **update** del controlador **api.codersfree\app\Http\Controllers\Api\PostController.php**:
    ```php
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts,slug,' . $post->id,
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id'
        ]);
        $post->update($request->all());
        return PostResource::make($post);
    }
    ```
11. Definir el método **destroy** del controlador **api.codersfree\app\Http\Controllers\Api\PostController.php**:
    ```php
    public function destroy(Post $post)
    {
        $post->delete();
        return PostResource::make($post);
    }
    ```
12. Commit Video 20:
    + $ git add .
    + $ git commit -m "Video 20: Recibir peticiones y generar respuestas para el recurso Post"
    + $ git push -u origin main

## Sección 7: Laravel Passport

### Viedo 21. Instalar Laravel Passport
1. Redefinir el método **store** del controlador **api.codersfree\app\Http\Controllers\Api\PostController.php**:
    ```php
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts',
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);
        $user = auth()->user();
        $data['user_id'] =  $user->id;
        $post = Post::create($data);
        return PostResource::make($post);
    }
    ```
2. Crear el método constructo **__construct** en el controlador **api.codersfree\app\Http\Controllers\Api\PostController.php**:
    ```php
    public function __construct(){
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    ```
3. Instalar Laravel Passport:
    **URL instalación**: https://laravel.com/docs/8.x/passport
    + $ composer require laravel/passport
    + $ php artisan migrate
    + $ php artisan passport:install --uuids
        + In order to finish configuring client UUIDs, we need to rebuild the Passport database tables. Would you like to rollback and re-run your last migration? (yes/no) [no]: **yes**
        + Recuperar:
            ```
            Personal access client created successfully.
            Client ID: 94716146-8579-4e6f-afcc-29b2da6d125c
            Client secret: zR4WpKIHlUs7tWYDS9bo1zmIey0DxMgmSR3qslAk
            Password grant client created successfully.
            Client ID: 94716146-8d96-4e4f-9125-8e8a1d05ada0
            Client secret: ySeMR1eQaPMLzU1ZcU5ivy9iqcEob3iTzqTC5Cvr
            ```
    + $ php artisan migrate:fresh --seed
4. Modificar el modelo **api.codersfree\app\Models\User.php**:
    ```php
    ≡
    //use Laravel\Sanctum\HasApiTokens;
    use Laravel\Passport\HasApiTokens;

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable, ApiTrait;
        ≡
    }
    ```
5. Modificar el provider **api.codersfree\app\Providers\AuthServiceProvider.php**:
    ```php
    ≡
    use Laravel\Passport\Passport;

    class AuthServiceProvider extends ServiceProvider
    {
        ≡
        public function boot()
        {
            $this->registerPolicies();
            Passport::routes();
        }
    }
    ```
    **Nota**: para ver todas las ruta generadas por passport:
    + $ php artisan r:l --name=passport
6. Modificar el archivo de configuración **api.codersfree\config\auth.php**:
    ```php
    ≡
    'guards' => [
        ≡

        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
            'hash' => false,
        ],
    ],
    ≡
    ```
7. Commit Video 21:
    + $ git add .
    + $ git commit -m "Video 21: Instalar Laravel Passport"
    + $ git push -u origin main

### Viedo 22. Instalar Laravel Passport II
1. Formas de obtener las llaves en producción:
    1. Ejecutar en producción:
       + $ php artisan passport:keys
    2. Públicar el archivo de configuración de passport:
       + $ php artisan vendor:publish --tag=passport-config
       + Este comando creará el archivo de configuración **api.codersfree\config\passport.php**.
       + Agragar las siguientes variables de entorno en **api.codersfree\\.env**:
            ```
            PASSPORT_PRIVATE_KEY="{Contenido del archivo: api.codersfree\storage\oauth-private.key}"
            PASSPORT_PUBLIC_KEY="{Contenido del archivo: api.codersfree\storage\oauth-public.key}"
            ```
2. Commit Video 22:
    + $ git add .
    + $ git commit -m "Video 22: Instalar Laravel Passport II"
    + $ git push -u origin main

## Sección 8: Password grant client

### Viedo 23. Solicitar un acces token desde postman
1. Abrir proyecto **api.codersfree**.
2. Crear cliente tipo password:
    + $ php artisan passport:client --password
        + What should we name the password grant client? [Laravel Password Grant Client]: > [Presionar ENTER]
        + Which user provider should this client use to retrieve users? [users]:
            [0] users
            > [Presionar ENTER]
        + Recuperar las credenciales:
            ```
            Password grant client created successfully.
            Client ID: 94717435-7f73-4d1a-a9e2-0b88b0401377
            Client secret: 5yo9JZN2W8kA9JVkvQE8KymeI48uBfm3F7ipLGXr
            ```
3. Realizar petición http para probar endpoint:
    + Método: POST
    + URL: http://api.codersfree.test/oauth/token
    + Body:
        + Form:
            + Field name: grant_type    | Value: password
            + Field name: client_id     | Value: 94717435-7f73-4d1a-a9e2-0b88b0401377
            + Field name: client_secret | Value: 5yo9JZN2W8kA9JVkvQE8KymeI48uBfm3F7ipLGXr
            + Field name: username      | Value: bazo.pedro@gmail.com
            + Field name: password      | Value: 12345678
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Obtiene un token para el usuario que corresponde con el campo **email** = bazo.pedro@gmail.com de la tabla **users**.
    + Respuesta en formato JSON:
        ```json
        {
            "token_type": "Bearer",
            "expires_in": 31536000,
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NDcxNzQzNS03ZjczLTRkMWEtYTllMi0wYjg4YjA0MDEzNzciLCJqdGkiOiJmMDBiZGYzOTFmNTIxMmU4ODUxNjQ0MGJlZGViNmYzMmE1NTVlN2JiMTBlZmY4ODcxZGNlZjkwYzllMjA4ZGFhODdiZGEyMzc0Y2RmZGJjYyIsImlhdCI6MTYzMjE1MTA5MS4xNDM2ODYsIm5iZiI6MTYzMjE1MTA5MS4xNDM2OTEsImV4cCI6MTY2MzY4NzA5MS4xMTUzNzMsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.vghu8oPHHRayzHvzdc5zoIxjnGcnbEx9Tj79Cff71fafTW2IMCN0D-p5hESciYCBe2DmgeAbj-DaQmflBSEe3ips9agV1SJ9Mlm81MfpqtQ5pDS9VndLTof4Wgf99vdPv82tqpXx5914fxEYrp6pB6mSfDkotzJFRFohGoyGXl8I7UIFWO7Bz6qr5I8amo_nqigxhLQKHH8fJb_UpwzqZlppIf-K28gWv_MaaBGIjRguFV3U8uRZ71IBc87r8hRU1ax98_9WoWv-ahN1dUQC2tCzZY2t4rR-cWo7Jatfzx6jN7_opOSKQs_FpBdq9vImz1i7FlooBbQRWhEVqED3LTjlj8vlTMOFnEvhhg5s8y2fwqcOhsWLW3uwLX47NLVvVE18VbGmeBACkwo6k8Oh7wDMqtSId_jp4ifpJHWYVKF_-Fj5Y-MgI7jBsoeZ1mDgZLVy6-v5XF4VMKGXHldZrwdtHolwZJpRuyWqiSvwlgFdmJegx7BTVqVOO37xG7E5uNC2NtR2Vs1_WlS0Eun49uqER__vqS_vHNYmEvm6cn6tsxJygC3E6-_Ux-TeOKwWsQAiRB01zyeM3EQ5cfWOqnMBPBa7xGFpQO0UwWX2CLVxmKDXiBkpTw8DVLGddvi5vDQ1b_VRtS635Nl2OPH6o9DCyXrH2vrDwSuLeYopceM",
            "refresh_token": "def50200465e686d738b5b2a9ecf1bbf855c44f33483b67f2fc612d19ed2eb45881bf852eb9e7745a942816a4151d76a637b7388f7af0658bd35fe0ef86c2ea55f13e5ea85df372c81014ae8416bcabb2ba909c250e578483c8e9f7b5505b6c7425d5fb16f4276c312b73d29e04e6e1a389296ea84070393f57727d76a1b67b0d81a2f81703e5da7cec4ef8393a194608e8a6c70c595f38b839dce8516f9d14c088b4d63e8aa6f90a215042d9ab358cd6dbb085914bbf357cb2e63bd9459f757e043a7e74b015ba33e785091490d2fa5053055e0887c5415579e132b6cd102a7fe42a5c2c619944b312843ccb9306351e361000b3007d3de043d701ada4de939417ef710ba2ea9ba01e1cb38c8756f6de461485d27c473aa783874db9aefc1e045200909bee41a74a276f22eb4a52c7a9d9dadd05d31fb9be4c214247c13d46d2b2f61f5265e46628469d171f6dedff4ba2948d2c24095807412b526bb7edd54819dd09556a2a9207278cba9b6768ff3027c33c8ebbb6a42664646eecca9276ba35d504f"
        }
        ```
3. Realizar petición http para probar endpoint:
    + Método: POST
    + URL: http://api.codersfree.test/v1/posts
    + Body:
        + Form:
            + Field name: name          | Value: Título de prueba 2
            + Field name: slug          | Value: titulo-de-prueba-2
            + Field name: extract       | Value: Cualquier cosa
            + Field name: body          | Value: Cualquier cosa
            + Field name: category_id   | Value: 1
            + Field name: user_id       | Value: 1
    + Headers:
        + Header: Accept    | Value: application/json
        + Header: Authorization    | Value: Bearer + (un espacio) + (access_token de la petición anterior sin las comillas dobles)
    + Acción: Obtenemos la autorización para registrar un post en la tabla **posts**.
4. Commit Video 23:
    + $ git add .
    + $ git commit -m "Video 23: Solicitar un acces token desde postman"
    + $ git push -u origin main

### Viedo 24. Instalar laravel breeze en el cliente
+ **URL Repositorio Cliente**: https://github.com/coders-free/cliente1
1. Crear proyecto cliente para consumir la API RESTful:
    + $ laravel new codersfree
2. Abrir el archivo: **C:\Windows\System32\drivers\etc\hosts** como administrador y en la parte final del archivo escribir.
	```
	127.0.0.1     codersfree.test
	```
3. Guardar y cerrar.
4. Abri el archivo de texto plano de configuración de Apache **C:\xampp\apache\conf\extra\httpd-vhosts.conf**.
5. Ir al final del archivo y anexar lo siguiente:
    ```conf
    <VirtualHost *>
        DocumentRoot "C:\xampp\htdocs\cursos\24apirestful\codersfree\public"
        ServerName codersfree.test
        <Directory "C:\xampp\htdocs\cursos\24apirestful\codersfree\public">
            Options All
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
    ```
6. Guardar y cerrar.
7. Reiniciar el servidor Apache.
    + **Nota 1**: ahora podemos ejecutar nuestro proyecto local en el navegador introduciendo la siguiente dirección: http://codersfree.test
    + **Nota 2**: En caso de que no funcione el enlace, cambiar en el archivo **C:\xampp\apache\conf\extra\httpd-vhosts.conf** todos los segmentos de código **<VirtualHost \*>** por **<VirtualHost *:80>**.
8. Crear base de datos **codersfree**.
9. Modificar la siguiente variable de entorno del archivo **codersfree\\.env**:
    ```
    APP_NAME=Codersfree
    ```
11. Instalara Laravel Breeze:
    **URL Laravel Breeze**: https://laravel.com/docs/8.x/starter-kits#:~:text=Laravel%20Breeze%20is%20a%20minimal,templates%20styled%20with%20Tailwind%20CSS.
    + $ composer require laravel/breeze --dev
    + $ php artisan breeze:install
    + $ npm install
    + $ npm run dev
    + $ php artisan migrate
12. Commit Video 24:
    + $ git add .
    + $ git commit -m "Video 24: Instalar laravel breeze en el cliente"
    + $ git push -u origin main

### Viedo 25. Crear endpoint para hacer login
1. Abrir el proyecto **api.codersfree**.
2. Crear controlador LoginController:
    + php artisan make:controller Api\Auth\LoginController
3. Crear ruta tipo post para login en **api.codersfree\routes\api-v1.php**:
    ```php
    Route::post('login', [LoginController::class, 'store']);
    ```
    Importar la definición del controlador **LoginController**:
    ```php
    use App\Http\Controllers\Api\Auth\LoginController;
    ```
4. Crear método **store** en el controlador **api.codersfree\app\Http\Controllers\Api\Auth\LoginController.php**:
    ```php
    public function store(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        if (Hash::check($request->password, $user->password)) {
            return UserResource::make($user);
        }else{
            return response()->json(['message' => 'These credentials do not match our records.'], 404);
        }       
    }
    ```
    Importar la definición de recurso **UserResource**, el modelo **User** y el facade **Hash**:
    ```php
    use App\Http\Resources\UserResource;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    ``` 
5. Commit Video 25:
    + $ git add .
    + $ git commit -m "Video 25: Crear endpoint para hacer login"
    + $ git push -u origin main

### Viedo 26. Configurando el proyecto del cliente parahacer login
1. Abrir el proyecto cliente **codersfree**:
2. Eliminar los campos **email_verified_at** y **password** del archivo de migración  **codersfree\database\migrations\2014_10_12_000000_create_users_table.php**:
    ```php
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    ```
3. Modificar el modelo **codersfree\app\Models\User.php** para eliminar las referencias al campo **password**:
    ```php
    ≡
    class User extends Authenticatable
    {
        ≡
        protected $fillable = [
            'name',
            'email',
        ];
        ≡
        protected $hidden = [
            'remember_token',
        ];
        ≡
    }
    ```
4. Crear el modelo AccessToken con su migración:
    + $ php artisan make:model AccessToken -m
5. Modificar el método up de la migración **codersfree\database\migrations\2021_09_20_195913_create_access_tokens_table.php**:
    ```php
    public function up()
    {
        Schema::create('access_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();    // id del usuario en el cliente
            $table->unsignedInteger('service_id');          // id del usuario en la API
            $table->text('access_token');
            $table->text('refresh_token');
            $table->dateTime('expires_at');
            $table->timestamps();
        });
    }
    ```
6. Habilitar la asignación masiva en el modelo **codersfree\app\Models\AccessToken.php**:
    ```php
    ≡
    class AccessToken extends Model
    {
        ≡
        protected $fillable = ['user_id', 'service_id', 'access_token', 'refresh_token', 'expires_at'];
    }
    ```
7. Establecer relación en el modelo **codersfree\app\Models\User.php** con el modelo **AccessToken**:
    ```php
    //Relacion 1:1 con el modelo AccessToken
    public function accessToken(){
        return $this->hasOne(AccessToken::class);
    }
    ```
8. Reestablecer la base de datos del cliente **codersfree**:
    + $ php artisan migrate:fresh
9. Commit Video 26:
    + $ git add .
    + $ git commit -m "Video 26: Configurando el proyecto del cliente parahacer login"
    + $ git push -u origin main

### Viedo 27. Iniciar sesión desde el cliente
1. Abrir el proyecto cliente **codersfree**.
2. Modificar el método **store** del controlador **codersfree\app\Http\Controllers\Auth\AuthenticatedSessionController.php**:
    ```php
    public function store(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post('http://api.codersfree.test/v1/login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        $service = $response->json();

        $user = User::updateOrcreate([
            'email' => $request->email
        ], $service['data']);

        return $user;
    }
    ```
    Importar la definición del model **User** y del facade **Http**:
    ```php
    use App\Models\User;
    use Illuminate\Support\Facades\Http;
    ```
3. Para solventar problemas al ejecutar más de un proyecto Laravel en el mismo servidor local, ejecutar en el proyecto cliente:
    + $ php artisan config:cache
4. Para probar la aplicación intentar acceder al endpoint de la aplicación API a través del login en la aplicación cliente:
    + Email: bazo.pedro@gmail.com
    + Password: 12345678
5. Commit Video 27:
    + $ git add .
    + $ git commit -m "Video 27: Iniciar sesión desde el cliente"
    + $ git push -u origin main

### Viedo 28. Iniciar sesión desde el cliente II
1. Abrir el proyecto cliente **codersfree**.
2. Modificar el método **store** del controlador **codersfree\app\Http\Controllers\Auth\AuthenticatedSessionController.php**:
    ```php
    public function store(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post('http://api.codersfree.test/v1/login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($response->status() == 404) {
            return back()->withErrors('These credentials do not match our records.');
        }

        $service = $response->json();

        $user = User::updateOrcreate([
            'email' => $request->email
        ], $service['data']);

        if (!$user->accessToken) {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post('http://api.codersfree.test/oauth/token', [
                'grant_type' => 'password',
                'client_id' => '94717435-7f73-4d1a-a9e2-0b88b0401377',
                'client_secret' => '5yo9JZN2W8kA9JVkvQE8KymeI48uBfm3F7ipLGXr',
                'username' => $request->email,
                'password' => $request->password
            ]);

            $access_token = $response->json();

            $user->accessToken()->create([
                'service_id' => $service['data']['id'],
                'access_token' => $access_token['access_token'],
                'refresh_token' => $access_token['refresh_token'],
                'expires_at' => now()->addSecond($access_token['expires_in'])
            ]);
        }
        Auth::login($user, $request->remember);
        return redirect()->intended(RouteServiceProvider::HOME);
    }
    ```
3. Commit Video 28:
    + $ git add .
    + $ git commit -m "Video 28: Iniciar sesión desde el cliente II"
    + $ git push -u origin main

### Viedo 29. Registrar usuario desde el cliente
1. Abrir proyecto **api.codersfree**.
2. Mover el controlador **RegisterController.php**:
    + De: api.codersfree\app\Http\Controllers\Api
    + A: api.codersfree\app\Http\Controllers\Api\Auth
3. Modificar namespace del controlador **api.codersfree\app\Http\Controllers\Api\Auth\RegisterController.php**:
    ```php
    namespace App\Http\Controllers\Api\Auth;
    ```
4. Cambiar la importación de la definición de **RegisterController** en el archivo de rutas **api.codersfree\routes\api-v1.php**:
    + De:
    ```php
    use App\Http\Controllers\Api\RegisterController;
    ```
    + A:
    ```php
    use App\Http\Controllers\Api\Auth\RegisterController;
    ```
5. Modificar el método **store** del controlador **api.codersfree\app\Http\Controllers\Api\Auth\RegisterController.php**:
    ```php
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return UserResource::make($user);
    }
    ```
    Importar la definición del recurso **UserResource**:
    ```php
    use App\Http\Resources\UserResource;
    ```
6. Realizar petición http para probar endpoint:
    + Método: POST
    + URL: http://api.codersfree.test/v1/register
    + Body:
        + Form:
            + Field name: name                      | Value: Fulanito De Tal
            + Field name: email                     | Value: fulanito@gmail.com
            + Field name: password                  | Value: 12345678
            + Field name: password_confirmation     | Value: 12345678
    + Headers:
        + Header: Accept    | Value: application/json
    + Acción: Debe enviar el registro a la tabla **users**.
7. Commit Video 29:
    + $ git add .
    + $ git commit -m "Video 29: Registrar usuario desde el cliente"
    + $ git push -u origin main

### Viedo 30. Registrar usuario desde el cliente II
1. Abrir el proyecto cliente **codersfree**.
2. Modificar el método store del controlador **codersfree\app\Http\Controllers\Auth\RegisteredUserController.php**:
    ```php
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post('http://api.codersfree.test/v1/register', $request->all());

        if ($response->status() == 422) {
            return back()->withErrors($response->json()['errors']);
        }

        $service = $response->json();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email
        ]);
        
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post('http://api.codersfree.test/oauth/token', [
            'grant_type' => 'password',
            'client_id' => '94717435-7f73-4d1a-a9e2-0b88b0401377',
            'client_secret' => '5yo9JZN2W8kA9JVkvQE8KymeI48uBfm3F7ipLGXr',
            'username' => $request->email,
            'password' => $request->password
        ]);

        $access_token = $response->json();

        $user->accessToken()->create([
            'service_id' => $service['data']['id'],
            'access_token' => $access_token['access_token'],
            'refresh_token' => $access_token['refresh_token'],
            'expires_at' => now()->addSecond($access_token['expires_in'])
        ]);
        
        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
    ```
    Importar la definición del facade **Http**:
    ```php
    use Illuminate\Support\Facades\Http;
    ```
3. Commit Video 30:
    + $ git add .
    + $ git commit -m "Video 30: Registrar usuario desde el cliente II"
    + $ git push -u origin main

### Viedo 31. Proteger credenciales
1. Abrir el proyecto cliente **codersfree**.
2. Crear servicio **codersfree** en el archivo de configuración **codersfree\config\services.php**:
    ```php
    return [
        ≡
        'codersfree' => [
            'client_id' => env('CODERSFREE_CLIENT_ID'),
            'client_secret' => env('CODERSFREE_CLIENT_SECRET')
        ],
    ];
    ```
3. Crear variables de entorno para almacenar las llaves del cliente tipo password en **codersfree\\.env**:
    ```
    CODERSFREE_CLIENT_ID="94717435-7f73-4d1a-a9e2-0b88b0401377"
    CODERSFREE_CLIENT_SECRET="5yo9JZN2W8kA9JVkvQE8KymeI48uBfm3F7ipLGXr"
    ```
4. Para cachear el servicio **codersfree**:
    + $ php artisan config:clear
    + $ php artisan config:cache
5. Modificar la instrucción con la información de las llaves clientes tipo password en los controladores **codersfree\app\Http\Controllers\Auth\RegisteredUserController.php** y **codersfree\app\Http\Controllers\Auth\AuthenticatedSessionController.php**:
    + Cambiar de:
    ```
    'client_id' => '94717435-7f73-4d1a-a9e2-0b88b0401377',
    'client_secret' => '5yo9JZN2W8kA9JVkvQE8KymeI48uBfm3F7ipLGXr',
    ```
    + A:
    ```
    'client_id' => config('services.codersfree.client_id'),
    'client_secret' => config('services.codersfree.client_secret'),
    ```
6. Commit Video 31:
    + $ git add .
    + $ git commit -m "Video 31: Proteger credenciales"
    + $ git push -u origin main

### Viedo 32. Trait para solicitar un acces token
1. Abrir el proyecto cliente **codersfree**.
2. Crear treit **codersfree\app\Traits\token.php**:
    ```php
    <?php

    namespace App\Traits;

    use Illuminate\Support\Facades\Http;

    trait Token{

        public function setAccessToken($user, $service){
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post('http://api.codersfree.test/oauth/token', [
                'grant_type' => 'password',
                'client_id' => config('services.codersfree.client_id'),
                'client_secret' => config('services.codersfree.client_secret'),
                'username' => request('email'),
                'password' => request('password'),
            ]);

            $access_token = $response->json();

            $user->accessToken()->create([
                'service_id' => $service['data']['id'],
                'access_token' => $access_token['access_token'],
                'refresh_token' => $access_token['refresh_token'],
                'expires_at' => now()->addSecond($access_token['expires_in'])
            ]);
        }
    }
    ```
3. Importar y usar el trait Token a los controladores **codersfree\app\Http\Controllers\Auth\RegisteredUserController.php** y **codersfree\app\Http\Controllers\Auth\AuthenticatedSessionController.php**:
    ```php
    ≡
    use App\Traits\Token;

    class {Nombre del controlador} extends Controller
    {
        use Token;
        ≡
    }
    ```
4. Modificar el método **store** del controlador **codersfree\app\Http\Controllers\Auth\RegisteredUserController.php**:
    ```php
    public function store(Request $request)
    {
        ≡    
        $this->setAccessToken($user, $service);
        
        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
    ```
5. Modificar el método **store** del controlador **codersfree\app\Http\Controllers\Auth\AuthenticatedSessionController.php**:
    ```php
    public function store(LoginRequest $request)
    {
        ≡
        if (!$user->accessToken) {
            $this->setAccessToken($user, $service);
        }

        Auth::login($user, $request->remember);
        return redirect()->intended(RouteServiceProvider::HOME);
    }
    ```
6. Reestablecer la base de datos cliente **codersfree**:
    + $ php artisan migrate:fresh
7. Commit Video 32:
    + $ git add .
    + $ git commit -m "Video 32: Trait para solicitar un acces token"
    + $ git push -u origin main

### Viedo 33. Mandar acces token en las peticiones
1. Abrir el proyecto client **codersfree**.
2. Crear el controlador **PostController**:
    + $ php artisan make:controller PostController
3. Crear ruta get posts en el archivo de rutas **codersfree\routes\web.php**:
    ```php
    Route::get('posts', [PostController::class, 'store'])->middleware('auth');
    ```
    Importar la definición del controlador  **PostController**:
    ```php
    use App\Http\Controllers\PostController;
    ```
4. Crear método **store** en el controlador **codersfree\app\Http\Controllers\PostController.php**:
    ```php
    public function store(){
        $response = Http::withHeaders([
            'Accept'    => 'application/json',
            'Authorization' => 'Bearer ' . auth()->user()->accessToken->access_token
        ])->post('http://api.codersfree.test/v1/posts', [
            'name' => 'Este es un nombre de prueba',
            'slug' => 'esto-esun-nombre-de-prueba',
            'extract' => 'sdsdsds',
            'body' => 'asdasdasdasdas',
            'category_id' => 1
        ]);
        return $response->json();
    }
    ```
    Importar la definición del facade **Http**:
    ```php
    use Illuminate\Support\Facades\Http;
    ``` 
5. Commit Video 33:
    + $ git add .
    + $ git commit -m "Video 33: Mandar acces token en las peticiones"
    + $ git push -u origin main

## Sección 9: Gran type refresh token

### Viedo 34. Solicitar nuevo token
1. Abrir el proyecto **api.codersfree**.
2. Agregar el método **tokensExpireIn** de la clase **Passport** en el método **boot** del provider **api.codersfree\app\Providers\AuthServiceProvider.php**:
    ```php
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(now()->addSeconds(60));
    }
    ```
3. Abrir el proyecto client **codersfree**.
4. Modificar el método **store** del controlador **codersfree\app\Http\Controllers\PostController.php**:
    ```php
    public function store(){
        $this->resolveAuthorization();

        $response = Http::withHeaders([
            'Accept'    => 'application/json',
            'Authorization' => 'Bearer ' . auth()->user()->accessToken->access_token
        ])->post('http://api.codersfree.test/v1/posts', [
            'name' => 'Este es un nombre de prueba',
            'slug' => 'esto-esun-nombre-de-prueba',
            'extract' => 'sdsdsds',
            'body' => 'asdasdasdasdas',
            'category_id' => 1
        ]);

        return $response->json();
    }
    ```
5. Crear método resolveAuthorization en el controlador **codersfree\app\Http\Controllers\Controller.php**:
    ```php
    // Verifica si el token esta caducado para solicitar otro
    public function resolveAuthorization(){
        if(auth()->user()->accessToken->expires_at <= now()){
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post('http://api.codersfree.test/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => auth()->user()->accessToken->refresh_token,
                'client_id' => config('services.codersfree.client_id'),
                'client_secret' => config('services.codersfree.client_secret')
            ]);
    
            $access_token = $response->json();
    
            auth()->user()->accessToken->update([
                'access_token' => $access_token['access_token'],
                'refresh_token' => $access_token['refresh_token'],
                'expires_at' => now()->addSecond($access_token['expires_in'])
            ]);           
        }
    }
    ```
    Importar la definición del facade **Http**:
    ```php
    use Illuminate\Support\Facades\Http;
    ```
6. Commit Video 34:
    + $ git add .
    + $ git commit -m "Video 34: Solicitar nuevo token"
    + $ git push -u origin main

### Viedo 35. Purgar tokens
1. Abrir el proyecto **api.codersfree**.
2. Para purgar de la base de datos los access tokens caducos:
    + $ php artisan passport:purge
3. Programar tarea para purgar tokens caducos en el método **schedule** del kernel **api.codersfree\app\Console\Kernel.php**:
    ```php
    protected function schedule(Schedule $schedule)
    {
        // Para usar en desarrollo
        $schedule->command('passport:purge')->everyMinute();
        // Para usar en producción
        // $schedule->command('passport:purge')->daily();
    }
    ```
4. Para que se ejecute el comando programado anteriormente cada minuto en nuestra máquina local:
    + $ php artisan schedule:work
5. Commit Video 35:
    + $ git add .
    + $ git commit -m "Video 35: Purgar tokens"
    + $ git push -u origin main

## Sección 10: Gran type authorization_code

### Viedo 36. Instalar laravel breeze en nuestra api
**URL Documentación Laravel Breeze**: https://laravel.com/docs/8.x/starter-kits
1. Abrir el proyecto **api.codersfree**.
2. Instalara Laravel Breeze:
    + $ composer require laravel/breeze --dev
    + $ php artisan breeze:install
    + $ npm install
    + $ npm run dev
    + $ php artisan migrate
3. Crear controlador **ClientController**:
    + $ php artisan make:controller ClientController
4. Agregar ruta get clients en el archivo de rutas **api.codersfree\routes\web.php**:
    ```php
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    ```
    Importar la definción del controlador **ClientController**:
    ```php
    use App\Http\Controllers\ClientController;
    ```
5. Crear el método **index** del controlador **api.codersfree\app\Http\Controllers\ClientController.php**:
    ```php
    public function index(){
        return view('clients.index');
    }
    ```
6. Crear vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </x-slot>
    </x-app-layout>
    ```
7. Agregar componente **Clientes** al dropdown de la plantilla **api.codersfree\resources\views\layouts\navigation.blade.php**:
    ```php
    ≡
    <!-- Settings Dropdown -->
    <div class="hidden sm:flex sm:items-center sm:ml-6">
        <x-dropdown align="right" width="48">
            ≡
            <x-slot name="content">
                {{-- Clientes --}}
                <x-dropdown-link :href="route('clients.index')">
                    Clientes
                </x-dropdown-link>

                <!-- Authentication -->
                ≡
            </x-slot>
        </x-dropdown>
    </div>
    ```
8. Commit Video 36:
    + $ git add .
    + $ git commit -m "Video 36: Instalar laravel breeze en nuestra api"
    + $ git push -u origin main

### Viedo 37. Crear formulario para crear nuevo cliente
1. Abrir el proyecto **api.codersfree**.
2. Crear el componente **api.codersfree\resources\views\components\container.blade.php**:
    ```php
    <div {{$attributes->merge(["class" => "max-w-7xl mx-auto sm:px-6 lg:px-8"])}}>
        {{$slot}}
    </div>
    ```
3. Crear el componente **api.codersfree\resources\views\components\form-section.blade.php**:
    ```php
    <div {{$attributes->merge(["class" => "grid grid-cols-3 gap-6"])}}>
        <div class="px-4">
            <h3 class="text-lg font-medium text-gray-900">
                {{$title}}
            </h3>

            <p class="mt-1 text-sm text-gray-600">
                {{$description}}
            </p>
        </div>

        <div class="col-span-2">
            <div>
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-tl-md rounded-tr-md">
                    {{$slot}}
                </div>
                @isset($actions)
                    <div class="px-6 py-3 bg-gray-100 shadow flex justify-end items-center rounded-bl-md rounded-br-md">
                        {{$actions}}
                    </div>
                @endisset    
            </div>
        </div>
    </div>
    ```
4. Modificar la vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </x-slot>

        <x-container class="py-8">
            <x-form-section>
                <x-slot name="title">
                    Crea un nuevo cliente
                </x-slot> 
                <x-slot name="description">
                    Ingrese los datos solicitados para poder crear un nuevo cliente
                </x-slot>
                <x-slot name="actions">
                    <x-button>
                        Crear
                    </x-button>
                </x-slot>          
            </x-form-section>
        </x-container>
    </x-app-layout>
    ```
5. Commit Video 37:
    + $ git add .
    + $ git commit -m "Video 37: Crear formulario para crear nuevo cliente"
    + $ git push -u origin main

### Viedo 38. Volver formulario responsivo
1. Abrir el proyecto **api.codersfree**.
2. Convertir en responsivo el componente **api.codersfree\resources\views\components\form-section.blade.php**:
    ```php
    <div {{$attributes->merge(["class" => "md:grid md:grid-cols-3 md:gap-6"])}}>
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium text-gray-900">
                {{$title}}
            </h3>

            <p class="mt-1 text-sm text-gray-600">
                {{$description}}
            </p>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div>
                <div class="px-4 py-5 sm:p-6 bg-white shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    {{$slot}}
                </div>
                @isset($actions)
                    <div class="px-6 py-3 bg-gray-100 shadow flex justify-end items-center sm:rounded-bl-md sm:rounded-br-md">
                        {{$actions}}
                    </div>
                @endisset    
            </div>
        </div>
    </div>
    ```
3. Commit Video 38:
    + $ git add .
    + $ git commit -m "Video 38: Volver formulario responsivo"
    + $ git push -u origin main

### Viedo 39. Incluir vue y axios en nuestro proyecto
1. Abrir el proyecto **api.codersfree**.
2. Modificar la vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </x-slot>

        <x-container class="py-8">
            <x-form-section>
                <x-slot name="title">
                    Crea un nuevo cliente
                </x-slot> 
                <x-slot name="description">
                    Ingrese los datos solicitados para poder crear un nuevo cliente
                </x-slot>

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label>Nombre</x-label>
                        <x-input type="text" class="w-full mt-1"></x-input> 
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label>URL de redirección</x-label>
                        <x-input type="text" class="w-full mt-1"></x-input> 
                    </div>
                </div>
                    
                <x-slot name="actions">
                    <x-button>
                        Crear
                    </x-button>
                </x-slot>          
            </x-form-section>
        </x-container>
    </x-app-layout>
    ```
3. Agregar los CDN's de **VUE**, **Axios** y  **sweetalert2** en la plantilla **api.codersfree\resources\views\layouts\app.blade.php** para poder extender sus funcionalidades a todas las vistas:
    ```php
    ≡
    <head>
        ≡
        <!-- VUE -->
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

        <!-- Axios -->
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

        <!-- sweetalert2 -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    ≡
    ```
    + **URL CDN de VUE**: https://vuejs.org/v2/guide/installation.html
    + **URL CDN de Axios**: https://github.com/axios/axios
    + **URL CDN de sweetalert2**: https://sweetalert2.github.io/#download
4. Commit Video 39:
    + $ git add .
    + $ git commit -m "Video 39: Incluir vue y axios en nuestro proyecto"
    + $ git push -u origin main

### Viedo 40. Registrar nuevos clientes
1. Abrir el proyecto **api.codersfree**.
2. Modificar la vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </x-slot>

        <x-container id="app" class="py-8">
            <x-form-section>
                <x-slot name="title">
                    Crea un nuevo cliente
                </x-slot> 
                <x-slot name="description">
                    Ingrese los datos solicitados para poder crear un nuevo cliente
                </x-slot>

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label>Nombre</x-label>
                        <x-input v-model="createForm.name" type="text" class="w-full mt-1"></x-input> 
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label>URL de redirección</x-label>
                        <x-input v-model="createForm.redirect" type="text" class="w-full mt-1"></x-input> 
                    </div>
                </div>
                    
                <x-slot name="actions">
                    <x-button v-on:click="store">
                        Crear
                    </x-button>
                </x-slot>          
            </x-form-section>
        </x-container>

        @push('js')
            <script>
                new Vue({
                    el: "#app",
                    data:{
                        createForm:{
                            errors: [],
                            name: null,
                            redirect: null,
                        }
                    },
                    methods:{
                        store(){
                            axios.post('/oauth/clients', this.createForm)
                                .then(response => {
                                    this.createForm.name=null;
                                    this.createForm.redirect=null;
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                }).catch(error => {
                                    alert('No has completado los datos correspondientes')
                                })
                        }
                    }
                });
            </script>
        @endpush
    </x-app-layout>
    ```
3. Definir un stack en la plantilla **api.codersfree\resources\views\layouts\app.blade.php**:
    ```php
    ≡
    <body class="font-sans antialiased">
        ≡
        @stack('js')
    </body>
    ```
4. Commit Video 40:
    + $ git add .
    + $ git commit -m "Video 40: Registrar nuevos clientes"
    + $ git push -u origin main

### Viedo 41. Mostrar listado de clientes
1. Abrir el proyecto **api.codersfree**.
2. Modificar la vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        ≡
        <x-container id="app" class="py-8">
            <x-form-section class="mb-12">
                ≡         
            </x-form-section>

            <x-form-section>
                <x-slot name="title">
                    Lista de clientes
                </x-slot> 
                <x-slot name="description">
                    Aquí podrás encontrar todos los clientes que has agregado
                </x-slot>

                <div>
                    <table class="text-gray-600">
                        <thead class="border-b border-gray-300">
                            <tr class="text-left">
                                <th class="py-2 w-full">Nombre</th>
                                <th class="py-2">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                            <tr v-for="client in clients">
                                <td class=" y-2">
                                    @{{ client.name }}  {{-- El @ se escribe para evitar conflicto entre Blade y VUE --}}
                                </td>
                                <td class="flex divide-x divide-gray-300 py-2">
                                    <a class="pr-2 hover:text-blue-600 font-semibold cursor-pointer">Editar</a>
                                    <a class="pl-2 hover:text-red-600 font-semibold cursor-pointer">Eliminar</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>          
            </x-form-section>
        </x-container>

        @push('js')
            <script>
                new Vue({
                    el: "#app",
                    data:{
                        clients: [],
                        createForm:{
                            errors: [],
                            name: null,
                            redirect: null,
                        }
                    },
                    mounted(){
                        this.getClients();
                    },
                    methods:{
                        getClients(){
                            axios.get('/oauth/clients')
                                .then(response =>{
                                    this.clients = response.data
                                })
                        },
                        store(){
                            axios.post('/oauth/clients', this.createForm)
                                .then(response => {
                                    this.createForm.name=null;
                                    this.createForm.redirect=null;
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                }).catch(error => {
                                    alert('No has completado los datos correspondientes')
                                })
                        }
                    }
                });
            </script>
        @endpush
    </x-app-layout>
    ```
3. Commit Video 41:
    + $ git add .
    + $ git commit -m "Video 41: Mostrar listado de clientes"
    + $ git push -u origin main

### Viedo 42. Mostrar mensajes de error
1. Abrir el proyecto **api.codersfree**.
2. Modificar la vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        ≡
        <x-container id="app" class="py-8">
            <x-form-section class="mb-12">
                ≡
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <div v-if="createForm.errors.length > 0">
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 oy-3 rounded">
                                <strong class="font-bold">Whoops!</strong>
                                <span>¡Algo salio mal!</span>
                                <ul>
                                    <li v-for="error in createForm.errors">
                                        @{{error}}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <x-label>Nombre</x-label>
                        <x-input v-model="createForm.name" type="text" class="w-full mt-1"></x-input> 
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label>URL de redirección</x-label>
                        <x-input v-model="createForm.redirect" type="text" class="w-full mt-1"></x-input> 
                    </div>
                </div>
                    
                <x-slot name="actions">
                    <x-button v-on:click="store" v-bind:disabled="createForm.disabled">
                        Crear
                    </x-button>
                </x-slot>          
            </x-form-section>

            <x-form-section v-if="clients.length > 0">
                ≡          
            </x-form-section>
        </x-container>

        @push('js')
            <script>
                new Vue({
                    el: "#app",
                    data:{
                        clients: [],
                        createForm:{
                            disabled: false,
                            errors: [],
                            name: null,
                            redirect: null,
                        }
                    },
                    mounted(){
                        this.getClients();
                    },
                    methods:{
                        getClients(){
                            axios.get('/oauth/clients')
                                .then(response =>{
                                    this.clients = response.data
                                })
                        },
                        store(){
                            this.createForm.disabled = true;
                            axios.post('/oauth/clients', this.createForm)
                                .then(response => {
                                    this.createForm.name=null;
                                    this.createForm.redirect=null;
                                    Swal.fire(
                                        'Creado con éxito!',
                                        'El cliente se creó satisfactoriamente.',
                                        'success'
                                    )
                                    this.getClients();
                                    this.createForm.disabled = false;
                                }).catch(error => {
                                    this.createForm.errors = _.flatten(_.toArray(error.response.data.errors));
                                    this.createForm.disabled = false;
                                })
                        }
                    }
                });
            </script>
        @endpush
    </x-app-layout>
    ```
3. Commit Video 42:
    + $ git add .
    + $ git commit -m "Video 42: Mostrar mensajes de error"
    + $ git push -u origin main

### Viedo 43. Traducir Laravel
1. Abrir el proyecto **api.codersfree**.
2. Ejecutar en la consola del proyecto:
    + $ composer require laraveles/spanish
    + $ php artisan vendor:publish --tag=lang
3. Modificar el archivo de configuración **api.codersfree\config\app.php**:
    ```php
    <?php

    return [
        ≡
        'locale' => 'es',
        ≡
    ];
    ```
4. Modificar el archivo **api.codersfree\resources\lang\es\validation.php**:
    ```php
    <?php

    return [
        ≡
        'attributes' => [
            'name' => 'nombre',
            'redirect' => 'redirección'
        ],

    ];
    ```
5. Commit Video 43:
    + $ git add .
    + $ git commit -m "Video 43: Traducir Laravel"
    + $ git push -u origin main

### Viedo 44. Eliminar cliente
1. Abrir el proyecto **api.codersfree**.
2. Modificar la vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        ≡
        <x-container id="app" class="py-8">
            ≡
            <x-form-section v-if="clients.length > 0">
                ≡
                <div>
                    <table class="text-gray-600">
                        ≡
                        <tbody class="divide-y divide-gray-300">
                            <tr v-for="client in clients">
                                ≡
                                <td class="flex divide-x divide-gray-300 py-2">
                                    <a class="pr-2 hover:text-blue-600 font-semibold cursor-pointer">Editar</a>
                                    <a class="pl-2 hover:text-red-600 font-semibold cursor-pointer" v-on:click="destroy(client)">Eliminar</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>          
            </x-form-section>
        </x-container>

        @push('js')
            <script>
                new Vue({
                    ≡
                    methods:{
                        ≡
                        destroy(client){
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                if (result.isConfirmed) {

                                    axios.delete('/oauth/clients/' + client.id)
                                        .then(response => {
                                            this.getClients();
                                        });

                                    Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                    )
                                }
                            })
                        }
                    }
                });
            </script>
        @endpush
    </x-app-layout>
    ```
    + **URL sweetalert2**: https://sweetalert2.github.io
3. Commit Video 44:
    + $ git add .
    + $ git commit -m "Video 44: Eliminar cliente"
    + $ git push -u origin main

### Viedo 45. Editar cliente I
1. Abrir el proyecto **api.codersfree**.
2. Modificar la vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </x-slot>

        <div id="app" >
            <x-container class="py-8">
                {{-- Crear cliente --}}
                <x-form-section class="mb-12">
                    <x-slot name="title">
                        Crea un nuevo cliente
                    </x-slot> 
                    <x-slot name="description">
                        Ingrese los datos solicitados para poder crear un nuevo cliente
                    </x-slot>

                <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <div v-if="createForm.errors.length > 0">
                                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 oy-3 rounded">
                                    <strong class="font-bold">Whoops!</strong>
                                    <span>¡Algo salio mal!</span>
                                    <ul>
                                        <li v-for="error in createForm.errors">
                                            @{{error}}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <x-label>Nombre</x-label>
                            <x-input v-model="createForm.name" type="text" class="w-full mt-1"></x-input> 
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label>URL de redirección</x-label>
                            <x-input v-model="createForm.redirect" type="text" class="w-full mt-1"></x-input> 
                        </div>
                    </div>
                        
                    <x-slot name="actions">
                        <x-button v-on:click="store" v-bind:disabled="createForm.disabled">
                            Crear
                        </x-button>
                    </x-slot>          
                </x-form-section>

                {{-- Mostrar clientes --}}
                <x-form-section v-if="clients.length > 0">
                    <x-slot name="title">
                        Lista de clientes
                    </x-slot> 
                    <x-slot name="description">
                        Aquí podrás encontrar todos los clientes que has agregado
                    </x-slot>

                    <div>
                        <table class="text-gray-600">
                            <thead class="border-b border-gray-300">
                                <tr class="text-left">
                                    <th class="py-2 w-full">Nombre</th>
                                    <th class="py-2">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                                <tr v-for="client in clients">
                                    <td class=" y-2">
                                        @{{ client.name }}  {{-- El @ se escribe para evitar conflicto entre Blade y VUE --}}
                                    </td>
                                    <td class="flex divide-x divide-gray-300 py-2">
                                        <a class="pr-2 hover:text-blue-600 font-semibold cursor-pointer" v-on:click="edit(client)">Editar</a>
                                        <a class="pl-2 hover:text-red-600 font-semibold cursor-pointer" v-on:click="destroy(client)">Eliminar</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>          
                </x-form-section>
            </x-container>

            {{-- Modal --}}
            <x-dialog-modal modal="editForm.open">
                <x-slot name="title">
                    Editar cliente
                </x-slot>
                <x-slot name="content">
                    <div class="space-y-6">
                        <div v-if="editForm.errors.length > 0">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 oy-3 rounded">
                                <strong class="font-bold">Whoops!</strong>
                                <span>¡Algo salio mal!</span>
                                <ul>
                                    <li v-for="error in editForm.errors">
                                        @{{error}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="">
                            <x-label>Nombre</x-label>
                            <x-input v-model="editForm.name" type="text" class="w-full mt-1"></x-input> 
                        </div>
                        <div class="">
                            <x-label>URL de redirección</x-label>
                            <x-input v-model="editForm.redirect" type="text" class="w-full mt-1"></x-input> 
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Actualizar
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </x-slot>
            </x-dialog-modal>
        </div>

        @push('js')
            <script>
                new Vue({
                    el: "#app",
                    data:{
                        clients: [],
                        createForm:{
                            disabled: false,
                            errors: [],
                            name: null,
                            redirect: null,
                        },
                        editForm:{
                            open: false,
                            disabled: false,
                            errors: [],
                            name: null,
                            redirect: null,
                        }
                    },
                    mounted(){
                        this.getClients();
                    },
                    methods:{
                        getClients(){
                            axios.get('/oauth/clients')
                                .then(response =>{
                                    this.clients = response.data
                                })
                        },
                        store(){
                            this.createForm.disabled = true;
                            axios.post('/oauth/clients', this.createForm)
                                .then(response => {
                                    this.createForm.name=null;
                                    this.createForm.redirect=null;
                                    this.createForm.errors=[];
                                    Swal.fire(
                                        'Creado con éxito!',
                                        'El cliente se creó satisfactoriamente.',
                                        'success'
                                    )
                                    this.getClients();
                                    this.createForm.disabled = false;
                                }).catch(error => {
                                    this.createForm.errors = _.flatten(_.toArray(error.response.data.errors));
                                    this.createForm.disabled = false;
                                })
                        },
                        edit(client){
                            this.editForm.open = true;
                        },
                        destroy(client){
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                if (result.isConfirmed) {

                                    axios.delete('/oauth/clients/' + client.id)
                                        .then(response => {
                                            this.getClients();
                                        });

                                    Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                    )
                                }
                            })
                        }
                    }
                });
            </script>
        @endpush
    </x-app-layout>
    ```
3. Crear componente **api.codersfree\resources\views\components\dialog-modal.blade.php**:
    ```php
    @props(['modal'])

    <div v-show="{{$modal}}" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div v-on:click="{{$modal}} = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
            <div class="w-full inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full text-center sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{$title}}
                            </h3>
                            <div class="mt-2">
                                {{$content}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    {{$footer}}
                </div>
            </div>
        </div>
    </div>
    ```
    + URL Tailwind Modals: https://tailwindui.com/components/application-ui/overlays/modals
4. Commit Video 45:
    + $ git add .
    + $ git commit -m "Video 45: Editar cliente I"
    + $ git push -u origin main

### Viedo 46. Editar cliente II
1. Abrir el proyecto **api.codersfree**.
2. Modificar la vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        ≡
        <div id="app" >
            <x-container class="py-8">
                ≡
            </x-container>

            {{-- Modal --}}
            <x-dialog-modal modal="editForm.open">
                <x-slot name="title">
                    Editar cliente
                </x-slot>
                <x-slot name="content">
                    <div class="space-y-6">
                        <div v-if="editForm.errors.length > 0">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 oy-3 rounded">
                                <strong class="font-bold">Whoops!</strong>
                                <span>¡Algo salio mal!</span>
                                <ul>
                                    <li v-for="error in editForm.errors">
                                        @{{error}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="">
                            <x-label>Nombre</x-label>
                            <x-input v-model="editForm.name" type="text" class="w-full mt-1"></x-input> 
                        </div>
                        <div class="">
                            <x-label>URL de redirección</x-label>
                            <x-input v-model="editForm.redirect" type="text" class="w-full mt-1"></x-input> 
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <button type="button"
                        v-on:click="update()"
                        v-bind:disabled="editForm.disabled"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                        Actualizar
                    </button>
                    <button v-on:click="editForm.open = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </x-slot>
            </x-dialog-modal>
        </div>

        @push('js')
            <script>
                new Vue({
                    el: "#app",
                    data:{
                        clients: [],
                        createForm:{
                            ≡
                        },
                        editForm:{
                            open: false,
                            disabled: false,
                            errors: [],
                            id: null,
                            name: null,
                            redirect: null,
                        }
                    },
                    mounted(){
                        this.getClients();
                    },
                    methods:{
                        ≡
                        store(){
                            ≡
                        },
                        edit(client){
                            this.editForm.open = true;
                            this.editForm.errors = [];
                            this.editForm.id = client.id;
                            this.editForm.name = client.name;
                            this.editForm.redirect = client.redirect;
                        },
                        update(){
                            this.editForm.disabled = true;
                            axios.put('/oauth/clients/' + this.editForm.id, this.editForm)
                                .then(response => {
                                    this.editForm.open = false;
                                    this.editForm.disabled = false;
                                    this.editForm.name = null;
                                    this.editForm.redirect = null;
                                    this.editForm.errors = [];
                                    Swal.fire(
                                        '¡Actualizado con éxito!',
                                        'El cliente se actualizó satisfactoriamente.',
                                        'success'
                                    );
                                    this.getClients();
                                    
                                }).catch(error => {
                                    this.editForm.errors = _.flatten(_.toArray(error.response.data.errors));
                                    this.editForm.disabled = false;
                                })
                        },
                        destroy(client){
                            ≡
                        }
                    }
                });
            </script>
        @endpush
    </x-app-layout>
    ```
3. Commit Video 46:
    + $ git add .
    + $ git commit -m "Video 46: Editar cliente II"
    + $ git push -u origin main

### Viedo 47. Credenciales del cliente
1. Abrir el proyecto **api.codersfree**.
2. Modificar la vista **api.codersfree\resources\views\clients\index.blade.php**:
    ```php
    <x-app-layout>
        ≡
        <div id="app" >
            <x-container class="py-8">
                {{-- Crear cliente --}}
                <x-form-section class="mb-12">
                    ≡          
                </x-form-section>

                {{-- Mostrar clientes --}}
                <x-form-section v-if="clients.length > 0">
                    ≡          
                </x-form-section>
            </x-container>

            {{-- Modal edit --}}
            <x-dialog-modal modal="editForm.open">
                ≡
            </x-dialog-modal>

            {{-- Modal show --}}
            <x-dialog-modal modal="showClient.open">
                <x-slot name="title">
                    Mostrar credenciales
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-2">
                    <p>
                        <span class="font-semibold">CLIENTE:</span>
                        <span v-text="showClient.name"></span>
                    </p>
                    <p>
                        <span class="font-semibold">CLIENTE_ID:</span>
                        <span v-text="showClient.id"></span>
                    </p>
                    <p>
                        <span class="font-semibold">CLIENTE_SECRET:</span>
                        <span v-text="showClient.secret"></span>
                    </p>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <button v-on:click="showClient.open = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                        Cancelar
                    </button>
                </x-slot>
            </x-dialog-modal>
        </div>

        @push('js')
            <script>
                new Vue({
                    el: "#app",
                    data:{
                        clients: [],
                        showClient:{
                            open: false,
                            name: null,
                            id: null,
                            secret: null,
                        },
                        ≡
                    },
                    mounted(){
                        this.getClients();
                    },
                    methods:{
                        getClients(){
                            ≡
                        },            
                        show(client){
                            this.showClient.open = true;
                            this.showClient.name = client.name;
                            this.showClient.id = client.id;
                            this.showClient.secret = client.secret;
                        },
                        store(){
                            this.createForm.disabled = true;
                            axios.post('/oauth/clients', this.createForm)
                                .then(response => {
                                    this.createForm.name=null;
                                    this.createForm.redirect=null;
                                    this.createForm.errors=[];
                                    /* Swal.fire(
                                        'Creado con éxito!',
                                        'El cliente se creó satisfactoriamente.',
                                        'success'
                                    ) */
                                    this.show(response.data);
                                    this.getClients();
                                    this.createForm.disabled = false;
                                }).catch(error => {
                                    this.createForm.errors = _.flatten(_.toArray(error.response.data.errors));
                                    this.createForm.disabled = false;
                                })
                        },
                        ≡
                    }
                });
            </script>
        @endpush
    </x-app-layout>
    ```
3. Commit Video 47:
    + $ git add .
    + $ git commit -m "Video 47: Credenciales del cliente"
    + $ git push -u origin main

### Viedo 48. Crear nuevo proyecto para un cliente externo
1. Crear nuevo proyecto Laravel:
    + $ laravel new cliente2
2. Abrir el archivo: **C:\Windows\System32\drivers\etc\hosts** como administrador y en la parte final del archivo escribir.
	```
	127.0.0.1     cliente2.test
	```
3. Guardar y cerrar.
4. Abri el archivo de texto plano de configuración de Apache **C:\xampp\apache\conf\extra\httpd-vhosts.conf**.
5. Ir al final del archivo y anexar lo siguiente:
    ```conf
    <VirtualHost *>
        DocumentRoot "C:\xampp\htdocs\cursos\24apirestful\cliente2\public"
        ServerName cliente2.test
        <Directory "C:\xampp\htdocs\cursos\24apirestful\cliente2\public">
            Options All
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
    ```
6. Guardar y cerrar.
7. Reiniciar el servidor Apache.
    + **Nota 1**: ahora podemos ejecutar nuestro proyecto local en el navegador introduciendo la siguiente dirección: http://cliente2.test
    + **Nota 2**: En caso de que no funcione el enlace, cambiar en el archivo **C:\xampp\apache\conf\extra\httpd-vhosts.conf** todos los segmentos de código **<VirtualHost \*>** por **<VirtualHost *:80>**.
8.  Crear el servicio **codersfree** en **cliente2\config\services.php**:
    ```php
    <?php

    return [
        ≡
        'codersfree' => [
            'client_id' => env('CODERSFREE_CLIENT_ID'),
            'client_secret' => env('CODERSFREE_CLIENT_SECRET')
        ],
    ];
    ```
9.  Definir las variables del servicio **codersfree** al final del archivo de variables de entorno **cliente2\\.env**:
    ```php
    CODERSFREE_CLIENT_ID=
    CODERSFREE_CLIENT_SECRET=
    ```
10. Abrir el proyecto **api.codersfree** y crear el cliente:
    + Nombre: Cliente2
    + URL de redirección: http://cliente2.test/callback
11. Copiar las credenciales de **Cliente2** y volver al nuevo proyecto **cliente2**.
12. Pegar las credenciales que acabamos de copiar en las correspondiente al servicio **codersfree** en **cliente2\\.env**:
    ```php
    CODERSFREE_CLIENT_ID=94753fa7-3c7a-4aa6-a71a-5ec8bf202215
    CODERSFREE_CLIENT_SECRET=KL61T3ypp5qjE6iqaSFb2Vixvt1CmzhocuygziyS
    ```
13. Para solventar problemas al ejecutar más de un proyecto Laravel en el mismo servidor local, ejecutar en el proyecto **cliente2**:
    + $ php artisan config:cache
14. Commit Video 48:
    + $ git add .
    + $ git commit -m "Video 48: Crear nuevo proyecto para un cliente externo"
    + $ git push -u origin main

### Viedo 49. Instalar laravel breeze en el cliente 2
1. Abrir el proyecto **cliente2**.
2. Crear base de datos **cliente2**.
3. Modificar la siguiente variable de entorno del archivo **cliente2\\.env**:
    ```
    APP_NAME=Cliente2
    ```
4.  Instalara Laravel Breeze:
    **URL Laravel Breeze**: https://laravel.com/docs/8.x/starter-kits#:~:text=Laravel%20Breeze%20is%20a%20minimal,templates%20styled%20with%20Tailwind%20CSS.
    + $ composer require laravel/breeze --dev
    + $ php artisan breeze:install
    + $ npm install
    + $ npm run dev
    + $ php artisan migrate
5. Modificar la vista **cliente2\resources\views\dashboard.blade.php**:
    ```php
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Solicitar permisos
                        <a href="{{route('redirect')}}" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Redirigir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    ```
    + **URL Buttons Tailwind**: https://v1.tailwindcss.com/components/buttons
6. Crear ruta **redirect** tipo **get** en el archivo de rutas **cliente2\routes\web.php**:
    ```php
    Route::get('redirect', function () {
        return "Te has redirigido";
    })->name('redirect');
    ```
7. Commit Video 49:
    + $ git add .
    + $ git commit -m "Video 49: Instalar laravel breeze en el cliente 2"
    + $ git push -u origin main

### Viedo 50. Obtener código de autorización
**URL Documentación Laravel Passport**: https://laravel.com/docs/8.x/passport
1. Abrir el proyecto **cliente2**.
2. Crear controlador **OauthController**:
    + $ php artisan make:controller OauthController
3. Modificar la ruta **redirect** tipo **get** en el archivo de rutas **cliente2\routes\web.php**:
    ```php
    Route::get('redirect', [OauthController::class, 'redirect'])->name('redirect');
    ```
    Importar la definición del controlador **OauthController**:
    ```php
    use App\Http\Controllers\OauthController;
    ```
4. Definir el método **redirect** en el controlador **cliente2\app\Http\Controllers\OauthController.php**:
    ```php
    public function redirect(Request $request){
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => config('services.codersfree.client_id'),
            'redirect_uri' => route('callback'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);
    
        return redirect('http://api.codersfree.test/oauth/authorize?'.$query);        
    }
    ```
    Importar la definición del soporte **Str**:
    ```php
    use Illuminate\Support\Str;
    ```    
5. Crear ruta **callback** tipo **get** en el archivo de rutas **cliente2\routes\web.php**:
    ```php
    Route::get('callback', [OauthController::class, 'callback'])->name('callback');
    ```
6. Definir el método **callback** en el controlador **cliente2\app\Http\Controllers\OauthController.php**:
    ```php
    public function callback(Request $request){
        return $request->all();
    }
}
    ```
7. Abrir el proyecto **api.codersfree**.
7. Publicar vistas de Laravel Passport:
    + $ php artisan vendor:publish --tag=passport-views
8. Modificar la vista **api.codersfree\resources\views\vendor\passport\authorize.blade.php**:
    ```php
    <!DOCTYPE html>
    <html lang="en">
    <head>
        ≡
        <title>{{ config('app.name') }} - Authorization</title>

        <!-- Styles -->
        {{-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <style>
            ≡
        </style>
    </head>
    <body class="passport-authorize">
        ≡
    </body>
    </html>
    ```
    + **URL CDN Bootstrap**: https://getbootstrap.com
9. Commit Video 50:
    + $ git add .
    + $ git commit -m "Video 50: Obtener código de autorización"
    + $ git push -u origin main

### Viedo 51. Solicitar Acees Token



    ≡
    ```php
    ***
    ```



## Sección 11: Personal Access Token
### Viedo 52. Crear ruta
### Viedo 53. Generar Access Token
### Viedo 54. Mostrar Access Token
### Viedo 55. Mostrar Acces token II

## Sección 12: Scopes
### Viedo 56. Proteger rutas por scopes
### Viedo 57. Asignar scopes a token I
### Viedo 58. Asignar scopes a token II

## Sección 13: Roles y permisos
### Viedo 59. Instalar Laravel Permission
### Viedo 60. Asignar roles y permisos
### Viedo 61. Proteger rutas con roles y policies
### Viedo 62. Despedida del curso



https://github.com/coders-free/api.codersfree
https://github.com/coders-free/cliente1

## En caso de no permitir compilar algo:
+ $ php artisan clear-compiled
+ $ composer dumpautoload

## Peticiones http que puede responder el proyecto api.restful:

### Usuarios:

#### Registrar un usuario:
+ Método: POST
+ URL: http://api.codersfree.test/v1/register
+ Body:
    + Form:
        ```
        Field name: name                      | Value: Pedro Bazó
        Field name: email                     | Value: bazo.pedro@gmail.com
        Field name: password                  | Value: 12345678
        Field name: password_confirmation     | Value: 12345678
        ```
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Login a un usuario:
+ Método: POST
+ URL: http://api.codersfree.test/v1/login
+ Body:
    + Form:
        ```
        Field name: email       | Value: bazo.pedro@gmail.com
        Field name: password    | Value: 12345678
        ```
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```


### Permisos de accesos:

#### Obtener token para un usuario:
+ Método: POST
+ URL: http://api.codersfree.test/oauth/token
    + Body:
        + Form:
            ```
            Field name: grant_type      | Value: password
            Field name: client_id       | Value: {Client ID del cliente tipo password}
            Field name: client_secret   | Value: {Client secret del cliente tipo password}
            Field name: username        | Value: {email del usuario a autorizar}
            Field name: password        | Value: {clave del usuario}
            ```
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```
#### Obtener autorización por cliente tipo password:
+ Headers:
    ```
    Header: Accept          | Value: application/json
    Header: Authorization   | Value: Bearer + (un espacio) + (access_token de la petición anterior sin las comillas dobles)
    ```

### Categorías:

#### Obtener las categorías:
+ Método: GET
+ URL: http://api.codersfree.test/v1/categories
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Crear una categoría:
+ Método: POST
+ URL: http://api.codersfree.test/v1/categories
+ Body:
    + Form:
        ```
        Field name: name    | Value: Categoría de prueba
        Field name: slug    | Value: categoria-de-prueba
        ```
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Obtener una categoría:
+ Método: GET
+ URL: http://api.codersfree.test/v1/categories/{id}
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Actualizar una categoría:
+ Método: PUT
+ URL: http://api.codersfree.test/v1/categories/{id}
+ Body:
    + Form-encode:
        ```
        Field name: name  | Value: Categoría de prueba actualizada
        Field name: slug  | Value: categoria-de-prueba-actualizada
        ```
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Eliminar una categoría:
+ Método: DELETE
+ URL: http://api.codersfree.test/v1/categories/{id}
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Obtener las categorías y su relación con los posts:
+ Método: GET
+ URL: http://api.codersfree.test/v1/categories?included=posts
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Obtener las categorías y su relación con los posts y el autor del post:
+ Método: GET
+ URL: http://api.codersfree.test/v1/categories?included=posts.user
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Obtener una categoría y su relación con los posts:
+ Método: GET
+ URL: http://api.codersfree.test/v1/categories/{id}?included=posts
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Obtener una categoría y su relación con los posts y el autor del post:
+ Método: GET
+ URL: http://api.codersfree.test/v1/categories/1?included=posts.user
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

#### Obtener las categorías filtradas:
+ Método: GET
+ URL: http://api.codersfree.test/v1/categories?filter[{Campo1}]={Valor1}&filter[{Campo2}]={Valor2}
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```
  
#### Obtener las categorías ordenadas:
+ Método: GET
+ URL: http://api.codersfree.test/v1/categories?sort={Campo1,Campo2}
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```
+ **Nota**: Las categorías se ordenaran en orden ascendente, si se desea que se ordenen de manera descendente el campo debe ser precedido por el signo menos (-).

#### Obtener las categorías paginadas:
+ Método: GET
+ URL: http://api.codersfree.test/v1/categories?perPage{RegistrosPorPágina}&page={Página}
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```

### Posts

#### Obtener los posts:
+ Método: GET
+ URL: http://api.codersfree.test/v1/posts
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```
**Nota**: para relacionar, ordenar, filtrar y paginar es análogo a como se hace para las categorías.

#### Registrar un post:
+ Método: POST
+ URL: http://api.codersfree.test/v1/posts
    + Body:
        + Form:
            ```
            Field name: name        | Value: Título de prueba
            Field name: slug        | Value: titulo-de-prueba
            Field name: extract     | Value: Cualquier cosa
            Field name: body        | Value: Cualquier cosa
            Field name: category_id | Value: 1
            Field name: user_id     | Value: 1
            ```
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```
