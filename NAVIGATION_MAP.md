# 🗺️ Patient Management System - Navigation & Structure Map

## 📍 Application Structure

```
┌─────────────────────────────────────────────────────────────────┐
│  HOSPITEX - Hospital Management System                           │
├──────────────────────┬──────────────────────────────────────────┤
│                      │                                            │
│   SIDEBAR (64)       │   MAIN CONTENT AREA                       │
│                      │                                            │
│ ┌─────────────────┐  │ ┌──────────────────────────────────────┐ │
│ │ MAIN            │  │ │ TOP NAVBAR                           │ │
│ │ ├─ Dashboard    │  │ │ Hospital Management | Date | Profile │ │
│ │ └─ Home         │  │ └──────────────────────────────────────┘ │
│ │                 │  │                                            │
│ │ PATIENT MGT     │  │ ┌──────────────────────────────────────┐ │
│ │ ├─ Dashboard ───┼──→│ PATIENT MANAGEMENT DASHBOARD          │ │
│ │ ├─ Patient List ├──→│                                        │ │
│ │ ├─ Add Patient ─┼──→│ [Tab Nav]                             │ │
│ │ ├─ Profile      │  │ ├─ Patient List                       │ │
│ │ ├─ Med. History │  │ ├─ Add/Edit Patient                  │ │
│ │ ├─ Admission    │  │ ├─ Patient Profile                   │ │
│ │ ├─ Documents    │  │ ├─ Medical History                   │ │
│ │ └─ Status       │  │ ├─ Admission/Discharge               │ │
│ │                 │  │ ├─ Documents                          │ │
│ │                 │  │ └─ Patient Status                    │ │
│ │                 │  │                                        │ │
│ │                 │  │ Content changes based on selected tab │ │
│ │                 │  │                                        │ │
│ │                 │  │ [Action Buttons & Links]              │ │
│ │                 │  │                                        │ │
│ └─────────────────┘  │ [Real-time Data Display]              │ │
│                      │                                        │ │
│                      │ [Quick Navigation Links]              │ │
│                      │                                        │ │
│                      └──────────────────────────────────────┘ │
│                                                                  │
│ FOOTER                                                           │
│ © Hospitex - All rights reserved                                │
└──────────────────────────────────────────────────────────────────┘
```

## 🔀 Navigation Flow Diagram

```
Start Application
        ↓
   Visit Home
        ↓
  Choose Navigation ──┬─→ Click Sidebar "Patient Dashboard"
                     │         ↓
                     │   Patient Management Dashboard
                     │    (7 Sections in Tabs)
                     │
                     ├─→ Click Sidebar "Patient List"
                     │         ↓
                     │   Full Patient List Page
                     │
                     ├─→ Click Sidebar "Add Patient"
                     │         ↓
                     │   Patient Creation Form
                     │
                     └─→ Click Sidebar Other Sections
                             ↓
                         Redirects to Dashboard
                         (Then shows that section)
```

## 📊 Dashboard Section Navigation

```
PATIENT MANAGEMENT DASHBOARD
│
├─ TAB 1: PATIENT LIST ─────────────────────────────────┐
│  ├─ Shows: Recent 10 Patients                         │
│  ├─ Actions: View → Details                           │
│  │            Edit → Edit Form                        │
│  │            Delete → Remove                         │
│  └─ Links: "View Full List" → /patients              │
│            "Add Patient" → /patients/create           │
│                                                        │
├─ TAB 2: ADD / EDIT PATIENT ───────────────────────────┤
│  ├─ Card 1: Add New Patient → /patients/create       │
│  └─ Card 2: Edit Patient → /patients list            │
│                                                        │
├─ TAB 3: PATIENT PROFILE ──────────────────────────────┤
│  ├─ Shows: Patient Info (if selected)                │
│  ├─ Data: Personal, Health, Emergency Contact        │
│  └─ Links: "View Full Profile" → /patients/{id}      │
│                                                        │
├─ TAB 4: MEDICAL HISTORY ──────────────────────────────┤
│  ├─ Shows: Feature Overview                           │
│  ├─ Use Cases: Conditions, Treatments, Medications   │
│  └─ Links: Navigate to patient selection             │
│                                                        │
├─ TAB 5: ADMISSION/DISCHARGE ──────────────────────────┤
│  ├─ Shows: Feature Overview                           │
│  ├─ Info: Ward, Bed, Dates, Status                   │
│  └─ Links: Navigate to patient selection             │
│                                                        │
├─ TAB 6: DOCUMENTS ────────────────────────────────────┤
│  ├─ Shows: Document Types                             │
│  ├─ Features: Upload, Download, Delete               │
│  └─ Links: Navigate to patient selection             │
│                                                        │
└─ TAB 7: PATIENT STATUS ───────────────────────────────┘
   ├─ Shows: In-patient Card | Out-patient Card
   ├─ Current Stats: Count of In-patients & Out-patients
   └─ Updates: Automatic on admission status change
```

