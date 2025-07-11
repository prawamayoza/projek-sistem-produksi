<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tasklist extends Model
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
     * Get the Projek that owns the Tasklist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projek()
    {
        return $this->belongsTo(Projek::class);
    }

    /**
     * Get all of the comment for the Tasklist
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter($query, $filter)
    {
        $query->when($filter->projeks_id ?? false, function ($query, $projek_id) {
            return $query->where('projek_id', $projek_id);
        });
    
        return $query; // Pastikan mengembalikan query
    }

    /**
     * Get all of the history for the Tasklist
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(history_user::class);
    }
    
}
