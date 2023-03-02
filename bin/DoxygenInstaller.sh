#!/bin/bash

# mi posiziono nella root del progetto
cd $HOME/Sites/envass_v2

# installo il pacchetto doxygen
if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    sudo apt-get update -y
    sudo apt-get install -y doxygen
elif [[ "$OSTYPE" == "darwin"* ]]; then
    # Mac OSX
    brew install doxygen
elif [[ "$OSTYPE" == "cygwin" ]]; then
    # POSIX compatibility layer and Linux environment emulation for Windows
    sudo apt-get update -y
    sudo apt-get install -y doxygen
elif [[ "$OSTYPE" == "msys" ]]; then
    # Lightweight shell and GNU utilities compiled for Windows (part of MinGW)
    sudo apt-get update -y
    sudo apt-get install -y doxygen
fi


# creo il file di configurazione Doxyfile
doxygen -g

# verifico l'esistenza della directory di output docs, se non esiste la creo
if [ ! -d "docs" ]
    then mkdir docs
fi


