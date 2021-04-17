<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'deleted_at', 'id_user_created', 'id_user_updated', 'id_user_deleted'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
    * Apply filter to query*
    * @param Request $request
    **/
    public function scopeFilters($query, Request $request){
        if ($request->id) {
            $query->where('id', $request->id);
        }
        if ($request->name) {
            $query->where('name', 'rlike',$request->name);
        }
        if ($request->email) {
            $query->where('email', 'rlike',$request->email);
        }
        $query->whereNull('deleted_at')->orderBy('name');
    }
}
