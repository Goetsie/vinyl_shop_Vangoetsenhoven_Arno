<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('active')->default(true);
            $table->boolean('admin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Insert some users
        DB::table('users')->insert(
            [
                [
                    'name' => 'Arno Vangoetsenhoven',
                    'email' => 'r0741327@student.thomasmore.be',
                    'admin' => true,
                    'password' => \Illuminate\Support\Facades\Hash::make('admin1234'),
                    'created_at' => now(),
                    'email_verified_at' => now()
                ], [
                'name' => 'Jane Doe',
                'email' => 'jane.doe@example.com',
                'admin' => false,
                'password' => \Illuminate\Support\Facades\Hash::make('user1234'),
                'created_at' => now(),
                'email_verified_at' => now()
            ], [
                'name' => 'Jill van Rethij',
                'email' => 'jillekevanrethij@gmail.com',
                'admin' => true,
                'password' => \Illuminate\Support\Facades\Hash::make('admin1234'),
                'created_at' => now(),
                'email_verified_at' => now()
            ],[
                'name' => 'Anna Smith',
                'email' => 'anna.smith@example.com',
                'admin' => false,
                'password' => \Illuminate\Support\Facades\Hash::make('user1234'),
                'created_at' => now(),
                'email_verified_at' => now()
            ]
            ]
        );

        // Add 41 dummy users inside a loop
        for ($i = 0; $i <= 40; $i++) {
            DB::table('users')->insert(
                [
                    'name' => "ITF User $i",
                    'email' => "itf_user_$i@mailinator.com",
                    'password' => \Illuminate\Support\Facades\Hash::make("itfuser$i"),
                    'created_at' => now(),
                    'email_verified_at' => now()
                ]
            );
        }

        // Add 11 test users inside a loop
        for ($i = 0; $i <= 10; $i++) {
            DB::table('users')->insert(
                [
                    'name' => "TEST User $i",
                    'email' => "test_user_$i@mailinator.com",
                    'password' => \Illuminate\Support\Facades\Hash::make("testuser$i"),
                    'created_at' => now(),
                    'email_verified_at' => now()
                ]
            );
        }

        // Add 4 admin users inside a loop
        for ($i = 0; $i <= 3; $i++) {
            DB::table('users')->insert(
                [
                    'name' => "TEST Admin $i",
                    'email' => "test_admin$i@mailinator.com",
                    'admin' => true,
                    'password' => \Illuminate\Support\Facades\Hash::make("admin1234"),
                    'created_at' => now(),
                    'email_verified_at' => now()
                ]
            );
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
