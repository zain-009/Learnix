<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $table = 'assignments';

    protected $fillable = ["class_id", 'title', 'instructions', 'file', 'duration'];

    public function class() {
        return $this->belongsTo(ClassModel::class,'class_id');
    }
}
