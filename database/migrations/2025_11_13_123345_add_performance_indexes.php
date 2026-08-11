<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Add index on is_published (column exists based on migration)
            $table->index('is_published');
            
            // Composite index for common query: published articles ordered by date
            $table->index(['is_published', 'published_at'], 'articles_published_date_idx');
            
            // Composite index for featured published articles
            $table->index(['is_published', 'featured', 'published_at'], 'articles_featured_published_idx');
            
            // Index on author_id for dashboard queries
            $table->index('author_id');
            
            // Composite index for category and published status
            $table->index(['category_id', 'is_published'], 'articles_category_published_idx');
        });

        Schema::table('products', function (Blueprint $table) {
            // Composite index for active featured products
            $table->index(['is_active', 'is_featured'], 'products_active_featured_idx');
            
            // Composite index for category and active status
            $table->index(['product_category_id', 'is_active'], 'products_category_active_idx');
        });

        Schema::table('chatbot_rules', function (Blueprint $table) {
            // Index on status for filtering active rules
            $table->index('status');
            
            // Index on priority for ordering
            $table->index('priority');
            
            // Index on keyword for matching (full-text search would be better but this helps)
            $table->index('keyword');
            
            // Composite index for active rules ordered by priority
            $table->index(['status', 'priority'], 'chatbot_rules_status_priority_idx');
        });

        Schema::table('chat_histories', function (Blueprint $table) {
            // Index on rule_id for analytics
            $table->index('rule_id');
            
            // Composite index for session queries
            $table->index(['session_id', 'created_at'], 'chat_histories_session_date_idx');
            
            // Composite index for analytics queries
            $table->index(['created_at', 'rule_id'], 'chat_histories_date_rule_idx');
        });

        Schema::table('contacts', function (Blueprint $table) {
            // Composite index for status and date queries
            $table->index(['status', 'created_at'], 'contacts_status_date_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex(['is_published']);
            $table->dropIndex('articles_published_date_idx');
            $table->dropIndex('articles_featured_published_idx');
            $table->dropIndex(['author_id']);
            $table->dropIndex('articles_category_published_idx');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_active_featured_idx');
            $table->dropIndex('products_category_active_idx');
        });

        Schema::table('chatbot_rules', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['keyword']);
            $table->dropIndex('chatbot_rules_status_priority_idx');
        });

        Schema::table('chat_histories', function (Blueprint $table) {
            $table->dropIndex(['rule_id']);
            $table->dropIndex('chat_histories_session_date_idx');
            $table->dropIndex('chat_histories_date_rule_idx');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('contacts_status_date_idx');
        });
    }
};

