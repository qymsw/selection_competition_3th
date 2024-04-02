<?php

namespace App\Models;
use App\Models\Frame;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'frame_id',
    ];
    public function frame(){
        return $this->belongsTo('App\Models\Frame');
    }
}
