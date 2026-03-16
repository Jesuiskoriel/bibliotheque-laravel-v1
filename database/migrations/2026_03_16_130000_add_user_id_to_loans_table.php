<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('book_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
        });

        $members = DB::table('members')->get();

        foreach ($members as $member) {
            $userId = $member->user_id;

            if (!$userId) {
                $existingUser = DB::table('users')->where('email', $member->email)->first();

                if ($existingUser) {
                    $userId = $existingUser->id;
                } else {
                    $userId = DB::table('users')->insertGetId([
                        'name' => trim($member->first_name.' '.$member->last_name),
                        'email' => $member->email,
                        'password' => Hash::make('password'),
                        'role' => 'user',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('members')->where('id', $member->id)->update(['user_id' => $userId]);
            }

            DB::table('loans')
                ->where('member_id', $member->id)
                ->whereNull('user_id')
                ->update(['user_id' => $userId]);
        }
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
