<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use App\Ruolo;
use App\User;
use Validator;
use Defender;
use DB;
use Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Ritorna il contenuto della DataTable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function list(Request $request)
    {
        $utenti = DB::table('users')->join('role_user', 'users.id', 'role_user.user_id')
                                    ->join('roles', 'roles.id', 'role_user.role_id')
                                    ->select(['users.id', 'users.name as username', 'users.email', 'roles.name as rolename']);
                
        return DataTables::of($utenti)
            ->addColumn('actions', function ($utenti) {
                $button = '<span class="mr-1"><a href="utenti/' . $utenti->id . '/edit" id="'. $utenti->id .'" class="btn waves-effect btn-primary">Modifica</a></span>';
                $button .= '<span class="mr-1"><button id="'. $utenti->id .'" class="btn waves-effect btn-danger btn-elimina">Elimina</button></span>';

            return $button;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|string|unique:users|max:255',
            'password'  => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.utenti.create')->withErrors($validator)->withInput();
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        /**
         * Assegnamento ruolo ad utente
         */
        $role = Defender::findRole($input['role']);
        $user->attachRole($role);
        
        return view('user.index');
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
        $user = User::find($id);

        return view('user.edit', compact('user'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255',
            'password' => 'nullable|sometimes|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('utenti.edit', $id)->withErrors($validator)->withInput();
        }

        $input = $request->all();

        // Verifico se la password è da aggiornare
        if ($input['password'] && strlen($input['password']) > 0) {
            $input['password'] = Hash::make($input['password']);
       
        } else {
            unset($input['password']);
        }

        $user = User::find($id);
        $user->update($input);

        /**
         * Assegnamento ruolo ad utente
         */
        $role = Defender::findRole($input['role']);
        $user->attachRole($role);

        return redirect()->route('admin.utenti.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
        }

        return self::makeJsonResponse([], 200, "Utente eliminato");
    }
}
