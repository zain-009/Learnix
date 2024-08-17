<?php

namespace App\Models;

use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    public $table = "materials";
    public $fillable = ["class_id", "title", "file"];

    public function class() {
        return $this->belongsTo(ClassModel::class,'class_id');
    }
}
