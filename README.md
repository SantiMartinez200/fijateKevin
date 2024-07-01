# Guía de Instalación de la Aplicación
## Requisitos Previos
Laragon con PHP 8.1.10

Node.js

## Pasos para la Instalación
### Paso 1: Instalar Laragon
Descarga e instala Laragon desde [aquí.](https://laragon.org/)
Asegúrate de tener la versión de PHP 8.1.10 instalada.

### Paso 2: Instalar Node.js
Descarga e instala Node.js desde [aquí.](https://nodejs.org/en)

### Paso 3: Descargar la Aplicación
Tienes dos opciones para obtener el código de la aplicación:

### Paso 4: Instalar Dependencias con Composer
Abre la terminal de Laragon.
Navega hasta la carpeta de la aplicación: ``cd C:\laragon\www\"nombre"``
Ejecuta el siguiente comando: ``composer install``

### Paso 5: Instalar los paquetes de dependencia de VITE
Abre la terminal de Laragon.
Navega hasta la carpeta de la aplicación: ```cd C:\laragon\www\"nombre"```
Ejecuta el siguiente comando: ``npm install``

### Paso 6: Configurar el archivo ENV
Dentro de la carpeta Students copia el archivo .env.example y pégalo en el mismo lugar.
Renombra la copia a .env.

### Paso 7: Iniciar los Servidores
En tu terminal de preferencia, navega hasta la carpeta de la aplicación: cd C:\laragon\www\"nombre"
Ejecuta los siguientes comandos para iniciar los servidores: ``php artisan serve``, ``npm run dev``

### Paso 8: Acceder a la Aplicación
Abre tu navegador web y ve a http://localhost:8000 para acceder a la aplicación.




> [!NOTE]
> Respetar las versiones de las aplicaciones.
