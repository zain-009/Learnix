<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmissions extends Model
{
    use HasFactory;

    public $table = 'assignment_submissions';

    public $fillable = ['assignment_id', 'turn_in_time', 'file'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
