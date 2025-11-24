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

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/59c4ed59-2c5e-438a-8dd9-448f94bee468" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/dcc2c4f8-4ee0-437f-b065-6920902329bc" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/1160addc-d76a-4d65-bbf1-4eb77010821a" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/66b5b019-e046-4d41-b462-3a9e3e6ea6b1" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/0bf6cb51-47b6-4248-93e3-a2a51678867b" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/87daf108-b66e-47c8-8e53-3b2a52a2426d" />
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/f8acee3f-6ef9-4ee6-933d-213e31c47c13" />





## Credits
- **AI Tools Used:** GitHub Copilot (GPT-4.1)
  - Assisted with code generation, UI layout, and documentation.
- **Technologies:**
  - Laravel (PHP 8.2+)
  - Tailwind CSS
  - Blade Templates
  - FontAwesome


