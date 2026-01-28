<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Clean old data (optional but cleaner for this task)
        // We use DB::statement to disable foreign key checks for a clean truncate if needed,
        // but here we'll just delete to keep it simple and safe.
        // Article::query()->delete();
        // Comment::query()->delete();
        // Tag::query()->delete();
        // User::where('email', '!=', 'test@example.com')->delete();

        // 1. Create some tags
        $tags = Tag::factory(20)->create();

        // 2. Get existing categories
        $categories = Category::all();

        // 3. Create 10 users
        $users = User::factory(10)->create();

        // Ensure we have at least one test user if it doesn't exist
        if (!User::where('email', 'sasha@example.com')->exists()) {
             User::factory()->create([
                'name' => 'Sasha',
                'email' => 'sasha@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        foreach ($users as $user) {
            // 4. Create 3 to 8 articles per user
            $articleCount = rand(3, 8);
            $userArticles = Article::factory($articleCount)->create([
                'user_id' => $user->id,
            ]);

            foreach ($userArticles as $article) {
                // 5. Assign random tags (1 to 4)
                $article->tags()->attach(
                    $tags->random(rand(1, 4))->pluck('id')->toArray()
                );

                // 6. Assign random categories (1 to 2)
                if ($categories->isNotEmpty()) {
                    $article->categories()->attach(
                        $categories->random(rand(1, min(2, $categories->count())))->pluck('id')->toArray()
                    );
                }
            }

            // 7. Each user must have commented at least 2 times
            // We'll pick random articles from other users (or including themselves) to comment on
            $allArticles = Article::all();
            if ($allArticles->isNotEmpty()) {
                Comment::factory(rand(2, 5))->create([
                    'user_id' => $user->id,
                    'article_id' => $allArticles->random()->id,
                ]);
            }
        }
    }
}
