# Automated Skills Acquisition Management System (ASAMS)

**Brand:** NCP-Tech-NG  
**Stack:** PHP, MySQL, HTML, CSS, JavaScript, Bootstrap 5  
**Local environment:** XAMPP / Windows

## Updated user flow

1. Register
2. Login
3. Open Courses
4. Search/select a course
5. Make demo payment
6. Payment is recorded in MySQL
7. Enrollment is recorded in MySQL
8. Practice Course becomes available

## Important payment note

The current `payment.php` is a **demo payment implementation**. It does not charge real money and does not connect to Paystack, Flutterwave, Moniepoint, or another payment provider.

It records a successful demo transaction in the `payments` table and creates the corresponding record in `enrollments`.

A real payment gateway should only be added later when live credentials and server-side verification are ready.

## XAMPP installation

1. Install XAMPP.
2. Start **Apache** and **MySQL**.
3. Copy this project into:
   `C:\xampp\htdocs\ASAMS`
4. Open phpMyAdmin.
5. Import `database.sql`.
6. Confirm the database name is `asams_db`.
7. Open:
   `http://localhost/ASAMS/`

If you use a different folder name, update the URL accordingly.

## GitHub

Do not upload database passwords, API secret keys, or real payment credentials.

The project is suitable for a GitHub repository as a demonstration/local-development project.
