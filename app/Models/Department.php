<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Str;

class Department extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(fn ($department) => [
            $department->dept_id = Str::uuid()->toString(),
        ]);
    }

    protected $fillable = [
        'dept_id',
        'd_name',
    ];

    protected $primaryKey = 'dept_id';

    public function courses()
    {
        return $this->hasMany(Course::class, 'dept_id', 'dept_id');
    }
}
