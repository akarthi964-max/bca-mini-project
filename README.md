# BCU Campus Hall & Event Booking System

A clean, fully functional hall booking system for BCU College using PHP + MySQL with plain HTML5, CSS3, and JavaScript.

## 📁 Project Structure

```
hall_booking/
├── config.php      # Database connection (PDO)
├── index.php       # Main page (view schedule & book hall)
├── admin.php       # Admin dashboard (approve/reject requests)
├── style.css       # Modern, responsive styling
├── script.js       # Client-side form validation
├── database.sql    # Database schema
└── README.md       # This file
```

## 🚀 Quick Start

### 1. Database Setup
- Open phpMyAdmin (http://localhost/phpmyadmin)
- Import the `database.sql` file
- This creates the `hall_booking_db` database with sample data

### 2. File Placement
- Save all files in `C:/xampp/htdocs/hall_booking/` (XAMPP) or equivalent directory

### 3. Run the Application
- Start Apache and MySQL in XAMPP/WampServer
- Navigate to `http://localhost/hall_booking/`

## 📋 Features

### User Portal (index.php)
- View all bookings in a schedule table
- Submit booking requests with:
  - Applicant name/department
  - Event title
  - Hall selection
  - Date and time slots
- Real-time validation (no past dates, end time must be after start time)

### Admin Dashboard (admin.php)
- View all booking requests sorted by submission date
- Approve or reject pending requests
- Status tracking (Pending, Approved, Rejected)

## 🔐 Security
- **PDO Parameterized Queries**: Protection against SQL injection
- **Input Sanitization**: `htmlspecialchars()` prevents XSS attacks
- **Client-Side Validation**: Prevents common user errors before submission

## 🎨 Design
- Responsive CSS Grid and Flexbox layouts
- Modern color scheme with accessibility in mind
- Status badges with color coding:
  - Yellow: Pending
  - Green: Approved
  - Red: Rejected

## 📝 Database Schema

### halls table
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary Key |
| hall_name | VARCHAR(100) | Hall/Venue name |
| capacity | INT | Maximum occupancy |

### bookings table
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary Key |
| hall_id | INT | Foreign Key to halls |
| applicant_name | VARCHAR(100) | Requester name |
| event_name | VARCHAR(150) | Event title |
| booking_date | DATE | Requested date |
| start_time | TIME | Event start time |
| end_time | TIME | Event end time |
| status | ENUM | Pending/Approved/Rejected |
| created_at | TIMESTAMP | Submission timestamp |

## 🔧 Configuration

Edit `config.php` to match your database setup:
```php
$host = 'localhost';  // Database host
$db   = 'hall_booking_db';  // Database name
$user = 'root';       // MySQL username
$pass = '';           // MySQL password (leave empty for default XAMPP)
```

## 📌 Notes
- This system is exam-friendly with clear, modular code
- No external frameworks or complex dependencies
- Easy to explain to internal and external examiners
- Ready to extend with additional features (notifications, email confirmations, etc.)
