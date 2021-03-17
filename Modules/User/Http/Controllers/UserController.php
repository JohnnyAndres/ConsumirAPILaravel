<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    
    public function index()
    {
        $response = Http::get("https://jsonplaceholder.typicode.com/todos");

        $status   = $response->status();
        $users = $response->getBody();

        $data = json_decode($users);

        if ($status == 200){
            $arrUsers = array_slice($data, 10, 10);
            return view('user::index', compact('arrUsers'));
        } 

        if ($status != 200){
            return ("Ha ocurrido un error " . $status);
        }  
        
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $response = Http::put("https://jsonplaceholder.typicode.com/todos/".$id,
            [
                'json' => $request->all()
            ]
        );

        $status   = $response->status();
        $updatedUser = $response->getBody();
        $data = json_decode($updatedUser);

        if ($status == 200){
            return response()->json($data); //Retornamos el json que nos provee el resultado de la peticion put
                                            //Nos devuelve un arreglo con los datos del usuario que habrian sido cambiados
        } 

        if ($status != 200){
            return ("Ha ocurrido un error " . $status);
        } 
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $response = Http::delete("https://jsonplaceholder.typicode.com/todos/".$id);
        
        $status   = $response->status();
        $deletedUser = $response->getBody();
        $data = json_decode($deletedUser);

        if ($status == 200){
            return response()->json(["deletedUserId" => $id, "data"=> $data ]);
       //Retornamos json con un parametro data que se encuentra vacio que nos devulve la peticion
       //ya que este seria el resultado en base de datos mas el userId del usuario que fue eliminado,
       //con el fin de usarlo para eliminar el registro de la lista en el componente que muestra los usuarios 
        } 
        if ($status != 200){
            return ("Ha ocurrido un error " . $status);
        } 
        

    }

    public function store(Request $request)
    {   

        $response = Http::post("https://jsonplaceholder.typicode.com/todos/",
        [
            'json' => $request->all()
        ]);
        
        $status   = $response->status();
        $createdUser = $response->getBody();
        $data = json_decode($createdUser);    

        if ($status == 201){
            return response()->json($data); 
            //Retornamos el json que nos devulve la peticion post con la información del nuevo usuario que habria sido almacenada en la base de datos 
        } 
        if ($status != 201){
            return ("Ha ocurrido un error " . $status);
        } 
    }

    
    
}
