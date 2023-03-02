<?php

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
   return view('home');
})->name('home');*/

/**
 * @var Router
 */
$router = app('router');

/**
 * Authenticazione
 */
Auth::routes();


$router->get('logout', 'Auth\LoginController@logout')->name('logout');
$router->post('login', 'Auth\LoginController@authenticate');
$router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
/**
 * Shiboleth
 */
// $router->get('login/callback', 'Auth\LoginController@shibbolethAuthCallback');
// $router->get('login/error', 'Auth\LoginController@shibbolethAuthError');



$router->get('/', 'HomeController@index')->name('home');
$router->get('bye', 'HomeController@bye')->name('bye');

$router->group(['middleware' => ['auth', 'needsPermission:antibiotici.store']], function (Router $router) {
    /**
     * GestioneInterna
     */
    $router->get('/gestioneinterna/create','GestioneInternaController@create');
    $router->get('/gestioneinterna/getId','GestioneInternaController@getId');

    /**
     * Antibiotici
     */
    $router->post('/antibiotico','AntibioticoController@store');
    $router->post('/antibiotico/{idOption}','AntibioticoController@destroy');
    $router->post('/antibiotico/update/{id}','AntibioticoController@update');

    /**
     * Materiali
     */
    $router->post('/materiale','MaterialeController@store');
    $router->post('/materiale/{id}','MaterialeController@destroy');
    $router->post('/materiale/update/{id}','MaterialeController@update');  
    
    
    /**
     * Categorie
     */
    $router->post('/categoria','CategoriaController@store');
    $router->post('/categoria/{id}','CategoriaController@destroy');
    $router->post('/categoria/update/{id}','CategoriaController@update'); 
    $router->get('/categoria/{id}/getPC','CategoriaController@getPC');

    /**
     * Prodotti
     */
    $router->post('/prodotto','ProdottoController@store');
    $router->post('/prodotto/{id}','ProdottoController@destroy');
    $router->post('/prodotto/update/{id}','ProdottoController@update'); 

    /**
    * Protocolli
    */
    $router->post('/protocollo','ProtocolloController@store');
    $router->post('/protocollo/{id}','ProtocolloController@destroy');
    $router->post('/protocollo/update/{id}','ProtocolloController@update'); 

    /**
    * PuntiCampionamento
    */
    $router->post('/puntocampionamento','PuntoCampionamentoController@store');
    $router->post('/puntocampionamento/{id}','PuntoCampionamentoController@destroy');
    $router->post('/puntocampionamento/update/{id}','PuntoCampionamentoController@update');  
    
    /**
    * Struttura
    */
    $router->resource('strutture','StrutturaController')->only(['index','create']);
    $router->post('/strutture','StrutturaController@store');
    $router->post('/strutture/{id}','StrutturaController@destroy');
    $router->post('/strutture/update/{id}','StrutturaController@update'); 

    /**
    * Reparti
    */
    $router->post('/reparto','RepartoController@store');
    $router->post('/reparto/{id}','RepartoController@destroy');
    $router->post('/reparto/update/{id}','RepartoController@update');
    $router->get('/reparto/getReparti','RepartoController@getReparti');
    $router->get('/reparto/getReparto','RepartoController@getReparto');

    /**
    * Stanza
    */
    $router->post('/stanza','StanzaController@store');
    $router->post('/stanza/{id}','StanzaController@destroy');
    $router->post('/stanza/update/{id}','StanzaController@update');

    /**
    * TipoPiastra
    */
    $router->post('/tipopiastra','TipoPiastraController@store');
    $router->post('/tipopiastra/{id}','TipoPiastraController@destroy');
    $router->post('/tipopiastra/update/{id}','TipoPiastraController@update');

    /**
     * StruttRep
     */
    $router->post('/struttrep','StruttRepController@store');
    $router->post('/struttrep/{id}','StruttRepController@destroy');
    $router->post('/struttrep/update/{id}','StruttRepController@update');

    /**
     * MicrorganismiPiastre
     */
    $router->post('/microrganismopiastra','MicrorganismoPiastraController@store');
    $router->post('/microrganismopiastra/{id}','MicrorganismoPiastraController@destroy');
    $router->post('/microrganismopiastra/update/{id}','MicrorganismoPiastraController@update');

    /**
     * MicroPiastra
     */
    $router->post('/micropiastra','MicroPiastraController@store');
    $router->post('/micropiastra/{id}','MicroPiastraController@destroy');
    $router->post('/micropiastra/update/{id}','MicroPiastraController@update');

    /**
     * Area Partizione
     */
    $router->get('/getAreaPart','AreaPartizioneController@getAreaPart');
    // $router->get('/arepartizione/get','AreaPartizioneController@get');
});

    /**
     * Rotte ausiliari strutture
     */
    $router->get('/strutture/getDataOfStrutture','StrutturaController@getDataOfStruttura');
    $router->get('/strutture/getStrutture','StrutturaController@getStrutture');


    /**
     * Rotte Segnalazioni
     */
    $router->resource('segnalazioni', 'SegnalazioneController')->only(['index', 'update']);
    $router->get('/segnalazioni/list', 'SegnalazioneController@list');
    // $router->get('/segnalazioni/{id}', 'SegnalazioneController@vediPDF');
    // $router->post('/segnalazioni/{id}', 'SegnalazioneController@movePDF');

    /**
     * Rotte per Utenti
     */
    $router->group(['middleware' => ['auth', 'needsPermission:users.index']], function (Router $router) {
        $router->group(['middleware' => ['auth', 'needsPermission:users.create']], function (Router $router) {
            $router->resource('utenti', 'UserController')->only(['index','create']);
            $router->post('/utenti', 'UserController@store');
            $router->get('/utenti/list', 'UserController@list');
            $router->post('/utenti/{id}/delete', 'UserController@destroy');
            $router->get('/utenti/{id}/edit', 'UserController@edit');
            $router->post('/utenti/{id}', 'UserController@update');

            /**
             * Rotte rilevatori
             */
            $router->get('/rilevatori','RilevatoreController@index');
            $router->get('/rilevatori/create','RilevatoreController@create');
            $router->get('/rilevatori/list/{id_progetto}/{interno}','RilevatoreController@list');
            $router->get('/rilevatori/{id_progetto}/getStruttureProgetto','RilevatoreController@getStruttureProgetto');
            $router->post('/rilevatori/store','RilevatoreController@store');
            $router->post('/rilevatori/update','RilevatoreController@update');
            $router->post('/rilevatori/delete','RilevatoreController@destroy');
            $router->get('/rilevatori/{id}/getData','RilevatoreController@getData');
        });
    });
    
    /**
     * Rotte Eventi Log
     */
    $router->group(['middleware' => ['auth', 'needsPermission:log_envass.index']], function (Router $router) {
        $router->resource('logeventi', 'LogEventController')->only(['index']);
        $router->get('/logeventi/list', 'LogEventController@list');
        $router->get('/logeventi/{id}', 'LogEventController@getDati');
        $router->get('/logeventi/view/filterData','LogEventController@filterData');
        $router->get('/logeventi/view/list_filter/{id_rdp}','LogEventController@list_filter');
    });

    /**
     * Rotte Campioni
     */
    $router->resource('campioni', 'CampioneController')->except(['create','store', 'show','destroy','update','index','edit']);
    $router->group(['middleware' => ['auth', 'needsPermission:campioni.edit']], function (Router $router) {
        $router->get('/campioni/{id}/{id_campagna}/{tipo}/edit','CampioneController@edit');
        $router->get('/campionianalisimolecolare/{id}/{id_campagna}/edit','CampioneAnalisiMolecolareController@edit'); //CampioniAnalisiMolecolari
        $router->post('/microsupiastra/getMicro','MicroSuPiastraController@getMicro');
        $router->get('/microrganismopiastra/group','MicrorganismoPiastraController@getGroup');
        $router->get('/micropiastra/getMicro','MicroPiastraController@getMicro');
        $router->get('/reparto/areapartizione','AreaPartizioneController@getAll');

        /**Speciazione */
        $router->post('/speciazione/getMicro','SpeciazioneCampioneController@getMicroSpeciazione');
        $router->post('/speciazione/delete','SpeciazioneCampioneController@destroy');


    });
    $router->group(['middleware' => ['auth', 'needsPermission:campioni.index']], function (Router $router) {
        $router->get('/campioni/list/{id_campagna}/{tipo}', 'CampioneController@list');
        $router->get('/campioni','CampioneController@index')->name('index');
        $router->get('/campioni/{progetto}/{id_campagna}', 'CampioneController@getDatiGrafici');
    });
    $router->group(['middleware' => ['auth', 'needsPermission:campioni.store']], function (Router $router) {
        $router->post('/campioni/unlock','CampioneController@unlock');
        $router->get('/campioni/nuovo','CampioneController@create');
        // $router->get('/genera_rapporto','CampioneController@createRapportoProva');
        $router->post('/campioni','CampioneController@store');
        $router->get('/campioni/nuovascheda/{numeroProgressivo}/{id_campionamento}/{tipo}','CampioneController@next_scheda');
        /**
        * Rotte Microrganismi
        */
        $router->post('/microsupiastra','MicroSuPiastraController@store');
        $router->post('/microsupiastra/delete','MicroSuPiastraController@destroy');
        /**
         * Rotte Immagini
         */
        $router->post('/immaginipiastre','ImmaginiPiastreController@store');
        $router->post('/immaginipiastre/delete','ImmaginiPiastreController@destroy');
        Route::get('/immaginipiastre/{filename}/{id_campione}', function ($filename,$id)
        {
            $path = storage_path() . "/app/public/$id/" . $filename;
            if(!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        })->name('immaginipiastre');
        $router->post('/immaginipiastreswab','ImmaginiPiastreSwabController@store');
        $router->post('/immaginipiastreswab/delete','ImmaginiPiastreSwabController@destroy');


        Route::get('/immaginiswabpiastre/{id_campione}/{filename}', function ($id,$filename)
        {
            $path = storage_path() . "/app/public/campionianalisimolecolare/$id/" . $filename;
            if(!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        })->name('immaginiswabpiastre');

        Route::get('/planimetrie_anteprima/{id}/{filename}',function($id,$filename){
            $path = storage_path() . "/app/public/planimetrie/$id/" . $filename;
            if(!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        })->name('planimetria_anteprima');

        /**
         * Rotte Immagini Temporanee
         */
        Route::get('/immaginitemporaneepiastre/{filename}', function ($filename)
        {
            $path = storage_path() . '/app/public/temporary/' . $filename;
            if(!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        })->name('immaginitemporaneepiastre');

    
        /**
         * Rotte Antibiogrammi
         */
        $router->post('/immaginiantibiogramma','ImmagineMicroAntibiogrammaController@store');
        $router->post('/immaginiantibiogramma/delete','ImmagineMicroAntibiogrammaController@destroy');
        Route::get('/immaginiantibiogramma/{filename}/{id_campione}', function ($filename,$id)
        {
            $path = storage_path() . "/app/public/$id/antibiogrammi/$filename";
            if(!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        })->name('immaginiantibiogramma');
        $router->post('/microantibiogramma/delete','MicroAntibiogrammaController@destroy');

        $router->post('/immaginiantibiogrammaswab','ImmagineMicroAntibiogrammaSwabController@store');
        Route::get('/immaginiantibiogrammaswab/{filename}/{id_campione}', function ($filename,$id)
        {
            $path = storage_path() . "/app/public/campionianalisimolecolare/$id/antibiogrammi/$filename";
            if(!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        })->name('immaginiantibiogrammaswab');
        $router->post('/microantibiogrammaswab/delete','MicroAntibiogrammaSwabController@destroy');


        /**
         * Rotte AntibioticiAntibiogrammi
         */
        $router->post('/antibioticiantibiogrammi/delete','AntibioticoAntibiogrammaController@destroy');
    });

    $router->group(['middleware' => ['auth', 'needsPermission:campioni.update']], function (Router $router) {
        $router->post('/campioni/{id}/update','CampioneController@update');
    });
    $router->group(['middleware' => ['auth', 'needsPermission:campioni.destroy']], function (Router $router) {
        $router->post('/campioni/{id}/delete','CampioneController@destroy');
    });

    /**
     * Rotte Campioni Analisi Molecolari
     */
    $router->group(['middleware' => ['auth', 'needsPermission:campioni_analisi_molecolari.store']], function (Router $router) {
        $router->get('/campionianalisimolecolare/{id_campagna}/nuovomolecolari','CampioneAnalisiMolecolareController@create');
        $router->post('/campionianalisimolecolare/storemolecolari','CampioneAnalisiMolecolareController@store');
         /**
         * Rotte MicroSuPiastraSWAB
         */
        $router->post('/microsupiastraswab/delete','MicroSuPiastraSwabController@destroy');
    });
    $router->group(['middleware' => ['auth', 'needsPermission:campioni_analisi_molecolari.update']], function (Router $router) {
        $router->post('/campionianalisimolecolare/{id}/update','CampioneAnalisiMolecolareController@update');
    });
    $router->group(['middleware' => ['auth', 'needsPermission:campioni_analisi_molecolari.destroy']], function (Router $router) {
        $router->post('/campionianalisimolecolare/{id}/delete','CampioneAnalisiMolecolareController@destroy');
    });

    /**
     * Rotte Campagne
     */
    $router->group(['middleware' => ['auth', 'needsPermission:campagna.index']], function (Router $router) {
        $router->get('/campagna','CampagnaController@index');
        $router->get('/campagna/list/{societa}/{struttura}/{progetto}/{dataCampagna}','CampagnaController@list');
        $router->get('/campagna/{id}/edit','CampioneController@index'); //chiamo la index per quel sottogruppo di campioni appartenenti alla campagna che sto aprendo

    });
    $router->group(['middleware' => ['auth', 'needsPermission:campagna.store']], function (Router $router) {
        $router->post('/campagna/store','CampagnaController@store');
    });

    /**
     * Rotte ausiliari Campagne
     */
    $router->get('/campagna/{id}/getData','CampagnaController@getProgettiSocieta');
    $router->get('/campagna/{id_progetto}/{id_societa}/getStruttureProgetto','CampagnaController@getStruttureProgetto');
    $router->get('/campagna/{id_societa}/{id_progetto}/{id_struttura}/getStruttureReparti','CampagnaController@getStruttureReparti');
    $router->get('/campagna/{reparto}/areapartizione','CampagnaController@getAreaPartizione');

    /**
     * Rotte rapporto di prova
     */
    $router->get('/rapportodiprova/genera','RapportoRelazioneController@createDocumento');
    $router->post('/rapportodiprova/pdf','RapportoRelazioneController@generaPDF');
    $router->get('/rapportodiprova/genera_da_committente','RapportoRelazioneController@createDocumento_committente');
    $router->post('/rapportodiprova/pdf_committente','RapportoRelazioneController@generaPDF_committente');
    $router->post('/rapportodiprova/firma', 'RapportoRelazioneController@gestisciFirma');
    $router->get('/rapportodiprova/crearev','RapportoRelazioneController@creaRev');

    /**
     * Rotte per metodi
     */
    $router->get('/metodo/{id_metodo}/getValues','MetodoController@getValues');


    /**
     * Rotte Societa (Clienti)
     */
    $router->group(['middleware' => ['auth', 'needsPermission:societa.index']], function (Router $router) {
        $router->resource('societa', 'SocietaController')->only(['index','create']);
        $router->group(['middleware' => ['auth', 'needsPermission:societa.store']], function (Router $router) {
            $router->post('/societa','SocietaController@store');
        });
        $router->get('/societa/list','SocietaController@list');
        $router->group(['middleware' => ['auth', 'needsPermission:societa.destroy']], function (Router $router) {
            $router->post('/societa/{id}','SocietaController@destroy');
        });
        $router->get('/societa/{id}','SocietaController@getCliente');
        $router->group(['middleware' => ['auth', 'needsPermission:societa.update']], function (Router $router) {
            $router->post('/societa/{id}/modifica','SocietaController@update');
        });

        Route::get('/committenti/{file}/view', function ($filename)
        {
            $path = storage_path() . "/app/public/contratti/$filename";
            if(!File::exists($path)) abort(404);

            return response()->file($path);
        });
    });

    /**
     * Rotte Progetti (Progetti)
     */
    $router->group(['middleware' => ['auth', 'needsPermission:progetti.index']], function (Router $router) {
        $router->resource('progetti', 'ProgettoController')->only(['index','create']);
        $router->get('/progetti/list','ProgettoController@list');
        $router->group(['middleware' => ['auth', 'needsPermission:progetti.store']], function (Router $router) {
            $router->post('/progetti','ProgettoController@store');
        });
        $router->group(['middleware' => ['auth', 'needsPermission:progetti.destroy']], function (Router $router) {
            $router->post('/progetti/{id}','ProgettoController@destroy');
        });
        $router->get('/progetti/{id}','ProgettoController@getProgetto');
        $router->group(['middleware' => ['auth', 'needsPermission:progetti.update']], function (Router $router) {
            $router->post('/progetti/{id}/modifica','ProgettoController@update');
        });
    });
    $router->get('/progetti/{progetto}/getData','ProgettoController@getDataOfProgetto');
   

    /**
     * Rotte ausiliari StruttRep
     */
    $router->resource('struttrep','StruttRepController')->only(['index','create']);
    $router->get('struttrep/getCodice','StruttRepController@getCodice');
    $router->get('struttrep/reparti/getReparto','StruttRepController@getReparto');
    $router->get('struttrep/{id_progetto}/{id_struttura}/getReparto','StruttRepController@getReparto');
    $router->get('struttrep/{id_progetto}/getStruttura','StruttRepController@getStruttura');


    /**
    * Rotte Procedure 
    */
    $router->group(['middleware' => ['auth', 'needsPermission:eprocedure.index']], function (Router $router) {
        $router->get('/procedure','ProceduraController@index')->name('procedure');
        $router->get('/procedure/list','ProceduraController@list');
        $router->group(['middleware' => ['auth', 'needsPermission:eprocedure.store']], function (Router $router) {
            $router->get('/procedure/create','ProceduraController@create');
            $router->post('procedure/store','ProceduraController@store');
        });
        $router->group(['middleware' => ['auth', 'needsPermission:eprocedure.destroy']], function (Router $router) {
            $router->post('/procedure/{id}','ProceduraController@destroy');
        });
        $router->group(['middleware' => ['auth', 'needsPermission:eprocedure.update']], function (Router $router) {
            $router->get('/procedure/edit','ProceduraController@edit');
            $router->post('/procedure/{id}/edit','ProceduraController@update');
        });
        Route::get('/procedure/{file}/view', function ($filename)
        {
            $path = storage_path() . "/app/public/procedure/$filename";
            if(!File::exists($path)) abort(404);

            return response()->file($path);
        });
    });

    /**
     * Rotte Relazioni Rapporti
     */
    $router->group(['middleware' => ['auth', 'needsPermission:rapp_rel.index']], function (Router $router) {

        $router->get('/rapprel','RapportoRelazioneController@index')->name('rapportirelazioni');  
        $router->get('/rapprel/list/{progetto}/{struttura}/{reparto}','RapportoRelazioneController@list');

        $router->group(['middleware' => ['auth', 'needsPermission:rapp_rel.store']], function (Router $router) {
            $router->get('/rapprel/uploadRapporto','RapportoRelazioneController@create');
            $router->post('/rapprel/storeRapporto','RapportoRelazioneController@store');
        });

        $router->get('/rapprel/{id_progetto}/getStruttureProgetto','RapportoRelazioneController@getStruttureProgetto');
        $router->get('/rapprel/{id_progetto}/{struttura}/getStruttureReparti','RapportoRelazioneController@getStruttureReparti');

        $router->group(['middleware' => ['auth', 'needsPermission:rapp_rel.destroy']], function (Router $router) {
            $router->post('/rapprel/{id}','RapportoRelazioneController@destroy');
        });

        $router->group(['middleware' => ['auth', 'needsPermission:rapp_rel.sendEmail']], function (Router $router) {
            $router->post('/rapprel/{id}/sendemail/committente','RapportoRelazioneController@sendEmailCommittente');
            $router->post('/rapprel/{id}/sendemail/dir','RapportoRelazioneController@sendEmailDir');
            $router->post('/rapprel/{id}/sendemail/approva','RapportoRelazioneController@sendEmailApprovazione');
        });

        Route::get('/rapprel/{file}/view', function ($filename)
        {
            $path = storage_path() . "/app/public/rapporti_relazioni/$filename";
            if(!File::exists($path)) abort(404);

            return response()->file($path);
        });

        $router->post('/planimetrie_anteprime/delete','PlanimetriaRdpAnteprimaController@destroy');
    });

// /**
//  * Admin
//  */
// Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {    

//     $router = app('router');
//     $router->group(['middleware' => 'auth'], function (Router $router) {

//         // Rotta per la Dashboard (Home)
//         $router->get('/', 'Admin\HomeController@index')->name('home');
//         $router->post('proposal/list', 'Admin\HomeController@proposalList');

//         /**
//          * Rotte per Utenti
//          */
//         $router->group(['middleware' => ['auth', 'needsRole:admin']], function (Router $router) {        
//             $router->resource('utenti', 'Admin\UserController')->except(['show']);
//             $router->get('utenti/list', 'Admin\UserController@list');
//         });
//     });
// });
