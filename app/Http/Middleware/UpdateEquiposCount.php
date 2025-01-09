<?php

namespace App\Http\Middleware;

use App\Models\equipos;
use Illuminate\Support\Facades\Cache;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateEquiposCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
    //formato de busqueda mas robusta
    $menu = config('adminlte.menu');
    
    // Buscar el elemento 'Equipos' de manera más robusta
    $equiposElement = array_reduce($menu, function($carry, $item) {
        if (is_array($item) && isset($item['text']) && $item['text'] === 'Equipos') {
            $carry = $item;
        }
        return $carry;
    }, null);
    
    if ($equiposElement) {
        // Usar caché para evitar consultas frecuentes
        $equiposCount = Cache::remember('equipos_count', now()->addMinutes(5), function () {
            return equipos::count();
        });
        
        // Actualizar el label del elemento 'Equipos'
        $equiposElement['label'] = $equiposCount;
        
        // Actualizar la configuración del menú
        config(['adminlte.menu' => array_map(function($item) use ($equiposElement) {
            return $item === $equiposElement ? $equiposElement : $item;
        }, $menu)]);
    }
    
    return $next($request);

    }
}
