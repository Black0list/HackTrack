<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class JuryMember extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public function getJuryMember(Request $request)
    {
        try {
            $token = $request->bearerToken();

            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 401);
            }

            $payload = JWTAuth::setToken($token)->getPayload();

            $juryMember = $payload->get('juryMember');

            return response()->json($juryMember);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $fillable = ['username', 'password'];
    protected $hidden = ['jury_id'];

    protected $table = 'jurymembers';
    public function jury()
    {
        return $this->belongsTo(Jury::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
