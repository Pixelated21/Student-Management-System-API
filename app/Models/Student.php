<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Str;

class Student extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(
            fn ($student) => [
                $student->s_id = Str::uuid()->toString(),
                $student->status = self::STATUS['pending']
            ]
        );
    }

    // Constants for student's status
    const STATUS = [
        'pending' => 2,
        'approved' => 1,
        'rejected' => 0,
    ];

    protected $fillable = [
        's_id',
        'name',
        'section',
        'email_id',
        'profile_pic',
        'c_id',
        'mobile',
        'address',
        'status',
    ];

    protected $primaryKey = 's_id';

    public function course()
    {
        return $this->belongsTo(Course::class, 'c_id', 'c_id');
    }
    // public function courses()
    // {
    //     return $this->belongsToMany(Course::class, 'course_student', 'c_id', 'c_id');
    // }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 's_id', 's_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 's_id', 's_id');
    }

    public function scopeUuid($query, $uuid)
    {
        return $query->where('s_id', '=', $uuid);
    }

    public function scopeOrEmail($query, $email)
    {
        return $query->orWhere('email_id', 'like', '%' . $email . '%');
    }

    public function scopeOrMobile($query, $mobile)
    {
        return $query->orWhere('mobile', '=', '%' . $mobile . '%');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS['approved']);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS['pending']);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS['rejected']);
    }

    public function generateStudent($student, $course)
    {

        // $this->courses()->attach($course);
        $this->s_id = Str::uuid()->toString();

        $this->c_id = $course['c_id'];
        $this->section = $course['section'];

        $this->name = $student['name'];
        $this->email_id = $student['email'];
        $this->mobile = $student['mobile'];
        $this->address = $student['address'];
        // $this->profile_pic = $student['profile_pic'];

        $this->save();
        return $this;
    }
}
