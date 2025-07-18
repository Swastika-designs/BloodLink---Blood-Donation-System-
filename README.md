

---

## 🩸 BloodLink: Centralized Blood Donation Management System

**BloodLink** is a PHP-based web system developed to streamline and optimize blood donation management across hospitals, blood banks, and donors. It aims to eliminate delays in blood availability, ensure real-time tracking of blood stock, and reduce wastage through efficient coordination.

---

## 🔑 Features

### 👤 Donor Dashboard:

* Register and manage personal profile
* View upcoming donation events
* Track donation history and eligibility

### 🏥 Hospital Dashboard:

* Submit blood requests with urgency and quantity
* Track request fulfillment status

### 🏪 Blood Bank Dashboard:

* Manage inventory of blood stock (type, quantity, expiry)
* Organize donation events and record participation
* Fulfill hospital requests

### 📊 Admin Features:

* Centralized monitoring of requests, stock, and events
* Trigger-based validations (e.g., 3-month donor cooldown)

---

## 💻 Technologies Used

| Component       | Technology                     |
| --------------- | ------------------------------ |
| Backend         | PHP                            |
| Frontend        | HTML, CSS, Bootstrap           |
| Database        | MySQL                          |
| Web Server      | Apache (XAMPP)                 |
| DB Connectivity | PHP MySQLi                     |
| Design Model    | ER Diagram + Normalized Schema |

---

##Installation & Setup

## Prerequisites

* XAMPP or WAMP (PHP + MySQL)
* Browser (Chrome recommended)
* Git (optional for cloning)

## Installation Steps

1. Clone the repository (or download the ZIP):
   git clone https://github.com/Swastika-designs/BloodLink---Blood-Donation-System-.git
   

2. Move the project folder to:
   C:\xampp\htdocs\bloodlink
   

3. Import the database:

   * Start Apache and MySQL using XAMPP
   * Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   * Create a new database: `bloodlink`
   * Import `database/bloodlink.sql`

4. Run the application:

   http://localhost/bloodlink
   

---

## Database Structure

* `donor`: Donor info, blood group, location, last donation
* `blood_bank`: Blood bank profile and contact details
* `hospital`: Hospital request initiators
* `blood_stock`: Inventory tracking with expiry
* `donation_event`: Records of organized donation drives
* `request`: Tracks hospital requests and statuses
* `donation_record`: Links donors with events

---

## Screenshots

Screenshots of UI pages are available in the [`screenshots/`](screenshots/) folder of this repository.


