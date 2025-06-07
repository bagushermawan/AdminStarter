<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;

class addAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for adding user (superadmin)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $input['name'] = $this->ask('Input Name');
        $input['username'] = $this->ask('Input Username');
        $input['email'] = $this->ask('Input Email');
        $input['password'] = $this->secret('Input Password');
        $input['password'] = Hash::make($input['password']);
        $input['email_verified_at'] = Carbon::now();
        $user = User::create($input);
        $user->assignRole('superadmin');
        $this->info('Superadmin created');
    }
}
