# Titulo de la app
"" es un sitio web que ayuda principalmente a estudiantes a localizar los objetos que se les han perdido durante sus jornadas académicas, mediante un sistema de publicaciones que notifican al posible dueño y lo ayudan a encontrar de manera más eficiente sus objetos.

# Ejecución
## Preparación del entorno
1. **Descargar Xampp:** https://www.apachefriends.org/es/download.html
2. **Descargar Composer:** https://getcomposer.org/download/
3. **Descargar Git:** https://git-scm.com/install/windows

4. **Clonar repositorio:** 
En la terminal de VS Code escribir el siguiente comando: **git clone https://github.com/JuanDev27/SistemaGestionPublicaciones.git**
5. **Creación del .env:** Por seguridad se crea un .env.example, vamos a renombrar este como "**.env**"
6. **Configurar .env:** Cambiar el campo DB_DATABASE=laravel por "**DB_DATABASE=sistema_publicaciones**"
7. **Crear DB:** en Xampp, iniciar Mysql, clic en "Admin"(a la derecha de stop), y crear una nueva DB llamada "**sistema_publicaciones**"
8. **Migraciones:** ejecutar en la terminal php artisan migrate

## Iniciar servidor local
**Comando en terminal:** php artisan serve