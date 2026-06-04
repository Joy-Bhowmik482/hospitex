<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Faker\Factory as Faker;

class PatientsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_IN');
        
        $firstNames = ['Ramesh', 'Kavya', 'Suresh', 'Ananya', 'Vikram', 'Priya', 'Rajesh', 'Neha', 'Arjun', 'Divya', 
                      'Amit', 'Shreya', 'Rohan', 'Anika', 'Sanjay', 'Pooja', 'Karan', 'Isha', 'Harish', 'Rani',
                      'Naresh', 'Anjali', 'Manish', 'Sakshi', 'Ashok', 'Ritu', 'Nitin', 'Avni', 'Sushil', 'Vedya',
                      'Rajiv', 'Preeti', 'Sandeep', 'Sneha', 'Varun', 'Anu', 'Abhishek', 'Disha', 'Nikhil', 'Tejas',
                      'Prakash', 'Ritika', 'Vishal', 'Simran', 'Kumar', 'Priyanka', 'Aryan', 'Zara', 'Gaurav', 'Meera'];
        $lastNames = ['Kumar', 'Singh', 'Patel', 'Sharma', 'Gupta', 'Verma', 'Reddy', 'Iyer', 'Nair', 'Joshi',
                     'Malhotra', 'Chopra', 'Kapoor', 'Desai', 'Agarwal', 'Pandey', 'Tiwari', 'Saxena', 'Bhat', 'Das'];
        
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $genders = ['Male', 'Female'];
        
        $medicalConditions = [
            'No known conditions',
            'Hypertension',
            'Diabetes',
            'Asthma',
            'Heart Disease',
            'Thyroid',
            'Arthritis',
            'Migraine',
            'Allergic Rhinitis',
        ];
        
        $allergies = [
            'No known allergies',
            'Penicillin',
            'Aspirin',
            'Sulphonamides',
            'NSAIDs',
            'Peanuts',
            'Shellfish',
            'Latex',
        ];

        for ($i = 1; $i <= 50; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $email = strtolower($firstName . '.' . $lastName . $i . '@patient.com');
            $phone = '9' . rand(100000000, 999999999);

            Patient::firstOrCreate([
                'email' => $email,
            ], [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $phone,
                'age' => (string) rand(5, 90),
                'gender' => $genders[array_rand($genders)],
                'address' => $faker->streetAddress,
                'blood_type' => $bloodGroups[array_rand($bloodGroups)],
                'allergies' => $allergies[array_rand($allergies)],
                'medical_conditions' => $medicalConditions[array_rand($medicalConditions)],
                'emergency_contact_name' => $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)],
                'emergency_contact_phone' => '9' . rand(100000000, 999999999),
                'date_admitted' => now()->subDays(rand(0, 365))->toDateString(),
                'status' => ['In', 'Out'][array_rand(['In', 'Out'])],
                'notes' => 'Patient created via seeder',
            ]);
        }
    }
}
