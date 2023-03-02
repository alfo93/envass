<?php

namespace App\Http\Controllers;

use App\Event\LoggerEvent;
use App\Ruolo;
use App\User;
use Carbon\Carbon;
use DB;
use Defender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Storage;
use Validator;
use Log;


use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('utenti.gestione_utenti');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('utenti.crea_utente');
    }

    /**
     * Ritorna il contenuto della DataTable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function list(Request $request)
    {
        $utenti = User::join('role_user','role_user.user_id','=','users.id')->whereNull('users.deleted_at');
        $utenti = $utenti->orderBy('users.id','ASC')->select(['users.id','users.uid','users.nome','users.cognome','users.email','role_user.*','users.diritti']);
        return DataTables::of($utenti)
        ->addColumn('pulsante', function ($utenti) {
            $button = '<div class="row">' .
                        '<div class="col-sm-4">' .
                        '<a href="utenti/' . $utenti->id . '/edit" id="'. $utenti->id .'" class="btn btn-action btn-primary btn-modifica">Modifica</a>' .
                        '</div>';
            $button .=   '<div class="row">' .
                        '<div class="col-sm-4">' .
                        '<button id="'. $utenti->id .'" class="btn btn-action btn-danger btn-elimina">Elimina</button>' .
                        '</div>';

            return $button;
        })
        ->editColumn('ruolo',function ($utenti){
            $ruoli="";
            if($utenti->role_id == 1)
            {
                $ruoli .= "Admin ";
            }
            if($utenti->role_id == 2)
            {
                $ruoli .= "Gestore ";
            }
            if($utenti->role_id == 4)
            {
                $ruoli .= "Committente ";
            }
            if($utenti->role_id == 5)
            {
                $ruoli .= "Utente ";
            }

            return $ruoli;
        })
        ->editColumn('diritti',function ($utenti){
            return ucfirst($utenti->diritti);
        })
        ->filterColumn('ruolo', function ($query) use ($request) {
            $keyword = str_replace(' ','%',request()->search['value']);
            $role_id = "";
            if(levenshtein(strtolower($keyword),'admin') < 2)
            {
                $role_id = 1;
            }
            if(levenshtein(strtolower($keyword),'gestore') < 3)
            {
                $role_id = 2;
            }
            if(levenshtein(strtolower($keyword),'committente') < 4)
            {
                $role_id = 4;
            }
            if(levenshtein(strtolower($keyword),'utente') < 3)
            {
                $role_id = 5;
            }
            if(levenshtein(strtolower($keyword),'rilevatore') < 4)
            {
                $role_id = 3;
            }
            $query->where('role_id', 'like', "%" . $role_id . "%");   
        })
        ->filterColumn('uid', function ($query) use ($request) {
            $keyword = request()->search['value'];            
            $query->where('users.uid', 'like', $keyword);   
        })
        ->filterColumn('nome', function ($query) use ($request) {
            $keyword = request()->search['value'];            
            $query->where('users.nome', 'like', $keyword);   
        })
        ->filterColumn('cognome', function ($query) use ($request) {
            $keyword = request()->search['value'];            
            $query->where('users.cognome', 'like', $keyword);   
        })
        ->filterColumn('email', function ($query) use ($request) {
            $keyword = request()->search['value'];            
            $query->where('users.email', 'like', $keyword);   
        })
        ->filterColumn('diritti', function ($query) use ($request) {
            $keyword = request()->search['value'];            
            $query->where('users.diritti', 'like', $keyword);   
        })
        ->rawColumns(['pulsante','ruolo','uid','nome','cognome','email','diritti'])
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => ['required', Rule::unique('users')->whereNull('deleted_at')],
            'diritti' => 'required'
            //'email' => 'unique:users|email:rfc,dns',
        ]);

        if ($validator->fails()) 
        {
            return response()->json(['error' => 'Errore: dati non validi'], 403);
        }
        
        /**
         * Creazione e salvataggio utente
         */
        $user = new User();

        $user->nome = $request->nome;
        $user->cognome = $request->cognome;
        $user->email = isset($request->email) ? $request->email : null;
        $user->password = Hash::make($request->password);
        $user->uid = $request->uid;
        $user->email_verified_at = Carbon::now();
        $user->diritti = $request->diritti;
        //$user->path_firma = $newname;
        $user->rememberToken = "NULL";
        $user->progetto = isset($request->progetto) && $request->progetto != 0 ? $request->progetto : 0;
        $user->save();

        /**
         * Assegnamento ruolo ad utente
         */
        $ruolo = Defender::findRole($request->ruolo);
        $user->attachRole($ruolo);

        LoggerEvent::log(auth()->user()->id,"Creato nuovo utente",$request->all(),false);
        return json_encode('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $utenti = DB::table('users')->join('role_user', 'users.id', 'role_user.user_id');
        $utenti = $utenti->join('roles', 'roles.id', 'role_user.role_id');
        //$utenti = $utenti->select(['users.id','users.uid','users.nome','users.cognome','users.email','roles.name','users.path_firma']);
        $utenti = $utenti->select(['users.id','users.uid','users.nome','users.cognome','users.email','roles.name','users.diritti','users.progetto']);

        $user = $utenti->where('users.id', $id)->first();
        if ($user != null) {
            $dati = [];
            $dati['id'] = $user->id;
            $dati['nome'] = $user->nome;
            $dati['cognome'] = $user->cognome;
            $dati['email'] = $user->email;
            $dati['uid'] = $user->uid;
            $dati['ruolo'] = $user->name;
            $dati['progetto'] = $user->progetto;
            $dati['diritti'] = $user->diritti;

            return view('utenti.modifica_utente', compact('dati'));
        } else {
            return '';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $user = User::find($id);

        $user->nome = $request->nome ?? $user->nome;
        $user->cognome = $request->cognome ?? $user->cognome;
        $user->email = $request->email ?? $user->email;
        $user->progetto = $request->progetto ?? $user->progetto;
        
        
        /**
         * Assegnamento ruolo ad utente
         */
        if (isset($request->ruolo)) {
            $utenti = DB::table('users')->join('role_user', 'users.id', 'role_user.user_id');
            $utenti = $utenti->join('roles', 'roles.id', 'role_user.role_id');
            $utenti = $utenti->select(['users.id','users.uid','users.nome','users.cognome','users.email','roles.name']);
            $userFound = $utenti->where('users.id', $id)->first();

            $newRuolo = Defender::findRole(strtolower($request->ruolo));
            $oldRuolo = Defender::findRole(strtolower($userFound->name));

            $user->detachRole($oldRuolo);
            $user->attachRole($newRuolo);
        }
        if(isset($request->diritti))
        {
            $user->diritti = $request->diritti;
        }
        $user->save();
        
        if($newRuolo != null)
        {
            $result = [
                'nome' => $user->nome,
                'cognome' => $user->cognome,
                'email' => $user->email,
                'password' => $user->password,
                'ruolo' => $newRuolo->name,
                'diritti' => $user->diritti,
            ];
        }
        else
        {
            $result = [
                'nome' => $user->nome,
                'cognome' => $user->cognome,
                'email' => $user->email,
                'password' => $user->password,
                'ruolo' => null,
                'diritti' => $user->diritti,
            ];
        }
        

        LoggerEvent::log(auth()->user()->id, "Modifica utente", $request->all(), true);
        return json_encode($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($request->id);
        if ($user != null) {
            $user->delete();
            LoggerEvent::log(auth()->user()->id, "Eliminazione utente", $id, true);
        }

        return json_encode("Eliminato");
    }
}
