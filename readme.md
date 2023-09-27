<p align="center"> 
 <a href="https://orchid.software/"><img src="https://raw.githubusercontent.com/orchidsoftware/.github/e23597cffa8cbf24d47913ce903fcc7aa4a59335/web/avatars/orchid-github-splash.svg" alt="Laravel Orchid"></a>
</p>


<h4 align="center">For the full documentation, visit <a href="http://orchid.software">orchid.software</a>.</h4>

Orchid is a free [Laravel](https://laravel.com) package that abstracts standard business logic and allows code-driven rapid application development of back-office applications, admin/user panels, and dashboards.

## Install

- Create project

```
composer create-project laravel/laravel my-awesome-admin
```

- Configure `.env`

- Install main admin package

```
composer require divotek/admin
```

- Publish package config & assets

```
php artisan admin:install

php artisan elfinder:publish
```

- Configure main admin credentials

```
php artisan admin:make
```

## Local Development

- Download source code

- Extract archive

- Make your magic in extracted directory

- Build frontend for modified admin panel:

```
npm i & npm run production
```

- Edit your project `composer.json` and add/modify the following directives:

```
"require": {
    "divotek/admin": "dev-main",
    ...
},
"repositories": [
    {
        "type": "path",
        "url": "../path/to/extracted/directory"
    },
    ...
]
```

- In your project directory remove `vendor` dir and `composer.lock` file

- Run following command:

```
composer install
```