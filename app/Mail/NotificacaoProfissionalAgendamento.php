<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificacaoProfissionalAgendamento extends Mailable
{
    use Queueable, SerializesModels;

    protected $notificacao;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notificacao)
    {
        $this->notificacao = $notificacao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@medcallconsultas.com.br')
                    ->subject('Notificação Medcall Consultas')
                    ->view('emails.notificacao-profissional-agendamento')
                    ->with([ 'notificacao' => $this->notificacao ]);
    }
}
