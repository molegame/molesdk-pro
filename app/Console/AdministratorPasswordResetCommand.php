<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AdministratorPasswordResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for a specific administrator user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $administrators = \App\Administrator::all();

        askForUserName:
        $email = $this->askWithCompletion('Please enter a email who needs to reset his password', $administrators->pluck('email')->toArray());

        $administrator = $administrators->first(function ($administrator) use ($email) {
            return $administrator->email == $email;
        });

        if (is_null($administrator)) {
            $this->error('The administrator you entered is not exists');
            goto askForUserName;
        }

        enterPassword:
        $password = $this->secret('Please enter a password');

        if ($password !== $this->secret('Please confirm the password')) {
            $this->error('The passwords entered twice do not match, please re-enter');
            goto enterPassword;
        }

        $administrator->password = bcrypt($password);
        $administrator->save();

        $this->info("Administrator [$administrator->name] password reset successfully.");
    }
}