## 🔗 Inter-page Navigation

```
PATIENT LIST PAGE (/patients)
├─ View Patient → PATIENT DETAIL PAGE (/patients/{id})
│                 ├─ Edit Button → EDIT FORM
│                 ├─ Medical History → Add/Edit History
│                 ├─ Admission → Add/Edit Admission
│                 ├─ Documents → Upload/Download
│                 └─ Profile Info → Display
│
├─ Create Button → ADD PATIENT PAGE (/patients/create)
│
└─ Sidebar → Dashboard → PATIENT MANAGEMENT DASHBOARD
```

## ═══════════════════════════════════════════════════════════════

## 📱 Sidebar Structure

```
SIDEBAR MENU
│
├─ HEADER
│  └─ Hospitex Logo
│
├─ MAIN SECTION
│  ├─ 🏠 Dashboard
│  └─ 🌐 Home
│
├─ PATIENT MANAGEMENT SECTION
│  ├─ 🏥 Patient Dashboard ──→ /patient-management
│  ├─ 📋 Patient List ────────→ /patients
│  ├─ ➕ Add Patient ─────────→ /patients/create
│  ├─ 👤 Patient Profile ────→ Scroll to section
│  ├─ 📝 Medical History ────→ Scroll to section
│  ├─ 🏥 Admission/Discharge → Scroll to section
│  ├─ 📄 Documents ──────────→ Scroll to section
│  └─ ❤️  Patient Status ────→ Scroll to section
│
└─ FOOTER
   └─ © Copyright Info
```

## 🎯 User Journeys

### Journey 1: View All Patients
```
Start
  ↓
Click "Patient List" in Sidebar
  ↓
See List of Patients
  ↓
Click "View" on a Patient
  ↓
See Full Patient Profile
  ↓
Click on Medical History Tab
  ↓
See Medical Records
```

### Journey 2: Add New Patient
```
Start
  ↓
Click "Add Patient" in Sidebar
  ↓
Fill Patient Form
  ↓
Submit
  ↓
Redirected to Patient List
  ↓
New Patient Visible
```

### Journey 3: Manage Patient Data
```
Start
  ↓
Click "Patient Dashboard"
  ↓
See All 7 Sections
  ↓
Click "Patient Profile" Tab
  ↓
See Patient Summary
  ↓
Click "View Full Profile"
  ↓
Edit Patient Data
  ↓
Add Medical Records
  ↓
Add Admissions
  ↓
Upload Documents
```

### Journey 4: Track Patient Status
```
Start
  ↓
Click "Patient Dashboard"
  ↓
Click "Patient Status" Tab
  ↓
See In-patient Count
  ↓
See Out-patient Count
  ↓
View Status Comparison
```

## 📊 Data Flow

```
Create Patient
    ↓
Patient Record Created
    ↓
Appears in Patient List
    ↓
Can Add:
├─ Medical History
├─ Admissions
└─ Documents
    ↓
All Data Displayed in:
├─ Patient Profile
├─ Patient List
├─ Medical History Tab
├─ Admission Tab
└─ Documents Tab
```

## 🔐 Access Points Summary

| Access Point | Route | Section |
|---|---|---|
| Sidebar Dashboard | `/patient-management` | All 7 Sections |
| Sidebar List | `/patients` | Full List Page |
| Sidebar Add | `/patients/create` | Create Form |
| Dashboard Tabs | `/patient-management#{tab}` | Individual Section |
| Patient List | `/patients` | Table View |
| Patient Detail | `/patients/{id}` | Profile + All Data |
| Edit Patient | `/patients/{id}/edit` | Edit Form |

## 🎨 Color Coding

```
SIDEBAR:     Blue Gradient (Blue-600 to Blue-800)
HEADER:      White with Shadow
TABS:        Active = Blue, Inactive = Gray
STATUS:      In-patient = Red, Out-patient = Green
ALERTS:      Info = Blue, Success = Green, Error = Red
```

## ✨ Key Features at a Glance

```
✅ Single Dashboard with 7 Sections
✅ Professional Sidebar Navigation
✅ Tab-based Section Switching
✅ Direct URL Access to All Pages
✅ Real-time Data Display
✅ Responsive Mobile Design
✅ Form Validation
✅ Error Handling
✅ Direct Links Between Pages
✅ Smooth Transitions
```

---

**Last Updated:** February 18, 2026
**Version:** 1.1
**Ready to Use:** ✅ Yes
