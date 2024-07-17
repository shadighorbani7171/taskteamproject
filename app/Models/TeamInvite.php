<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamInvite extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'email',
        'status',
        'accept_token',
        'deny_token',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
}
}



