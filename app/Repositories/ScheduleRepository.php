<?php   
  namespace App\Repositories;
  use Carbon\Carbon;
  use App\Models\Schedule;
  
  class ScheduleRepository implements ScheduleRepositoryInterface
  {


    public function add($request){
          $conflict = Schedule::where('day_id', $request['day_id'])
          ->where('year_id', $request['year_id'])
          ->where('semester_id', $request['semester_id'])
          ->where(function($query) use ($request) {
              $query->where(function($q) use ($request) {
                  $q->where('start_time', '<', $request['end_time'])
                    ->where('end_time', '>', $request['start_time']);
              });
          })
          ->exists();

            if ($conflict) {
                return null;
      }
        $schedule = Schedule::create([
            'start_time' => $request['start_time'],
            'end_time' => $request['end_time'],
            'type' => $request['type'],
            'semester_id' => $request['semester_id'],
            'year_id' => $request['year_id'],
            'course_id' => $request['course_id'],
            'day_id' => $request['day_id'],
            'doctor_name'=>$request['doctor_name']?? null
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