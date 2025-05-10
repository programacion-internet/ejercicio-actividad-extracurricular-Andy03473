<?php

namespace App\Mail;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscripcionEvento extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $alumno;

    /**
     * Create a new message instance.
     */
    public function __construct(Evento $evento, User $alumno)
    {
        $this->evento = $evento;
        $this->alumno = $alumno;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inscripción al Evento: ' . $this->evento->nombre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.inscripcion',
            with: [
                'evento' => $this->evento,
                'alumno' => $this->alumno,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

