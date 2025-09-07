# 📰 Daily Planet (PHP App)

The **Daily Planet** is a simple yet powerful PHP web application designed as a news-style platform.  
It is built with vanilla **PHP** following an MVC structure and includes user authentication, content management, and a clean separation of concerns.

It supports **three user roles**: Reader, Author, and Admin — each with specific permissions and capabilities.

---

## ✨ Features

### 👤 Reader User
- 🔐 Authentication: Sign up, Sign in  
- ❌ Delete own account  
- 📜 Scroll and search articles  
- ⭐ Bookmark articles  
- 📖 Read article details  

### ✍️ Author User
- 🔐 Authentication: Sign in  
- 📜 Scroll and search articles  
- 📖 Read article details  
- 📝 Create articles and submit for admin approval  
- ✏️ Edit own pending articles  
- 🗑️ Delete own pending and/or approved articles  

### 🛡️ Admin User
- 🔐 Authentication: Sign in  
- 📜 Scroll and search articles  
- 📖 Read article details  
- ✅ Approve or deny submitted articles  
- ✏️ Edit or delete approved articles  
- 👤 Manage author users (create or delete accounts)  
- 📋 See a list of all reader users  

---

## 🛠️ Technology Stack
- **Backend**: [PHP 8+](https://www.php.net/)
- **Database**: [MySQL](https://www.mysql.com/)
- **Web Server**: [Apache/Nginx](https://www.apachefriends.org/)
- **Composer**: For autoloading and dependencies  
- **CSS Framework**: [Tailwind CSS](https://tailwindcss.com/)  
- **UI Components**: [daisyUI](https://daisyui.com/)  

---

## 📂 Project Structure
│── App/            # Application logic (Controllers, Models, Views, routes)
│── Framework/      # Core framework files
│── config/         # Configurations (DB setup)
│── public/         # Public entry point (assets, css, javascript)
│── utils/          # Utility functions/helpers
│── Dump20250223.sql # Database dump
│── composer.json   # Composer dependencies
│── .htaccess       # Apache rewrite rules

---

## 🚀 Getting Started

### 1. Clone the Repository
```bash
git clone https://github.com/bojan-ski/php-daily-planet.git
cd php-daily-planet
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Database Setup
- Create a new MySQL database: `CREATE DATABASE daily_planet;`
- Import the provided SQL dump: `mysql -u username -p daily_planet < Dump20250223.sql`
- Or follow the instructions in `database.txt`

### 4. Environment Setup
Create a `.env` file in the root directory:
```env
# Database Configuration
DB_HOST=localhost
DB_NAME=daily_planet
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Articles - Database limit (customize as needed)
LIMIT=12
```

---

## 👨‍💻 Author
Developed with ❤️ by BPdevelopment (bojan-ski)