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

namespace App\Service;

use Carbon\Carbon;
use Hyperf\Redis\Redis;
use Psr\SimpleCache\InvalidArgumentException;
use RedisException;

class MetricCacheService
{
    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws RedisException
     */
    public function getKeys(): array
    {
        $pattern = '*';
        $keys = $this->redis->keys($pattern);

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $this->redis->get($key);
        }

        return $data;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RedisException
     */
    public function persist(array $data): bool
    {
        $id = (int) ($data['media_id'] . rand(1, 100));

        $key = $this->mountKey($data['type'], $id);
        $this->redis->incrBy($key, 1);

        return true;
    }

    private function mountKey(string $type, int $id): string
    {
        $keyDate = Carbon::now()->format('Ymd');
        $keyId = ':type_' . $type . '_' . $id;

        return 'view_' . $keyDate . $keyId;
    }
}
