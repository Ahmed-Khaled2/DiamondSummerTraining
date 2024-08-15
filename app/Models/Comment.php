<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable =[ 'content', 'user_id', 'post_id' ];

    public function post(): BelongsTo{
        return $this->belongsTo(post::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
