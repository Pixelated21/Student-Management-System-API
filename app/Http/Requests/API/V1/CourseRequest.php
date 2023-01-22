<?php

namespace App\Http\Requests\API\V1;

use App\Http\Requests\API\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    const PREFIX = 'courses.';
    const ROUTE = [
        'index' => self::PREFIX . 'index', // List all courses
        'show' => self::PREFIX . 'show', // Show a course
        'store' => self::PREFIX . 'store', // Store a course
        'destroy' => self::PREFIX . 'destroy', // Store a course
        'edit' => self::PREFIX . 'edit', // Edit a course
        'update' => self::PREFIX . 'update', // Update a course
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Stores the current request route
        $currentRouteName = $this->route()->getName();

        if ($currentRouteName === self::ROUTE['index']) {
            return [];
        }

        if ($currentRouteName === self::ROUTE['show']) {

            return [];
        }

        if ($currentRouteName === self::ROUTE['store']) {
            return [
                'name' => ['bail', 'required', 'string', 'max:150', Rule::unique('courses', 'c_name')],
                'course_type' => ['bail','required', 'uuid', Rule::exists('course_types', 'ct_id')],
                'department' =>  ['bail','required', 'uuid', Rule::exists('departments', 'dept_id')],
                'qualifications' => ['required', 'string'],
            ];
        }

        if ($currentRouteName === self::ROUTE['destroy']) {
            return [];
        }

        if ($currentRouteName === self::ROUTE['update']) {
            return [
                'name' => ['bail', 'required', 'string', 'max:150', Rule::unique('courses', 'c_name')->ignore($this->course)],
                'course_type' => ['bail','required', 'uuid', Rule::exists('course_types', 'ct_id')],
                'department' =>  ['bail','required', 'uuid', Rule::exists('departments', 'dept_id')],
                'qualifications' => ['required', 'string'],
            ];
        }
        return [];
    }
}
