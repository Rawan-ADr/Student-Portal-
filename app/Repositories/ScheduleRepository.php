<?php   
  namespace App\Repositories;
  use Carbon\Carbon;
  use App\Models\Schedule;
  
  class ScheduleRepository implements ScheduleRepositoryInterface
  {


    public function add($request){
        $schedule = Schedule::create([
            'start_time' => $request['start_time'],
            'end_time' => $request['end_time'],
            'type' => $request['type'],
            'semester_id' => $request['semester_id'],
            'year_id' => $request['year_id'],
            'course_id' => $request['course_id'],
            'day_id' => $request['day_id'],
        ]);
        return $schedule;

    }

    public function get($request){

        $schedules = Schedule::with(['course', 'day'])
        ->where('year_id', $request['year_id'])
        ->where('semester_id', $request['semester_id'])
        ->orderBy('day_id')
        ->orderBy('start_time')
        ->get()
        ->groupBy('day.name');

        return $schedules;
    }

  }