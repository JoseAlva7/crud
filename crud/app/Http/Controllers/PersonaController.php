<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Persona;
use DataTables;

class PersonaController extends Controller
{
    
    public function listar(Request $request){
       
        if ($request->ajax()) {
            $data = DB::select("select * from persona");
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip" onclick="editar('.$row->id.')"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Editar</a>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  onclick="eliminar('.$row->id.')" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Eliminar</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

        }else{
            $results = DB::select("select * from persona"); 
            // $results=Persona::get();
            $data = [
                'data' => $results,
            ];
            return $data;
        }
    }

    public function crear(Request $request)
    {
       
        DB::select('insert into persona (nombre,apellido,correo,edad) values (?,?,?,?)', [$request->input("nombre"),$request->input("apellido"),$request->input("correo"),$request->input("edad")]);
        // Persona::updateOrCreate(['id' => $request->product_id],
        //         ['name' => $request->name, 'detail' => $request->detail]);        
   
        return response()->json(['success'=>'Persona saved successfully.']);
    }

    public function buscar(Request $request)
    {
        //$persona = Persona::find($id);
        $persona= DB::select('select * from persona where id = :id', ['id' => $request->input("id")]);
        return response()->json($persona);
    }
    public function editPersona(Request $request)
    {
        DB::update('update persona set nombre = ? , apellido = ?, correo= ?, edad= ? where id = ?', [$request->input("nombre") , $request->input("apellido"),$request->input("correo"),$request->input("edad"), $request->input("id")]);
        return response()->json(['success'=>'Persona saved successfully.']);
    }

    public function eliminarPersona(Request $request)
    {
       DB::delete('delete from persona where id = :id', ['id' => $request->input("id")]);
     
        return response()->json(['success'=>'Product deleted successfully.']);
    }

}
