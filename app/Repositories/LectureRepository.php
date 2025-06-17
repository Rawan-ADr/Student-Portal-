<?php

namespace App\Repositories;
use App\Models\Lecture;
use App\Models\Course;
use App\Models\Year;
use App\Models\Semester;
use App\Models\Announcement;
use Carbon\Carbon;


    class LectureRepository implements LectureRepositoryInterface
{

    public function get($request){
        $course=Course::find($request['course_id']);
        if(!$course){
            return null;
        }
        else{

        $lectures=Lecture::where('course_id',$course->id)->where('type',$request['type'])->where('specialization',$request['specialization'])->get();

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
            'type'=> $request['type'],
            'specialization'=> $request['specialization'],
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

     public function addAnnouncement($request){

        $value = $request->file('value');
        $fileName = time() . '_' . $value->getClientOriginalName(); 
        $filePath = $value->storeAs('Announcement', $fileName, 'public');
    
        
        $Announcement = Announcement::create([
            'description' => $request['description'],
            'value' => $filePath,
            
        ]);

        return $Announcement;

    }

    public function getAnnouncement(){
       

        $Announcements=Announcement::latest()->get();

       

        $Announcements->transform(function ($Announcement) {
            $Announcement->file_url = url('storage/' . $Announcement->value);
           return $Announcement;
        });

        return $Announcements;
    }


}