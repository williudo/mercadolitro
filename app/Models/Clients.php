<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Clients extends Model
{
    use SoftDeletes;
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'document_id', 'phone_number', 'address', 'address_number', 'complement', 'city', 'state'
    ];

    /**
    * Apply filter to query*
    * @param Request $request
    **/
    public function scopeFilters($query, Request $request){
        if ($request->name) {
            $query->where('name', 'rlike',$request->name);
        }
        if ($request->address) {
            $query->where('address', 'rlike', $request->address);
        }
        if ($request->city) {
            $query->where('city', 'rlike', $request->city);
        }
        if ($request->state) {
            $query->where('state', 'rlike', $request->state);
        }
        if ($request->phone_number) {
            $query->where('phone_number', 'rlike', $request->phone_number);
        }
        if ($request->document_id) {
            $query->where('document_id', $request->document_id);
        }
        $query->whereNull('deleted_at')->orderBy('name');
    }

    /**
     * Get the user that owns the phone.
     */
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}
