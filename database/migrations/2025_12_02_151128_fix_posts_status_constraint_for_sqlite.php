<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite menggunakan CHECK constraint untuk enum
            // Kita perlu membuat ulang tabel dengan constraint yang benar
            
            // 1. Buat tabel baru dengan constraint yang benar
            DB::statement("
                CREATE TABLE posts_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title VARCHAR(255) NOT NULL,
                    slug VARCHAR(255) NOT NULL UNIQUE,
                    type VARCHAR(255) NOT NULL DEFAULT 'berita' CHECK(type IN ('berita', 'artikel')),
                    excerpt VARCHAR(500),
                    body TEXT NOT NULL,
                    thumbnail_path VARCHAR(255),
                    status VARCHAR(255) NOT NULL DEFAULT 'draft' CHECK(status IN ('draft', 'published', 'unpublished')),
                    published_at TIMESTAMP NULL,
                    is_featured BOOLEAN NOT NULL DEFAULT 0,
                    author_id INTEGER,
                    meta_description VARCHAR(255),
                    created_at TIMESTAMP NULL,
                    updated_at TIMESTAMP NULL,
                    view_count INTEGER DEFAULT 0,
                    author_name VARCHAR(255),
                    tags TEXT,
                    images TEXT,
                    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
                )
            ");
            
            // 2. Copy data dari tabel lama
            DB::statement("
                INSERT INTO posts_new 
                SELECT * FROM posts
            ");
            
            // 3. Drop tabel lama
            DB::statement("DROP TABLE posts");
            
            // 4. Rename tabel baru
            DB::statement("ALTER TABLE posts_new RENAME TO posts");
            
            // 5. Recreate indexes
            DB::statement("CREATE INDEX posts_type_index ON posts(type)");
            DB::statement("CREATE INDEX posts_status_index ON posts(status)");
            DB::statement("CREATE INDEX posts_published_at_index ON posts(published_at)");
            DB::statement("CREATE INDEX posts_is_featured_index ON posts(is_featured)");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // Kembalikan ke constraint lama (tanpa unpublished)
            
            // Update data yang unpublished menjadi draft
            DB::table('posts')->where('status', 'unpublished')->update(['status' => 'draft']);
            
            // Buat tabel baru dengan constraint lama
            DB::statement("
                CREATE TABLE posts_old (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title VARCHAR(255) NOT NULL,
                    slug VARCHAR(255) NOT NULL UNIQUE,
                    type VARCHAR(255) NOT NULL DEFAULT 'berita' CHECK(type IN ('berita', 'artikel')),
                    excerpt VARCHAR(500),
                    body TEXT NOT NULL,
                    thumbnail_path VARCHAR(255),
                    status VARCHAR(255) NOT NULL DEFAULT 'draft' CHECK(status IN ('draft', 'published')),
                    published_at TIMESTAMP NULL,
                    is_featured BOOLEAN NOT NULL DEFAULT 0,
                    author_id INTEGER,
                    meta_description VARCHAR(255),
                    created_at TIMESTAMP NULL,
                    updated_at TIMESTAMP NULL,
                    view_count INTEGER DEFAULT 0,
                    author_name VARCHAR(255),
                    tags TEXT,
                    images TEXT,
                    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
                )
            ");
            
            DB::statement("
                INSERT INTO posts_old 
                SELECT * FROM posts
            ");
            
            DB::statement("DROP TABLE posts");
            DB::statement("ALTER TABLE posts_old RENAME TO posts");
            
            DB::statement("CREATE INDEX posts_type_index ON posts(type)");
            DB::statement("CREATE INDEX posts_status_index ON posts(status)");
            DB::statement("CREATE INDEX posts_published_at_index ON posts(published_at)");
            DB::statement("CREATE INDEX posts_is_featured_index ON posts(is_featured)");
        }
    }
};
