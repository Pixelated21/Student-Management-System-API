<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Str;

class CourseType extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(
            fn ($courseType) => $courseType->ct_id = Str::uuid()->toString()
        );
    }

    protected $fillable = [
        'ct_id',
        'ct_name',
    ];

    protected $primaryKey = 'ct_id';

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
