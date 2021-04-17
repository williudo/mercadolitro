<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Orders extends Model
{
    use SoftDeletes;
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'product_id', 'status', 'tracking_number', 'date_order_paid', 'date_order_shipped'
    ];

    /**
    * Apply filter to query*
    * @param Request $request
    **/
    public function scopeFilters($query, Request $request){
        if ($request->status) {
            $query->where('status', 'rlike',$request->status);
        }
        if ($request->tracking_number) {
            $query->where('tracking_number', 'rlike', $request->tracking_number);
        }
        if ($request->client_id) {
            $query->where('client_id', $request->client_id);
        }
        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        $query->whereNull('deleted_at');
    }

    /**
     * Get the user that owns the phone.
     */
    public function client()
    {
        return $this->belongsTo(Clients::class);
    }

    /**
     * Get the user that owns the phone.
     */
    public function product()
    {
        return $this->hasOne(Products::class);
    }

}
