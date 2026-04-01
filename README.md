<p align="center">
    <h1>🎫 Event Management System</h1>
    <p>A modern, full-featured event management platform built with Laravel 11, Tailwind CSS, and Alpine.js</p>
</p>

---

## 📋 About

The **Event Management System** is a comprehensive web application designed to simplify event creation, management, and booking. Users can create events, manage attendees, and discover upcoming events in a beautiful, intuitive interface.

### Key Features

✨ **Event Management**
- Create, edit, and delete events
- Set event dates, capacities, and detailed descriptions
- View event attendee lists with attendee information
- Track booking status and availability

👥 **Booking System**
- Users can browse and book available events
- Automatic capacity management
- Cancel bookings with one click
- View personal booking history

🔐 **Authorization & Security**
- Role-based access control using Policies
- Users can only manage their own events
- Event owners control event details and attendee access
- Secure booking management

🎨 **Beautiful UI/UX**
- Modern, responsive design with Tailwind CSS
- Gradient backgrounds and smooth animations
- Mobile-friendly interface
- Intuitive navigation and user flows

📊 **Dashboard**
- Quick statistics (events created, bookings made, total attendees)
- Recent events and bookings at a glance
- Fast action buttons for common tasks

---

## 🏗️ Technical Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| **Laravel** | 11.x | Backend framework |
| **PHP** | 8.2+ | Server-side language |
| **MySQL** | 8.0 | Database |
| **Tailwind CSS** | 3.3+ | Styling |
| **Alpine.js** | Latest | Frontend interactivity |
| **Vite** | 5.x | Build tool |
| **PHPUnit** | Latest | Testing framework |

---

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL 8.0 or higher
- Git

### Step 1: Clone the Repository
```bash
git clone <repository-url>
cd event-management-system
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### Step 3: Configure Environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Database Setup
```bash
# Run migrations
php artisan migrate

# Seed sample data (optional)
php artisan db:seed
```

### Step 5: Build Assets
```bash
# Development mode
npm run dev

# Production build
npm run build
```

### Step 6: Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 🐳 Docker Setup (Optional)

### Using Docker Compose

```bash
# Start containers
docker-compose -f docker/docker-compose.yml up -d

# Access MySQL
# Host: localhost:2081
# PHPMyAdmin: localhost:2082
```

Update `.env` to use Docker:
```env
DB_HOST=event-management-system-db
DB_PORT=3306
```

---

## 📁 Project Structure

```
event-management-system/
├── app/
│   ├── Models/              # Eloquent models (Event, Booking, User)
│   ├── Http/
│   │   ├── Controllers/     # EventController, BookingController
│   │   ├── Requests/        # Form requests with validation
│   │   ├── Middleware/      # Custom middleware
│   │   └── Kernel.php
│   ├── Policies/            # Authorization policies (EventPolicy, BookingPolicy)
│   └── Providers/           # Service providers
├── routes/
│   ├── web.php              # Web routes
│   ├── api.php              # API routes
│   └── auth.php             # Authentication routes
├── resources/
│   ├── views/
│   │   ├── events/          # Event CRUD views
│   │   ├── bookings/        # Booking views
│   │   ├── dashboard.blade.php
│   │   ├── welcome.blade.php
│   │   └── layouts/         # Layout templates
│   ├── css/
│   │   └── app.css          # Tailwind CSS
│   └── js/
│       └── app.js           # Alpine.js & JavaScript
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories
├── tests/
│   ├── Feature/             # Feature tests
│   └── Unit/                # Unit tests
├── docker/
│   └── docker-compose.yml   # Docker configuration
└── public/                  # Public assets

```

---

## 🔑 Core Concepts

### Models & Relationships

#### Event Model
```php
// Relationships
- belongsTo(User) → Owner/Creator
- hasMany(Booking) → All bookings for this event

// Scopes
- upcoming() → Future events
- past() → Past events

