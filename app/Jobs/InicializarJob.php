<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Follow;

class InicializarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $token = '';

    private function llamar_ws ($url){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $auth = "Authorization: Bearer ". $this->$token;
        $headers = array(
           "Accept: application/json",
           $auth,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        var_dump($resp);
        return $resp;
    }

    private function login_ws ($url){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //$auth = "Authorization: Bearer ".$token;
        $headers = array(
           "Accept: application/json",
        //   $auth,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        var_dump($resp);
        return $resp;
    }

    private function crear_diputados()
    {
        $this->$token = $this->login_ws ('https://civis-api.herokuapp.com/api/login');
        //Recuperar de Civis-API los diputados
        $url = 'https://civis-api.herokuapp.com/api/diputados';
        $diputados = $this->llamar_ws ($url);

        $url2 = 'https://civis-api.herokuapp.com/api/partidos';
        $partidos = $this->llamar_ws ($url);

        //Para cada uno crear un usuario referenciando a su id del congreso
        foreach ($diputados as $diputado)
        {
            //llamamos al servicio para recoger el fondo de cada partido

            //Crear el modelo y guardarlo
            $user = new User ();
            $user->name = $diputado->nombrecompleto;
            $user->email = $diputado->email;
            $user->password = '123456';
            $user->politico_id = $diputado->id;
            $user->urlavatar = $diputado->urlfoto;
            $user->urlfondo = $partidos.find(id , $diputado->partido_id)->url;
            $user->biografia = $diputado->biografia;
            $user->urlpage = $diputado->urlperfil;

            $user->save();

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
        /*$this->init_icons();
        $this->crear_diputados();*/
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
