# 🌍 GeoGo Intranet  
### Smart Attendance System with Geolocation Validation

GeoGo is a platform designed to **streamline and validate attendance tracking** in companies.  
Users can register check-ins and check-outs using their **mobile devices**, while GeoGo verifies the employee’s real-time location to ensure attendance is recorded only from **authorized areas**.

This intranet version manages companies, branches, users, schedules, and attendance logs through a secure and modular Laravel 12 backend.

---

## 📌 Features

### 🎯 Core Modules
- 🔐 **Login & Role Management** (Super Admin, Admin, Staff)
- 🏢 **Company Registration**
- 🏬 **Branch / Local Management**
- 👥 **User Registration per Company & Branch**
- 🗓️ **Schedule Assignment**
- 📍 **Geolocation-based Attendance Tracking**
- 🛡️ **Radio-distance Validation** (validate if user is inside Authorized GPS radius)
- 📊 **Dashboard with attendance indicators**

### ⚙️ System Capabilities
- REST-based architecture  
- Real-time communication powered by **Pusher**  
- Clean UI with **Bootstrap**  
- Secure authentication  
- Modular Laravel structure  

---

## 🧱 Tech Stack

| Layer | Technology |
|------|------------|
| Backend | **Laravel 12**, PHP 8.3.9 |
| Database | MySQL |
| Frontend | Bootstrap 5, jQuery |
| Real-time Events | Pusher |
| Others | Laravel Broadcasting, MVC architecture |

---

## 📦 Installation Guide

Follow these steps to run **GeoGo Intranet** locally:

### 1️⃣ Clone Repository
```bash
git clone https://github.com/tu_usuario/geogo-intranet.git
cd geogo-intranet
