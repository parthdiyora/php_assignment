# PHP Test Assignment (Laravel)

## Setup Instructions

### Step 1: Clone the Repository
```bash
git clone <repository-url>
cd php-test-assignment
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Configure Environment Variables
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Run the Application
```bash
php artisan serve
```

## CLI Command: `php artisan add:author`

### Usage

This command allows you to add an author via the terminal. Run the following command with the required parameters:

```bash
php artisan add:author "First Name" "Last Name" "YYYY-MM-DD" "Biography" "Gender" "Place of Birth"
```

