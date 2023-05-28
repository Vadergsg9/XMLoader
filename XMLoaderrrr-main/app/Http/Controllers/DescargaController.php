<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DescargaController extends Controller
{   protected $verificarController;
    protected $descargarController;
    protected $complementoController;
    protected $loginController;
    protected $solicitarController;

    public function __construct(
        VerificarcfdiController $verificarController, 
        DescargarcfdiController $descargarController, 
        ComplementocfdiController $complementoController,
        LogincfdiController $loginController,
        SolicitarcfdiController $solicitarController
    )
    {
        $this->verificarController = $verificarController;
        $this->descargarController = $descargarController;
        $this->complementoController = $complementoController;
        $this->loginController = $loginController;
        $this->solicitarController = $solicitarController;
    }

    public function manejarDescarga(Request $request)
    {

        // Recibir el archivo .key
        if ($request->hasFile('clavePrivada')) {
            $file = $request->file('clavePrivada');

            // Crear un nombre único para el archivo
            $uniqueName = Str::random(10) . '.key';
            $uniquePemName = Str::random(10) . '.pem';

            // Guardar el archivo en el storage
            Storage::disk('local')->put($uniqueName, file_get_contents($file));

            // Ruta al archivo .key
            $keyPath = storage_path('app/' . $uniqueName);

            // Ruta al archivo .pem
            $pemPath = storage_path('app/' . $uniquePemName);

            // Comando para convertir el .key a .pem
            $command = "openssl pkcs8 -inform DER -in {$keyPath} -out {$pemPath} -nocrypt";

            // Ejecutar el comando
            shell_exec($command);

            // Ahora puedes usar $pemPath en lugar de $clavePrivadaContenido
            $clavePrivadaContenido = $pemPath;

            // Resto del código...

            // Luego de terminar, es recomendable eliminar los archivos
            Storage::disk('local')->delete([$uniqueName, $uniquePemName]);
        }

        // Ahora puedes usar los métodos de los otros controladores. Por ejemplo:
        $this->verificarController->algunaFuncion();
        $this->descargarController->algunaFuncion();
        $this->complementoController->algunaFuncion();
        $this->loginController->algunaFuncion();
        $this->solicitarController->algunaFuncion();
        
        // Resto del código...

        $certificadoContenido = $request->input('certificado');
        $clavePrivadaContenido = $request->input('clavePrivada');
        $password = $request->input('password');
        $rfc = $request->input('rfc');
        $fechaInicial = $request->input('fechaInicial');
        $fechaFinal = $request->input('fechaFinal');
        $tipoSolicitud = $request->input('tipoSolicitud');
        $tipoConsulta = $request->input('tipoConsulta');

        // Mostrar los datos recibidos (deberías reemplazar esto con tu lógica de negocio)
        echo 'Certificado: ' . $certificadoContenido . '<br>';
        echo 'Clave Privada: ' . $clavePrivadaContenido . '<br>';
        echo 'Contraseña: ' . $password . '<br>';
        echo 'RFC: ' . $rfc . '<br>';
        echo 'Fecha inicial: ' . $fechaInicial . '<br>';
        echo 'Fecha final: ' . $fechaFinal . '<br>';
        echo 'Tipo de solicitud: ' . $tipoSolicitud . '<br>';
        echo 'Tipo de consulta: ' . $tipoConsulta . '<br>';

        $login = $this->loginController->soapRequest($certificadoContenido, $pemPat);
        $solicitar = $this->solicitarController->soapRequest($certificadoContenido, $pemPat, $login->token, $rfc, $fechaInicial, $fechaFinal, $TipoSolicitud, $TipoConsulta);

        $idSolicitud = $solicitar->IdSolicitud;

        $verificar = $this->verificarController->soapRequest($certificadoContenido, $pemPat, $login->token, $rfc, $solicitar->IdSolicitud);

        $descargar = $this->descargarController->soapRequest($certificadoContenido, $pemPat, $login->token, $rfc, $verificar->idPaquete);
        $this->complementoController->saveBase64File($descargar->Paquete, $verificar->idPaquete. ".zip");

        echo "Terminado";

        // Luego de terminar, es recomendable eliminar los archivos
        Storage::disk('local')->delete([$uniqueName, $uniquePemName]);

    }
}
