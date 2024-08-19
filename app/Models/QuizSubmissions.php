<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSubmissions extends Model
{
    use HasFactory;

    public $table = 'quiz_submissions';

    public $fillable = ['quiz_id', 'turn_in_time', 'file'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
