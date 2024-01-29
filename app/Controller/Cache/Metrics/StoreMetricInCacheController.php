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
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RedisException;
use Swoole\Http\Status;

#[AutoController]
class StoreMetricInCacheController
{
    private MetricCacheService $metricCacheService;

    public function __construct(MetricCacheService $metricCacheService)
    {
        $this->metricCacheService = $metricCacheService;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RedisException
     */
    public function __invoke(RequestInterface $request): array
    {
        $data = $request->all();
        $this->metricCacheService->persist($data);

        return [
            'status' => Status::OK,
        ];
    }
}
