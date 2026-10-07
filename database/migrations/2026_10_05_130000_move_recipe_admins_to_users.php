<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->boolean('is_admin')->default(false);
            });
        }

        if (Schema::hasTable('customer') && Schema::hasColumn('customer', 'is_admin')) {
            DB::table('customer')->where('is_admin', true)->orderBy('customer_id')->cursor()->each(function (object $admin): void {
                $existingUser = DB::table('users')->where('email', $admin->email)->first();

                if ($existingUser) {
                    DB::table('users')->where('id', $existingUser->id)->update(['is_admin' => true]);

                    return;
                }

                DB::table('users')->insert([
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'password' => $admin->pasword,
                    'is_admin' => true,
                    'created_at' => $admin->created_at,
                    'updated_at' => $admin->updated_at,
                ]);
            });
        }

        Schema::dropIfExists('customer');
        Schema::dropIfExists('customers');
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('is_admin');
            });
        }
    }
};
