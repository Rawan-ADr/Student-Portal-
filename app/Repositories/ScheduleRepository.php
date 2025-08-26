<?php   
  namespace App\Repositories;
  use Carbon\Carbon;
  use App\Models\Schedule;
  
  class ScheduleRepository implements ScheduleRepositoryInterface
  {


    public function add($request){
          $created = [];

    $year_id = $request['year_id'];
    $semester_id = $request['semester_id'];
    $day_id = $request['day_id'];

    foreach ($request['schedules'] as $sched) {
        $conflict = Schedule::where('day_id', $day_id)
    ->where('year_id', $year_id)
    ->where('semester_id', $semester_id)
    ->where(function($query) use ($sched) {
        // إذا الاختصاص موجود، نتحقق منه، وإذا null نتحقق من null
        if(isset($sched['specialization']) && $sched['specialization'] !== null) {
            $query->where('specialization', $sched['specialization']);
        } else {
            $query->whereNull('specialization');
        }
    })
    ->where(function($query) use ($sched) {
        $query->where(function($q) use ($sched) {
            $q->where('start_time', '<', $sched['end_time'])
              ->where('end_time', '>', $sched['start_time']);
        });
    })
    ->exists();

        if ($conflict) {
            return null;
        }

        $created[] = Schedule::create([
            'start_time' => $sched['start_time'],
            'end_time' => $sched['end_time'],
            'type' => $sched['type'],
            'semester_id' => $semester_id,
            'year_id' => $year_id,
            'course_id' => $sched['course_id'],
            'day_id' => $day_id,
            'doctor_name' => $sched['doctor_name'] ?? null,
            'specialization' => isset($sched['specialization']) ? trim($sched['specialization']) : null
        ]);
    }

    return $created;

    }

    public function get($request){

         $schedules = Schedule::with(['course', 'day'])
        ->where('year_id', $request['year_id'])
        ->where('semester_id', $request['semester_id'])
        ->orderBy('specialization') // ترتيب حسب الاختصاص أولًا
        ->orderBy('day_id')         // ثم ترتيب حسب اليوم
        ->orderBy('start_time')     // ثم ترتيب حسب الوقت
        ->get();

    return $schedules;
    }

  }