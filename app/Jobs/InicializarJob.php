<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InicializarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private function crear_diputados()
    {
        //Recuperar de Civis-API los diputados
        $diputados = '';

        //Para cada uno crear un usuario referenciando a su id de civis-api
        foreach ($diputados as $diputado)
        {
            //Crear el modelo y guardarlo

            //Inicializamos su muro
        }

    }

    private function init_icons ()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->init_icons();
        $this->crear_diputados();

    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        dump ("Proceso terminado por excepción");
    }
}
