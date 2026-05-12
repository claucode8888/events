# EventHub

- For English content scroll down.

Una plataforma de tickets donde los usuarios pueden explorar eventos próximos, reservar entradas gratuitas o de pago, y procesar pagos — todo desde una cuenta personal.

**Demo en vivo:** [upbeat-energy-production.up.railway.app](https://upbeat-energy-production.up.railway.app)

## Funcionalidades

- Explorar todos los eventos publicados
- Ver detalles de cada evento (descripción, fecha, ubicación, precio)
- Registro e inicio de sesión de usuarios
- Seleccionar cantidad de tickets y comprar mediante procesamiento de pago
- Sección "Mis Tickets" para ver las entradas adquiridas
- Creación de eventos exclusiva para administradores

## Stack Tecnológico

- **Backend:** PHP 8.5, Symfony 7.4
- **Frontend:** HTML, JavaScript, Tailwind CSS 4.1.11 (symfonycast/tailwind-bundle)
- **Base de datos:** MySQL
- **Herramientas de desarrollo local:** Symfony CLI server, Mailpit (pruebas de correo)
- **Producción:** Railway hosting, despliegue mediante Dockerfile

## Configuración Local

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/claucode8888/events.git
   cd events
   ```

2. Instalar dependencias PHP:
   ```bash
    composer install
   ```

3. Crear la base de datos y ejecutar migraciones:
   ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
   ```

4. Construir los assets del frontend:
   ```bash
    php bin/console tailwind:build
   ```

5. Iniciar el servidor local:
   ```bash
    symfony serve start
   ```

6. Mailpit captura los correos salientes. Visitar `http://127.0.0.1:8025` para verlos.

## Notas de producción
- La aplicación está desplegada en Railway usando un Dockerfile personalizado.
- El envío de correos está configurado y es funcional en local. En el plan Hobby de Railway, el tráfico SMTP saliente está restringido. Para habilitar el envío real de correos se requiere actualizar a un plan Pro o integrar un servicio de terceros vía API (ej. Resend, SendGrid).

## Autor
- **Claucode**

- [Email](mailto:claucode88@gmail.com)
- [LinkedIn](https://www.linkedin.com/in/claudio-gandolffi)
- [Portfolio](https://upbeat-energy-production.up.railway.app)

# ############################################################################################################### 

# EventHub

A ticket platform where users can browse upcoming events, reserve free or paid tickets, and process payments — all from a personal account.

**Live demo:** [upbeat-energy-production.up.railway.app](https://upbeat-energy-production.up.railway.app)

## Features

- Browse all published events
- View event details (description, date, location, pricing)
- User registration and login
- Select ticket quantity and purchase via payment processing
- "My Tickets" section to view purchased tickets
- Admin-only event creation

## Tech Stack

- **Backend:** PHP 8.5, Symfony 7.4
- **Frontend:** HTML, JavaScript, Tailwind CSS 4.1.11 (symfonycast/tailwind-bundle)
- **Database:** MySQL
- **Local dev tools:** Symfony CLI server, Mailpit (email testing)
- **Production:** Railway hosting, Dockerfile-based deployment

## Local Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/claucode8888/events.git
   cd events
   ```

2. Install PHP dependencies:
   ```bash
    composer install
   ```

3. Create the database and run migrations:
   ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
   ```

4. Build frontend assets:
   ```bash
    php bin/console tailwind:build
   ```

5. Start the local server:
   ```bash
    symfony serve start
   ```

6. Mailpit captures outgoing emails. Visit `http://127.0.0.1:8025` to view them.

## Production Notes

- The application is deployed on Railway using a custom Dockerfile.
- Email delivery is configured and functional locally. On Railway's Hobby plan, outbound SMTP is restricted. Enabling real email delivery requires upgrading to a Pro plan or integrating a third-party API service (e.g., Resend, SendGrid).

## Author
- **Claucode**

- [Email](mailto:claucode88@gmail.com)
- [LinkedIn](https://www.linkedin.com/in/claudio-gandolffi)
- [Portfolio](https://upbeat-energy-production.up.railway.app)