# MyPortfolio

A modern, responsive personal portfolio website built with PHP, MySQL, Bootstrap 5, and custom CSS/JS. Features a public-facing portfolio, blog, contact form, and a secure admin dashboard for managing content.

## Features

- **Modern UI/UX**: Glassmorphism, dark/light mode toggle, animated skill icons, and responsive design.
- **Dynamic Content**: Projects, skills, about, and blog posts are managed from a MySQL database.
- **Admin Dashboard**: Secure login, CRUD for projects, skills, about, blog posts, and contact messages.
- **Image Uploads**: Robust, validated image upload for projects and skills.
- **Contact Form**: Sends messages to the admin dashboard.
- **Deployment Ready**: Follows best practices for security and deployment.

## Technologies Used

- PHP (PDO for MySQL)
- MySQL
- Bootstrap 5
- Custom CSS (glassmorphism, dark/light mode, animations)
- JavaScript (theme toggle, UI enhancements)

## Setup Instructions

   ```
2. **Set up the database**
   - Import `database_schema.sql` into your MySQL server.
   - Update `includes/db_connect.php` with your database credentials.
3. **Configure file permissions**
   - Ensure `assets/uploads/` is writable for image uploads.
4. **Run locally**
   - Place the project in your web server's root (e.g., XAMPP's `htdocs`).
   - Access via `htt`.
5. **Admin Access**
   - Visit `/admin/login.php` to log in and manage content.

## Folder Structure

- `index.php` — Homepage (hero, skills, projects, contact)
- `about.php`, `portfolio.php`, `blog.php`, `contact.php` — Public pages
- `admin/` — Admin dashboard and content management
- `assets/` — CSS, JS, images, uploads
- `includes/` — DB connection, header, footer

## Customization

- Update your name, bio, and images via the admin dashboard or directly in the database.
- Edit styles in `assets/css/style.css` for further customization.

## Security Notes

- Uses prepared statements (PDO) to prevent SQL injection.
- Validates and sanitizes file uploads.
- Admin area protected by authentication.

## Credits

- Developed by jot3c for Agyemang Kofi Hackman
- Bootstrap 5, and other libraries as credited in code.

## License

This project is for personal/portfolio use. For commercial use, please contact the author.
