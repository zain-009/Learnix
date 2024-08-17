<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';

    protected $fillable = ['className', 'section', 'classCode', 'teacherName','teacherId','image'];
    public function users(){
        return $this->belongsToMany(User::class, 'class_users', 'class_id', 'user_id');
    }

    public function announements(){
        return $this->hasMany(Announcment::class);
    }

    public function materials(){
        return $this->hasMany(Material::class);
    }
} 
