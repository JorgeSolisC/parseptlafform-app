# Parse Platform Integration with Laravel & Vue 3

Este proyecto es un ejemplo de cómo integrar **Parse Platform** en una aplicación de **Laravel** usando **Vue 3**. Incluye la configuración de un servidor de Parse con soporte para **Live Query** y la configuración del Parse Dashboard para administrar la aplicación.

---

## 🚀 Características

- **Parse Server** configurado en `server.js` con soporte para Live Query.
- **Laravel** como backend con un controlador para crear usuarios usando un servicio de Parse.
- **Vue 3** en el frontend para manejar eventos de Live Query con un composable personalizado.
- **Parse Dashboard** configurado con un archivo JSON para fácil administración de la app.
- **Ejecución en segundo plano** con **PM2** npm install -g pm2.

---

## 🛠 Instalación

1. **Clonar el repositorio**
    ```bash
    git clone https://github.com/JorgeSolisC/parseptlafform-app.git
    cd parseptlafform-app
    ```

2. **Instalar dependencias de Laravel**
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    ```

3. **Instalar dependencias de Node**
    ```bash
    npm install
    ```

4. **Iniciar Parse Server**
    ```bash
    node server.js
    ```

5. **Iniciar Parse Dashboard**
    ```bash
    parse-dashboard --config dashboard.json --port 8080 --allowInsecureHTTP
    ```

---

## 📂 Estructura del Proyecto

- **server.js**  
  Configuración de Parse Server con Live Query habilitado.

- **dashboard.json**  
  Configuración de Parse Dashboard con las credenciales de la app y el soporte para WebSockets.

- **app/Http/Controllers/UserController.php**  
  Controlador de Laravel que llama a un servicio para crear usuarios en Parse.

- **app/Services/UserService.php**  
  Servicio que maneja la lógica de creación de usuarios usando Parse SDK.

- **resources/js/composables/parselive.js**  
  Composable de Vue 3 que maneja suscripciones a eventos de Live Query.

---

## ✨ Uso

### 1️⃣ ⃣ Crear un usuario en Parse usando Artisan
```php
Primero, se debe crear un usuario del sistema con el siguiente comando:
```
 ```bash
 php artisan system:user-create
 ```
Luego, opcionalmente, se puede crear un tenant si se está usando Laravel Tenancy:

 ```bash
php artisan tenant:create cceo cceo.localhost
 ```

Finalmente, se ejecuta el comando para crear un usuario en Parse dentro del tenant:
 ```bash
php artisan tenant:user-create-sdk cceo
 ```

