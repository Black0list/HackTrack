<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jury extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }

    public function members()
    {
        return $this->hasMany(JuryMember::class);
    }
}
