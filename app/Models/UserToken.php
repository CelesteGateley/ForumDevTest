<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserToken extends Model
{
    use HasFactory;

    protected $primaryKey = 'token';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = ['expiry' => 'integer'];
    protected $guarded = ['created_at','updated_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getExpiresAttribute(): Carbon
    {
        return Carbon::createFromTimestamp($this->expiry);
    }

    public function setExpiresAttribute(Carbon $expires): void
    {
        $this->expiry = $expires->unix();
        $this->save();
    }

    public function expired(): bool
    {
        return $this->expires->isBefore(now());
    }
}
