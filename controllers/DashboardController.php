<?php

namespace Controllers;

use Model\Evento;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class DashboardController{
    public static function index(Router $router){

        // Obtener ultimos registros
        $registros = Registro::get(5);
        foreach($registros as $registro){
            $registro->usuario = Usuario::find($registro->usuario_id);
        }

        // Calcular los ingresos
        $vituales = Registro::total('paquete_id', 2);
        $presenciales = Registro::total('paquete_id', 1);

        $ingresos = ($vituales * 46.41) + ($presenciales * 189.54);

        //Obtener eventos con más y menos lugares disponibles
        $menosDisponibles = Evento::ordenarLimite('disponibles', 'ASC', 5);
        $masDisponibles = Evento::ordenarLimite('disponibles', 'DESC', 5);

        $router->render('admin/dashboard/index',[
            'titulo' => 'Panel de Administración',
            'registros' => $registros,
            'ingresos' => $ingresos,
            'menosDisponibles' => $menosDisponibles,
            'masDisponibles' => $masDisponibles
        ]);
    }
}