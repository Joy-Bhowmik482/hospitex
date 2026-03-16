# Database Tables & Migrations Summary

## ✅ All Tables Successfully Created

Documentation for the 6 new hospital management tables with complete migrations and models.

---

## 1. **APPOINTMENTS TABLE**
**Migration File:** `2026_03_02_000009_create_appointments_table.php`  
**Model:** `App\Models\Appointment`

### Columns:
- `id` (Primary Key)
- `appointment_no` (String, Unique) - Unique appointment identifier
- `patient_id` (Foreign Key) → patients table
- `doctor_id` (Foreign Key) → doctors table
- `department_id` (Foreign Key) → departments table
- `appointment_date` (DateTime) - Date and time of appointment
- `appointment_time` (Time) - Time of appointment
- `status` (Enum) - Pending, Confirmed, Completed, Cancelled, NoShow
- `token_no` (Integer, Nullable) - Queue token number
- `notes` (Text, Nullable) - Additional notes
- `created_by` (Foreign Key) → users table - Staff who created the appointment
- `created_at` & `updated_at` (Timestamps)

### Relationships:
- Belongs to Patient
- Belongs to Doctor
- Belongs to Department
- Belongs to User (creator)

---

## 2. **WARDS TABLE**
**Migration File:** `2026_03_02_000010_create_wards_table.php`  
**Model:** `App\Models\Ward`

### Columns:
- `id` (Primary Key)
- `name` (String) - Ward name
- `code` (String) - Ward code/identifier
- `floor` (Integer, Nullable) - Floor number
- `gender_policy` (Enum) - Male, Female, Any
- `created_at` & `updated_at` (Timestamps)

### Relationships:
- Has Many Rooms

---

## 3. **ROOMS TABLE**
**Migration File:** `2026_03_02_000011_create_rooms_table.php`  
**Model:** `App\Models\Room`

### Columns:
- `id` (Primary Key)
- `ward_id` (Foreign Key) → wards table
- `room_no` (String) - Room number
- `room_type` (String) - Type of room
- `daily_rate` (Decimal 10,2) - Daily charge for the room
- `is_active` (Boolean) - Whether room is active
- `created_at` & `updated_at` (Timestamps)

### Relationships:
- Belongs to Ward
- Has Many Beds

---

## 4. **BEDS TABLE**
**Migration File:** `2026_03_02_000012_create_beds_table.php`  
**Model:** `App\Models\Bed`

### Columns:
- `id` (Primary Key)
- `room_id` (Foreign Key) → rooms table
- `bed_no` (String) - Bed number/identifier
- `status` (Enum) - Available, Occupied, Maintenance
- `created_at` & `updated_at` (Timestamps)

### Relationships:
- Belongs to Room
- Has Many BedAllocations

---

## 5. **ADMISSIONS TABLE**
**Migration File:** `2026_03_02_000013_create_admissions_table.php`  
**Model:** `App\Models\Admission`

### Columns:
- `id` (Primary Key)
- `admission_no` (String, Unique) - Unique admission identifier
- `patient_id` (Foreign Key) → patients table
- `doctor_id` (Foreign Key) → doctors table (Primary consultant)
- `department_id` (Foreign Key) → departments table
- `admitted_at` (DateTime) - Admission date and time
- `discharge_at` (DateTime, Nullable) - Discharge date and time (if discharged)
- `status` (Enum) - Admitted, Discharged, Cancelled
- `diagnosis` (Text, Nullable) - Patient diagnosis
- `remarks` (Text, Nullable) - Additional remarks
- `created_by` (Foreign Key) → users table - Staff who created the admission
- `created_at` & `updated_at` (Timestamps)

### Relationships:
- Belongs to Patient
- Belongs to Doctor
- Belongs to Department
- Belongs to User (creator)
- Has Many BedAllocations

---

## 6. **BED_ALLOCATIONS TABLE**
**Migration File:** `2026_03_02_000014_create_bed_allocations_table.php`  
**Model:** `App\Models\BedAllocation`

### Columns:
- `id` (Primary Key)
- `admission_id` (Foreign Key) → admissions table
- `bed_id` (Foreign Key) → beds table
- `allocated_at` (DateTime) - When the bed was allocated
- `released_at` (DateTime, Nullable) - When the bed was released (if released)
- `allocation_status` (Enum) - Active, Released
- `notes` (Text, Nullable) - Notes about the allocation
- `created_at` & `updated_at` (Timestamps)

### Relationships:
- Belongs to Admission
- Belongs to Bed

---

## Database Relationships Diagram

```
Users
  ├── Appointments (created_by)
  ├── Admissions (created_by)
  └── etc.

Departments
  ├── Appointments
  └── Admissions

Doctors
  ├── Appointments
  └── Admissions

Patients
  ├── Appointments
  └── Admissions

Wards
  └── Rooms

Rooms
  └── Beds

Admissions (1) ──────→ (Many) BedAllocations
Beds (1) ──────→ (Many) BedAllocations
```

---

## Migration Execution Status

✅ All 6 migrations executed successfully in Batch [2]:
- 2026_03_02_000009_create_appointments_table ............ [2] Ran
- 2026_03_02_000010_create_wards_table .................. [2] Ran
- 2026_03_02_000011_create_rooms_table .................. [2] Ran
- 2026_03_02_000012_create_beds_table ................... [2] Ran
- 2026_03_02_000013_create_admissions_table ............. [2] Ran
- 2026_03_02_000014_create_bed_allocations_table ........ [2] Ran

---

## Models Created

All models are located in `app/Models/`:
- ✅ `Appointment.php` - With fillable attributes and relationships
- ✅ `Ward.php` - With fillable attributes and relationships
- ✅ `Room.php` - With fillable attributes and casts for decimal
- ✅ `Bed.php` - With fillable attributes and relationships
- ✅ `Admission.php` - With fillable attributes and datetime casts
- ✅ `BedAllocation.php` - With fillable attributes and datetime casts

---

## Key Features Implemented

✅ **Unique Constraints:**
- appointment_no (unique per appointment)
- admission_no (unique per admission)

✅ **Enum Fields:**
- Appointments: status (Pending, Confirmed, Completed, Cancelled, NoShow)
- Wards: gender_policy (Male, Female, Any)
- Beds: status (Available, Occupied, Maintenance)
- Admissions: status (Admitted, Discharged, Cancelled)
- BedAllocations: allocation_status (Active, Released)

✅ **Foreign Keys:**
- All relationships properly configured with cascadeOnDelete

✅ **Nullable Fields:**
- Token_no in appointments
- Notes in appointments
- Floor in wards
- Discharge_at in admissions
- Diagnosis and remarks in admissions
- Released_at in bed_allocations
- Notes in bed_allocations

✅ **Timestamps:**
- created_at and updated_at on all tables

✅ **Proper Casts:**
- DateTime casts for appointment_date, admitted_at, discharge_at, allocated_at, released_at
- Time cast for appointment_time
- Decimal cast for daily_rate

---

## Next Steps (Optional)

You can now:
1. Create factories for testing data generation
2. Create seeders to populate these tables with sample data
3. Create controllers and routes for CRUD operations
4. Create views for managing appointments, admissions, and bed allocations
