# Pruebamomseguros
Ejercicio de consumir una API utilizando Laravel

git clone https://github.com/JohnnyAndres/Pruebamomseguros.git

composer install

npm install 

npm run dev

php artisan serve

Con el fin de desarrollar el ejercicio propuesto, consumir la API "https://jsonplaceholder.typicode.com/todos", se ha desarrollado este proyecto de laravel.
Se simula que los datos provenienetes de la API representan los datos de usuarios de alguna empresa y se crea un CRUD para poder acceder y manejar los datos. 

En el proyecto se ha creado un modulo User, dentro del cual existe un controlador, "userController", que contiene direntes funciones que realizan peticiones get, put, update y post a la API segun lo requiera el usuario desde el frontend. Los endpoints que apuntan a dichas funciones se encuentran en el carpeta routes del modulo User, estos endpoints son los encargados tambien de recibir la peticion que viene del lado de usuario. 

Para el desarrollo de la interfaz de Usuario se opto por integrar VueJs para realizar peticiones al backend, los componentes que integran la interfaz se encuentran en la carpeta .Modules/User/resources/js/components, las respuestas a estas peticiones son recibidas por Vue y mostrados en una tabla que nos brinda la libreria Element UI, desde esta tabla es posible visualizar los datos de los usuarios almacenados en la API, ademas de poder agregar usuarios a la lista, eliminarlos y editar algunos de sus datos.

