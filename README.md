# Agro Vista - Agricultural E-Commerce Platform

![Agro Vista Logo](assets/img/logo.png)

## 🌾 Project Overview

Agro Vista is a comprehensive digital trade fair platform developed by undergraduates of the Faculty of Agricultural Sciences, Sabaragamuwa University of Sri Lanka. The platform promotes and supports local agricultural industries by showcasing high-quality Sri Lankan products to both local and international markets.

## ✨ Features

### 🏪 Product Categories
- **Utilized Products**: Traditional Sri Lankan agricultural products
  - Ceylon Cinnamon
  - Kithul Products
  - Handmade Tea
  - Dry Fish
- **Underutilized Fruits**: Indigenous and rare fruits that are underutilized in the market

### 👥 User Management
- **Public Users**: Browse products, view details, and watch product videos
- **Sellers**: Manage their product listings through the admin panel
- **Administrators**: Full CRUD operations for products and sellers

### 🎥 Multimedia Support
- Product video demonstrations
- Image galleries with fallback system
- Responsive design for all devices

## 🏗️ Project Structure

```
agri-ecommerce/
├── admin/                      # Administrative interface
│   ├── add_product.php        # Add new products
│   ├── edit_product.php       # Edit existing products
│   ├── delete_product.php     # Delete products
│   ├── view_products.php      # View all products with filtering
│   ├── add_seller.php         # Seller management
│   ├── edit_seller.php
│   ├── delete_seller.php
│   ├── view_sellers.php
│   └── dashboard_admin.php    # Admin dashboard
├── api/                       # API endpoints
├── assets/                    # Static resources
│   ├── css/                   # Stylesheets
│   ├── js/                    # JavaScript files
│   ├── img/                   # Images
│   │   └── products/          # Product images
│   ├── fonts/                 # Custom fonts
│   └── vendor/                # Third-party libraries
├── authentication/            # User authentication
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── db/                        # Database configuration
│   └── DBcon.php
├── shared/                    # Public pages
│   ├── index.php              # Homepage
│   ├── products.php           # Utilized products showcase
│   ├── ufruits.php            # Underutilized fruits page
│   ├── viewproducts.php       # Category-specific product listings
│   ├── contact.php            # Contact information
│   └── session_active.php     # Session management
└── db.sql                     # Database schema
```

## 🗄️ Database Schema

### Tables
- **`products`**: Product information with seller relationships
- **`sellers`**: Seller profiles and contact information  
- **`users`**: User authentication and profiles

### Key Relationships
- Products are linked to sellers via `seller_id`
- Categories are managed through ENUM values ('Utilized', 'UnderUtilized')

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Modern web browser

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd agri-ecommerce
   ```

2. **Database Setup**
   ```bash
   # Import the database schema
   mysql -u your_username -p your_database_name < db.sql
   ```

3. **Configure Database Connection**
   ```php
   // Edit db/DBcon.php
   $servername = "localhost"; 
   $username = "your_db_username"; 
   $password = "your_db_password"; 
   $database = "your_database_name";
   ```

4. **Set Directory Permissions**
   ```bash
   chmod 755 assets/img/products/
   chmod 644 *.php
   ```

5. **Web Server Configuration**
   - Point document root to the project directory
   - Ensure PHP extensions are enabled: `mysqli`, `gd`, `fileinfo`

## 💻 Usage

### For Public Users
1. Visit the homepage (`index.php`)
2. Browse products via navigation menu
3. Click on product categories to view specific items
4. Watch product demonstration videos
5. Contact sellers through provided information

### For Administrators
1. Login through the authentication system
2. Access admin panel for product management
3. Add/Edit/Delete products and sellers
4. Filter products by category
5. Monitor system activity

## 🛠️ Technical Features

### Frontend Technologies
- **HTML5/CSS3**: Modern, responsive design
- **Bootstrap 5**: Mobile-first responsive framework
- **JavaScript**: Interactive user interface
- **AOS Library**: Smooth scroll animations
- **Custom CSS**: Tailored styling for agricultural theme

### Backend Technologies
- **PHP**: Server-side logic and database interactions
- **MySQL**: Relational database management
- **Session Management**: Secure user authentication
- **File Upload System**: Image handling for products

### Security Features
- SQL injection prevention with prepared statements
- XSS protection with input sanitization
- Session-based authentication
- File upload validation
- Admin access control

## 🎨 Design Philosophy

The platform features a clean, agricultural-themed design that emphasizes:
- **Green Color Palette**: Reflecting agricultural and natural themes
- **Card-based Layout**: Easy product browsing
- **Responsive Design**: Seamless experience across devices
- **Intuitive Navigation**: Clear pathways for different user types
- **Visual Hierarchy**: Important information prominently displayed

## 🤝 Contributing

This project was developed as an academic initiative. Contributions are welcome in the form of:
- Bug reports and fixes
- Feature enhancements
- Documentation improvements
- Code optimization

## 📞 Contact & Support

**Institution**: Faculty of Agricultural Sciences, Sabaragamuwa University of Sri Lanka
**Email**: agrovista@sabac.lk
**Phone**: (081) 5 612 850

## 📄 License

This project is developed for academic purposes by the Faculty of Computing, Sabaragamuwa University of Sri Lanka.

## 🙏 Acknowledgments

- Faculty of Computing, Sabaragamuwa University of Sri Lanka
- Local farmers and producers who inspire our mission
- Open-source community for the tools and libraries used

---

**© 2025 Agro Vista - Promoting Sri Lankan Agricultural Excellence**
