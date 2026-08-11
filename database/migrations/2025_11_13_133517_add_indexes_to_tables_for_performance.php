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
        Schema::table('products', function (Blueprint $table) {
            // Add indexes for better query performance (if not exist)
            if (!Schema::hasIndex('products', 'products_status_created_index')) {
                $table->index(['is_active', 'created_at'], 'products_status_created_index');
            }
            if (!Schema::hasIndex('products', 'products_category_index')) {
                $table->index(['product_category_id'], 'products_category_index');
            }
            if (!Schema::hasIndex('products', 'products_featured_index')) {
                $table->index(['is_featured'], 'products_featured_index');
            }
            if (!Schema::hasIndex('products', 'products_price_index')) {
                $table->index(['price'], 'products_price_index');
            }
            if (!Schema::hasIndex('products', 'products_name_index')) {
                $table->index(['name'], 'products_name_index');
            }
            if (!Schema::hasIndex('products', 'products_slug_index')) {
                $table->index(['slug'], 'products_slug_index');
            }
        });

        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasIndex('articles', 'articles_status_created_index')) {
                $table->index(['is_published', 'created_at'], 'articles_status_created_index');
            }
            if (!Schema::hasIndex('articles', 'articles_author_index')) {
                $table->index(['author_id'], 'articles_author_index');
            }
            if (!Schema::hasIndex('articles', 'articles_title_index')) {
                $table->index(['title'], 'articles_title_index');
            }
            if (!Schema::hasIndex('articles', 'articles_slug_index')) {
                $table->index(['slug'], 'articles_slug_index');
            }
            if (!Schema::hasIndex('articles', 'articles_category_index')) {
                $table->index(['category_id'], 'articles_category_index');
            }
        });

        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasIndex('contacts', 'contacts_status_created_index')) {
                $table->index(['status', 'created_at'], 'contacts_status_created_index');
            }
            if (!Schema::hasIndex('contacts', 'contacts_name_index')) {
                $table->index(['name'], 'contacts_name_index');
            }
            if (!Schema::hasIndex('contacts', 'contacts_email_index')) {
                $table->index(['email'], 'contacts_email_index');
            }
        });

        Schema::table('chatbot_rules', function (Blueprint $table) {
            if (!Schema::hasIndex('chatbot_rules', 'chatbot_rules_status_priority_index')) {
                $table->index(['status', 'priority'], 'chatbot_rules_status_priority_index');
            }
            if (!Schema::hasIndex('chatbot_rules', 'chatbot_rules_keyword_index')) {
                $table->index(['keyword'], 'chatbot_rules_keyword_index');
            }
        });

        Schema::table('chat_histories', function (Blueprint $table) {
            if (!Schema::hasIndex('chat_histories', 'chat_histories_session_index')) {
                $table->index(['session_id'], 'chat_histories_session_index');
            }
            if (!Schema::hasIndex('chat_histories', 'chat_histories_created_index')) {
                $table->index(['created_at'], 'chat_histories_created_index');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasIndex('users', 'users_email_index')) {
                $table->index(['email'], 'users_email_index');
            }
            if (!Schema::hasIndex('users', 'users_name_index')) {
                $table->index(['name'], 'users_name_index');
            }
            if (!Schema::hasIndex('users', 'users_created_index')) {
                $table->index(['created_at'], 'users_created_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $indexes = ['products_status_created_index', 'products_category_index', 'products_featured_index', 'products_price_index', 'products_name_index', 'products_slug_index'];
            foreach ($indexes as $index) {
                if (Schema::hasIndex('products', $index)) {
                    $table->dropIndex($index);
                }
            }
        });

        Schema::table('articles', function (Blueprint $table) {
            $indexes = ['articles_status_created_index', 'articles_author_index', 'articles_title_index', 'articles_slug_index', 'articles_category_index'];
            foreach ($indexes as $index) {
                if (Schema::hasIndex('articles', $index)) {
                    $table->dropIndex($index);
                }
            }
        });

        Schema::table('contacts', function (Blueprint $table) {
            $indexes = ['contacts_status_created_index', 'contacts_name_index', 'contacts_email_index'];
            foreach ($indexes as $index) {
                if (Schema::hasIndex('contacts', $index)) {
                    $table->dropIndex($index);
                }
            }
        });

        Schema::table('chatbot_rules', function (Blueprint $table) {
            $indexes = ['chatbot_rules_status_priority_index', 'chatbot_rules_keyword_index'];
            foreach ($indexes as $index) {
                if (Schema::hasIndex('chatbot_rules', $index)) {
                    $table->dropIndex($index);
                }
            }
        });

        Schema::table('chat_histories', function (Blueprint $table) {
            $indexes = ['chat_histories_session_index', 'chat_histories_created_index'];
            foreach ($indexes as $index) {
                if (Schema::hasIndex('chat_histories', $index)) {
                    $table->dropIndex($index);
                }
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $indexes = ['users_email_index', 'users_name_index', 'users_created_index'];
            foreach ($indexes as $index) {
                if (Schema::hasIndex('users', $index)) {
                    $table->dropIndex($index);
                }
            }
        });
    }
};
