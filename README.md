
Laravel Expertise Showcase

This repository showcases my expertise in Laravel, covering key aspects such as Blade templating, API development, and code testing.

Features

✅ Laravel from Scratch – All projects are built entirely with Laravel.
✅ Blade Templating – Efficient frontend collaboration using Blade.
✅ RESTful API Development – Structured and optimized API endpoints.
✅ Code Testing – Ensuring stability and reliability with PHPUnit.


---

1. Blade Templating Example

Blade provides an elegant templating system in Laravel. Below is an example of a Blade component to display user profiles dynamically:

<!-- resources/views/components/user-profile.blade.php -->
<div class="profile-card">
    <h3>{{ $user->name }}</h3>
    <p>Email: {{ $user->email }}</p>
    <p>Joined: {{ $user->created_at->format('d M Y') }}</p>
</div>

Usage in a view:

<x-user-profile :user="$user" />


---

2. RESTful API Development

Example of a simple API controller for managing users:

// app/Http/Controllers/Api/UserController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $user = User::create($request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]));

        return response()->json($user, 201);
    }
}

API Routes:

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);


---

3. Writing Code Tests (PHPUnit)

Ensuring Laravel applications are stable by writing tests:

// tests/Feature/UserTest.php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }
}


---

Installation & Usage

To run this project, clone the repository and set up the Laravel environment:

git clone https://github.com/shadighorbani7171/laravel-expertise-showcase.git
cd laravel-expertise-showcase
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

Run tests:

php artisan test


---

Contact

If you have any questions or suggestions, feel free to reach out!

🔗 LinkedIn
📧 Email: shadighorbani7171@gmail.com








