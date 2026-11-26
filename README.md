# Smart Internship & Skill Recommendation Portal

A web-based platform built with **Laravel** and **MySQL** that connects students with companies through role-based access, city-based internship search, and rule-based skill matching.

## Overview
Finding relevant internships often requires students to sift through dozens of mismatched listings. This portal streamlines the process by matching student skill profiles with company requirements, while providing dedicated dashboards for students, recruiters, and administrators to manage the entire application lifecycle.

## Key Features

### Student Module
* **Profile & Skill Management:** Create and update academic details and technical skills.
* **Rule-Based Skill Matching:** View internship recommendations aligned with your skill set.
* **City-Based Search & Filtering:** Search and filter available internships by location and domain.
* **Application Tracking:** Apply to listings and monitor application status in real time.

### Company Module
* **Internship Posting:** Create, update, and manage internship listings with required skills and location details.
* **Applicant Management:** Review incoming student applications and update candidate statuses.
* **Company Profile:** Maintain organization details visible to prospective interns.

### Admin Module
* **User & Company Management:** Oversee registered students and companies, including account status controls.
* **Platform Monitoring:** Manage posted internships, applications, and platform-wide reports.

## Tech Stack
* **Backend:** PHP, Laravel
* **Frontend:** HTML, CSS, JavaScript, Blade Templates
* **Database:** MySQL
* **Local Environment:** XAMPP, Composer

## Local Setup Instructions

1. **Clone the repository**
   `git clone https://github.com/Dhruvishaba/smart-internship-portal.git`
   `cd smart-internship-portal`

2. **Install dependencies**
   `composer install`

3. **Configure environment**
   * Copy `.env.example` to `.env`
   * Update `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` to match your local MySQL setup.

4. **Generate application key & run migrations**
   `php artisan key:generate`
   `php artisan migrate`

5. **Start the local server**
   `php artisan serve`
   Open `http://127.0.0.1:8000` in your browser.

## Screenshots

### Login Page
<img width="1517" height="772" alt="Login Page" src="https://github.com/user-attachments/assets/bb71b310-5f83-4aef-baf7-c819bec99eb2" />

### Student Dashboard
<img width="1282" height="703" alt="Student Dashboard" src="https://github.com/user-attachments/assets/b589ac47-4ffc-4e4d-84e5-c6a909375036" />

### Company / Admin View
<img width="1637" height="867" alt="Dashboard View" src="https://github.com/user-attachments/assets/c9fbf46e-e839-4862-8419-d30637355134" />
