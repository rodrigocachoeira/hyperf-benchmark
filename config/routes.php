<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use App\Controller\Cache\Metrics\ShowMetricsInCacheController;
use App\Controller\Cache\Metrics\StoreMetricInCacheController;
use App\Controller\Metrics\StoreMetricController;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::addGroup('/metrics', function () {
    Router::post('', StoreMetricController::class);
});

Router::addGroup('/cache/metrics', function () {
    Router::post('', StoreMetricInCacheController::class);
    Router::get('', ShowMetricsInCacheController::class);
});
