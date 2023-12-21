<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
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
