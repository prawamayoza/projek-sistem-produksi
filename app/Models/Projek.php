<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Projek extends Model
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
     * Get all of the tasklist for the Projek
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasklist()
    {
        return $this->hasMany(Tasklist::class);
    }
}
