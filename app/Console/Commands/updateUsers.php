<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class updateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update users information using Civis API data';

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

    private function crear_diputados()
    {
        $token = $this->login_ws ('https://civis-api.herokuapp.com/api/login');
        //print_r ("Recuperado el token ", $token);

        //Recuperar de Civis-API los diputados
        $url = 'https://civis-api.herokuapp.com/api/diputados';
        $diputados = $this->llamar_ws ($url, $token);
        //dump ("Diputados cargados: " , $diputados);

        $url2 = 'https://civis-api.herokuapp.com/api/partidos';
        $partidos = $this->llamar_ws ($url, $token);
        //dump ("Partidos cargados: " , $partidos);

        //Para cada uno crear un usuario referenciando a su id del congreso
        foreach ($diputados as $diputado)
        {
            //comprobamos si el usuario ya existe
            $user = User::where ('idcivis', '=', $diputado->id)->first();
            //llamamos al servicio para recoger el fondo de cada partido

            if ($user == null)
            {
                //Crear el modelo y guardarlo
                $user = new User ();
                $user->name = $diputado->nombrecompleto;
                $user->nombre = $diputado->nombrecompleto;
                $user->email = $diputado->email;
                $user->password = '123456';
                $user->idcivis = $diputado->id;
                $diputado->urlfoto == null? $user->fotoperfil = '': $user->fotoperfil = $diputado->urlfoto;
                //$user->fotoperfil = $diputado->urlfoto;
                //$user->urlfondo = $partidos.find(id , $diputado->partido_id)->url;
                $user->biografia = $diputado->biografia;
                $diputado->urlperfil == null? $user->web = '': $user->web = $diputado->urlperfil;
                //$user->web = $diputado->urlperfil;
                $user->save();
                dump ("Creado usuario: ", $user->id, $user->name);
            }
            else {
                dump ("Ya existía el usuario: ", $user->name);
            }

            //Inicializamos su muro
        }

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->crear_diputados ();
        return 0;
    }
}
