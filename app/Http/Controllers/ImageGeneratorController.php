<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageGeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');

        if (!$prompt) {
            return response()->json(['error' => 'Prompt kosong.'], 400);
        }

        $response = Http::withToken(env('REPLICATE_API_TOKEN'))
            ->post('https://api.replicate.com/v1/predictions', [
                "version" => "c221b2b8ef527988fb59bf24a8b97c4561f1c671f73bd389f866bfb27c061316",
                "input" => [
                    "prompt" => $prompt,
                    "width" => 768,
                    "height" => 768,
                    "refine" => "expert_ensemble_refiner",
                    "scheduler" => "K_EULER",
                    "lora_scale" => 0.6,
                    "num_outputs" => 1,
                    "guidance_scale" => 7.5,
                    "apply_watermark" => false,
                    "high_noise_frac" => 0.8,
                    "negative_prompt" => "",
                    "prompt_strength" => 0.8,
                    "num_inference_steps" => 25
                ]
            ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Gagal kirim ke Replicate.'], 500);
        }

        $prediction = $response->json();
        $statusUrl = $prediction['urls']['get'] ?? null;

        if (!$statusUrl) {
            return response()->json(['error' => 'URL status kosong.'], 500);
        }

        // Polling status
        for ($i = 0; $i < 10; $i++) {
            sleep(1);
            $result = Http::withToken(env('REPLICATE_API_TOKEN'))->get($statusUrl)->json();

            if ($result['status'] === 'succeeded') {
                return response()->json(['output' => $result['output'] ?? []]);
            }

            if ($result['status'] === 'failed') {
                return response()->json(['error' => 'Gagal generate.'], 500);
            }
        }

        return response()->json(['error' => 'Timeout menunggu hasil.'], 504);
    }

}
