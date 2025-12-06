<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Perbaiki data tags yang tidak valid
        $posts = DB::table('posts')->get();
        
        foreach ($posts as $post) {
            $updates = [];
            
            // Perbaiki tags - harus JSON array atau null
            if (!empty($post->tags)) {
                // Jika tags adalah integer atau bukan JSON yang valid, set ke null
                if (is_numeric($post->tags) || !$this->isValidJson($post->tags)) {
                    $updates['tags'] = null;
                }
            } else {
                $updates['tags'] = null;
            }
            
            // Perbaiki images - harus JSON array atau null
            if (!empty($post->images)) {
                // Jika images bukan JSON yang valid, set ke null
                if (!$this->isValidJson($post->images)) {
                    $updates['images'] = null;
                }
            } else {
                $updates['images'] = null;
            }
            
            // Perbaiki view_count - harus integer
            if (!is_numeric($post->view_count)) {
                $updates['view_count'] = 0;
            }
            
            // Perbaiki author_name - harus string biasa, bukan JSON
            if (!empty($post->author_name) && $this->isValidJson($post->author_name)) {
                // Jika author_name adalah JSON, set ke default
                $updates['author_name'] = 'Admin';
            }
            
            if (!empty($updates)) {
                DB::table('posts')->where('id', $post->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak ada rollback yang diperlukan
    }
    
    /**
     * Check if string is valid JSON
     */
    private function isValidJson($string): bool
    {
        if (!is_string($string)) {
            return false;
        }
        
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
};
