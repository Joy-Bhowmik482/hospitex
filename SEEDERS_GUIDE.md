# Hospital Management System - Seeders Guide

This document describes all available database seeders for the HospiteX Hospital Management System.

## Overview

The application includes comprehensive seeders that populate the database with realistic hospital data. The seeders are organized by entity type and can be run in a specific order to ensure proper data relationships.

## Running Seeders

### Run all seeders:
```bash
php artisan db:seed
```

### Run specific seeder:
```bash
php artisan db:seed --class=PatientsSeeder
```

### Reset and reseed database:
```bash
php artisan migrate:fresh --seed
```

## Core Seeders (Enhanced)

### 1. **DepartmentsSeeder** (15 departments)
- **File**: `database/seeders/DepartmentsSeeder.php`
- **Departments Created**:
  - General Medicine (GEN)
  - Pediatrics (PED)
  - Obstetrics & Gynecology (OBG)
  - Cardiology (CAR)
  - Orthopedics (ORT)
  - Neurology (NEU)
  - Psychiatry (PSY)
  - Dermatology (DER)
  - ENT (ENT)
  - Ophthalmology (OPH)
  - Gastroenterology (GAS)
  - Pulmonology (PUL)
  - Urology (URO)
  - Surgery (SUR)
  - Emergency Medicine (EMR)

### 2. **DoctorsSeeder** (20 doctors)
- **File**: `database/seeders/DoctorsSeeder.php`
- **Features**:
  - 20 realistic Indian doctor names
  - Department-specific specializations
  - Email: doctorX@hospitex.com
  - Registration numbers: REG0001 to REG0020
  - Consultation fees: 500-2000
  - Linked to departments

### 3. **PatientsSeeder** (50 patients)
- **File**: `database/seeders/PatientsSeeder.php`
- **Features**:
  - 50 realistic Indian patient names
  - Varied blood groups (A+, A-, B+, B-, AB+, AB-, O+, O-)
  - Medical conditions (Hypertension, Diabetes, Asthma, etc.)
  - Allergies data
  - Emergency contact information
  - Status: In/Out
  - Faker-generated dates and addresses

## Service & Insurance Seeders (Enhanced)

### 4. **EnhancedServicesSeeder** (15 services)
- **File**: `database/seeders/EnhancedServicesSeeder.php`
- **Services Include**:
  - Consultation (500)
  - Blood Test (300)
  - X-Ray (800)
  - Ultrasound (1200)
  - CT Scan (3500)
  - MRI Scan (5000)
  - ECG (400)
  - EEG (600)
  - Vaccination (350)
  - Anesthesia (2000)
  - Surgery (15000)
  - Pharmacy (0)
  - Physiotherapy (400)
  - Dental Cleaning (600)
  - Pathology Test (500)

### 5. **EnhancedInsuranceProvidersSeeder** (10 providers)
- **File**: `database/seeders/EnhancedInsuranceProvidersSeeder.php`
- **Providers Include**:
  - Apollo Munich Health Insurance
  - ICICI Lombard Health Insurance
  - HDFC ERGO Health Insurance
  - Bajaj Allianz Health Insurance
  - Aetna Health Insurance
  - Star Health Insurance
  - United India Health Insurance
  - Care Health Insurance
  - Niva Bupa Health Insurance
  - Religare Health Insurance

## Infrastructure Seeders (Enhanced)

### 6. **EnhancedWardsRoomsBedsSeder** (8 wards + rooms + beds)
- **File**: `database/seeders/EnhancedWardsRoomsBedsSeder.php`
- **Wards Created**:
  - General Ward - A (50 beds)
  - General Ward - B (50 beds)
  - ICU Ward (20 beds)
  - Pediatric Ward (30 beds)
  - Maternity Ward (25 beds)
  - Surgical Ward (40 beds)
  - Cardiac Ward (20 beds)
  - Orthopedic Ward (30 beds)
- **Features**:
  - Automatic room creation (4 beds per room average)
  - Bed numbering: WARD-ROOM-BED format
  - Room types: Single, Double, Triple, Quad
  - Initial status: Available

### 7. **EnhancedStaffSeeder** (15 staff members)
- **File**: `database/seeders/EnhancedStaffSeeder.php`
- **Staff Types**:
  - Nurses (5)
  - Lab Technicians (3)
  - Receptionists (2)
  - Pharmacists (2)
  - Attendants (3)
- **Features**:
  - Linked to departments
  - Email: staff.name@hospitex.com
  - Hire dates: 1-60 months ago
  - Phone numbers with +91 prefix

## Schedule & Appointment Seeders (Enhanced)

### 8. **EnhancedDoctorSchedulesSeeder**
- **File**: `database/seeders/EnhancedDoctorSchedulesSeeder.php`
- **Features**:
  - Weekly schedules for all doctors
  - Multiple time slots per day
  - 3-5 days per week per doctor
  - Time slots: 09:00-12:00, 14:00-17:00, 10:00-12:00, 15:00-19:00
  - Room assignments

### 9. **EnhancedAppointmentsSeeder** (100 appointments)
- **File**: `database/seeders/EnhancedAppointmentsSeeder.php`
- **Features**:
  - 100 appointments across all doctors
  - Random patients and doctors
  - Appointment reasons: General Checkup, Follow-up, Complaints, etc.
  - Status: Scheduled, Completed, Cancelled, No-Show
  - Dates: -30 to +60 days from today

## Patient Care Seeders (Enhanced)

### 10. **EnhancedAdmissionsSeeder** (30 admissions)
- **File**: `database/seeders/EnhancedAdmissionsSeeder.php`
- **Features**:
  - 30 patient admissions
  - Linked to wards and beds
  - Admission reasons: Emergency, Surgery, Chronic Disease, etc.
  - Status: Active or Discharged
  - Discharge dates: 1-30 days after admission

