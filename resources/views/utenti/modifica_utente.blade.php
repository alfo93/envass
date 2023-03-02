@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>Gestione Utenti
            <small>Modifica l'utente per il sistema ENVASS</small>
        </h2>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Modifica utente</h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="nome">Nome</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="nome" class="form-control" name="nome"
                                                value="{{ old('nome') ?? $dati['nome'] ?? '' }}" maxlength="255">
                                        </div>
                                        <div class="help-info">Nome dell'utente</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Cognome</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="cognome" class="form-control" name="cognome"
                                                value="{{ old('cognome') ?? $dati['cognome'] ?? '' }}" maxlength="255">
                                        </div>
                                        <div class="help-info">Cognome dell'utente</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="email">Email</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="email" class="form-control" name="email"
                                                value="{{ old('email') ?? $dati['email'] ?? '' }}" maxlength="255">
                                        </div>
                                        <div class="help-info">email</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="uid_utente">User ID</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="uid_utente"  value="{{ old('uid_utente') ?? $dati['uid'] ?? '' }}" class="form-control" name="uid" aria-required="true" placeholder="uid" disabled>
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
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Ruolo</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" id="ruolo_utente" data-size="5">
                                                @foreach (App\User::ruoli() as $ruoli)
                                                        <option data-option="{{ $ruoli }}" value="{{ strtolower($ruoli) }}" {{ is_selected_option($dati['ruolo'], strtolower($ruoli)) }}>{{ $ruoli }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="help-info">Ruolo dell'utente</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label for="diritti_utente">Diritti</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="diritti_utente" data-size="7">
                                                @foreach (App\User::diritti() as $key => $diritti)
                                                        <option data-option="{{ $diritti }}" value="{{ $key }}" {{ is_selected_option( strtolower($dati['diritti']), strtolower($diritti)) }}>{{ $diritti }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="help-info">Diritti dell'utente</div>
                                    </div>
                                </div>
                                <div id="progetto_committente" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label for="prog_comm">Attività</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="prog_comm" data-size="7">
                                                <option data-option="" value="0">Nessuna attività</option>
                                                @foreach (App\Progetto::all() as $progetto)
                                                        <option data-option="{{ $progetto->progetto }}" value="{{ $progetto->id }}" {{ is_selected_option($dati['progetto'],$progetto->id) }}>{{ $progetto->progetto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="help-info">Attività associato all'utente</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <!--div vuoto-->
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <button class="btn btn-lg btn-primary modifica_utente waves-effect mt-2" id="{{ $dati['id'] }}" type="submit" style="text-align: center">Modifica utente</button>
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
    $('.modifica_utente').on('click', function() {
        var id = $(this).prop('id');
        var nome = $('#nome').val();
        var cognome = $('#cognome').val();
        var email = $('#email').val();
        var ruolo = $('#ruolo_utente option:selected').val()
        var uid = $('#uid_utente').val();
        var progetto = $('#prog_comm option:selected').val();
        var diritti = $('#diritti_utente option:selected').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro di voler modificare l'utente selezionato?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/utenti/" + id,
                    type: "POST",
                    dataType: "json",
                    data: {
                        nome: nome,
                        cognome: cognome,
                        ruolo: ruolo,
                        email: email,
                        uid:    uid,
                        progetto: progetto,
                        diritti: diritti,
                    },
                    success: function(returnValue) {
                        text = "L'utente è stato modificato correttamente."
                        showNotification('alert-success', text,'top', 'right', null, null);
                        window.location.href = '/utenti';
                    },
                    error: function(response, stato) {
                        $('#modificaModal').modal('hide');
                        console.log(stato);
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