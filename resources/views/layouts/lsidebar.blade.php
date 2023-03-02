@php
/**
 * @category	Layout file
 * @version    	1.0
 * @see        	https://github.com/gurayyarar/AdminBSBMaterialDesign
 * @see			https://gurayyarar.github.io/AdminBSBMaterialDesign/index.html
 * @see 		https://getbootstrap.com/docs/3.3/
 */	
@endphp

<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="/images/user.png" width="48" height="48" alt="User" />
        </div>
        @if (Auth::user() != null)
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Ciao <span class="name">{{ Auth::user()->uid }}</span>! </div>
            <div class="email">Hai effettuato il login come: <span class="username">{{  Auth::user()->diritti }} </span><br/> 
            Il tuo ruolo è: 
            @foreach (Auth::user()->roles as $role) 
                <span class="role" id="{{ $role['name'] }}">{{ $role['name'] }}</span>
            @endforeach</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{ url('/logout') }}"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
        @else
        {{ $home = new App\Http\Controllers\HomeController() }}
        {{ $home->bye() }}
        @endif
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MENU PRINCIPALE</li>
            @is(['admin','gestore','committente','utente'])
            <li class="{{ is_section_active(['home']) ? 'active' : '' }}">
                <a href="{{ URL::action('HomeController@index') }}">
                    <i class="material-icons">home</i>
                    <span>Home</span>
                </a>
            </li>
            @endis
            @is(['admin','gestore'])
            <li class="{{ is_section_active(['clienti']) ? 'active' : '' }}">
                <a href="{{ URL::action('SocietaController@index') }}">
                    <i class="material-icons">business</i>
                    <span>Committenti</span>
                </a>
            </li>
            @endis
            @is(['admin','gestore'])
            <li class="{{ is_section_active(['progetti']) ? 'active' : '' }}">
                <a href="{{ URL::action('ProgettoController@index') }}">
                    <i class="material-icons">card_travel</i>
                    <span>Attività e Monitoraggi</span>
                </a>
            </li>
            @endis
            @is(['admin','gestore','committente','utente'])
            <li class="{{ is_section_active(['schede']) ? 'active' : '' }}">
                <a href="{{ URL::action('CampagnaController@index') }}">
                    <i class="material-icons">assignment</i>
                    <span>Campionamenti</span>
                </a>
            </li>
            @endis
            @is(['admin','gestore'])
            <li class="{{ is_section_active(['rilevatori']) ? 'active' : '' }}">
                <a href="{{ URL::action('RilevatoreController@index') }}">
                    <i class="material-icons">supervisor_account</i>
                    <span>Campionatori</span>
                </a>
            </li>
            @endis
            @is(['admin','gestore'])
            <li class="{{ is_section_active(['gestione_interna']) ? 'active' : '' }}">
                <a href="{{ URL::action('GestioneInternaController@create') }}">
                    <i class="material-icons">build</i>
                    <span>Gestione interna</span>
                </a>
            </li>
            @endis
            @is(['admin','gestore'])
            <li class="{{ is_section_active(['documenti']) ? 'active' : '' }}">
                <a href="{{ URL::action('ProceduraController@index') }}">
                    <i class="material-icons">library_books</i>
                    <span>Repository</span>
                </a>
            </li>
            @endis
            @is(['admin','gestore','committente'])
            <li>
                <!-- Le variabili token e uid sono generate all'interno di AppServiceProvider con View::composer -->
                <a href="{{ URL::action('RapportoRelazioneController@index') }}">
                    <i class="material-icons">description</i>
                    <span>Relazioni e rapporto di prova</span>
                </a>
            </li>
            @endis
            {{-- @is(['admin','gestore'])
            <li class="{{ is_section_active(['query']) ? 'active' : '' }}">
                <a href="">
                    <i class="material-icons">search</i>
                    <span>Query</span>
                </a>
            </li>
            @endis --}}
            @is(['admin','gestore'])
            <li class="{{ is_section_active(['logeventi']) ? 'active' : '' }}">
                <a href="{{ URL::action('LogEventController@index') }}">
                    <i class="material-icons">comment</i>
                    <span>Eventi</span>
                </a>
            </li>
            @endis
            @is(['admin','gestore'])
            <li class="{{ is_section_active(['utenti']) ? 'active' : '' }}">
                <a href=" {{ URL::action('UserController@index') }}">
                    <i class="material-icons">account_circle</i>
                    <span>Utenti</span>
                </a>
            </li>
            @endis
            {{-- @is(['admin'])
            <li class="{{ is_section_active(['filtro']) ? 'active' : '' }}">
                <a href="">
                    <i class="material-icons">subject</i>
                    <span>Tabelle filtro</span>
                </a>
            </li>
            @endis --}}
            {{-- @is(['admin'])
            <li class="{{ is_section_active(['segnalazioni']) ? 'active' : '' }}">
                <a href="{{ URL::action('SegnalazioneController@index') }}">
                    <i class="material-icons">add_alert</i>
                    <span>Segnalazioni</span>
                </a>
            </li>
            @endis --}}
           
            <!--li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">widgets</i>
                    <span>Widgets</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Cards</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/widgets/cards/basic.html">Basic</a>
                            </li>
                            <li>
                                <a href="pages/widgets/cards/colored.html">Colored</a>
                            </li>
                            <li>
                                <a href="pages/widgets/cards/no-header.html">No Header</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Infobox</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/widgets/infobox/infobox-1.html">Infobox-1</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-2.html">Infobox-2</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-3.html">Infobox-3</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-4.html">Infobox-4</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-5.html">Infobox-5</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li-->

            <!--li class="header">LABELS</li>
            <li>
                <a href="javascript:void(0);">
                    <i class="material-icons col-light-blue">donut_large</i>
                    <span>Information</span>
                </a>
            </li-->
        </ul>
    </div>
    <!-- #Menu -->

    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
        </div>
        <div class="version">
            <b>Version: </b> 2.0
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->
