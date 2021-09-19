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
    Definir variable **allowIncluded** en la clase **Category**:
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
    Definir variable **allowIncluded** en la clase **Category**:
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
***


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