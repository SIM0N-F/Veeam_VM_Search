# Introduction:

Ce script permet d'exporter la liste des machines virtuelle backupé par Veeam puis à l'aide d'un script PHP de rechercher dans la liste.

Le script POWERSHELL génére un fichier vm.txt puis le pousse en FTP la ou se trouve index.php. Le script PHP lui parse simplement le fichier ligne par ligne et cherche une chaine de caractères.

Le script powershell require VeeamPSSnapIn.
