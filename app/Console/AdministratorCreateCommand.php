<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AdministratorCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an administrator user';

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
        $email = $this->ask('Please enter a email to login');
        $password = bcrypt($this->secret('Please enter a password to login'));
        $name = $this->ask('Please enter a name to display');

        $administrator = new \App\Administrator(compact('email', 'password', 'name'));
        $administrator->save();

        $this->info("Administrator user [$name] created successfully.");
    }
}
