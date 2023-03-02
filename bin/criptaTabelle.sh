#!/bin/bash

#Eseguo criptazione tabelle

cd ..

echo 'Eseguo criptazione tabelle: ...'

echo '...'
echo 'Cripto tabella societa: '
php artisan encryptable:encryptModel 'App\Societa'
if [ $? -ne 0 ]; then
    echo "Si è verificato un errore"
    exit;
fi

echo '...'
echo 'Cripto tabella rilevatori: '
php artisan encryptable:encryptModel 'App\Rilevatore'
if [ $? -ne 0 ]; then
    echo "Si è verificato un errore"
    exit;
fi

echo '...'
echo 'Cripto tabella progetti: '
php artisan encryptable:encryptModel 'App\Progetto'
if [ $? -ne 0 ]; then
    echo "Si è verificato un errore"
    exit;
fi

echo '...'
echo 'Cripto tabella immagini: '
php artisan encryptable:encryptModel 'App\ImmaginiPiastre'
if [ $? -ne 0 ]; then
    echo "Si è verificato un errore"
    exit;
fi

echo '...'
echo 'Cripto tabella immagini_microantibiogrammi: '
php artisan encryptable:encryptModel 'App\ImmagineMicroAntibiogramma'
if [ $? -ne 0 ]; then
    echo "Si è verificato un errore"
    exit;
fi

echo '...'
echo 'Cripto tabella immagini_microantibiogrammi_analisi_molecolari: '
php artisan encryptable:encryptModel 'App\ImmagineMicroAntibiogrammaSwab'
if [ $? -ne 0 ]; then
    echo "Si è verificato un errore"
    exit;
fi

echo '...'
echo 'Cripto tabella immagini_piastre_analisi_molecolari: '
php artisan encryptable:encryptModel 'App\ImmaginiPiastreSwab'
if [ $? -ne 0 ]; then
    echo "Si è verificato un errore"
    exit;
fi

echo 'Criptazione terminata con successo!'
