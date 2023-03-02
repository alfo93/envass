<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;
use App\RapportoRelazione;
use App\Struttura;
use App\AreaPartizione;
use App\Reparto;
use Carbon\Carbon;

class SendEmailApprovazione extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, RapportoRelazione $rapporto, String $motivo)
    {
        $this->email = $user;
        $this->rapporto = $rapporto;
        $this->motivo = $motivo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = [
            //qui ci vanno i dati del rapporto di prova
            'nome' => explode('.pdf',$this->rapporto->file,)[0],
            'struttura' => Struttura::find($this->rapporto->ospedale)->struttura,
            'data_campagna' => Carbon::parse($this->rapporto->dataCampagna)->format('d/m/Y'),
            'reparto' => Reparto::find(AreaPartizione::find($this->rapporto->id_areapartizione)->id_reparto)->partizione,
            'area_partizione' =>  AreaPartizione::find($this->rapporto->id_areapartizione)->area_partizione,
            'motivo' => $this->motivo,
            'tecnico' => $this->email->nome . " " . $this->email->cognome
        ];

        return (new MailMessage)
                    ->subject('Esito di approvazione del rapporto di prova '.$this->rapporto->file)
                    ->view('email.email-inviata-approvazione',$data);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
