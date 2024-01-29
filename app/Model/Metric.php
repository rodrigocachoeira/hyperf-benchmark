<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @Entity
 * @Table(name="metrics")
 */
class Metric extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'metrics';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'type',
        'media_id',
        'action',
        'user_type',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];
}
