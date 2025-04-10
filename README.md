# Multi-Tenant Blog API

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![Tenancy](https://img.shields.io/badge/Stancl_Tenancy-3.x-blue)
![API](https://img.shields.io/badge/API-RESTful-green)

A secure multi-tenant blogging platform with user approval workflow, built with Laravel 12 and Stancl Tenancy.

## Features

- ✅ Multi-tenancy with domain isolation
- ✅ User registration with admin approval
- ✅ JWT Authentication via Laravel Sanctum
- ✅ CRUD operations for blog posts
- ✅ Admin dashboard for cross-tenant management
- ✅ SOLID principles implementation

## Tech Stack

- **Backend**: Laravel 12
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Multi-tenancy**: Stancl Tenancy v3
- **API Docs**: OpenAPI 3.0

## Setup Instructions

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer 2.0+

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/vinboy20/multi-tenancy-blog.git
   cd multi-tenant-blog

2. Install dependencies:
	composer install

3. Configure environment:
	cp .env.example .env
	php artisan key:generate

4. Database setup:
	php artisan migrate --seed

5. Serve the application:
	php artisan serve

### Base URL
	http://localhost:8000/api

### Authentication

### Endpoint	Method	Description
	/register	POST	Register new user (pending)
	/login	POST	Get JWT token
	/logout	POST	Invalidate token

### User Endpoints
	Endpoint	Method	 Description
	/posts |	GET |	List user's posts
	/posts |	POST |	Create new post
	/posts/{id} |	PUT |	Update post
	/posts/{id}	| DELETE |	Delete post

### Admin Endpoints
	Endpoint	Method	  Description
	/admin/pending-users  |	GET	 | List users pending approval
	/admin/approve-user |	POST  |	Approve user & create tenant
	/admin/all-posts |	GET	 | View posts across all tenants