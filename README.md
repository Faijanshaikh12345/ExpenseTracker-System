# 💰 ExpenseTracker System (Laravel)

A complete Expense Tracker System built with Laravel that helps users manage income, expenses, categories, payment methods, transactions, and financial reports through a clean Admin Dashboard.

## 🚀 Features

### Dashboard

* Total Income
* Total Expenses
* Current Balance
* Categories Count

### Category Management

* Add Category
* Edit Category
* Delete Category
* Income & Expense Categories

### Payment Method Management

* Add Payment Method
* Edit Payment Method
* Delete Payment Method

### Transaction Management

* Add Income Transactions
* Add Expense Transactions
* Update Transactions
* Delete Transactions

### Reports

* Income Reports
* Expense Reports
* Balance Summary
* Transaction History

### Authentication

* User Registration
* User Login
* Secure Logout

---

## 🛠️ Tech Stack

* Laravel
* PHP
* MySQL
* Blade Template
* AdminLTE
* Bootstrap

---

## ⚙️ Project Setup (After Downloading from GitHub)

Follow these steps in order after downloading or cloning the project.

### ✅ Step 1 — Open Project in VS Code

Open the project folder and open the terminal inside it.

### ✅ Step 2 — Create .env File

Run:

```bash
cp .env.example .env
```

### ✅ Step 3 — Install Vendor Packages

```bash
composer install --ignore-platform-reqs
```

### ✅ Step 4 — Generate Application Key

```bash
php artisan key:generate
```

### ✅ Step 5 — Configure Database

Open the `.env` file and update:

```env
DB_DATABASE=expense_tracker
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
```

### ✅ Step 6 — Run Migrations

```bash
php artisan migrate
```

### ✅ Step 7 — Start Laravel Server

```bash
php artisan serve
```

### ✅ Step 8 — Open in Browser

```text
http://127.0.0.1:8000/login
```

---

## 🔐 Demo User Login

Register a new account and start using the system.

---

## 📌 Modules Included

* Dashboard
* Categories
* Payment Methods
* Transactions
* Reports
* Authentication

---

## 👨‍💻 Author

Faijan Shaikh

---

## 📌 Note

This project was developed for learning and portfolio purposes using Laravel and AdminLTE.

If you find any issues or have suggestions for improvement, feel free to create an issue or contact me.
