<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create
                            {--email=admin@charliedevlab.com : Email de l\'admin}
                            {--password=Admin@2025 : Mot de passe de l\'admin}
                            {--name=Admin : Nom de l\'admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un compte administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');

        // Vérifier si l'admin existe déjà
        $existingAdmin = User::where('email', $email)->first();

        if ($existingAdmin) {
            if ($this->confirm("Un utilisateur avec l'email {$email} existe déjà. Voulez-vous le remplacer ?")) {
                $existingAdmin->delete();
                $this->info("✅ Ancien utilisateur supprimé.");
            } else {
                $this->error("❌ Opération annulée.");
                return 1;
            }
        }

        // Créer le compte admin
        $admin = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->newLine();
        $this->info('✅ Compte administrateur créé avec succès !');
        $this->newLine();

        $this->table(
            ['Champ', 'Valeur'],
            [
                ['ID', $admin->id],
                ['Nom', $admin->name],
                ['Email', $admin->email],
                ['Mot de passe', $password],
                ['Rôle', $admin->role],
            ]
        );

        $this->newLine();
        $this->warn('⚠️  Conservez ces identifiants en sécurité !');

        return 0;
    }
}
