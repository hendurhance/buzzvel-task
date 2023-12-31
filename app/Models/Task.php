<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'title',
        'description',
        'completed',
        'completed_at'
    ];

    /**
     * The attributes be mutated to dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'completed_at',
        'deleted_at'
    ];

    /**
     * Get the user that owns the task.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the files for the task.
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
