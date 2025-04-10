<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasUlids, HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['name', 'phone'];


    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_student',
            'student_id', 'lesson_id')->withTimestamps();
    }
}
