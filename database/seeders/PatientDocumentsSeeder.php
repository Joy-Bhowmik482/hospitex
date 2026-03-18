<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\PatientDocument;

class PatientDocumentsSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();

        $u = \App\Models\User::first();
        $uploadedBy = $u ? $u->id : null;

        foreach ($patients as $patient) {
            PatientDocument::create([
                'patient_id' => $patient->id,
                'title' => 'ID Document',
                'file_path' => 'documents/sample-id.pdf',
                'file_type' => 'application/pdf',
                'uploaded_by' => $uploadedBy,
            ]);
        }
    }
}
