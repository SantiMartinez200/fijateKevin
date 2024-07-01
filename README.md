#Guía de Instalación de la Aplicación
##Requisitos Previos
Laragon con PHP 8.1.10
Node.js

##Pasos para la Instalación
###Paso 1: Instalar Laragon
Descarga e instala Laragon desde [aquí.](https://laragon.org/)
Asegúrate de tener la versión de PHP 8.1.10 instalada.

###Paso 2: Instalar Node.js
Descarga e instala Node.js desde [aquí.](https://nodejs.org/en)

###Paso 3: Descargar la Aplicación
Tienes dos opciones para obtener el código de la aplicación:

##Abre una terminal y ejecuta el siguiente comando: git clone <URL_DEL_REPOSITORIO> C:\laragon\www\"nombre"
###Paso 4: Instalar Dependencias con Composer
Abre la terminal de Laragon.
Navega hasta la carpeta de la aplicación: ``cd C:\laragon\www\"nombre"``
Ejecuta el siguiente comando: "composer install"

###Paso 5: Instalar los paquetes de dependencia de VITE
Abre la terminal de Laragon.
Navega hasta la carpeta de la aplicación: ```cd C:\laragon\www\"nombre"```
Ejecuta el siguiente comando: *npm install*

###Paso 6: Configurar el archivo ENV
Dentro de la carpeta Students copia el archivo .env.example y pégalo en el mismo lugar.
Renombra la copia a .env.
Opcional: Cambiar el nombre de la base de datos
En el archivo .env, en la línea que dice DB_DATABASE=, puedes poner el nombre que desees para la base de datos.

###Paso 7: Iniciar los Servidores
En tu terminal de preferencia, navega hasta la carpeta de la aplicación: cd C:\laragon\www\Students

Ejecuta los siguientes comandos para iniciar los servidores: "php artisan serve", "npm run dev"

###Paso 8: Acceder a la Aplicación
Abre tu navegador web y ve a http://localhost:8000 para acceder a la aplicación.


> [!NOTE]
> Respetar las versiones de las aplicaciones.