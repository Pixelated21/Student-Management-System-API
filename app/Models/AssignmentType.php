<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Str;

class AssignmentType extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($assignment_type) {
            $assignment_type->asst_id = Str::uuid()->toString();
        });
    }

    protected $fillable = [
        'asst_id',
        'asst_name',
    ];

    protected $primaryKey = 'asst_id';

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'asst_id', 'asst_id');
    }
}
