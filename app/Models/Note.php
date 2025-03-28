<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function juryMember()
    {
        return $this->belongsTo(JuryMember::class);
    }

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }
}
