# CIFRADO BACK
> API CIFRADO

### Requirements

- PHP >= 8.0
- Composer
- Laravel 9.x
- Docker
- Docker Compose

### Enlaces De Interes
    * Documentacion => https://www.cifrado.com.co/cifrado-back/public/
    * Logs          => https://www.cifrado.com.co/cifrado-back/public/logs

### Installation

2. Install dependencies
```sh
composer install
```

3. Create a copy of the .env file
```sh
cp .env.example .env
```

4. Generate the application key
```sh
php artisan key:generate
```

5. Run the application
```sh
php artisan serve
```


### Code Quality Tools

- [Laravel Pint](https://github.com/laravel/pint)
- [Larastan](https://github.com/nunomaduro/larastan)
- [PhpStan](https://phpstan.org/)

### API Docs Tools

- [OpenAPI Docs](https://vyuldashev.github.io/laravel-openapi/)
- [Laravel OpenAPI](https://github.com/vyuldashev/laravel-openapi)
- [Laravel Stoplight Elements](https://github.com/JustSteveKing/laravel-stoplight-elements)

### Testing Requirements
- Xdebug [Video Youtube](https://www.youtube.com/watch?v=4lGzriRZlYo) - Esta configuracion la debe realizar solo si deseas ver un perfil de coverage de testing


### ✅ Generar documentacion
```sh
    php artisan openapi:generate
```

### ✅ Tests execution
```sh
    php artisan test
```
```sh
    php artisan test --filter testExampleTest
```

> !! Es Obligatorio que para poder ejecutar los test de cobertura tengas intalada la extension Xdebug [Wizard Installation](https://xdebug.org/wizard)

```bash
    php artisan test --coverage
```
```bash
    php artisan test --parallel --coverage
```


### 📝 Code Style Fix

```sh
    vendor/bin/pint
```

### 📝 Code Analyze
```sh
    vendor/bin/phpstan analyse
```
