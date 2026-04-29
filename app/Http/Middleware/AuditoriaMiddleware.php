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
            $detalhesTecnicos = $request->input('detalhes_tecnicos');

            $conteudoResposta = $response->getContent();

            $dadosLog = [
                'metodo'            => $request->method(),
                'endpoint'          => $request->path(),
                'payload_envio'     => json_encode($request->except('detalhes_tecnicos')),
                'erros_validacao'   => $detalhesTecnicos ? json_encode($detalhesTecnicos) : null,
                'status_http'       => $response->status(),
                'ip_origem'         => $request->ip(),

                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            DB::table('auditoria_logs')->insert($dadosLog);


            Log::info("AUDITORIA [" . $response->status() . "]: " . $request->method() . " " . $request->path(), [
                'envio' => $request->except('detalhes_tecnicos'),
                'resposta_do_servidor' => json_decode($conteudoResposta, true), // PROVA REAL
                'erro_interno_laravel' => $detalhesTecnicos ?? 'Nenhum'
            ]);

        } catch (\Exception $e) {
            Log::error("Falha no AuditoriaMiddleware: " . $e->getMessage());
        }

        return $response;
    }
}
