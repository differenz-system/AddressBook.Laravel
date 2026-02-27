# Address Book (Laravel 12)

A modern address book application built with Laravel 12, PHP 8.2, MySQL, Bootstrap 5, jQuery, and DataTables. It features secure authentication, AJAX-based CRUD for contacts, polished UI/UX, a collapsible sidebar, and a phonebook-style contact list with alphabetical filtering, search, and client-side pagination.

**NEW:** Complete RESTful API layer with Laravel Sanctum authentication for mobile apps and third-party integrations.

## Features

### Web Application
- Authentication (register, login, logout) with CSRF protection and hashed passwords
- Contacts CRUD via jQuery AJAX and Laravel controllers
- Ownership enforcement: users can only access their own contacts
- Dashboard with animated stat cards and searchable DataTable (10 per page)
- Contacts page: modern list + detail panel, alphabet rail (A–Z), search, and pagination
- Bootstrap modals for Add/Edit/View/Delete, with client-side and server-side validation
- Additional contact fields: Work (job title, company, department, work email/phone, website) and About (birthday, notes)
- Collapsible sidebar with persistent state and tooltips

### RESTful API
- Token-based authentication using Laravel Sanctum
- Complete CRUD operations for contacts
- User registration, login, logout, and profile management
- Search, filtering, and pagination support
- Standardized JSON responses with proper error handling
- CORS enabled for cross-origin requests
- Production-ready with security best practices

## Tech Stack

- Backend: Laravel 12 (PHP 8.2), MySQL, Laravel Sanctum
- Frontend: Bootstrap 5, Bootstrap Icons, jQuery, DataTables (via CDN)
- API: RESTful endpoints with JSON responses
- Validation: Laravel Form Requests + jQuery Validate (client-side hints)

## Requirements

- PHP 8.2+
- MySQL 5.7+/8.0+
- Composer

## Quick Start

### Web Application

1. Clone the repo and install dependencies
   - composer install

2. Create and configure environment
   - cp .env.example .env
   - Update DB_ settings (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

3. Generate app key and run migrations
   - php artisan key:generate
   - php artisan migrate

4. Start the dev server
   - php artisan serve

5. Visit the app
   - http://127.0.0.1:8000
   - Register a user account and log in

### API Setup

The API is automatically available when you start the application. No additional setup required!

**API Base URL:** `http://127.0.0.1:8000/api/`

**API Documentation:** Visit `http://127.0.0.1:8000/api/` for complete endpoint documentation.

#### Quick API Test

```bash
# 1. Register a new user
curl -X POST http://127.0.0.1:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123","password_confirmation":"password123"}'

# 2. Login to get token
TOKEN=$(curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password123"}' | jq -r '.data.token')

# 3. Get contacts using token
curl -X GET http://127.0.0.1:8000/api/contacts \
  -H "Authorization: Bearer $TOKEN"
```

## Project Structure Highlights

### Web Application
- routes/web.php
  - Guest: login/register
  - Auth: dashboard and contacts routes (index, datatable, show, store, update, destroy)

- app/Http/Controllers/
  - Auth/LoginController, Auth/RegisterController
  - DashboardController (stats + recent contacts)
  - ContactController (AJAX CRUD + datatable endpoint)

- app/Http/Requests/
  - LoginRequest, RegisterRequest, StoreContactRequest, UpdateContactRequest

### API Layer
- routes/api.php
  - Public: auth/register, auth/login
  - Protected: auth/logout, auth/profile, contacts CRUD, favorites

- app/Http/Controllers/Api/
  - AuthController (register, login, logout, profile)
  - ContactController (CRUD, search, favorites, pagination)

- app/Http/Requests/Api/
  - RegisterRequest, LoginRequest, StoreContactRequest, UpdateContactRequest

- app/Http/Resources/
  - ContactResource (single contact formatting)
  - ContactCollection (paginated collection formatting)

### Shared Components
- app/Models/
  - User (hasMany Contact, HasApiTokens trait)
  - Contact (fillable, belongsTo User)

- database/migrations/
  - 2026_02_24_000000_create_contacts_table.php
  - 2026_02_24_010000_add_work_about_to_contacts_table.php
  - 2026_02_27_074505_create_personal_access_tokens_table.php (Sanctum)

- resources/views/
  - layouts/app.blade.php (collapsible sidebar, top navbar)
  - auth/login.blade.php, auth/register.blade.php (animated UI, merged icon inputs, error styling)
  - dashboard/index.blade.php (stat cards + Recent Contacts DataTable)
  - contacts/index.blade.php (list + detail UI, alphabet rail, search, pagination)
  - contacts/modals.blade.php (Add/Edit/View/Delete modals)

- public/css/
  - admin.css (admin layout + components)
  - auth.css (auth pages look & feel)

## Usage Guide

### Web Application

- Dashboard
  - See total contacts and recent list (DataTable: 10 per page, search enabled)
  - Quick-add contact via modal (AJAX)

- Contacts
  - A–Z alphabet filter, search box, and client-side pagination for the left list
  - Click a contact to open the right detail panel (tabs: Contact, Work, About)
  - Add/Edit/Delete via modals; fields validated on client and server

### RESTful API

#### Authentication
All API endpoints (except register/login) require a Bearer token:

```http
Authorization: Bearer {your_token_here}
```

#### Authentication Endpoints

**Register User**
```http
POST /api/auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Login User**
```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

**Logout User**
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

**Get User Profile**
```http
GET /api/auth/profile
Authorization: Bearer {token}
```

#### Contact Endpoints

**List Contacts**
```http
GET /api/contacts?search=john&is_favorite=true&sort_by=first_name&per_page=10
Authorization: Bearer {token}
```

**Create Contact**
```http
POST /api/contacts
Authorization: Bearer {token}
Content-Type: application/json

{
    "first_name": "Jane",
    "last_name": "Smith",
    "email": "jane@example.com",
    "phone": "+1234567890",
    "company": "Tech Corp",
    "is_favorite": true
}
```

**Get Single Contact**
```http
GET /api/contacts/{id}
Authorization: Bearer {token}
```

**Update Contact**
```http
PUT /api/contacts/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "first_name": "Jane Updated",
    "email": "jane.updated@example.com"
}
```

**Delete Contact**
```http
DELETE /api/contacts/{id}
Authorization: Bearer {token}
```

**Get Favorite Contacts**
```http
GET /api/contacts/favorites
Authorization: Bearer {token}
```

**Toggle Favorite Status**
```http
PATCH /api/contacts/{id}/toggle-favorite
Authorization: Bearer {token}
```

#### Response Format

**Success Response:**
```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        // Response data here
    }
}
```

**Error Response:**
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "field_name": ["Error message"]
    }
}
```

**Paginated Response:**
```json
{
    "success": true,
    "message": "Contacts retrieved successfully",
    "data": {
        "data": [...],
        "meta": {
            "total": 100,
            "count": 15,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 7,
            "has_more_pages": true
        },
        "links": {
            "first": "http://localhost/api/contacts?page=1",
            "last": "http://localhost/api/contacts?page=7",
            "prev": null,
            "next": "http://localhost/api/contacts?page=2"
        }
    }
}
```

## Security & Authorization

### Web Application
- All contacts are scoped to the authenticated user (authorization enforced in queries)
- Non-owned/missing contacts return 404/JSON errors; form requests validate inputs

### API Security
- Token-based authentication using Laravel Sanctum
- All contact endpoints are protected and require valid Bearer token
- Users can only access their own contacts (scoped queries)
- CORS enabled for cross-origin requests
- Token revocation on logout
- Password hashing and secure token generation
- Request validation with custom error messages

## Troubleshooting

### Web Application
- Styles not updating: hard refresh the browser or run php artisan optimize:clear
- DB errors: verify .env DB_ credentials and that migrations ran (php artisan migrate:status)
- 419/CSRF issues: ensure meta csrf-token is present (layout) and AJAX sets the header

### API Issues
- 401 Unauthorized: Check that you're sending a valid Bearer token in Authorization header
- 403 Forbidden: Ensure user has permission to access the resource
- 419 Page Expired: API doesn't use CSRF tokens, ensure you're hitting /api/ endpoints
- CORS errors: Check that your frontend is sending proper headers and credentials
- Token not working: Ensure token hasn't expired and user hasn't logged out

### Common Commands
```bash
# Check migration status
php artisan migrate:status

