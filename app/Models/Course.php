<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Str;

class Course extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(
            fn ($course) => $course->c_id = Str::uuid()->toString()
        );
    }

    protected $dispatchEvents = [
        'deleting' => CourseDeleted::class,
    ];

    protected $fillable = [
        'c_id',
        'c_name',
        'ct_id',
        'dept_id',
        'qualifications',
    ];

    protected $primaryKey = 'c_id';

    public function courseType()
    {
        return $this->belongsTo(CourseType::class, 'ct_id', 'ct_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'c_id', 'c_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'c_id', 'c_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'c_id', 'c_id');
    }

    public function scopeUuid($query, $uuid)
    {
        return $query->where('c_id', '=', $uuid);
    }

    public function generateAssignments($data)
    {
        // return $assignment;
        $students = Student::where('c_id', $this->c_id)
            ->where('status', Student::STATUS['approved'])
            ->get();

        // return $students;

        // If no students are enrolled in the course, exits function
        if ($students->count() == 0) {
            return false;
        }

        // Create assignments for each student within the course
        foreach ($students as $student) {
            $assignment = new Assignment();
            $assignment->ass_id = Str::uuid()->toString(); // Assignment ID
            $assignment->marks = null;

            $assignment->asst_id = $data['asst_id']; // Assignment Type ID
            $assignment->c_id = $this->c_id; // Course ID
            $assignment->s_id = $student->s_id; // Student ID
            $assignment->ass_name = $data['assignment_name'];

            $isSaved = $assignment->save();

            if (!$isSaved) {
                return false;
            }
        }
        return true;
    }
}
