<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Societa;
use App\RapportoRelazione;
use App\Struttura;
use App\AreaPartizione;
use App\Reparto;
use Carbon\Carbon;

class SendEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Societa $committente, RapportoRelazione $rapprel, String $progetto)
    {
        $this->email = $committente;
        $this->rapporto = $rapprel;
        $this->progetto = $progetto;
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
        $n_rdp = (isset(explode('_',$this->rapporto->file,)[3]) && isset(explode('_',$this->rapporto->file,)[4])) ? explode('_',$this->rapporto->file,)[3] . "_" . explode('_',$this->rapporto->file,)[4] : $rapprel->file;
        $data = [
            //qui ci vanno i dati del rapporto di prova
            'nome' => explode('.pdf',$n_rdp)[0],
            'progetto' => $this->progetto,
            'struttura' => Struttura::find($this->rapporto->ospedale)->struttura,
            'data_campagna' => Carbon::parse($this->rapporto->dataCampagna)->format('d/m/Y'),
            'reparto' => Reparto::find(AreaPartizione::find($this->rapporto->id_areapartizione)->id_reparto)->partizione,
            'area_partizione' =>  AreaPartizione::find($this->rapporto->id_areapartizione)->area_partizione
        ];

        return (new MailMessage)
                    ->subject("Emissione Rapporto di Prova ". explode('.pdf',$n_rdp)[0])
                    ->view('email.email-inviata',$data);
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
