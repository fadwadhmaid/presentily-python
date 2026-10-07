#  Presentily Python

> **A new way to learn Python.**

Presentily Python is an educational web platform designed to help students learn Python through a **visual, interactive, and progressive learning experience**.

The project focuses on an important difficulty faced by beginners: understanding not only **what the code says**, but also **what happens when the code is executed**.

The first learning path is designed around the **Tunisian Informatique curriculum**, with a focus on Python fundamentals and programming concepts.

---

##  The Idea

Learning programming is not only about memorizing syntax.

For example:

```python
x = 10
x = x + 1
```

A beginner should be able to understand:

* What is stored in `x`?
* What happens when `x = x + 1` is executed?
* How does the value change in memory?
* What type of value is stored?
* What does Python actually do step by step?

Presentily Python aims to make these concepts easier to understand through **visual explanations, examples, memory-focused learning, quizzes, and progressive lessons**.

---

##  Current Features

###  Structured lessons

Learning content is organized into progressive lessons rather than presenting Python as a collection of isolated syntax rules.

###  Memory-oriented explanations

The platform emphasizes understanding how variables and values change during program execution.

###  Interactive code learning

Python concepts are introduced through concrete code examples and step-by-step explanations.

###  Quizzes

Lessons can include questions and quizzes to help students check their understanding.

### 🇹🇳 Tunisian educational context

The first learning path is designed with the Tunisian secondary-school Informatique context in mind.

###  Common mistakes

The lessons address typical beginner mistakes and misconceptions encountered when learning Python.

---

##  Current Learning Content

The current repository includes an **Informatique** learning path.

### 01 — Algorithmique

**Apprendre à penser comme un ordinateur**

Introduction to algorithmic thinking and the logic behind program execution.

### 02 — Variables et types en Python

This lesson introduces:

* Variables
* Memory
* `int`
* `float`
* `str`
* `bool`
* `input()`
* Type conversion
* Python syntax and common mistakes
* Step-by-step variable changes

More lessons are planned as the platform evolves.

---

##  Educational Content Architecture

Educational content is stored as structured JavaScript modules inside the frontend.

Example:

```text
resources/
└── js/
    └── data/
        └── lessons/
            └── sections/
                └── informatique/
                    ├── 01-algorithmique.js
                    └── 02-variables-types.js
```

A lesson can contain structured elements such as:

```text
Lesson
├── Objectives
├── Explanations
├── Teacher / Student dialogue
├── Code examples
├── Memory concepts
├── Key points
├── Common mistakes
├── Quizzes
└── Exercises
```

This approach keeps the educational content separated from the application logic and makes it easier to add new lessons and learning paths.

---

##  Tech Stack

### Backend

* **Laravel 13**
* **PHP 8.3+**
* Laravel Sanctum

### Frontend

* **Vue 3**
* Vue Router
* **Vite 8**
* **Tailwind CSS 4**
* Axios
* GSAP
* Lucide Vue

### Database

* **PostgreSQL**

### Development

* Git
* GitHub
* PHPUnit

---

##  Project Structure

```text
presentily-python/
│
├── app/                    # Laravel application logic
├── bootstrap/              # Laravel bootstrap
├── config/                 # Application configuration
├── database/               # Migrations, factories and seeders
├── public/                 # Public assets
├── resources/              # Frontend and educational content
│   └── js/
│       └── data/
│           └── lessons/
├── routes/                 # Application routes
├── storage/                # Application storage
├── tests/                  # Automated tests
│
├── artisan
├── composer.json
├── package.json
├── vite.config.js
├── tailwind.config.js
└── README.md
```

---

##  Getting Started

### Requirements

Before installing the project, make sure you have:

* PHP 8.3 or higher
* Composer
* Node.js 20 or higher
* npm
* PostgreSQL

### 1. Clone the repository

```bash
git clone https://github.com/fadwadhmaid/presentily-python.git

cd presentily-python
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Create the environment file

```bash
cp .env.example .env
```

### 5. Generate the application key

```bash
php artisan key:generate
```

### 6. Configure the database

Update your `.env` file with your PostgreSQL configuration.

Example:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 7. Run migrations

```bash
php artisan migrate
```

### 8. Start the frontend

```bash
npm run dev
```

In another terminal, start Laravel:

```bash
php artisan serve
```

The application will then be available locally.

---

##  Testing

Run the Laravel test suite with:

```bash
php artisan test
```

---

##  Roadmap

### Learning experience

* [x] Learning platform foundation
* [x] Informatique learning path
* [x] Algorithmique lesson
* [x] Variables and Python types lesson
* [x] Interactive educational content
* [x] Quizzes
* [ ] Additional Python lessons
* [ ] More exercises
* [ ] More interactive learning activities
* [ ] Advanced memory visualization

### Student experience

* [ ] Student progress tracking
* [ ] Learning dashboard
* [ ] XP and achievements
* [ ] Personalized learning path

### Educational expansion

* [ ] More Tunisian secondary-school levels
* [ ] Additional learning tracks
* [ ] More Bac-oriented content

---

##  Learning Philosophy

Presentily Python is built around a simple idea:

> **Don't just learn the code. Understand what happens when it runs.**

The learning approach follows:

```text
Concept
   ↓
Example
   ↓
Execution
   ↓
Memory
   ↓
Practice
   ↓
Feedback
```

The goal is to help beginners build a real mental model of programming instead of relying only on memorization.

---

##  Project Status

**Active development**

Presentily Python is currently being developed and tested as a new approach to learning Python.

The initial version focuses on the Tunisian Informatique learning context, with additional content and features planned for future releases.

---

##  About

Presentily Python is an independent educational project combining:

**Software Engineering + Education + Interactive Learning**

The project is developed with the goal of making programming education more understandable, visual, and engaging for students.

---

##  Project

**GitHub:**
https://github.com/fadwadhmaid/presentily-python

**Presentily:**
https://presentily.com
