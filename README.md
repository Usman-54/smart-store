# Smart Store — Full-Stack E-Commerce Web Application

Smart Store is a full-stack web-based e-commerce platform built with **Laravel** and **MySQL** to streamline online retail operations. The application bridges the gap between customer shopping workflows and administrative inventory management by providing a responsive storefront for buyers and a centralized control panel for store administrators.

---

## Project Overview

Online stores require reliable product organization, real-time stock accuracy, and transparent order tracking. Smart Store solves these requirements through a structured Model-View-Controller (MVC) architecture:
- **Storefront Module:** Enables customers to browse categorized products, filter listings, manage a dynamic shopping cart, complete checkout, and track order progress.
- **Administration Module:** Equips store managers with role-restricted tools to manage categories, products, stock quantities, customer accounts, and order fulfillment states.

---

## Key Features

### Customer Storefront
- **Authentication & Account Management:** Secure user registration, login, password handling, and profile updates powered by Laravel authentication.
- **Catalog Browsing & Search:** Browse products by category, search by keyword, and view detailed product pages with pricing, descriptions, specifications, and stock availability.
- **Dynamic Shopping Cart:** Add products to the cart, adjust item quantities, remove items, and view automatic subtotal and total calculations.
- **Checkout Workflow:** Streamlined order placement capturing shipping information, contact details, and order summaries.
- **Order History & Status Tracking:** Customers can view past purchases and monitor live fulfillment statuses (`Pending`, `Processing`, `Shipped`, `Delivered`, `Cancelled`).

### Admin Dashboard
- **Store Analytics Overview:** Quick summary of total revenue, active orders, total products, and registered customers.
- **Category & Product CRUD:** Full Create, Read, Update, and Delete operations for categories and products, including image upload and validation.
- **Inventory & Stock Control:** Track product stock levels and automatically prevent orders when items are out of stock.
- **Order Processing:** Inspect incoming customer orders, verify shipping details, and update order statuses through each stage of fulfillment.

---

## System Architecture & Database Design

The application follows Laravel's **MVC (Model-View-Controller)** pattern with a normalized relational database schema in **MySQL**:

- **`users`:** Stores customer and administrator credentials, contact details, and role flags.
- **`categories`:** Organizes products into structured storefront groups.
- **`products`:** Stores product names, slugs, descriptions, prices, stock quantities, image paths, and foreign keys linking to `categories`.
- **`carts` / `cart_items`:** Tracks active customer cart sessions and selected product quantities.
- **`orders`:** Records completed purchases, total amounts, shipping addresses, payment methods, and order statuses.
- **`order_items`:** Links individual purchased products, quantities, and unit prices at the time of purchase to each order.

---

## Tools & Technologies Used

| Layer | Technologies |
| :--- | :--- |
| **Backend Framework** | PHP, Laravel (MVC Architecture, Eloquent ORM, Blade Templating) |
| **Frontend** | HTML5, CSS3, Bootstrap 5, JavaScript (DOM manipulation & AJAX interactions) |
| **Database** | MySQL (Relational Schema, Foreign Key Constraints, Migrations) |
| **Development Environment** | Visual Studio Code, XAMPP (Apache & MySQL), Composer |
| **Version Control** | Git, GitHub |

---

## Installation & Local Setup

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/Usman-54/smart-store.git](https://github.com/Usman-54/smart-store.git)
   cd smart-store
