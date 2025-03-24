<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hackathon extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'place'];

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function juries()
    {
        return $this->hasMany(Jury::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin');
    }
}
