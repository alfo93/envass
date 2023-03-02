<?php

namespace App\Event;

use App\LogEvent;
use Illuminate\Support\Facades\Log;

class LoggerEvent extends LogEvent
{
    public static function log($userId, $action, $dati, $logEvent = false, $campioneId = null, $rdp = null)
    {
        $fields = $dati;
        if (isset($fields['dati'])) {
            if (isset($fields['dati']["_token"])) {
                unset($fields['dati']["_token"]);
            }
            if (isset($fields['dati']["_method"])) {
                unset($fields['dati']["_method"]);
            }
        }

        if (isset($fields["_token"])) {
            unset($fields["_token"]);
        }
        
        if (isset($fields["_method"])) {
            unset($fields["_method"]);
        }

        /*if (isset($fields['nome'])) {
            $nome_criptato = $fields['nome'];
            $fields['nome'] = $nome_criptato;
        }

        if (isset($fields['cognome'])) {
            $nome_criptato = $fields['cognome'];
            $fields['cognome'] = $nome_criptato;
        }*/

        if ($logEvent == true) {
            Log::info("Id Utente: " . $userId ." Ha effettuato l'Azione: " . $action . "\t" . "Dati: " . json_encode($fields));
        }

        $log = new LogEvent();
        $log->id_utente = $userId;
        $log->id_campione = $campioneId;
        $log->rdp = $rdp;
        $log->azione = $action;
        $log->dati = json_encode($fields);
        $log->save();
    }
}
