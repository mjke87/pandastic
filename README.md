<p align="center">
  <img src="public/img/logo.png" alt="Pandastic Logo" width="120"/>
</p>

# Pandastic

A simple family management application to let your kids know they are doing pandasticly.

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

## Development

### Local Development

To develop Pandastic locally:

1. Make sure you have PHP 8.0+ and Composer installed.
2. Install dependencies with `composer install` if you haven't already.
3. Start a local development server from the project root:
   ```sh
   php -S localhost:8000 -t public
   ```
   This will serve the app at http://localhost:8000
4. You can now edit code and templates. Refresh your browser to see changes.

**Key files and folders:**
- All templates are in `/views`
- Main entry point: `index.php`
- Routing: `public/routes.php`
- Configuration: `config/app.php`
- Controllers: `App/Controllers/`
- Models: `App/Models/`

**Note:**
If you change the data structure or config, you may need to clear or update files in the `data/` directory.

## License

This project is released into the public domain under [The Unlicense](LICENSE).