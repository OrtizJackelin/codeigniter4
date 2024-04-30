<?php
namespace App\Controllers;
use App\Models\ModeloUsuario;
use CodeIgniter\Exceptions\PageNotFoundException;

class Usuario extends BaseController
{
    private $session;
    public function __construct()
    {
        $this->session = session();
    }
    /*public function verificarCorreo()
    {
        $request = $this->request->getJSON();
        $email = $request->email;

        // Lógica para verificar si el correo electrónico ya está registrado en la base de datos
        $existeEmail = $this->tuModelo->verificarEmailExistente($email);

        return $this->response->setJSON(['exists' => $existeEmail]);
    }*/
    public function nueva(){

        helper('form');

        $data = [
            'tituloPagina' => 'Crear Usuario',
            'tituloCuerpo' => 'Crear Usuario'
        ];

        return view('plantillas/header',$data)
        .view('usuarios/crear', $data)
        .view('plantillas/footer');
    }

  /*  public function verificar_opciones(string $str = null, string &$error = null): bool
    {
        if ($this->request->getPost('es_editor') == null && $this->request->getPost('es_validador') == null) {
            $error = 'Debe seleccionar al menos una opción.';
            return false;
        }
        return true;
    }*/
    public function crear(){
        helper('form');

        
        $data = $this->request->getPost(['nombre', 'apellido', 'correo', 'clave', 'repetirClave', 'es_editor', 'es_validor']);

       
        if (!$this->validateData($data, [
            'nombre' => 'required|max_length[50]|min_length[2]|alpha',
            'apellido'  => 'required|max_length[50]|min_length[2]|alpha',
            'correo'  => [
                'rules' => 'required|max_length[50]|min_length[8]
                            |regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]
                            |is_unique[usuario.correo]',
                'errors' => [
                    'regex_match' => 'El formato del correo electrónico es incorrecto.',
                    'is_unique' => 'El correo electrónico ya está registrado.'//revisar aqui
                ]
            ],
            'clave'  => 'required',// revisar aqui
            'repetirClave' => 'matches[clave]',//revisar aqui
            //'rol' => 'required',

        ], [
            'repetir_clave' => [//revisar aqui
                'matches' => 'Las claves no coinciden.'
            ],
           
        ])) {
            return $this->nueva();
        }


        $data['clave'] = password_hash($data['clave'], PASSWORD_DEFAULT);

            //Para imprimir en consola////
            echo "<script>";
            echo "console.log('Lista:', " . json_encode($data['clave']) . ");";
            echo "</script>";

        $es_editor = false;
        $es_validador = false;

         for ($i = 0; $i < count($_POST['rol']); $i++) {

            if (isset($_POST['rol'][$i]) && $_POST['rol'][$i] === "1") {
                $es_validador = true;    
                var_dump("entro validador");
            } 
            if (isset($_POST['rol'][$i]) && $_POST['rol'][$i] === "2") {
                var_dump("entro editor");
                $es_editor = true;
            }

        }

        $post = $this->validator->getValidated();
        $modelo = model(ModeloUsuario::class);
        $modelo->save([
            'nombre'=> $post['nombre'], 
            'apellido' => $post['apellido'],
            'correo'  => $post['correo'],
            'clave'  => $data['clave'],
            'es_editor'  => $es_editor,
            'es_validador'  => $es_validador,
        ]);
        
        return view('plantillas/header',['tituloPagina'=>'Noticia Creada'])
            .view('plantillas/exito')
            .view('plantillas/footer');
    }

    public function iniciarSesion(){

        if($this->session->has('id')){
            return redirect()->to(base_url());
        }
        helper('form');

        $data = [
            'tituloPagina' => 'Inicar Sesion',
            'tituloCuerpo' => 'Inicar Sesion',
        ];

        return view('plantillas/header',$data)
        .view('usuarios/iniciar_sesion', $data)
        .view('plantillas/footer');
    }

    public function validarSesion(){

        helper('form');        
        $data = $this->request->getPost(['correo', 'clave']);
       
        if (!$this->validateData($data, [
            'correo'  => [
                'rules' => 'required|max_length[50]|min_length[8]
                            |regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]',
                'errors' => [
                    'regex_match' => 'El formato del correo electrónico es incorrecto.',
                ]
            ],
            'clave' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/]',
                'errors' => [
                    'required' => 'El campo Clave es obligatorio.',
                    'min_length' => 'La clave debe tener al menos 8 caracteres.',
                    'regex_match' => 'La clave debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.',
                ]  
            ]         
        ])) {
            // Manejar errores de validación aquí
            return $this->iniciarSesion();
        }

        $modeloUsuario = model(ModeloUsuario::class);
        $usuario = $modeloUsuario
                    ->where('correo', $data['correo'])
                    ->first();

        
        if ($usuario && password_verify($data['clave'], $usuario['clave'])) {
            $datosUsuario = [
                'id'  => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'apellido' => $usuario['apellido'],
                'esValidador' => $usuario['es_validador'],
                'esEditor' => $usuario['es_editor']
            ];
            $this->session->set($datosUsuario);

            return redirect()->to(base_url());
             

        } else {
            echo "usuario/clave invalido";
            return $this->iniciarSesion();
        }
        
    }

    public function cerrarSesion(){
        $this->session->destroy();
        $this->session->close();
        return redirect()->to(base_url());
    }

}


?>