## Financial Seeders (Enhanced)

### 11. **EnhancedInvoicesSeeder** (50 invoices)
- **File**: `database/seeders/EnhancedInvoicesSeeder.php`
- **Features**:
  - 50 invoices for patients
  - 2-5 services per invoice
  - Invoice numbers: INV-TIMESTAMP-RANDOM
  - Status: Pending, Paid, Partially Paid, Cancelled
  - Due date: 30 days from invoice date

### 12. **EnhancedPaymentsSeeder**
- **File**: `database/seeders/EnhancedPaymentsSeeder.php`
- **Features**:
  - Payments for "Paid" and "Partially Paid" invoices
  - Payment methods: Cash, Card, Bank Transfer, Cheque, UPI
  - Reference numbers: PAY-TIMESTAMP-RANDOM

## Inventory Seeder (Enhanced)

### 13. **EnhancedInventoryItemsSeeder** (20 items)
- **File**: `database/seeders/EnhancedInventoryItemsSeeder.php`
- **Item Categories**:
  - **Medical Supplies**: Syringes, Needles, Gauze, Swabs, Bandages
  - **Equipment**: Thermometers, BP Monitors, Pulse Oximeters, Stethoscopes
  - **Medicines**: Paracetamol, Amoxicillin, Ibuprofen, Metformin, Lisinopril
  - **Safety**: Gloves, Masks, Sanitizers, Disinfectants

## Legacy Seeders (Optional)

These seeders are kept for backward compatibility but are superseded by enhanced versions:

- **PatientDocumentsSeeder**: Patient medical documents
- **PatientVisitsSeeder**: Patient visit records
- **BedAllocationsSeeder**: Bed allocation records
- **AssetsSeeder**: Hospital assets
- **RolesPermissionsSeeder**: User roles and permissions
- **SettingsSeeder**: Application settings

## Database Seeder Execution Order

The `DatabaseSeeder.php` orchestrates seeding in the following order:

1. **Departments** → Foundation for specialty assignments
2. **Doctors** → Assigned to departments
3. **Patients** → With medical history
4. **Services** → Available medical services
5. **Insurance Providers** → Coverage options
6. **Wards, Rooms, Beds** → Infrastructure
7. **Staff** → Hospital employees
8. **Doctor Schedules** → Weekly availability
9. **Appointments** → Patient bookings
10. **Admissions** → Patient stays
11. **Invoices & Items** → Billing records
12. **Payments** → Payment records
13. **Inventory Items** → Stock management
14. **Legacy Seeders** → Supporting data

## Total Data Created

When all seeders run successfully:

- **15** Departments
- **20** Doctors
- **50** Patients
- **15** Services
- **10** Insurance Providers
- **8** Wards
- **~32** Rooms (4 per ward average)
- **~128** Beds (4 per room average)
- **15** Staff Members
- **Weekly schedules** for all doctors (multiple slots)
- **100** Appointments
- **30** Admissions
- **50** Invoices
- **Multiple** Payments
- **20** Inventory Items
- **50+** Supporting records (documents, visits, etc.)

## Tips & Troubleshooting

### 1. **Data Not Appearing**
```bash
# Check for migration issues
php artisan migrate:status

# Refresh migrations if needed
php artisan migrate:fresh
```

### 2. **Duplicate Entry Errors**
- Seeders use `firstOrCreate()` to avoid duplicates
- Run `php artisan migrate:fresh` to reset database

### 3. **Faker Locale**
- Seeders use `en_IN` locale for Indian names and addresses
- Install Faker: `composer require fakerphp/faker`

### 4. **Performance**
- For large datasets (1000+ records), run seeders in stages
- Use: `php artisan db:seed --class=DepartmentsSeeder`

## Customizing Seeders

### To add more patients:
Edit `PatientsSeeder.php` and change the loop:
```php
for ($i = 1; $i <= 100; $i++) {  // Change 50 to 100
```

### To change doctor count:
Edit `DoctorsSeeder.php` and update the array size and loop.

### To add custom services:
Edit `EnhancedServicesSeeder.php` and add to the `$services` array.

## File Structure
```
database/seeders/
├── DatabaseSeeder.php                      (Master orchestrator)
├── DepartmentsSeeder.php                   (15 departments)
├── DoctorsSeeder.php                       (20 doctors)
├── PatientsSeeder.php                      (50 patients - enhanced)
├── EnhancedServicesSeeder.php              (15 services)
├── EnhancedInsuranceProvidersSeeder.php    (10 providers)
├── EnhancedWardsRoomsBedsSeder.php         (8 wards + beds)
├── EnhancedStaffSeeder.php                 (15 staff)
├── EnhancedDoctorSchedulesSeeder.php       (Weekly schedules)
├── EnhancedAppointmentsSeeder.php          (100 appointments)
├── EnhancedAdmissionsSeeder.php            (30 admissions)
├── EnhancedInvoicesSeeder.php              (50 invoices)
├── EnhancedPaymentsSeeder.php              (Payments)
├── EnhancedInventoryItemsSeeder.php        (20 items)
└── [Legacy seeders...]
```

## Next Steps

1. **Run the seeders**:
   ```bash
   php artisan db:seed
   ```

2. **Verify data in database**:
   ```bash
   php artisan tinker
   >>> Patient::count()
   >>> Doctor::count()
   >>> Appointment::count()
   ```

3. **Start the application**:
   ```bash
   php artisan serve
   ```

4. **Test with data**:
   - Login and view doctor schedules
   - Create appointments
   - View admissions and wards
   - Check invoices and payments

---

**Created**: 2024
**Version**: 1.0
**Status**: Production Ready
