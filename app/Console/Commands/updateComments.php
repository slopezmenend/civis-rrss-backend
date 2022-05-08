<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use App\Models\Follow;
use App\Models\User;
use App\Models\Comentario;

class updateComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:comments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update comments for Civis API new data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $token = '';

    private function llamar_ws ($url, $token){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $auth = "Authorization: Bearer ". $token;
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
        $json = json_decode($resp);
        //dump("Respuesta: " , $resp);
        //dump("JSON: " , $json->data);
        return $json->data;
    }

    private function login_ws ($url){
        $user ="slopezmenend";
        $pass = "123456";
        $postfields = "name=" . $user . "&password=" . $pass ."&password_confirmation=" . $pass;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
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
        $json = json_decode($resp);
        //dump("Respuesta: " , $resp);
        //dump("JSON: " , $json->token);
        return $json->token;
    }

    private function crear_votaciones()
    {
        $token = $this->login_ws ('https://civis-api.herokuapp.com/api/login');
        //print_r ("Recuperado el token ", $token);

        //Recuperar de Civis-API los diputados
        $url = 'https://civis-api.herokuapp.com/api/votaciones';
        $votaciones = $this->llamar_ws ($url, $token);
        //dump ("Diputados cargados: " , $diputados);

        //$url2 = 'https://civis-api.herokuapp.com/api/partidos';
        //$partidos = $this->llamar_ws ($url, $token);
        //dump ("Partidos cargados: " , $partidos);

        //Para cada uno crear un usuario referenciando a su id del congreso
        foreach ($votaciones as $votacion)
        {
            $url2 = 'https://civis-api.herokuapp.com/api/votacion/votos/' . $votacion->id;
            $votos = $this->llamar_ws ($url2, $token);

            foreach ($votos as $voto)
            {
            $user_id = User::where('idcivis', '=', $voto->diputado_id)->first();

            if (isset ($user_id->id))
            {
                $user_id = $user_id->id;
            $comentario = new Comentario();
            $comentario->user_id = $user_id;
            $comentario->titulo = $votacion->titulo . ($votacion->sesion . '/' . $votacion->numeroVotacion);
            $comentario->text = $votacion->textoExpediente . "\nMi voto al respecto ha sido un \"" . $voto->voto . "\"";
            //$comentario->created_at = $intervencion->created_at;

            $comentario->save();
            dump ("Creado voto: ", $voto->id);
            }
            else {
                dump ("Error buscando el diputado ", $intervencion->diputado_id, $user_id);
            }
            }
        }

    }

    private function crear_intervenciones()
    {
        $token = $this->login_ws ('https://civis-api.herokuapp.com/api/login');
        //print_r ("Recuperado el token ", $token);

        //Recuperar de Civis-API los diputados
        $url = 'https://civis-api.herokuapp.com/api/intervenciones';
        $intervenciones = $this->llamar_ws ($url, $token);
        //dump ("Diputados cargados: " , $diputados);

        //$url2 = 'https://civis-api.herokuapp.com/api/partidos';
        //$partidos = $this->llamar_ws ($url, $token);
        //dump ("Partidos cargados: " , $partidos);

        //Para cada uno crear un usuario referenciando a su id del congreso
        foreach ($intervenciones as $intervencion)
        {


            $user_id = User::where('idcivis', '=', $intervencion->diputado_id)->first();

            if (isset ($user_id->id))
            {
                $user_id = $user_id->id;
            $comentario = new Comentario();
            $comentario->user_id = $user_id;
            $comentario->video = $intervencion->enlaceDescargaDirecta;
            $comentario->subs = $intervencion->enlaceSubtitles;
            $comentario->titulo = $intervencion->tipoIntervencion . $intervencion->organo;
            $comentario->text = $intervencion->objeto . "\n<a href=\"" . $intervencion->EnlacePDF . "\">Enlace a la transcripción en PDF.";
            //$comentario->created_at = $intervencion->created_at;

            $comentario->save();
            dump ("Creado comentario: ", $comentario->id);
            }
            else {
                dump ("Error buscando el diputado ", $intervencion->diputado_id, $user_id);
            }
        }

    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->crear_votaciones ();
        //$this->crear_intervenciones ();
        return 0;
    }

}
