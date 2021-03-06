<?php

use App\Providers\AliasProvider;
use App\Providers\ContainerProvider;
use App\Providers\ServiceProvider;
use App\Providers\SessionProvider;

return[

    'providers'=>[
        ServiceProvider::class,
        AliasProvider::class,
        SessionProvider::class,
        ContainerProvider::class
    ]
];
