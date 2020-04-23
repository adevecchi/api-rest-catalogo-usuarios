<?php

$app->container->singleton('db', function () {
    return \App\Persistence\DB::create()->getConnection();
});
