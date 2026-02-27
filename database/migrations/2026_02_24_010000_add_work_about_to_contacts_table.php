<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Work fields
            $table->string('job_title', 100)->nullable()->after('postal_code');
            $table->string('company', 150)->nullable()->after('job_title');
            $table->string('department', 100)->nullable()->after('company');
            $table->string('work_email', 255)->nullable()->after('department');
            $table->string('work_phone', 30)->nullable()->after('work_email');
            $table->string('website', 255)->nullable()->after('work_phone');

            // About fields
            $table->date('birthday')->nullable()->after('website');
            $table->text('notes')->nullable()->after('birthday');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'job_title', 'company', 'department', 'work_email', 'work_phone', 'website', 'birthday', 'notes'
            ]);
        });
    }
};
