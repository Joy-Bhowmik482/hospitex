# Database schema — reference for ChatGPT checks

This file summarizes the main database tables and provides SQL CREATE statements you can use to check the running system.

## Notes
- This is derived from the project's Laravel migrations (selected core tables).
- Use these definitions to validate table existence, columns, types, defaults, and foreign keys.

---

## Table: patients

- Columns:
  - id: BIGINT unsigned, primary key, auto-increment
  - first_name: VARCHAR(255), not null
  - last_name: VARCHAR(255), not null
  - email: VARCHAR(255), not null, unique
  - phone: VARCHAR(255), not null
  - date_of_birth: DATE, not null
  - gender: ENUM('Male','Female','Other'), default 'Male'
  - address: TEXT, nullable
  - city: VARCHAR(255), nullable
  - state: VARCHAR(255), nullable
  - postal_code: VARCHAR(255), nullable
  - blood_type: VARCHAR(255), nullable
  - allergies: TEXT, nullable
  - medical_conditions: TEXT, nullable
  - emergency_contact_name: VARCHAR(255), nullable
  - emergency_contact_phone: VARCHAR(255), nullable
  - insurance_provider: VARCHAR(255), nullable
  - insurance_id: VARCHAR(255), nullable
  - date_admitted: DATE, nullable
  - status: ENUM('In','Out','Discharged'), default 'In'
  - created_at, updated_at: TIMESTAMP nullable

CREATE TABLE example (MySQL syntax):

```
CREATE TABLE patients (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(255) NOT NULL,
  date_of_birth DATE NOT NULL,
  gender ENUM('Male','Female','Other') DEFAULT 'Male',
  address TEXT,
  city VARCHAR(255),
  state VARCHAR(255),
  postal_code VARCHAR(255),
  blood_type VARCHAR(255),
  allergies TEXT,
  medical_conditions TEXT,
  emergency_contact_name VARCHAR(255),
  emergency_contact_phone VARCHAR(255),
  insurance_provider VARCHAR(255),
  insurance_id VARCHAR(255),
  date_admitted DATE,
  status ENUM('In','Out','Discharged') DEFAULT 'In',
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB;
```

---

## Table: users

- Columns:
  - id: BIGINT unsigned, primary key, auto-increment
  - name: VARCHAR(255), not null
  - email: VARCHAR(255), not null, unique
  - phone: VARCHAR(255), nullable
  - password: VARCHAR(255), not null
  - is_active: BOOLEAN, default true
  - last_login_at: TIMESTAMP, nullable
  - created_at, updated_at: TIMESTAMP

```
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(255),
  password VARCHAR(255) NOT NULL,
  is_active TINYINT(1) DEFAULT 1,
  last_login_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB;
```

---

## Table: departments

- Columns:
  - id: BIGINT unsigned, primary key, auto-increment
  - name: VARCHAR(255), not null
  - code: VARCHAR(255), nullable
  - is_active: BOOLEAN, default true
  - created_at, updated_at

```
CREATE TABLE departments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  code VARCHAR(255),
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB;
```

---

## Table: staff

- Columns:
  - id: BIGINT unsigned, primary key
  - user_id: BIGINT unsigned, nullable, FK -> users(id) ON DELETE SET NULL
  - department_id: BIGINT unsigned, not null, FK -> departments(id) ON DELETE CASCADE
  - designation: VARCHAR(255), nullable
  - joining_date: DATE, nullable
  - salary: DECIMAL(12,2), nullable
  - is_active: BOOLEAN, default true
  - created_at, updated_at

```
CREATE TABLE staff (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  department_id BIGINT UNSIGNED NOT NULL,
  designation VARCHAR(255),
  joining_date DATE,
  salary DECIMAL(12,2),
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
) ENGINE=InnoDB;
```

---

## How to use this file
- Use the SQL snippets to validate schema via a DB client or to let ChatGPT reason about expected tables/columns.
- If you want the full schema for every migration, say so and I will expand this file to include all migrations.

---

Generated from migrations in repository on March 24, 2026.