// Methods
- getAvailableSeats() → Remaining capacity
- isFullyBooked() → Boolean check
- isPast() → Event status
```

#### Booking Model
```php
// Relationships
- belongsTo(User) → Attendee
- belongsTo(Event) → Associated event
```

#### User Model
```php
// Relationships
- hasMany(Event) → Events created
- hasMany(Booking) → Events booked
```

### Understanding Policies

**Policies** are Laravel's authorization classes that determine what actions a user can perform. They centralize permission logic in a clean, testable way.

#### How Policies Work

1. **Policy Definition**: Each policy has methods for actions (create, view, update, delete)
2. **Authorization Check**: Use `authorize()` in controllers or `@can`/`@cannot` in views
3. **Return Values**: Methods return `true` (allowed) or `false` (forbidden)

#### EventPolicy Example

```php
class EventPolicy
{
    // Owner can update their events
    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    // Owner can delete their events
    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    // Anyone can view events
    public function view(User $user, Event $event): bool
    {
        return true;
    }
}
```

#### How Authorization Works in This Project

**In Controllers:**
```php
// Automatically checks EventPolicy@update
$this->authorize('update', $event);

// Or explicitly
if ($this->authorize('update', $event)) {
    // Update logic
}
```

**In Blade Views:**
```blade
@can('update', $event)
    <a href="{{ route('events.edit', $event) }}">Edit</a>
@endcan

@cannot('delete', $event)
    <p>You cannot delete this event</p>
@endcannot
```

#### Policy Methods in This Project

**EventPolicy:**
- `create(User)` → Who can create events
- `view(User, Event)` → Who can view events
- `update(User, Event)` → Only event owner
- `delete(User, Event)` → Only event owner

**BookingPolicy:**
- `create(User, Event)` → Can user book this event
- `delete(User, Booking)` → Only booker can cancel
- `viewAny(User)` → View booking list

#### Why Policies Matter

✅ **Security**: Prevents unauthorized actions  
✅ **Clean Code**: Authorization logic separated from controllers  
✅ **Testable**: Easy to unit test permissions  
✅ **Reusable**: Use same policy in controllers, views, and APIs  
✅ **Maintainable**: Central place to change permissions

---

## 🔌 API Routes

### Events
```
GET     /events              - List all events
GET     /events/create       - Show create form
POST    /events              - Store new event
GET     /events/{id}         - Show event details
GET     /events/{id}/edit    - Show edit form
PUT     /events/{id}         - Update event
DELETE  /events/{id}         - Delete event
```

### Bookings
```
GET     /bookings            - List user's bookings
POST    /events/{id}/book    - Create booking
DELETE  /bookings/{id}       - Cancel booking
```

---

## 🧪 Testing

The project includes comprehensive test coverage with 44 passing tests.

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/EventControllerTest.php

# Run with coverage
php artisan test --coverage
```

### Test Categories
- **Feature Tests**: Test complete user workflows
- **Unit Tests**: Test individual components
- **Authorization Tests**: Verify policy enforcement

---

## 📝 Database Migrations

### Tables

**events**
- id, user_id, title, description, date, capacity, created_at, updated_at

**bookings**
- id, user_id, event_id, created_at, updated_at

**users**
- id, name, email, email_verified_at, password, created_at, updated_at

---

## 🔒 Environment Variables

Key variables in `.env`:

```env
APP_NAME=EventManagementSystem
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

---

## 📚 Project Statistics

- **44 Passing Tests**: Complete test coverage
- **3 Models**: Event, Booking, User
- **2 Controllers**: EventController, BookingController
- **2 Policies**: EventPolicy, BookingPolicy
- **6 Blade Views**: Modern, responsive design
- **~1500 lines**: Clean, well-documented code

---

## 🎯 Common Tasks

### Create an Event (as authenticated user)
1. Go to Dashboard → "Create New Event"
2. Fill in title, description, date, and capacity
3. Click "Create Event"
4. View your event on the browse page

### Book an Event
1. Go to "Browse Events"
2. Click on an event card
3. Click "Book Now" if available
4. View in "My Bookings" dashboard

### Manage Your Events
1. Go to Dashboard → Recent Events
2. Click "Edit" or "View" on an event
3. Edit details or view attendees

---

## 🐛 Troubleshooting

**Database Connection Error**
```bash
# Check .env credentials
# Ensure MySQL is running
# Run migrations again
php artisan migrate:fresh --seed
```

**Styles not showing**
```bash
# Rebuild CSS/JS
npm run build

# Or use dev server
npm run dev
```

**Permission Denied**
- Ensure `storage/` and `bootstrap/cache/` are writable:
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📞 Support

For issues or questions, please refer to:
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [Alpine.js Guide](https://alpinejs.dev/)

---

## 📄 License

This project is open-sourced software licensed under the MIT license.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
