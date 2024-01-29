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

namespace App\Controller\Cache\Metrics;

use App\Service\MetricCacheService;
use Hyperf\HttpServer\Annotation\AutoController;
use Psr\SimpleCache\InvalidArgumentException;
use RedisException;

#[AutoController]
class ShowMetricsInCacheController
{
    private MetricCacheService $metricCacheService;

    public function __construct(MetricCacheService $metricCacheService)
    {
        $this->metricCacheService = $metricCacheService;
    }

    /**
     * @throws InvalidArgumentException|RedisException
     */
    public function __invoke(): array
    {
        return $this->metricCacheService->getKeys();
    }
}
