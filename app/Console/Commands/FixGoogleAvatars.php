<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FixGoogleAvatars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avatars:fix-google';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix broken Google avatar URLs by clearing them so fallback will be used';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing broken Google avatars...');

        $users = User::whereNotNull('google_id')
            ->whereNotNull('avatar')
            ->where('avatar', 'LIKE', '%googleusercontent.com%')
            ->get();

        $fixed = 0;
        foreach ($users as $user) {
            // If avatar URL is too short (likely truncated), clear it
            if (strlen($user->avatar) < 120) {
                $this->info("Fixing avatar for: {$user->name} (was: " . substr($user->avatar, 0, 50) . "...)");
                $user->update(['avatar' => null]);
                $fixed++;
            }
        }

        $this->info("Fixed {$fixed} broken Google avatars.");
        $this->info('Users will now see UI Avatar fallbacks until they re-login with Google.');

        return Command::SUCCESS;
    }
}
