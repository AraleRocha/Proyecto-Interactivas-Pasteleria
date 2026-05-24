<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Producto;

class ChatbotController extends Controller
{
    public function responder(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:500',
        ]);

        // Datos de la bd
        $productos = Producto::where('disponible', true)
            ->where('stock', '>', 0)
            ->get(['nombre', 'categoria', 'sabor', 'tamano', 'precio'])
            ->map(fn($p) => "- {$p->nombre} ({$p->categoria}), sabor {$p->sabor}, tamaño {$p->tamano}, \${$p->precio}")
            ->implode("\n");

        // Construir el prompt 
        $prompt = "Eres el asistente virtual de Amoretti, una pastelería artesanal.\n\n"
            . "SOLO puedes recomendar productos de esta lista:\n"
            . ($productos ?: 'No hay productos disponibles en este momento.') . "\n\n"
            . "REGLAS DE FORMATO CRÍTICAS:\n"
            . "- Responde en español, de forma amable y breve.\n"
            . "- Solo regresa texto simple y limpio, puedes usar emojis.\n"
            . "- PROHIBIDO usar formato Markdown. NO uses asteriscos (como **texto** o *texto*), ni guiones bajos, ni almohadillas (#). Escribe todo en texto normal y plano.\n"
            . "- Recomienda máximo 2 opciones y explica por qué combinan con la ocasión.\n\n"
            . "Cliente: {$request->mensaje}";

        return response()->json([
            'respuesta' => $this->consultarGemini($prompt)
        ]);
    }

    private function consultarGemini(string $prompt): string
    {
        $apiKey = config('services.gemini.key');
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        $response = Http::post($url, [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $prompt]]
                ]
            ]
        ]);

        if ($response->failed()) {
            return 'En este momento no puedo responder. Intenta de nuevo.';
        }

        $texto = $response->json('candidates.0.content.parts.0.text') ?? 'No pude procesar tu consulta.';

        // Elimina asteriscos residuales por si el modelo los genera por error
        return trim(str_replace(['**', '*'], '', $texto));
    }
}