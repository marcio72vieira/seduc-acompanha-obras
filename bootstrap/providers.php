<?php

/* 
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\SeatiMailServiceProvider::class,
]; 
*/

return [
    App\Providers\AppServiceProvider::class,
    App\Infrastructure\Providers\AtiMailServiceProvider::class,
];
