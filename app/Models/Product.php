<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'type_id',
        'amount',
    ];

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $term = '%' . $term . '%';

            // Kiểm tra nếu term là số và tìm theo ID
            if (is_numeric($term)) {
                $query->where('id', $term);
            }

            // Tìm theo tên và mô tả
            $query->orWhere('name', 'like', $term)
                ->orWhere('description', 'like', $term);
        }
        return $query;
    }

    public function scopeSort($query, $sortBy, $sortDirection)
    {
        return $query->orderBy($sortBy, $sortDirection);
    }
}
