<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
use HasFactory;
protected $fillable = [
'product_id', 'user_id', 'image'
];

/**
 * product
 *
 * @return void
 */
public function product()
{
return $this->belongsTo(Product::class);
}


/**
* getImageAttribute
*
* @param mixed $image
* @return void
*/
public function getImageAttribute($image)
{
return asset('storage/galleries/' . $image);
}
}
