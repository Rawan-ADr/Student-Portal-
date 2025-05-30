<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditionId = DB::table('conditions')->insertGetId([
            'name' => 'one_document_per_year',
            'validation_query' => '
                SELECT COUNT(*) AS count 
                FROM requests 
                WHERE student_id = :student_id 
                AND academic_year_id = :academic_year_id
            ',
            'error_message' => 'لا يمكنك تقديم أكثر من وثيقة دوام في نفس العام الدراسي!',
        ]);

        // ربط الباراميترات بالشرط
        DB::table('condition_parameters')->insert([
            [
                'condition_id' => $conditionId,
                'name' => 'student_id',
                'source' => 'student_id',
            ],
            [
                'condition_id' => $conditionId,
                'name' => 'academic_year_id',
                'source' => 'academic_year_id',
            ],
        ]);
    }
    }

