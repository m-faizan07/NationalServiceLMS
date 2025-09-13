<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingBatch;
use App\Models\CertificateProgram;
use App\Models\Student;
use App\Models\StudentProfile;
use App\Models\Address;
use App\Models\ParentDetail;
use App\Models\StudentDocument;
use App\Models\Interview;
use App\Models\Deployment;
use App\Models\StudentTrainingEnrollment;
use App\Models\StudentCertificate;

class NationalServiceLMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample training batches
        $batches = [
            [
                'batch_name' => 'National Service Batch 2024-01',
                'batch_code' => 'NS2024-001',
                'start_date' => '2024-01-15',
                'end_date' => '2024-06-15',
                'status' => 'active',
                'capacity' => 50,
                'enrolled_count' => 35,
                'description' => 'First batch of 2024 for National Service training program'
            ],
            [
                'batch_name' => 'National Service Batch 2024-02',
                'batch_code' => 'NS2024-002',
                'start_date' => '2024-07-01',
                'end_date' => '2024-12-01',
                'status' => 'active',
                'capacity' => 50,
                'enrolled_count' => 0,
                'description' => 'Second batch of 2024 for National Service training program'
            ]
        ];

        foreach ($batches as $batchData) {
            TrainingBatch::create($batchData);
        }

        // Create sample certificate programs
        $certificatePrograms = [
            [
                'program_name' => 'Advanced Leadership Certificate',
                'description' => 'Advanced leadership and management skills for National Service personnel',
                'duration_months' => 6,
                'cost' => 5000.00,
                'status' => 'active'
            ],
            [
                'program_name' => 'Emergency Response Certificate',
                'description' => 'Specialized training in emergency response and crisis management',
                'duration_months' => 4,
                'cost' => 3500.00,
                'status' => 'active'
            ]
        ];

        foreach ($certificatePrograms as $programData) {
            CertificateProgram::create($programData);
        }

        // Create sample students with complete profiles
        $students = [
            [
                'name' => 'Ahmed Hassan',
                'email' => 'ahmed.hassan@example.com',
                'password' => bcrypt('password123'),
                'profile_completed' => true,
                'status' => 'approved',
                'application_stage' => 'approved',
                'is_reachable' => true,
                'is_under_age_18' => false,
                'application_date' => '2024-01-10'
            ],
            [
                'name' => 'Fatima Ali',
                'email' => 'fatima.ali@example.com',
                'password' => bcrypt('password123'),
                'profile_completed' => true,
                'status' => 'pending',
                'application_stage' => 'under_review',
                'is_reachable' => true,
                'is_under_age_18' => false,
                'application_date' => '2024-01-12'
            ],
            [
                'name' => 'Mohammed Ibrahim',
                'email' => 'mohammed.ibrahim@example.com',
                'password' => bcrypt('password123'),
                'profile_completed' => true,
                'status' => 'approved',
                'application_stage' => 'interview_completed',
                'is_reachable' => true,
                'is_under_age_18' => false,
                'application_date' => '2024-01-08'
            ]
        ];

        foreach ($students as $studentData) {
            $student = Student::create($studentData);

            // Create profile for each student
            $profileData = [
                'student_id' => $student->id,
                'first_name' => explode(' ', $student->name)[0],
                'last_name' => explode(' ', $student->name)[1] ?? '',
                'nid' => 'NID' . str_pad($student->id, 6, '0', STR_PAD_LEFT),
                'mobile_no' => '+960' . rand(7000000, 9999999),
                'dob' => '1995-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT)
            ];

            StudentProfile::create($profileData);

            // Create addresses
            $addresses = [
                [
                    'student_id' => $student->id,
                    'type' => 'permanent',
                    'atoll' => 'Male Atoll',
                    'island' => 'Male',
                    'district' => 'Central District',
                    'address' => 'House ' . rand(1, 100) . ', Street ' . rand(1, 50)
                ],
                [
                    'student_id' => $student->id,
                    'type' => 'present',
                    'atoll' => 'Male Atoll',
                    'island' => 'Male',
                    'district' => 'Central District',
                    'address' => 'Apartment ' . rand(1, 50) . ', Building ' . rand(1, 20)
                ]
            ];

            foreach ($addresses as $addressData) {
                Address::create($addressData);
            }

            // Create parent details
            $parentData = [
                'student_id' => $student->id,
                'father_name' => 'Mr. ' . explode(' ', $student->name)[1] . ' ' . explode(' ', $student->name)[0],
                'father_occupation' => 'Business Owner',
                'father_contact' => '+960' . rand(7000000, 9999999),
                'mother_name' => 'Mrs. ' . explode(' ', $student->name)[1] . ' ' . explode(' ', $student->name)[0],
                'mother_occupation' => 'Teacher',
                'mother_contact' => '+960' . rand(7000000, 9999999)
            ];

            ParentDetail::create($parentData);

            // Create sample documents
            $documentTypes = ['id_card', 'birth_certificate', 'educational_certificate'];
            foreach ($documentTypes as $type) {
                StudentDocument::create([
                    'student_id' => $student->id,
                    'type' => $type,
                    'file_name' => $type . '_' . $student->id . '.pdf',
                    'file_path' => 'documents/' . $type . '_' . $student->id . '.pdf',
                    'file_size' => rand(100000, 5000000)
                ]);
            }
        }

        // Create sample interviews
        $students = Student::all();
        foreach ($students as $student) {
            if ($student->application_stage === 'interview_completed') {
                Interview::create([
                    'student_id' => $student->id,
                    'scheduled_at' => now()->subDays(rand(1, 30)),
                    'status' => 'completed',
                    'interviewer_name' => 'Captain ' . ['Ahmed', 'Hassan', 'Ibrahim'][rand(0, 2)],
                    'result' => 'pass',
                    'feedback' => 'Excellent candidate with strong potential for National Service.'
                ]);
            }
        }

        // Create sample deployments
        $approvedStudents = Student::where('status', 'approved')->get();
        foreach ($approvedStudents as $student) {
            $units = ['mndf', 'police', 'other'];
            $unit = $units[rand(0, 2)];

            Deployment::create([
                'student_id' => $student->id,
                'unit' => $unit,
                'unit_name' => $unit === 'mndf' ? 'Maldives National Defence Force' : ($unit === 'police' ? 'Maldives Police Service' : 'Special Operations Unit'),
                'position' => ['Private', 'Corporal', 'Sergeant'][rand(0, 2)],
                'deployment_date' => now()->subDays(rand(1, 60)),
                'status' => 'active',
                'notes' => 'Successfully deployed and performing well in assigned role.'
            ]);
        }

        // Create sample training enrollments
        $batch = TrainingBatch::where('status', 'active')->first();
        if ($batch) {
            foreach ($students as $student) {
                if ($student->status === 'approved') {
                    StudentTrainingEnrollment::create([
                        'student_id' => $student->id,
                        'training_batch_id' => $batch->id,
                        'status' => 'in_training',
                        'enrollment_date' => now()->subDays(rand(1, 30)),
                        'notes' => 'Enrolled in National Service training program.'
                    ]);
                }
            }
        }

        // Create sample certificates
        $certificateProgram = CertificateProgram::first();
        if ($certificateProgram) {
            foreach ($students as $student) {
                if ($student->status === 'approved' && rand(0, 1)) {
                    StudentCertificate::create([
                        'student_id' => $student->id,
                        'certificate_program_id' => $certificateProgram->id,
                        'completion_date' => now()->subDays(rand(1, 90)),
                        'certificate_number' => 'CERT-' . str_pad($student->id, 6, '0', STR_PAD_LEFT),
                        'status' => 'active',
                        'notes' => 'Successfully completed certificate program.'
                    ]);
                }
            }
        }
    }
}
