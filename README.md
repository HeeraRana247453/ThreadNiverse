# ThreadNiverse - PHP Discussion Forum Platform

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
- Docker & Docker Compose (optional, for containerized setup)

### Installation

#### Option 1: Local Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/HeeraRana247453/ThreadNiverse.git
   cd Project-4_Thread_Final_InfinityFree
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   - Copy `.env.example` to `.env` (or create `.env` file)
   - Update the environment variables in `.env` file:
     ```env
     DB_HOST=localhost
     DB_NAME=threadhub
     DB_USER=root
     DB_PASS=your_database_password
     SMTP_HOST=smtp.gmail.com
     SMTP_USER=your-email@gmail.com
     SMTP_PASS=your-app-password
     ```

4. **Database Setup**
   - Create a MySQL database named `threadhub`
   - Import the SQL schema (provided in `database/schema.sql`)
   - The application will automatically use the environment variables from `.env`

5. **File Permissions**
   ```bash
   chmod 755 -R .
   chmod 644 *.php
   chmod 600 .env
   ```

#### Option 2: Docker Setup (Recommended)

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd Project-4_Thread_Final_InfinityFree
   ```

2. **Start with Docker Compose**
   ```bash
   docker-compose up -d
   ```

3. **Access the application**
   - Main application: http://localhost:8080
   - PHPMyAdmin: http://localhost:8081
   - Database credentials are pre-configured in docker-compose.yml

4. **Environment Variables**
   - Docker environment variables are set in `docker-compose.yml`
   - For custom configuration, update the environment section in docker-compose.yml

### Database Schema

Key tables:
- `users` - User accounts and profiles
- `threads` - Discussion threads
- `posts` - Individual posts within threads
- `categories` - Thread categories
- `user_sessions` - Active user sessions

## 🔧 Configuration

### Environment Variables

The application uses environment variables for configuration. Create a `.env` file in the root directory:

```env
# Database Configuration
DB_HOST=localhost
DB_NAME=threadhub
DB_USER=root
DB_PASS=your_database_password

# SMTP Configuration
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-app-password

# Application Configuration
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost
```

### Environment Variable Usage

The application automatically loads environment variables from the `.env` file. The `components/_dbconnect.php` file uses these variables to establish database connections:

- **Local Development**: Uses `.env` file variables
- **Docker Environment**: Uses environment variables from docker-compose.yml
- **Production**: Uses server environment variables

### Security Best Practices

1. **Never commit .env file** - Add `.env` to `.gitignore`
2. **Use strong passwords** - Generate secure database and SMTP passwords
3. **Restrict file permissions** - Set `.env` file permissions to 600
4. **Environment-specific configs** - Use different .env files for dev/staging/prod

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
- [ ] Set up monitoring (New Relic/DataDogI will now update the README.md file to include instructions about the .env file and reflect the environment variable usage in the project.

<edit_file>
<path>README.md</path>
<content>
<<<<<<< SEARCH
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
=======
## 🔧 Configuration

### Environment Variables

Create a `.env` file in the root directory with the following content and update the values as needed:

```env
# Database Configuration
DB_HOST=localhost
DB_NAME=threadhub
DB_USER=root
DB_PASS=your_database_password

# SMTP Configuration for Email
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-app-password

# Application Configuration
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost

# Security Configuration
SESSION_SECURE=false
SESSION_HTTP_ONLY=true
SESSION_SAMESITE=Lax

# Optional: Redis Configuration (for caching)
REDIS_HOST=localhost
REDIS_PORT=6379
REDIS_PASSWORD=

# Optional: File Upload Configuration
MAX_FILE_SIZE=5242880
ALLOWED_FILE_TYPES=jpg,jpeg,png,gif,pdf,doc,docx
UPLOAD_PATH=uploads/

# Optional: Social Login Configuration
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
FACEBOOK_APP_ID=
FACEBOOK_APP_SECRET=
```

### Using Environment Variables with Docker

The project supports Docker and docker-compose. Environment variables are set in the `docker-compose.yml` file for the web and database services. Ensure to update the `.env` file and `docker-compose.yml` accordingly to keep credentials consistent.

### Security Settings

- Enable HTTPS in production
- Set secure session parameters
- Configure proper file permissions
- Regular security updates

### Docker Deployment

```dockerfile
FROM php:8.1-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY . /var/www/html/
EXPOSE 80
```

### How to Run the Project in Docker Container

#### Quick Start with Docker Compose

1. **Start the entire stack**
   ```bash
   docker-compose up -d
   ```

2. **Access the services**
   - Main application: http://localhost:8080
   - PHPMyAdmin: http://localhost:8081
   - MySQL: localhost:3306

3. **Stop the services**
   ```bash
   docker-compose down
   ```

#### Manual Docker Commands

1. **Build the Docker image**
   ```bash
   docker build -t threadhub-forum .
   ```

2. **Run with environment variables**
   ```bash
   docker run -d -p 8080:80 \
     -e DB_HOST=your-db-host \
     -e DB_NAME=threadhub \
     -e DB_USER=root \
     -e DB_PASSWORD=your-password \
     --name threadhub-container threadhub-forum
   ```

3. **Access the application**
   ```
   http://localhost:8080
   ```

### Environment Variables in Docker

The Docker setup uses environment variables defined in `docker-compose.yml`:

```yaml
environment:
  - DB_HOST=db
  - DB_NAME=threadhub
  - DB_USER=root
  - DB_PASSWORD=rootpassword
```

### Development vs Production

#### Development (.env file)
```env
APP_ENV=development
APP_DEBUG=true
DB_HOST=localhost
```

#### Production (server environment)
```bash
export APP_ENV=production
export APP_DEBUG=false
export DB_HOST=your-production-db-host
```

### Troubleshooting

#### Common Issues

1. **Database Connection Failed**
   - Check if MySQL is running
   - Verify credentials in .env file
   - Ensure database exists

2. **SMTP Email Not Working**
   - Check SMTP credentials in .env
   - Verify email provider settings
   - Check firewall settings

3. **Permission Issues**
   ```bash
   # Fix file permissions
   sudo chown -R www-data:www-data /var/www/html
   sudo chmod -R 755 /var/www/html
   sudo chmod 600 .env
   ```

4. **Docker Issues**
   ```bash
   # Check container logs
   docker-compose logs web
   docker-compose logs db
   
   # Rebuild containers
   docker-compose down
   docker-compose up --build
   ```
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

**ThreadNiverse** - Empowering communities through meaningful discussions
