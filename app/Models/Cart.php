<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;

class Cart extends Model
{
    use HasFactory;

    public function photo()
    {
        // 假设 photo_id_list 字段中存储的是 photo 表中的 id，建立一对多关系
        return $this->belongsTo(Photo::class);
    }
}
