<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\SupervisionProyecto;
use App\ImgSupervision;
use App\Proyecto;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;

class SupervisionController extends Controller
{
    public $anio;

    public function __construct()
    {
        $this->anio = config('app.app_year');
    }

    //registrar supervisiones
    public function store(Request $request)
    {
            try{
                  DB::beginTransaction();
                  $supervision = new SupervisionProyecto();
                  $supervision->fecha = $request->fecha;
                  $supervision->observacion = $request->observacion;
                  $supervision->estado = 0;
                  $supervision->fecha_registro = $this->anio;
                  Proyecto::findOrFail($request->proyecto_id)->supervision()->save($supervision);
                  
                  $imagenes = $request->imagenes;

                  for ($i=0;$i<count($imagenes);$i++) {

                    $imgSuper = new ImgSupervision();
                    $name_img = $supervision->id.'-'. uniqid().'.'. explode('/', explode(':', substr($imagenes[$i], 0, strpos($imagenes[$i], ';')))[1])[1];
                    $imgSuper->img = $name_img;
                    $imgSuper->fecha_registro = $this->anio;
                    Image::make($imagenes[$i])->save(public_path('images_superv/').$name_img);
                    SupervisionProyecto::findOrFail($supervision->id)->imgSupervisiones()->save($imgSuper);

                  }
                  DB::commit();
              }catch (Exception $e){
                  DB::rollBack();
              }
    }
    //actualizacion de supervisiones
    public function update(Request $request){

        $supervision = Proyecto::findOrFail($request->id_proyecto)->supervision;
        $supervision->fecha = $request->fecha;
        $supervision->observacion = $request->observacion;
        $imagenes = $request->images;
        for ($i=0;$i<count($imagenes);$i++) {

            $imgSuper = new ImgSupervision();
            $name_img = $supervision->id.'-'. uniqid().'.'. explode('/', explode(':', substr($imagenes[$i], 0, strpos($imagenes[$i], ';')))[1])[1];
            $imgSuper->img = $name_img;
            Image::make($imagenes[$i])->save(public_path('images_superv/').$name_img);
            SupervisionProyecto::findOrFail($supervision->id)->imgSupervisiones()->save($imgSuper);
          }
        $supervision->update();
    }
    //obtener las supervisiones
    public function GetSupervision($id)
    {
        $s = Proyecto::findOrFail($id)->supervision;
        $i = ImgSupervision::where('supervision_id',$s->id)->get();
        $s->setAttribute('imagenes',$i);
        return $s;
    }

    //imagenes de supervisiones
    public function imgSuperv($id){

        $s = Proyecto::findOrFail($id)->supervision;
        $img = ImgSupervision::where('supervision_id',$s->id)->select('img')->get();
        return $img;
    }

    //eliminar imagenes
    public function delete($id){

        $img = ImgSupervision::findOrFail($id);
        if(file_exists(public_path('images_superv/').$img->img))
        {
            unlink(public_path('images_superv/').$img->img);
        }
        $img->delete();
    }

}
