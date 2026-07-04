<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GeminiService
{
    protected $keys;
    protected $baseUrl;
    protected $currentKeyIndex;

    public function __construct()
    {
        $this->keys = config('services.gemini.keys');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
        $this->currentKeyIndex = Cache::get('gemini_key_index', 0);
    }

    private function getNextKey()
    {
        $key = $this->keys[$this->currentKeyIndex];
        $this->currentKeyIndex = ($this->currentKeyIndex + 1) % count($this->keys);
        Cache::put('gemini_key_index', $this->currentKeyIndex, 3600);
        return $key;
    }

    public function consultarAsistente(string $pregunta, string $contextoInformacion): string
    {
        $contextoLimpio = str_replace(["\r", "\n"], ' ', $contextoInformacion);
        
        // Reglas inyectadas desde tu archivo de instrucciones
        $reglasVisuales = "REGLA CRÍTICA DE FORMATO VISUAL:\n" .
                        "1. Cuando respondas con listas de productos, inventario, precios o stocks, NO uses viñetas ni tablas Markdown tradicionales (como '|' o '**').\n" .
                        "2. Debes generar OBLIGATORIAMENTE una tabla HTML utilizando clases de Bootstrap 5 con el siguiente formato exacto:\n" .
                        "<div class='table-responsive mt-2' style='max-height: 250px; overflow-y: auto;'>\n" .
                        "  <table class='table table-sm table-striped table-hover border table-bordered' style='font-size: 0.8rem;'>\n" .
                        "    <thead class='table-dark' style='position: sticky; top: 0; z-index: 5;'>\n" .
                        "      <tr><th>Modelo</th><th>Descripción</th><th>Precio</th><th>Stock</th></tr>\n" .
                        "    </thead>\n" .
                        "    <tbody>\n" .
                        "      <tr><td><strong>[MODELO]</strong></td><td>[DESCRIPCIÓN]</td><td class='text-nowrap'>S/. [PRECIO]</td><td><span class='badge [CLASE_BADGE]'>[STOCK]</span></td></tr>\n" .
                        "    </tbody>\n" .
                        "  </table>\n" .
                        "</div>\n" .
                        "3. Para la columna Stock, si el stock es 0 usa class='badge bg-danger'. Si es mayor a 0 usa class='badge bg-success'.";

        $promptSistema = "Eres el asistente inteligente de la intranet DAS_ACE.\n" .
                        "Responde EXCLUSIVAMENTE con el contexto. Si no hay datos, sé amable.\n\n" .
                        $reglasVisuales . "\n\n" .
                        "CONTEXTO DISPONIBLE:\n" . $contextoLimpio;

        $attempts = count($this->keys);
        for ($i = 0; $i < $attempts; $i++) {
            $apiKey = $this->getNextKey();
            try {
                $response = Http::timeout(60)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post("{$this->baseUrl}?key={$apiKey}", [
                        'contents' => [
                            ['parts' => [['text' => $promptSistema . "\n\nPregunta: " . $pregunta]]]
                        ],
                        'generationConfig' => ['temperature' => 0.2]
                    ]);

                if ($response->successful()) {
                    return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Sin respuesta.';
                }

                if ($response->status() === 429) {
                    Log::warning("Clave Gemini agotada (429), intentando con la siguiente...");
                    continue;
                }

                Log::error('Fallo en API Gemini: ' . $response->status() . ' - ' . $response->body());
                return 'Error de conexión (' . $response->status() . '). Revisa el log.';

            } catch (\Exception $e) {
                Log::error('Excepción Gemini: ' . $e->getMessage());
                if ($i === $attempts - 1) {
                    return 'Error técnico: ' . $e->getMessage();
                }
            }
        }

        return 'No se pudo obtener respuesta de ninguna clave.';
    }
}
