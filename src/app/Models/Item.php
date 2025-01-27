<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'condition_id',
        'name',
        'description',
        'price',
        'image',
        'is_sold',
        'brand_name',
        'category_id',   
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function categories()
    {
    return $this->belongsToMany(Category::class);

    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    protected $casts = [
        'is_sold' => 'boolean',  // これで is_sold を boolean としてキャスト
    ];
}

