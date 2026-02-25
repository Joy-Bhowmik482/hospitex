# Patient Management System - Complete Implementation Guide

## Overview
A comprehensive patient management system built with Laravel that includes patient profiles, medical history tracking, admission/discharge management, and document handling.

## Features Implemented

### 1. **Patient List**
- View all patients with pagination (15 per page)
- Display patient status (In-patient/Out-patient)
- Quick actions to view, edit, or delete patients
- Search and filter capabilities

**Route:** `GET /patients`
**View:** `resources/views/patients/index.blade.php`

### 2. **Add/Edit Patient**
- Comprehensive patient registration form
- Fields include:
  - Personal Information (Name, Email, Phone, DOB, Gender)
  - Contact Details (Address, City, State, Postal Code, Country)
  - Medical Information (Blood Type, Allergies, Medical Conditions)
  - Emergency Contact Information
  - Patient Status (In-patient/Out-patient)

**Routes:**
- `GET /patients/create` - Create form
- `POST /patients` - Store patient
- `GET /patients/{patient}/edit` - Edit form  
- `PUT /patients/{patient}` - Update patient

**Views:**
- `resources/views/patients/create.blade.php`
- `resources/views/patients/edit.blade.php`

### 3. **Patient Profile**
- Complete patient overview with all sections
- Displays all related information and records
- Central hub for managing patient data

**Route:** `GET /patients/{patient}`
**View:** `resources/views/patients/show.blade.php`

### 4. **Medical History**
- Track patient medical conditions and treatments
- Record diagnosis dates and prescribed medications
- Add detailed treatment notes
- Multiple history entries per patient

**Database Fields:**
- condition, diagnosis_date
- treatment, medications, notes

**Routes:**
- `GET /patients/{patient}/medical-histories/create`
- `POST /patients/{patient}/medical-histories`
- `GET /patients/{patient}/medical-histories/{medicalHistory}/edit`
- `PUT /patients/{patient}/medical-histories/{medicalHistory}`
- `DELETE /patients/{patient}/medical-histories/{medicalHistory}`

**Views:**
- `resources/views/medical_histories/create.blade.php`
- `resources/views/medical_histories/edit.blade.php`

### 5. **Admission / Discharge**
- Record patient admissions with detailed information
- Track ward assignments and bed numbers
- Monitor admission status (Admitted, Discharged, Cancelled)
- Automatic patient status updates based on admission status
- Discharge notes and reason for admission

**Database Fields:**
- admission_date, discharge_date
- ward, bed_number
- reason_for_admission, diagnosis
- treatment_plan, discharge_notes
- status (Admitted, Discharged, Cancelled)

**Routes:**
- `GET /patients/{patient}/admissions/create`
- `POST /patients/{patient}/admissions`
- `GET /patients/{patient}/admissions/{admission}/edit`
- `PUT /patients/{patient}/admissions/{admission}`
- `DELETE /patients/{patient}/admissions/{admission}`

**Views:**
- `resources/views/admissions/create.blade.php`
- `resources/views/admissions/edit.blade.php`

### 6. **Patient Documents**
- Upload and manage patient medical documents
- Support for various document types:
  - Medical Reports
  - Prescriptions
  - Lab Tests
  - X-Rays, MRIs, CT Scans
  - Ultrasounds
  - Insurance Documents
  - Custom types
- File storage with document metadata
- Download and delete documents
- Maximum file size: 10MB

**Database Fields:**
- document_type, file_name, file_path
- mime_type, file_size
- description, document_date

**Routes:**
- `GET /patients/{patient}/documents/create`
- `POST /patients/{patient}/documents`
- `GET /patients/{patient}/documents/{document}/download`
- `DELETE /patients/{patient}/documents/{document}`

**View:**
- `resources/views/documents/create.blade.php`

### 7. **Patient Status**
- Track patient status: In-patient or Out-patient
- Automatically updated based on admission records
- Visual indicators in patient list and profile

## Database Schema

### patients table
```sql
- id (primary key)
- first_name, last_name
- email (unique), phone
- date_of_birth, gender
- address, city, state, postal_code, country
- blood_type, allergies, medical_conditions
- emergency_contact_name, emergency_contact_phone
- patient_status (enum: 'In-patient', 'Out-patient')
- timestamps, soft_deletes
```

### medical_histories table
```sql
- id (primary key)
- patient_id (foreign key)
- condition, diagnosis_date
- treatment, medications, notes
- timestamps
```

### admissions table
```sql
- id (primary key)
- patient_id (foreign key)
- admission_date, discharge_date
- ward, bed_number
- reason_for_admission, diagnosis
- treatment_plan, discharge_notes
- status (enum: 'Admitted', 'Discharged', 'Cancelled')
- timestamps
```

### patient_documents table
```sql
- id (primary key)
- patient_id (foreign key)
- document_type, file_name, file_path
- mime_type, file_size
- description, document_date
- timestamps
```

## Models

### Patient Model (`app/Models/Patient.php`)
- Relationships:
  - `medicalHistories()` - One-to-Many
  - `admissions()` - One-to-Many
  - `documents()` - One-to-Many
- Accessors:
  - `full_name` - Combined first and last name
  - `age` - Calculated from date_of_birth

### MedicalHistory Model (`app/Models/MedicalHistory.php`)
- Relationship:
  - `patient()` - Belongs-to Patient

