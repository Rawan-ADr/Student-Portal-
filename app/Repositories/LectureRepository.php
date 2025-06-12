<?php

namespace App\Repositories;
use App\Models\Lecture;
use App\Models\Course;
use App\Models\Year;
use App\Models\Semester;
use Carbon\Carbon;


    class LectureRepository implements LectureRepositoryInterface
{

    public function get($request){
        $course=Course::find($request['course_id']);
        if(!$course){
            return null;
        }
        else{

        $lectures=Lecture::where('course_id',$course->id)->get();

        if ($lectures->isEmpty()) {
            return null;
        }

        $lectures->transform(function ($lecture) {
            $lecture->file_url = url('storage/' . $lecture->path);
            return $lecture;
        });

        return $lectures;}
    }



    public function add($request){

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName(); 
        $filePath = $file->storeAs('lectures', $fileName, 'public');
    
        
        $lecture = Lecture::create([
            'name' => $request['name'],
            'course_id' => $request['course_id'],
            'path' => $filePath,
            'date' => Carbon::now(), 
        ]);

        return $lecture;

    }

    public function getCourse($request){
        $course=Course::where('semester_id',$request['semester_id'])
        ->where('year_id',$request['year_id'])->get();
        if(!$course){
            return null;
        }
        else{
        return $course;
        }
    }


    public function getSemester(){
       $semester= Semester::all();
        if(!$semester){
            return null;
        }
        else{
        return $semester;
        }
    }

    public function getYear(){
        $Years= Year::all();
         if(!$Years){
             return null;
         }
         else{
         return $Years;
         }
     }
}