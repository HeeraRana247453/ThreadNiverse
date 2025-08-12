# ThreadHub - PHP Discussion Forum Platform

A modern, responsive PHP-based discussion forum platform that enables users to create, manage, and participate in threaded conversations across various topics.

## 🚀 Features

- **User Authentication**: Secure login/signup system with password hashing
- **Thread Management**: Create, edit, and delete discussion threads
- **Responsive Design**: Mobile-first responsive interface
- **Search Functionality**: Advanced search across threads and posts
- **User Profiles**: Customizable user profiles with avatars
- **Categories**: Organized discussion categories
- **Real-time Updates**: Dynamic content loading with AJAX
- **Email Integration**: Contact forms with SMTP support
- **Admin Panel**: Moderation tools for thread management

## 🛠️ Tech Stack

### Backend
- **PHP 7.4+** - Server-side scripting
- **MySQL** - Database management
- **PHPMailer** - Email handling
- **Composer** - Dependency management

### Frontend
- **HTML5/CSS3** - Structure and styling
- **JavaScript (ES6+)** - Dynamic functionality
- **Bootstrap 5** - Responsive framework
- **Font Awesome** - Icons

### Security
- **Password Hashing** - bcrypt encryption
- **Input Validation** - XSS and SQL injection prevention
- **CSRF Protection** - Token-based protection
- **Session Management** - Secure session handling

## 📁 Project Structure

```
Project-4_Thread_Final_InfinityFree/
├── components/                 # Reusable components
│   ├── _dbconnect.php         # Database connection
│   ├── _header.php            # Site header
│   ├── _footer.php            # Site footer
│   ├── _loginmodal.php        # Login modal
│   ├── _searchmodal.php       # Search modal
│   └── logout.php             # Logout handler
├── images/                     # Site assets and images
├── logo/                       # Brand assets
├── PHPMailer/                  # Email library
├── index.php                   # Homepage
├── thread.php                  # Individual thread view
├── threadlist.php             # Thread listing
├── profilePage.php            # User profile
├── searchPage.php             # Search functionality
├── contactUs.php              # Contact form
├── loginPage.php              # Login page
├── signupPage.php             # Registration page
├── about.php                  # About page
└── README.md                  # This file
```

## 🚦 Getting Started

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (for dependency management)

### Installation

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd Project-4_Thread_Final_InfinityFree
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Database Setup**
   - Create a MySQL database named `threadhub`
   - Import the SQL schema (provided in `database/schema.sql`)
   - Update database credentials in `components/_dbconnect.php`

4. **Configuration**
   - Copy `config.example.php` to `config.php`
   - Update configuration values:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'threadhub');
     ```

5. **Email Configuration**
   - Update SMTP settings in `contactSMTP.php`
   - Configure email credentials for contact forms

6. **File Permissions**
   ```bash
   chmod 755 -R .
   chmod 644 *.php
   chmod 600 config.php
   ```

### Database Schema

Key tables:
- `users` - User accounts and profiles
- `threads` - Discussion threads
- `posts` - Individual posts within threads
- `categories` - Thread categories
- `user_sessions` - Active user sessions

## 🔧 Configuration

### Environment Variables

Create a `.env` file in the root directory:

```env
DB_HOST=localhost
DB_NAME=threadhub
DB_USER=root
DB_PASS=password
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-app-password
```

### Security Settings

- Enable HTTPS in production
- Set secure session parameters
- Configure proper file permissions
- Regular security updates

## 🎯 Usage

### User Roles

1. **Guest Users**
   - Browse threads and posts
   - View user profiles
   - Use search functionality

2. **Registered Users**
   - Create new threads
   - Reply to existing threads
   - Edit own posts
   - Customize profile

3. **Moderators**
   - Edit/delete any post
   - Lock/unlock threads
   - Manage user accounts

4. **Administrators**
   - Full system access
   - Category management
   - User role assignment

### Key Pages

- **Homepage** (`index.php`) - Latest threads and categories
- **Thread View** (`thread.php`) - Detailed thread with replies
- **Profile** (`profilePage.php`) - User profile and activity
- **Search** (`searchPage.php`) - Advanced search functionality
- **Contact** (`contactUs.php`) - Contact form with email

## 🧪 Testing

### Manual Testing Checklist

- [ ] User registration and login
- [ ] Thread creation and management
- [ ] Post creation and editing
- [ ] Search functionality
- [ ] Email notifications
- [ ] Responsive design on mobile devices
- [ ] Admin panel functionality

### Automated Testing

```bash
# Run PHP syntax check
find . -name "*.php" -exec php -l {} \;

# Check for common security issues
grep -r "eval\|exec\|system" --include="*.php" .
```

## 🚀 Deployment

### Production Checklist

- [ ] Update all configuration files
- [ ] Set up SSL certificate
- [ ] Configure error logging
- [ ] Set up automated backups
- [ ] Configure caching (Redis/Memcached)
- [ ] Set up monitoring (New Relic/DataDog)

### Docker Deployment

```dockerfile
FROM php:8.1-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY . /var/www/html/
EXPOSE 80
```

### How to Run the Project in Docker Container

1. Build the Docker image:

```bash
docker build -t threadhub-forum .
```

2. Run the Docker container:

```bash
docker run -d -p 8080:80 --name threadhub-container threadhub-forum
```

3. Access the application in your browser at:

```
http://localhost:8080
```

4. To stop the container:

```bash
docker stop threadhub-container
```

5. To remove the container:

```bash
docker rm threadhub-container
```

Make sure your database is accessible to the container, either by running a separate MySQL container or connecting to an external database. Update your database credentials accordingly in the configuration files.
docker rm threadhub-container
3. Access the application in your browser at:

docker run -d -p 8080:80 --name threadhub-container threadhub-forum
docker build -t threadhub-forum .
EXPOSE 80

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Code Style

- Follow PSR-12 coding standards
- Use meaningful variable names
- Add comments for complex logic
- Maintain consistent indentation (4 spaces)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support, email threadniverse@gmail.com or join our Slack channel.

## 🙏 Acknowledgments

- Bootstrap team for the responsive framework
- PHPMailer team for email functionality
- Font Awesome for icons
- All contributors and testers

## 📈 Roadmap

- [ ] Real-time notifications
- [ ] Private messaging system
- [ ] Thread subscriptions
- [ ] Advanced moderation tools
- [ ] Multi-language support
- [ ] RESTful API
- [ ] Mobile app integration

---

**ThreadHub** - Empowering communities through meaningful discussions
