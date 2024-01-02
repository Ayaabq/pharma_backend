<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;use SoftDeletes;
    protected $fillable=[
        'category_id',
        'scientific_name',
        'commercial_name',
        'company',
        'quantity_available',
        'createdat',
        'cost'
    ];


    protected $table ='products';
    function category(){
        return $this->belongsTo(Categorie::class,'category_id','id');

    }
   public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

}
