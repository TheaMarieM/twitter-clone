# TweetyBird

A simple Twitter clone built with Laravel, allowing users to post tweets, like, edit, and delete them. The project demonstrates core social media features in a clean, responsive UI using Tailwind CSS and Blade templates.

## Features
- User authentication (register, login)
- Post tweets (up to 280 characters)
- Like, edit, and delete tweets
- Responsive timeline feed
- Profile images for users
- Real-time tweet count and timestamps
- Clean UI with Tailwind CSS and FontAwesome icons

## Installation
1. **Clone the repository:**
   ```sh
   git clone https://github.com/yourusername/tweetybird.git
   cd tweetybird
   ```
2. **Install dependencies:**
   ```sh
   composer install
   npm install
   ```
3. **Copy and configure environment:**
   ```sh
   cp .env.example .env
   # Edit .env with your database credentials
   ```
4. **Generate application key:**
   ```sh
   php artisan key:generate
   ```

## Database Setup
1. **Run migrations:**
   ```sh
   php artisan migrate:fresh
   ```
2. **Seed the database (optional):**
   ```sh
   php artisan db:seed
   ```

## Running the Application
1. **Build frontend assets:**
   ```sh
   npm run dev
   ```
2. **Start the Laravel server:**
   ```sh
   php artisan serve
   ```
3. **Visit:** [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Screenshots

### Tweet Form and Timeline
![Tweet Form and Timeline](screenshots/timeline.png)

### Tweet Actions
![Tweet Actions](screenshots/tweet-actions.png)

## Credits
- **AI Tools Used:** GitHub Copilot (GPT-4.1)
  - Assisted with code generation, UI layout, and documentation.
- **Technologies:**
  - Laravel (PHP 8.2+)
  - Tailwind CSS
  - Blade Templates
  - FontAwesome

---
For any questions or contributions, feel free to open an issue or pull request!
