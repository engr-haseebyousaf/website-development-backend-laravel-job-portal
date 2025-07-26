<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppliedJob extends Model
{
    use HasFactory;
    public function job() {
        return $this->belongsTo(Job::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
