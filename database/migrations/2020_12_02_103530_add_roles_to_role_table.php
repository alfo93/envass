<?php

use App\User;

use Illuminate\Database\Migrations\Migration;

class AddRolesToRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rolesNames = [
            'admin', //Coccagna, Mazzacane, Elisabetta, Colui che cura la parte informatica (POSSONO FARE TUTTO)
            'gestore', //Luca Lanzoni, Matteo Bisi, Antonella Volta, Maria D'Accolti, Irene Soffritti (Editano le schede ed inseriscono campionamenti)
            'rilevatori', //Tutti i rilevatori (interni) (SEMBRANO NON FARE NULLA NEL SISTEMA, SONO SEMPLICEMENTE COLORO CHE FANNO I RILEVAMENTI SUL CAMPO)
            'committente', //ETABETA; CopMA; ecc.. (I CLIENTI CHE VEDONO SOLO LE SCHEDE RELATIVE ALLA LORO COMMESSA E NON POSSO EFFETTUARE MODIFICHE O AZIONI PARTICOLARI, SOLO VEDERE)
            'utente', //gestori degli ospedali (VEDONO SOLO LE SCHEDE RELATIVE ALLA PROPRIA STRUTTURA)
        ];

        foreach ($rolesNames as $roleName) {
            Defender::createRole($roleName);
        }

        /** @var Defender $defender */
        $defender = app('defender');
        $user_role = $defender->findRole('utente');
        $admin_role = $defender->findRole('admin');
        $committente_role = $defender->findRole('committente');
        $gestore_role = $defender->findRole('gestore');
        $rilevatore_role = $defender->findRole('rilevatore');

        $admins = ['admin','santemazzacane','elisabettacaselli','maddalenacoccagna','Alfonso Esposito','pvigcm','scvgdu']; //AUTHCODE 65535
        $gestori = ['lucalanzoni','mariadaccolti','matteobisi','antonellavolta','irenesoffritti']; 
        $committenti = ['copma','etabeta','nola','laboratoriopma'];
        $utenti = ['mariateresacamerada','messina','ciassm','ciasmed','ciasbio','aaaa','chiello','lisavolpe','demo','menichini','albertobenati'];

        foreach ($admins as $admin) {
            $a = User::where('uid', $admin)->where('versione',2)->first();
            if($a != null)
            {
                $a->attachRole($admin_role);
            }
        }

        foreach ($gestori as $gestore) {
            $g = User::where('uid', $gestore)->where('versione',2)->first();
            if($g != null)
            {
                $g->attachRole($gestore_role);
            }
        }

        foreach ($committenti as $committente) {
            $c = User::where('uid', $committente)->where('versione',2)->first();
            if($c != null)
            {
                $c->attachRole($committente_role);
            }
        }

        foreach ($utenti as $utente) {
            $u = User::where('uid', $utente)->where('versione',2)->first();
            if($u != null)
            {
                $u->attachRole($user_role);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        echo "I ruoli devono essere cancellati manualmente" . PHP_EOL;
    }
}
