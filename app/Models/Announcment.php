<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcment extends Model
{
    use HasFactory;

    protected $table = 'announcments';

    protected $fillable = ['announcement'];
    public function class(){
        return $this->belongsTo(ClassModel::class);
    }
}
