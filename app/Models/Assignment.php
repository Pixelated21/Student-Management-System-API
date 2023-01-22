<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Str;

class Assignment extends Model
{
    use HasFactory;


    protected $fillable = [
        'ass_id',
        'ass_name',
        's_id',
        'c_id',
        'asst_id',
        'marks',
    ];

    public function assignmentType()
    {
        return $this->belongsTo(AssignmentType::class, 'asst_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 's_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'c_id');
    }

    public function scopeUuid($query, $uuid)
    {
        return $query->where('ass_id','=', $uuid);
    }

    public function scopeStudent($query, $uuid)
    {
        return  $query->where('s_id', $uuid);
    }

    public function scopeMarked($query){
        return $query->where('marks','!=',null);
    }

    public function scopeUnmarked($query){
        return $query->where('marks','=',null);
    }

    public function generateAssignments($data,$course){

    }

    public function gradeAssignment($gradesData){

        $this->marks = $gradesData['marks'];
        $this->save();

        }
}


