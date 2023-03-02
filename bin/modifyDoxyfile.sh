#!/bin/bash

# mi posiziono nella root del progetto
cd $HOME/Sites/envass_v2

#modifico il file di configurazione Doxyfile
sed -i 's#^PROJECT_NAME           = "My Project"#PROJECT_NAME = ENVASS #' $HOME/Sites/envass_v2/Doxyfile;
sed -i "s#^OUTPUT_DIRECTORY.*#OUTPUT_DIRECTORY  = $HOME/Sites/envass_v2/docs#" $HOME/Sites/envass_v2/Doxyfile;
sed -i "s#^INPUT                  =#INPUT = $HOME/Sites/envass_v2/app#" $HOME/Sites/envass_v2/Doxyfile;
sed -i "s#^WARN_LOGFILE.*#WARN_LOGFILE = $HOME/Sites/envass_v2/docs/warnings.log#" $HOME/Sites/envass_v2/Doxyfile;
sed -i "s/^RECURSIVE              = NO/RECURSIVE = YES/" $HOME/Sites/envass_v2/Doxyfile;
sed -i "s/^USE_MDFILE_AS_MAINPAGE.*/USE_MDFILE_AS_MAINPAGE = README.md/" $HOME/Sites/envass_v2/Doxyfile;
# sed -i "s/^GENERATE_LATEX         = YES/GENERATE_LATEX = YES/" $HOME/Sites/envass_v2/Doxyfile;
sed -i "s/^GENERATE_XML           = NO/GENERATE_XML = YES/" $HOME/Sites/envass_v2/Doxyfile;

#creo la documentazione
doxygen