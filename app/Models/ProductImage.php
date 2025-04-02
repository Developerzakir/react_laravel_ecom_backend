<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        if ($this->image == "") {
            return "";
        }
        return asset('/uploads/products/small/'. $this->image);
    }
}
