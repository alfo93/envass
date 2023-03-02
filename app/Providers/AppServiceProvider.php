<?php

namespace App\Providers;

use App\Segnalazione;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // invia tutte le segnalazioni attive alla topbar
         View::composer('layouts.topbar', function ($view) {
            $view->with('segnalazioni', Segnalazione::where('controllato', '0')->latest('data')->get());
        });

        // invia token e uid alla lsidebar
        View::composer('layouts.lsidebar', function ($view) {
            $token = base64_encode(date('YmdHi') . 'abcdefghilmnopqrstuvz');
            //$uid = Auth::user()->Nome_utente;
            $uid = Auth::user();

            $view->with(compact('token', 'uid'));
        });

        Validator::extend('uniqueCombo', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0])
                ->where($attribute, '=', $value)
                ->where($parameters[1], '=', request($parameters[1]));
                
            if(isset($parameters[2]))
            {
                $query = $query->where($parameters[2], '=', request($parameters[2]));
            }

            if (isset($parameters[3])) {
                $query = $query->where($parameters[3], '=', request($parameters[3]));
            }

            if (isset($parameters[4])) {
                $query = $query->where($parameters[4], '=', request($parameters[4]));
            }
            
            return ($query->count() <= 0);

           
        });

        Validator::extend('uniqueComboIgnore', function ($attribute, $value, $parameters, $validator) {
            $param_count = count($parameters);
            $query = DB::table($parameters[0])
                ->where($attribute, '=', $value)
                ->where($parameters[1], '=', request($parameters[1]));

            if ($param_count > 2) {
                for ($i = 2; $i < $param_count - 1; $i++) {
                    $query = $query->where($parameters[$i], '=', request($parameters[$i]));
                }

                $query = $query->where('id', '!=', request($parameters[$param_count - 1]));
            }

            // Log::info(DB::getQueryLog());
            return ($query->count() <= 0);
        });

        Validator::extend('unify', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0]);
            $param = $parameters[1] . " " . $parameters[2];

            if ($param != "") {
                $query = $query->where($attribute, $param);
            }
            
            return ($query->count() <= 0);
        });

    }
}
