<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryMember extends Model
{
    use HasFactory;
    protected $fillable = ['username', 'pin'];
    protected $hidden = ['jury_id'];

    protected $table = 'jurymembers';
    public function jury()
    {
        return $this->belongsTo(Jury::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