# Clear cache if API routes not working
php artisan route:clear
php artisan config:clear

# Generate new app key if needed
php artisan key:generate

# Check if Sanctum is properly installed
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

## Deployment Notes

### Web Application
- This project uses CDN assets (no NPM build required by default)
- Ensure APP_KEY is set (php artisan key:generate) and APP_ENV/APP_URL are correct
- Configure a persistent database and set proper file permissions for storage/

### API Deployment
- Ensure CORS settings are properly configured for your frontend domains
- Set appropriate token expiration limits in config/sanctum.php
- Consider rate limiting for API endpoints in production
- Ensure HTTPS is used for production API endpoints
- Configure proper firewall rules to protect API endpoints

### Environment Variables for API
```env
# Standard Laravel variables
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Sanctum configuration (optional)
SANCTUM_STATEFUL_DOMAINS=your-frontend-domain.com
```

## API Examples

### JavaScript/Fetch Example
```javascript
// Login and get token
const login = async (email, password) => {
  const response = await fetch('/api/auth/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ email, password })
  });
  const data = await response.json();
  return data.data.token;
};

// Get contacts
const getContacts = async (token) => {
  const response = await fetch('/api/contacts', {
    headers: { 'Authorization': `Bearer ${token}` }
  });
  return await response.json();
};

// Create contact
const createContact = async (token, contactData) => {
  const response = await fetch('/api/contacts', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(contactData)
  });
  return await response.json();
};
```

### Postman Collection
You can import the following collection into Postman to test all API endpoints:

```json
{
  "info": {
    "name": "Address Book API",
    "description": "Complete API for Laravel Address Book application"
  },
  "variable": [
    {
      "key": "baseUrl",
      "value": "http://127.0.0.1:8000/api"
    },
    {
      "key": "token",
      "value": ""
    }
  ],
  "item": [
    {
      "name": "Auth",
      "item": [
        {
          "name": "Register",
          "request": {
            "method": "POST",
            "header": [
              {
                "key": "Content-Type",
                "value": "application/json"
              }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\n  \"name\": \"John Doe\",\n  \"email\": \"john@example.com\",\n  \"password\": \"password123\",\n  \"password_confirmation\": \"password123\"\n}"
            },
            "url": "{{baseUrl}}/auth/register"
          }
        },
        {
          "name": "Login",
          "request": {
            "method": "POST",
            "header": [
              {
                "key": "Content-Type",
                "value": "application/json"
              }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\n  \"email\": \"john@example.com\",\n  \"password\": \"password123\"\n}"
            },
            "url": "{{baseUrl}}/auth/login"
          },
          "event": [
            {
              "listen": "test",
              "script": {
                "exec": [
                  "if (pm.response.code === 200) {",
                  "    const response = pm.response.json();",
                  "    pm.collectionVariables.set('token', response.data.token);",
                  "}"
                ]
              }
            }
          ]
        }
      ]
    }
  ]
}
```

---

**🎉 Your Laravel Address Book now includes both a beautiful web interface and a complete RESTful API!**

