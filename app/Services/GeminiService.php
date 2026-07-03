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
        $promptSistema = "Eres el asistente inteligente de la intranet DAS_ACE.\n" .
                         "Responde EXCLUSIVAMENTE con el contexto. Si no hay datos, sé amable.\n\n" .
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
