@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>Gestione Utenti
            <small>Crea un nuovo utente del sistema ENVASS</small>
        </h2>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Crea utente</h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label for="nome_utente">Nome</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="nome_utente" class="form-control" name="name" aria-required="true" placeholder="nome" required>
                                        </div>
                                        <div class="help-info">Nome dell'utente</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label for="cognome_utente">Cognome</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="cognome_utente" class="form-control" name="surname" aria-required="true" placeholder="cognome" required>
                                        </div>
                                        <div class="help-info">Cognome dell'utente</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label for="uid_utente">User ID</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="uid_utente" class="form-control" name="uid" aria-required="true" placeholder="uid" required>
                                        </div>
                                        <div class="help-info">uid dell'utente</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="email_utente">E-mail</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="email" id="email_utente" class="form-control" name="email" aria-required="true" placeholder="E-mail" required>
                                        </div>
                                        <div class="help-info">Recapito elettronico dell'utente</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="password_utente">Password</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" id="password_utente" class="form-control" name="password" aria-required="true" placeholder="password" required>
                                        </div>
                                        <div class="help-info">Password dell'utente</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label for="ruolo_utente">Ruolo</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="ruolo_utente" data-size="7">
                                                @foreach (App\User::ruoli() as $ruoli)
                                                        <option data-option="{{ $ruoli }}" value="{{ $ruoli }}">{{ $ruoli }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="help-info">Ruolo dell'utente</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label for="diritti_utente">Diritti</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="diritti_utente" data-size="7">
                                                @foreach (App\User::diritti() as $key => $diritti)
                                                        <option data-option="{{ $diritti }}" value="{{ $key }}">{{ $diritti }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="help-info">Diritti dell'utente</div>
                                    </div>
                                </div>
                                <div id="progetto_committente" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label for="prog_comm">Attività</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="prog_comm" data-size="7">
                                                <option data-option="" value="0">Nessuna attività</option>
                                                @foreach (App\Progetto::all() as $progetto)
                                                        <option data-option="{{ $progetto->progetto }}" value="{{ $progetto->id }}">{{ $progetto->progetto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="help-info">Attività associata all'utente</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <button class="btn btn-lg btn-primary waves-effect mt-2" id="aggiungi_utente" type="submit" style="text-align: center">Crea utente</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $( document ).ready(function() {
        $('input').attr('autocomplete','chrome-off');
    });    

    $('#aggiungi_utente').bind('click', function(event) {
        event.preventDefault();
        var nome = $('#nome_utente').val();
        var cognome = $('#cognome_utente').val();
        var email = $('#email_utente').val();
        var password = $('#password_utente').val();
        var uid = $('#uid_utente').val();
        var ruolo = $('select option:selected').val(); 
        var progetto = $('#prog_comm option:selected').val();
        var diritti = $('#diritti_utente option:selected').val();
        swal({
            title: "Sei sicuro?",
            text: "Vuoi creare il nuovo utente " + nome + " " + cognome + "?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#8CD4F5",
            confirmButtonText: "Si, procedi",
            cancelButtonText: "No, annulla",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/utenti",
                    type: "post",
                    dataType: "json",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        nome: nome,
                        cognome: cognome,
                        email: email,
                        password: password,
                        uid: uid,
                        ruolo: ruolo,
                        progetto:progetto,
                        diritti:diritti
                    },
                    success: function(data) {
                        window.location.href="/utenti";
                    }, 
                    error: function(response, stato) {
                        swal.close();
                        showNotification('alert-danger', response.responseJSON.error, 'top', 'right', null, null);
                    }
                });
            } else {
                swal("Annullato", "L'operazione è stata annullata", "info");
            }
        });
    });
</script>
@endsection