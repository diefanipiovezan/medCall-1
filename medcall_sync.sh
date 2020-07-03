#!/bin/bash

# models
echo "\033[32m--------> Sincronizando \033[1mModels\033[0m"
rsync -Cravzp --progress -e "ssh -p 2222" ~/Projects/medcall/app/Models/ medca403@medcallconsultas.com.br:~/applications/medcall/app/Models/

# controllers
echo "\033[32m--------> Sincronizando \033[1mControllers\033[0m"
rsync -Cravzp --progress -e "ssh -p 2222" ~/Projects/medcall/app/Http/Controllers/ medca403@medcallconsultas.com.br:~/applications/medcall/app/Http/Controllers/

# repositories
echo "\033[32m--------> Sincronizando \033[1mRepositories\033[0m"
rsync -Cravzp --progress -e "ssh -p 2222" ~/Projects/medcall/app/Http/Repositories/ medca403@medcallconsultas.com.br:~/applications/medcall/app/Http/Repositories/

# routes
echo "\033[32m--------> Sincronizando \033[1mRoutes\033[0m"
rsync -Cravzp --progress -e "ssh -p 2222" ~/Projects/medcall/routes/ medca403@medcallconsultas.com.br:~/applications/medcall/routes/

# views
echo "\033[32m--------> Sincronizando \033[1mViews\033[0m"
rsync -Cravzp --progress -e "ssh -p 2222" ~/Projects/medcall/resources/views/ medca403@medcallconsultas.com.br:~/applications/medcall/resources/views/

# mail
echo "\033[32m--------> Sincronizando \033[1mMail\033[0m"
rsync -Cravzp --progress -e "ssh -p 2222" ~/Projects/medcall/app/Mail/ medca403@medcallconsultas.com.br:~/applications/medcall/app/Mail/

# public/css
echo "\033[32m--------> Sincronizando \033[1mCSS\033[0m"
rsync -Cravzp --progress -e "ssh -p 2222" ~/Projects/medcall/public/css/ medca403@medcallconsultas.com.br:~/public_html/medcall/css/

# public/js
echo "\033[32m--------> Sincronizando \033[1mJS\033[0m"
rsync -Cravzp --progress -e "ssh -p 2222" ~/Projects/medcall/public/js/ medca403@medcallconsultas.com.br:~/public_html/medcall/js/

# public/images
echo "\033[32m--------> Sincronizando \033[1mImages\033[0m"
rsync -Cravzp --progress -e "ssh -p 2222" ~/Projects/medcall/public/images/ medca403@medcallconsultas.com.br:~/public_html/medcall/images/
