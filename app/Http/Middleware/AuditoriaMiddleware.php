<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuditoriaMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        $response = $next($request);

        try {

            $conteudoResposta = json_decode($response->getContent(), true);
            $errosDetalhados = null;

            if ($response->status() == 405 && isset($conteudoResposta['erros'])) {
                $errosDetalhados = json_encode($conteudoResposta['erros']);
            }


            $dadosLog = [
                'metodo'          => $request->method(),
                'endpoint'        => $request->path(),
                'payload_envio'   => json_encode($request->all()),
                'erros_validacao' => $errosDetalhados,
                'status_http'     => $response->status(),
                'ip_origem'       => $request->ip(),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];


            DB::table('auditoria_logs')->insert($dadosLog);


            Log::info("AUDITORIA [" . $response->status() . "]: " . $request->method() . " " . $request->path(), [
                'request' => $request->all(),
                'validation_errors' => $conteudoResposta['erros'] ?? 'Nenhum erro de validação'
            ]);

        } catch (\Exception $e) {

            Log::error("Falha no AuditoriaMiddleware: " . $e->getMessage());
        }

        return $response;
    }
}
