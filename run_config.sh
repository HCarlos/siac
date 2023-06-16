#!/usr/bin/env bash

## Para Remover laravel/homestead
vagrant box remove laravel/homestead --box-version=7.0.0 --provider=virtualbox
## ó para eliminar todas las versiones
vagrant box list | cut -f 1 -d ' ' | xargs -L 1 vagrant box remove -f

alias art='php artisan'
php artisan migrate
art migrate:refresh --seed

php artisan make:migration create_codigo_lenguaje_paises_table --path=database/migrations/catalogos
php artisan migrate --path=database/migrations/catalogos=
php artisan db:seed --class=InitializeCodigoLenguajePaisesSeeder
art make:model "Models\Catalogos\Prueba"

## Para UNDO: rm -rf public/imagenes
php artisan storage:link
## No Olvide darle permisos de lectura y escritura a la carpeta chmod +rwx public/imagenes

composer require "laravelcollective/remote":"^5.7.0"
php artisan vendor:publish --provider="Collective\Remote\RemoteServiceProvider"

composer require "laravelcollective/html":"^5.7.0"
php artisan vendor:publish --provider="Collective\Html\HtmlServiceProvider"

composer require doctrine/dbal

composer require yajra/laravel-datatables-oracle
php artisan vendor:publish => 9 y 11

composer require guzzlehttp/guzzle
composer require intervention/image

## Para publicar la plantilla del Email
php artisan vendor:publish --tag=laravel-notifications

php artisan vendor:publish --tag=laravel-mail

php artisan vendor:publish --tag=laravel-pagination

## GEOCODER
composer require toin0u/geocoder-laravel
php artisan vendor:publish --provider="Geocoder\Laravel\Providers\GeocoderService" --tag="config"
composer require predis/predis
en .ENV => QUEUE_DRIVER=redis

composer require "styde/html=~1.5"
php artisan vendor:publish --provider='Styde\Html\HtmlServiceProvider'

composer require acacha/ace-template-laravel
php artisan vendor:publish --force --provider="Acacha\AceTemplateLaravel\Providers\AceTemplateLaravelServiceProvider"

##composer require codedge/laravel-fpdf
##provider > Codedge\Fpdf\FpdfServiceProvider::class,
##aliases > 'Fpdf' => Codedge\Fpdf\Facades\Fpdf::class,
##php artisan vendor:publish --provider="Codedge\Fpdf\FpdfServiceProvider" --tag=config
##php artisan make:provider FpdfServiceProvider

##composer require anouar/fpdf
##Anouar\Fpdf\FpdfServiceProvider::class,
##'Fpdf' => Anouar\Fpdf\Facades\Fpdf::class,

composer require setasign/fpdf

## Bouncer <-- No instalalr
composer require silber/bouncer v1.0.0-rc.1
Silber\Bouncer\BouncerServiceProvider::class,
'Bouncer' => Silber\Bouncer\BouncerFacade::class,
use HasRolesAndAbilities
php artisan vendor:publish --tag="bouncer.migrations"

# maatwebsite -> Para trabajar con MS Excel
composer require maatwebsite/excel
Maatwebsite\Excel\ExcelServiceProvider::class,
'Excel' => Maatwebsite\Excel\Facades\Excel::class,
php artisan vendor:publish
composer require maatwebsite/excel
composer require laravelcollective/bus
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"

# Faker
composer require fzaninotto/faker

##composer require barryvdh/laravel-dompdf
##Barryvdh\DomPDF\ServiceProvider::class,
##'PDF' => Barryvdh\DomPDF\Facade::class,
##php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"

composer require phpoffice/phpspreadsheet

composer require picqer/php-barcode-generator

composwr require elibyy/laravel-tcpdf
'Elibyy\TCPDF\ServiceProvider',

## para agregar fuentes personalizadas
composer require tecnickcom/tc-lib-pdf-font ^1.7

## Para hacer diagramas E-R

composer require beyondcode/laravel-er-diagram-generator --dev
php artisan vendor:publish --provider=BeyondCode\ErdGenerator\ErdGeneratorServiceProvider

composer require caouecs/laravel-lang:~3.0

composer require laravel/socialite

composer require opsway/doctrine-dbal-postgresql

===============================================================

Para la versión 7.0 se tuvo que hacer lo siguiente:

composer require laravel/ui "^2.0"

Datos de la DB

DBMS: PostgreSQL (ver. 12.4 (Ubuntu 12.4-1.pgdg20.04+1))
Case sensitivity: plain=lower, delimited=exact
Driver: PostgreSQL JDBC Driver (ver. 42.2.22, JDBC4.2)
Ping: 9 ms
SSL: yes


