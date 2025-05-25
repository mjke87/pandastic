<p align="center">
  <img src="public/img/logo.png" alt="Pandastic Logo" width="120"/>
</p>

# Pandastic

A simple school grade tracker and reward system for families.

## Features

- Track grades for multiple users (children)
- Assign rewards based on grades
- Simple user management (create, edit, delete users)
- File-based storage (default) or database support
- Role-based permissions (parent/child/guest)
- Responsive UI with Pico.css

## Requirements

- PHP 8.0+
- Composer

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/mjke87/pandastic.git
   cd pandastic
   ```

2. **Install dependencies:**
   ```sh
   composer install
   ```

3. **Set writable permissions for the data directory:**
   ```sh
   chmod -R 0777 data
   ```

4. **Configure your web server:**
   - Point your web root to the `public/` directory.
   - For Apache, use the provided `.htaccess` for routing.

5. **(Optional) Configure app settings:**
   - Edit `config/app.php` for app name, currency, and storage options.

## Usage

- Visit the app in your browser.
- Login or create users.
- Add grades and see rewards calculated automatically.

## Development

- All templates are in `/templates`
- Main entry point: `index.php`
- Routing: `public/routes.php`
- Configuration: `config/app.php`

## License

This project is released into the public domain under [The Unlicense](LICENSE).