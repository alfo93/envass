@php
/**
 * @category	Layout file
 * @version    	1.0
 * @see        	https://github.com/gurayyarar/AdminBSBMaterialDesign
 * @see			https://gurayyarar.github.io/AdminBSBMaterialDesign/index.html
 * @see 		https://getbootstrap.com/docs/3.3/
 */	
@endphp

<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" id="search-input" placeholder="INIZIA A SCRIVERE QUI...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->

<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{{ url('/') }}" style="padding: 0px;"><img src="{{ asset('images/twologo.png') }}" width="200px;"></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <!--<li><a href="javascript:void(0);" class="js-search" data-close="true">
                    <i class="material-icons">search</i></a>
                </li>-->
                <!-- #END# Call Search -->

                <!-- Notifications -->
                {{-- @is(['admin'])
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">notifications</i>
                        @if (count($segnalazioni))
                            <span id="segnalazioni-counter" class="label-count">{{ count($segnalazioni) }}</span>
                        @endif
                    </a>
                    <ul id="segnalazioni-dropdown" class="dropdown-menu">
                        <li class="header">SEGNALAZIONI</li>
                        <li class="body">
                            <ul id="segnalazioni-menu" class="menu">
                                @forelse ($segnalazioni as $s)
                                    <li id="{{ $s->id }}" class="segnalazione-dropdown">
                                        <a href="{{ URL::action('SegnalazioneController@index') }}">
                                            <div class="icon-circle bg-red">
                                                <i class="material-icons">warning</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>{{ App\Segnalazione::$titoli[$s->codice] }}</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> {{ format_date($s->data) }}
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="panel-body text-center small">Nessuna segnalazione da risolvere</li>
                                @endforelse
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="{{ URL::action('SegnalazioneController@index') }}">Vedi tutte</a>
                        </li>
                    </ul>
                </li>
                @endis --}}
                <!-- #END# Notifications -->
                
                <!-- Tasks -->
                <!--li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">flag</i>
                        <span class="label-count">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">TASKS</li>
                        <li class="body">
                            <ul class="menu tasks">
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Footer display issue
                                            <small>32%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Make new buttons
                                            <small>45%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Create new dashboard
                                            <small>54%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Solve transition issue
                                            <small>65%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Answer GitHub questions
                                            <small>92%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="javascript:void(0);">View All Tasks</a>
                        </li>
                    </ul>
                </li-->
                <!-- #END# Tasks -->

                <!--li class="pull-right">
                    <a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a>
                </li-->
            </ul>
        </div>
    </div>
</nav>
<!-- #END# Top Bar -->
