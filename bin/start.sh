#!/bin/bash

# mi posiziono nella root della migrazione dei dati
cd $HOME/Sites/migrazionedati

#effettuo migrazione dati
php migrate.php

# mi posizione nella root del progetto
cd $HOME/Sites/envass_v2

# effettuo la migrazione laravel
php artisan migrate

#elimino tutti i file in Storage/planimetrie
rm -rf $HOME/Sites/envass_v2/storage/app/public/planimetrie/*

#elimino tutti i file in Storage/eliminati
rm -rf $HOME/Sites/envass_v2/storage/app/public/eliminati/*

#elimino tutti i file in Storage/temporary
rm -rf $HOME/Sites/envass_v2/storage/app/public/temporary/*

#elimino tutti i file in Storage che nel nome contengono solo numeri
find $HOME/Sites/envass_v2/storage/app/public/ -type d -name '[0-9]*' -delete

# entro in bin per eseguire altri script
cd $HOME/Sites/envass_v2/bin

#Eseguo criptazione tabelle
sh criptaTabelle.sh

#credo documentazione
#sh DoxygenInstaller.sh

#modifico il file di configurazione Doxyfile
#sh modifyDoxyfile.sh