<?php

namespace App;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * Using soft deletes property
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description','price','status',
    ];

    /**
     * Show all the products.
     *
     * @return LengthAwarePaginator
     * @var array
     */
    public function showAll(){
        return $this->withoutTrashed()->paginate();
    }


}
