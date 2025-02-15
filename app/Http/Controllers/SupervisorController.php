<?php

namespace App\Http\Controllers;

use App\Institucion;
use App\Supervisor;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public $anio;

    public function __construct()
    {
        $this->anio = config('app.app_year');
    }

    //RUTA /institucion/supervisor/index/{$institucion_id}
    public function index(Request $request)
    {
        $supervisores = Institucion::find($request->institucion_id)->supervisores()->get();
        return $supervisores;
    }

    public function store(Request $request)
    {
        $supervisor = new Supervisor();
        $supervisor->nombre = $request->nombre;
        $supervisor->no_telefono = $request->telefono;
        $supervisor->institucion_id = $request->institucion_id;
        $supervisor->fecha_registro = $this->anio;
        $supervisor->save();
    }

    public function update(Request $request)
    {
       $supervisor = Supervisor::find($request->supervisor_id);
       $supervisor->nombre = $request->nombre;
       $supervisor->no_telefono = $request->telefono;
       $supervisor->update();
    }

    public function delete($id)
    {
        $supervisor = Supervisor::find($id);
        $supervisor->delete();
    }
    public function validateSupervisor(Request $request)
    {
        if(Supervisor::where('nombre',$request->nombre)->exists()){
            return response('existe', 200);
        }
    }
}
