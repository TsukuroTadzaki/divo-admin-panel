<h1 align="center"> 
 DiVoTek Admin Panel
</h1>

<p align="center"> 
 Based on <a href="https://github.com/orchidsoftware/platform">Orchid Platform</a>.
</p>

<h4 align="center">For the full documentation, visit <a href="http://orchid.software">orchid.software</a>.</h4>

This is a free [Laravel](https://laravel.com) package that abstracts standard business logic and allows code-driven rapid application development of back-office applications, admin/user panels, and dashboards.

## Implemented features

- Native support for `nakukryskin/orchid-repeater-field` 

- Native support for `nakipelo/orchid-ckeditor`

- Custom Command Bar with actions ('Go Back', 'Save and Leave', etc.)

- Automatic nested tables (requires model relation called `children`, e.g. `$product->children`)

- Custom slug fields for automatic slug generation

- Native support for `barryvdh/laravel-elfinder`

- Minor improvements

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