# Aprende a crear una API RESTful con Laravel
**URL Curso**: https://www.udemy.com/course/aprende-a-crear-una-api-restful-con-laravel
**URL Repositorio**: https://github.com/petrix12/apirestful_laravel8

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
    + Acción: Obtine un token para el usuario que corresponde con el campo **email** = bazo.pedro@gmail.com de la tabla **users**.
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
    **Nota 1**: ahora podemos ejecutar nuestro proyecto local en el navegador introduciendo la siguiente dirección: http://codersfree.test
    **Nota 2**: En caso de que no funcione el enlace, cambiar en el archivo **C:\xampp\apache\conf\extra\httpd-vhosts.conf** todos los segmentos de código **<VirtualHost \*>** por **<VirtualHost *:80>**.
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
### Viedo 26. Configurando el proyecto del cliente parahacer login
### Viedo 27. Iniciar sesión desde el cliente
### Viedo 28. Iniciar sesión desde el cliente II
### Viedo 29. Registrar usuario desde el cliente
### Viedo 30. Registrar usuario desde el cliente II
### Viedo 31. Proteger credenciales
### Viedo 32. Trait para solicitar un acces token
### Viedo 33. Mandar acces token en las peticiones



    ≡
    ```php
    ***
    ```
https://github.com/coders-free/api.codersfree



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
            Field name: name  | Value: Título de prueba
            Field name: slug  | Value: titulo-de-prueba
            Field name: extract  | Value: Cualquier cosa
            Field name: body  | Value: Cualquier cosa
            Field name: category_id  | Value: 1
            Field name: user_id  | Value: 1
            ```
+ Headers:
    ```
    Header: Accept  | Value: application/json
    ```
