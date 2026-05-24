<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\pedido;

class PedidoEstado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Configuración visual por estado
     */
    private const CONFIG = [
        'por_confirmar' => [
            'color' => '#1e40af',
            'fondo' => '#dbeafe',
            'icono' => '📋',
            'asunto' => 'Recibimos tu pedido. Amoretti',
            'titulo' => '¡Pedido recibido!',
            'mensaje' => 'Hemos recibido tu pedido y está en revisión. En breve nuestro equipo lo confirmará y comenzaremos con la preparación.',
        ],
        'horneando' => [
            'color' => '#6d28d9',
            'fondo' => '#ede9fe',
            'icono' => '🎂',
            'asunto' => 'Tu pastel está en el horno. Amoretti',
            'titulo' => '¡Estamos horneando tu pedido!',
            'mensaje' => 'Buenas noticias: tu pedido ha sido confirmado y ya estamos trabajando en él con todo nuestro cariño.',
        ],
        'listo' => [
            'color' => '#065f46',
            'fondo' => '#d1fae5',
            'icono' => '✅',
            'asunto' => 'Tu pedido está listo. Amoretti',
            'titulo' => '¡Tu pedido está listo!',
            'mensaje' => 'Tu pedido ya está listo para recoger.',
        ],
        'cancelado' => [
            'color' => '#991b1b',
            'fondo' => '#fee2e2',
            'icono' => '❌',
            'asunto' => 'Tu pedido fue cancelado. Amoretti',
            'titulo' => 'Pedido cancelado',
            'mensaje' => 'Tu pedido ha sido cancelado. Si tienes alguna duda o deseas hacer un nuevo pedido, no dudes en contactarnos.',
        ],
        'rechazado' => [
            'color' => '#92400e',
            'fondo' => '#fef3c7',
            'icono' => '⚠️',
            'asunto' => 'No pudimos procesar tu pedido. Amoretti',
            'titulo' => 'Pedido no procesado',
            'mensaje' => 'Lamentablemente no fue posible procesar tu pedido en este momento. Por favor contáctanos para conocer los detalles y buscar una solución.',
        ],
    ];
 
    public array $config;
 
    public function __construct(
        public readonly pedido $pedido
    ) {
        $this->config = self::CONFIG[$pedido->estado] ?? [
            'color' => '#973100',
            'fondo' => '#fff1ec',
            'icono' => '🧁',
            'asunto' => 'Actualización de tu pedido. Amoretti',
            'titulo' => 'Tu pedido fue actualizado',
            'mensaje' => 'El estado de tu pedido ha cambiado. Ingresa a tu cuenta para ver los detalles.',
        ];
    }
 
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->config['asunto'],
        );
    }
 
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pedidoestado',
            with: [
                'pedido'  => $this->pedido,
                'config'  => $this->config,
                'cliente' => $this->pedido->user,
            ],
        );
    }
}
