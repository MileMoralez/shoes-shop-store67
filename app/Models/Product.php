<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

   protected $fillable = [
    'name',
    'slug',
    'description',
    'price',
    'quantity', // បន្ថែមថ្មី
    'image',
    'image_2',  // បន្ថែមថ្មី
    'image_3',  // បន្ថែមថ្មី
    'category',
    'is_featured',
];
}