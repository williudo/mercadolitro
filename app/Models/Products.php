<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Products extends Model
{
    use SoftDeletes;
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'quantity', 'price', 'color', 'deleted_at', 'id_user_created', 'id_user_updated', 'id_user_deleted'
    ];

    /**
    * Apply filter to query*
    * @param Request $request
    **/
    public function scopeFilters($query, Request $request){
        if ($request->name) {
            $query->where('name', 'rlike',$request->name);
        }
        if ($request->description) {
            $query->where('description', 'rlike', $request->description);
        }
        if ($request->color) {
            $query->where('color', $request->color);
        }
        $query->whereNull('deleted_at')->orderBy('name');
    }
}
