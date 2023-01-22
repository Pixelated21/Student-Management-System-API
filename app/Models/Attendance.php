<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    const IS_PRESENT = [
        true => true,
        false => false,
    ];

    protected $fillable = [
        's_id',
        'c_id',
        'p/a',
        'total_classes',
    ];

    protected $primaryKey = '_id';

    public function student()
    {
        return $this->belongsTo(Student::class, 's_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'c_id');
    }

    //  Scope to get all attendance records that are present
    public function scopePresent($query){
        return $query->where('p/a', true);
    }

    // Scope to get all attendance records that are absent
    public function scopeAbsent($query){
        return $query->where('p/a', false);
    }

    // Scope to get the total number of classes
    public function scopeTotalClasses($query){
        return $query->sum('total_classes');
    }

    // Scope to get the attendance for a particular student
    public function scopeStudent($query, $student){
        return $query->where('s_id', $student['s_id']);
    }

    // Scope to get the attendance for a particular course
    public function scopeCourse($query, $course){
        return $query->where('c_id', $course['c_id']);
    }

    public static function markAttendance($attendanceData, string $course): bool{

        // TODO: Check if student is belongs to the course
        // TODO: Check if the attendance is already marked for the student today

        // Creates a new attendance record for each $students and assigns the $course and $isPresent
        foreach($attendanceData as $student){
            $attendance = new Attendance();

            $attendance->s_id = $student['s_id'];
            $attendance['p/a'] = $student['isPresent'];

            $attendance->c_id = $course;
            $attendance->total_classes = 1;

            $isSaved = $attendance->save();
            if(!$isSaved){
                return false;
            }
        }
        return true;
    }
}
