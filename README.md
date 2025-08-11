<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Comandos para rodar o projeto localmente

### Copiar o arquivo `.env.example` e cola-lo com o nome de `.env`

### Abrir o Docker Desktop (não é necessário em computadores Linux)

### Subir todos os containers com o comando:
```bash
docker compose up -d
``` 

### Acessar o container com o comando:
```bash
docker compose exec webserver bash
``` 

### Aplicar as migrations existentes com o comando:
```bash
php artisan migrate
```

### Sair do container com o comando:
```bash
exit
```
