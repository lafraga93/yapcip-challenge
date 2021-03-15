<?php

declare(strict_types=1);

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->post('transactions', 'TransactionController@makeTransaction');
});
