<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    public $table = "quizzes";
    public $fillable = ["class_id", "title", 'instructions', "file", 'marks', 'duration'];

    public function class() {
        return $this->belongsTo(ClassModel::class,'class_id');
    }
}
