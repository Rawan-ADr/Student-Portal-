<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FieldType;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'string',
            'text',
            'integer',
            'boolean',
            'date',
            'datetime',
            'float',
            'double',
            'email',
            'file',
            'image',
            'url',
            'password',
            'enum',
        ];

        foreach ($types as $type) {
            FieldType::updateOrInsert(
                ['type' => $type]
            );
        }
    }
    }

