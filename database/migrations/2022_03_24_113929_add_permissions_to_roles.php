<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;

class AddPermissionsToRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Matrice dei permessi
         */

                                    //1 admin  //2 gestore //3 committente //4 utente
        
        //Creare Scheda                 X           X                                                 

        //Crea Scheda Molecolari        X           X                         

        //Crea Scheda Bianco            X           X

        //Crea Scheda Qualita           X           X                       

        //Eliminare scheda              X                                    

        //Modificare scheda             X           X                                      

        //Creare Campagna               X           X

        //Creare Cliente                X           

        //Modificare Cliente            X

        //Eliminare Cliente             X

        //Creare Progetto               X

        //Modificare Progetto           X

        //Eliminare Progetto            X

        //Inserire nuova Procedura      X

        //Modificare procedura          X

        //Elimianre procedura           X

        //Inserire Rapporto-relazione   X

        //Spedire mail                  X

        //Eliminare Rapporto-relazione  X

        //Gestione Utenti               X   

        //Gestione Interna              X           X          
        
        //visualizzare Clienti          X                                     
        
        //visualizzare progetti         X                                     

        //visualizzare campagne         X           X               X           X

        //visualizzare campionamenti    X           X               X           X

        //visualizzare schede           X           X               X           X

        //visualizzare procedure        X           X               X           X

        //visualizzare relazioni        X           X               X           X

        //visualizzare eventi           X                                     

        //visualizzare utenti           X
        
        $ruoli = [
            1 => 'admin',
            2 => 'gestore', 
            3 => 'committente',
            4 => 'utente',
        ];

        $creaScheda = Defender::createPermission('campioni.store', 'crea scheda'); //crea nuova scheda (Molecolari, Bianco, Qualità, (Piastra-Tamponi))
        $eliminaScheda = Defender::createPermission('campioni.destroy', 'elimina scheda');
        $modificaScheda = Defender::createPermission('campioni.update','modifica scheda');
        $creaSchedaM = Defender::createPermission('campioni_analisi_molecolari.store', 'crea scheda molecolare'); //crea nuova scheda (Molecolari, Bianco, Qualità, (Piastra-Tamponi))
        $eliminaSchedaM = Defender::createPermission('campioni_analisi_molecolari.destroy', 'elimina scheda molecolare');
        $modificaSchedaM = Defender::createPermission('campioni_analisi_molecolari.update','modifica scheda molecolare');
        $creaCampagna = Defender::createPermission('campagna.store','crea campagna');
        $creaCliente = Defender::createPermission('societa.store','crea societa');
        $modificaCliente = Defender::createPermission('societa.update','modifica societa');
        $eliminaCliente = Defender::createPermission('societa.destroy','elimina societa');
        $creaProgetto = Defender::createPermission('progetti.store','crea progetti');
        $modificaProgetto = Defender::createPermission('progetti.update','modifica progetti');
        $eliminaProgetto = Defender::createPermission('progetti.destroy','elimina progetti');
        $creaProcedura = Defender::createPermission('eprocedure.store','crea procedura');
        $modificaProcedura = Defender::createPermission('eprocedure.update','modifica procedura');
        $eliminaProcedura = Defender::createPermission('eprocedure.destroy','elimina procedura');
        $creaRappRel = Defender::createPermission('rapp_rel.store','crea rapporti-relazioni');
        //$modificaRappRel = Defender::createPermission('rapp_rel.update','modifica rapporti-relazioni');
        $eliminaRappRel = Defender::createPermission('rapp_rel.destroy','elimina rapporti-relazioni');
        $inviaMail = Defender::createPermission('rapp_rel.sendEmail','invia mail');
        $gestisciUtenti = Defender::createPermission('users.create', 'gestisci utenti');//Gestire utenti
        $gestioneInterna = Defender::createPermission('antibiotici.store', 'gestione interna'); //Possibilità di accedere alla gestione interna.
        $sezClienti = Defender::createPermission('societa.index','visualizza sezione clienti');
        $sezProgetti = Defender::createPermission('progetti.index','visualizza sezione progetti');
        $sezCampagneCampionamenti = Defender::createPermission('campagna.index','visualizza campagne');
        $sezCampioni = Defender::createPermission('campioni.index','visualizza campioni');
        $sezScheda = Defender::createPermission('campioni.edit','visualizza scheda');
        $sezProcedure = Defender::createPermission('eprocedure.index','visualizza sezione procedure');
        $sezRelazioni = Defender::createPermission('rapp_rel.index','visualizza sezione rapporti-relazioni');
        $sezEventi = Defender::createPermission('log_envass.index','visualizza log eventi');
        $sezUtenti = Defender::createPermission('users.index','visualizza sezione utenti');



        $permessi = [
            1 => $creaScheda,
            2 => $eliminaScheda,
            3 => $modificaScheda,
            4 => $creaCampagna,
            5 => $creaCliente,
            6 => $modificaCliente,
            7 => $eliminaCliente,
            8 => $creaProgetto,
            9 => $modificaProgetto,
            10 => $eliminaProgetto,
            11 => $creaProcedura,
            12 => $modificaProcedura,
            13 => $eliminaProcedura,
            14 => $creaRappRel,
            15 => $eliminaRappRel,
            16 => $inviaMail,
            17 => $gestisciUtenti,
            18 => $gestioneInterna,
            19 => $sezClienti,
            20 => $sezProgetti,
            21 => $sezCampagneCampionamenti,
            22 => $sezCampioni,
            23 => $sezScheda,
            24 => $sezProcedure,
            25 => $sezRelazioni,
            26 => $sezEventi,
            27 => $sezUtenti,
            28 => $creaSchedaM,
            29 => $eliminaSchedaM,
            30 => $modificaSchedaM,
        ];

        //1 -> admin; 2 -> gestore; 3 -> committente; 4 -> utente;
        foreach ($ruoli as $index => $ruolo) {

            if ($index == 1) 
            {
                $role = Defender::findRole($ruolo);
                if($role != null)
                {
                    for ($i = 1;$i <= count($permessi);$i++) {
                        $role->attachPermission($permessi[$i]);
                    }
                }
                
            }

            if ($index == 2) 
            {
                $role = Defender::findRole($ruolo);
                
                if($role != null)
                {
                    for ($i = 1;$i <= count($permessi);$i++) {
                        $role->attachPermission($permessi[$i]);
                    }
                    // $role->attachPermission($creaScheda);
                    // $role->attachPermission($modificaScheda);
                    // $role->attachPermission($creaCampagna);
                    // $role->attachPermission($gestioneInterna);
                    // $role->attachPermission($sezCampagneCampionamenti);
                    // $role->attachPermission($sezCampioni);
                    // $role->attachPermission($sezRelazioni);
                    // $role->attachPermission($sezScheda);
                    // $role->attachPermission($inviaMail);
                    // $role->attachPermission($creaRappRel);
                    // //$role->attachPermission($modificaRappRel);
                    // $role->attachPermission($eliminaRappRel);
                    // $role->attachPermission($sezProcedure);
                    // $role->attachPermission($creaProcedura);
                    // $role->attachPermission($modificaProcedura);
                    // $role->attachPermission($eliminaProcedura);
                    // $role->attachPermission($creaSchedaM);
                    // $role->attachPermission($eliminaSchedaM);
                    // $role->attachPermission($modificaSchedaM);
                    // $role->attachPermission($sezScheda);
                    // $role->attachPermission($sezEventi);
                    // $role->attachPermission($sezUtenti);
                    // $role->attachPermission($gestisciUtenti);
                }
            }

            if ($index == 3) 
            {
                $role = Defender::findRole($ruolo);
                if($role != null)
                {
                    $role->attachPermission($sezCampagneCampionamenti);
                    $role->attachPermission($sezCampioni);
                    $role->attachPermission($sezRelazioni);
                    $role->attachPermission($sezScheda);
                    $role->attachPermission($sezProcedure);
                }
            }

            if ($index == 4) 
            {
                $role = Defender::findRole($ruolo);
                if($role != null)
                {
                    $role->attachPermission($sezCampagneCampionamenti);
                    $role->attachPermission($sezCampioni);
                    $role->attachPermission($sezRelazioni);
                    $role->attachPermission($sezScheda);
                    $role->attachPermission($sezProcedure);
                }
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('permission_role')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
