<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    use HasFactory;
    public function size(){
        return $this->belongsTo('App\Models\Size');
    }
    protected $fillable = [
        'price',        
        'size_id',        
        'name',        
    ];
}
