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

namespace App\Controller\Metrics;

use App\Repository\MetricRepository;
use App\Request\StoreMetricRequest;
use Hyperf\HttpServer\Annotation\AutoController;

#[AutoController]
class StoreMetricController
{
    private MetricRepository $metricRepository;

    public function __construct(MetricRepository $metricRepository)
    {
        $this->metricRepository = $metricRepository;
    }

    public function __invoke(StoreMetricRequest $request): array
    {
        $data = $request->validated();
        $created = $this->metricRepository->create($data);

        return [
            'created' => ! is_null($created),
        ];
    }
}
