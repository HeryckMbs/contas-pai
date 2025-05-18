<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckPermission
{

    public function handle(Request $request, Closure $next, $permissao )
    {

        $grupos = explode('|', $permissao);
        $bool   = false;
        $user = Auth::user();

        /** @var User $user */
        info('Middleware CheckPermission chamado', [
            'uri' => $request->getRequestUri(), // URI da requisição
            'permissao' => $permissao, // Permissão recebida
            'method' => $request->method(),
            'pode' =>$user->obtemTodosGrupos() ,
            'grupos' => $grupos
        ]);

        if($user->obtemTodosGrupos() == 'administrador' || $user->obtemTodosGrupos() == 'root'){
            return $next($request);
        }
        if($user != null){
            foreach ($grupos as $grupo) {
                /** @var User $user */
                $bool = $user->pertenceAoGrupo($grupo);
            }
            abort_unless($bool, Response::HTTP_FORBIDDEN, 'Você não tem permissão para acessar esta página!');

            return $next($request);
        }

        if($request->getRequestUri() === '/painel/login'){
            return $next($request);
        }
        abort(401,'Login Expirado!');

    }
}
