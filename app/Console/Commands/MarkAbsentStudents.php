<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Attendance;
use App\Notifications\StudentAbsent;

class MarkAbsentStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-absent-students';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->format('Y-m-d');
        $students = Student::all();
        foreach ($students as $student) {
            $existing = Attendance::where('student_id', $student->id)
            ->where('attendance_date', $today)
            ->first();
        //
            if (!$existing) {
                Attendance::create([
                    'student_id' => $student->id,
                    'attendance_date' => $today,
                    'arrival_time' => null,
                    'status' => 'absent',
                    'scan_method' => 'system',
                ]);
                $student->notify(new StudentAbsent($student));
            }
        }
    }
}