### Admission Model (`app/Models/Admission.php`)
- Relationship:
  - `patient()` - Belongs-to Patient

### PatientDocument Model (`app/Models/PatientDocument.php`)
- Relationship:
  - `patient()` - Belongs-to Patient

## Controllers

### PatientController (`app/Http/Controllers/PatientController.php`)
- index() - List all patients
- create() - Show create form
- store() - Store new patient
- show() - Display patient profile
- edit() - Show edit form
- update() - Update patient
- destroy() - Delete patient

### MedicalHistoryController (`app/Http/Controllers/MedicalHistoryController.php`)
- create() - Show form
- store() - Add history
- edit() - Show edit form
- update() - Update history
- destroy() - Delete history

### AdmissionController (`app/Http/Controllers/AdmissionController.php`)
- create() - Show form
- store() - Create admission
- edit() - Show edit form
- update() - Update admission
- destroy() - Delete admission

### PatientDocumentController (`app/Http/Controllers/PatientDocumentController.php`)
- create() - Show upload form
- store() - Upload document
- download() - Download document
- destroy() - Delete document

## Migrations

All migrations are located in `database/migrations/`:

1. `2026_02_18_000001_create_patients_table.php`
2. `2026_02_18_000002_create_medical_histories_table.php`
3. `2026_02_18_000003_create_admissions_table.php`
4. `2026_02_18_000004_create_patient_documents_table.php`

**To run migrations:**
```bash
php artisan migrate
```

## Routes

All routes are defined in `routes/web.php`:

```php
// Patient Management (Resource Routes)
Route::resource('patients', PatientController::class);

// Medical History Routes
Route::post('/patients/{patient}/medical-histories', [MedicalHistoryController::class, 'store'])->name('medical-histories.store');
Route::get('/patients/{patient}/medical-histories/create', [MedicalHistoryController::class, 'create'])->name('medical-histories.create');
// ... [edit, update, destroy routes]

// Admission Routes
Route::post('/patients/{patient}/admissions', [AdmissionController::class, 'store'])->name('admissions.store');
Route::get('/patients/{patient}/admissions/create', [AdmissionController::class, 'create'])->name('admissions.create');
// ... [edit, update, destroy routes]

// Patient Document Routes
Route::post('/patients/{patient}/documents', [PatientDocumentController::class, 'store'])->name('documents.store');
Route::get('/patients/{patient}/documents/create', [PatientDocumentController::class, 'create'])->name('documents.create');
Route::get('/patients/{patient}/documents/{document}/download', [PatientDocumentController::class, 'download'])->name('documents.download');
// ... [destroy route]
```

## Views

All views are in `resources/views/`:

- `layouts/app.blade.php` - Main layout template
- `patients/`:
  - `index.blade.php` - Patient list
  - `create.blade.php` - Add patient form
  - `edit.blade.php` - Edit patient form
  - `show.blade.php` - Patient profile (includes all sections)
- `medical_histories/`:
  - `create.blade.php` - Add medical history form
  - `edit.blade.php` - Edit medical history form
- `admissions/`:
  - `create.blade.php` - New admission form
  - `edit.blade.php` - Edit admission form
- `documents/`:
  - `create.blade.php` - Upload document form

## Installation & Setup

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Configure Storage
Ensure public storage is linked:
```bash
php artisan storage:link
```

### 3. Start Laravel Server
```bash
php artisan serve
```

### 4. Access Patient Management
Navigate to: `http://localhost:8000/patients`

## File Upload Configuration

Patient documents are stored in `storage/app/public/patient_documents/{patient_id}/`

**Configuration in `.env`:**
```
FILESYSTEM_DISK=local
```

## Validation Rules

### Patient Creation/Update
- first_name, last_name: Required, string, max 255
- email: Required, unique, must be email
- date_of_birth: Required, must be before today
- gender: Required, in (Male, Female, Other)
- patient_status: Required, in (In-patient, Out-patient)

### Medical History
- condition: Optional, string
- diagnosis_date: Optional, date format
- treatment, medications, notes: Optional, text

### Admission/Discharge
- admission_date: Required, datetime format
- discharge_date: Optional, must be after admission_date
- status: Required, in (Admitted, Discharged, Cancelled)

### Patient Documents
- document_type: Required, string
- file: Required, file type, max 10MB
- document_date: Optional, date format

## Key Features

✅ Complete patient information management
✅ Medical history tracking with multiple entries
✅ Admission and discharge management
✅ Patient status tracking (In-patient/Out-patient)
✅ Document upload and management
✅ Soft delete support for patients
✅ Automatic relationship loading
✅ Validation and error handling
✅ Responsive Tailwind CSS design
✅ Pagination support
✅ Form field persistence on errors
✅ CRUD operations for all entities

## Future Enhancements

- Search and advanced filtering
- Patient reporting and statistics
- Appointment scheduling
- Prescription management
- Lab result integration
- Multi-user access control
- Audit logging
- Data export functionality
- SMS/Email notifications
- Mobile app integration

## Database Connection

The system uses MySQL database as configured in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospitex
DB_USERNAME=root
DB_PASSWORD=
```

## Support

For issues or questions, refer to the Laravel documentation:
- [Laravel Eloquent ORM](https://laravel.com/docs/eloquent)
- [Laravel Validation](https://laravel.com/docs/validation)
- [Laravel Routing](https://laravel.com/docs/routing)

---

**Last Updated:** February 18, 2026
**System Version:** 1.0
