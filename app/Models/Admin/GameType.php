<?php

namespace App\Models\Admin;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'order', 'img'];

    protected $appends = ['image', 'img_url'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'game_type_product')->withPivot('image');
    }

    public function getImageAttribute() //getImageAttribute
    {
        return $this->products->pluck('pivot.image');
    }

    // getImgUrlAttribute
    public function getImgUrlAttribute()
    {
        return asset('assets/img/game_type/'.$this->img);
    }

    public function scopeFilter(Builder $query ,array $data) : Builder {
        return $query
            ->when(!empty($data['search_input']), function ($q) use ($data) {
                $q->whereHas('products', function ($p) use ($data) {
                        $p->where('name', 'like', '%' . $data['search_input'] . '%');
                    });
            });
    }

}
