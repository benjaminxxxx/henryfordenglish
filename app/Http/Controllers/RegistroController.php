<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Nivel;
use Hash;


class RegistroController extends Controller{

    public function index(){
        $niveles = Nivel::get();
        return view('registro.index',[
            'niveles'=>$niveles
        ]);
    }
    public function store(Request $request){
        
        try {
            $user = User::where(['dni'=>$request->dni])->get();

            if($user->count()>0){
                return back()->withErrors(['message'=>'Usuario ya existe']);
            }

            User::create([
                'name'=>$request->name,
                'password'=>Hash::make($request->dni),
                'dni'=>$request->dni,
                'nivel_id'=>$request->nivel,
                'apellido'=>$request->apellido
            ]);
            
            return redirect()->route('login');

        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors(['message'=>$th->getMessage()]);
        }
    }
}