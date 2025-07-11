<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class history_user extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected static function boot()
    {
        parent::boot();

        // Set UUID otomatis ketika membuat record baru
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'id'; // Nama kolom UUID
    }

    /**
     * Get the user that owns the Tasklist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the task that owns the history_user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tasklist()
    {
        return $this->belongsTo(Tasklist::class);
    }
}
