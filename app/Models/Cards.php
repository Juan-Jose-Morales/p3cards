<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    public function thecollections(){
        return $this->belongsToMany(Collection::class);
    }
}
