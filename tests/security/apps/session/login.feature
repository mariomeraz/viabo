# language: es
Característica: Login
  Yo como usuario
  Quiero ingresar al sistema
  Para poder utilizarlo para mi negocio.

  Escenario: Ingresar como Administrador Viabo
    Dado que se ingresa con el usuario "alonso@viabo.com"
    Dado envio una solicitud "GET" a "/api/modules/user"
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Ingresar como Administrador de comercio Viabo
    Dado que se ingresa con el usuario "ajimmenezz+01@gmail.com"
    Dado envio una solicitud "GET" a "/api/modules/user"
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Ingresar como Propietario de tarjeta Viabo
    Dado que se ingresa con el usuario "ajimmenezz+01@icloud.com"
    Dado envio una solicitud "GET" a "/api/modules/user"
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Ingresar como Adminstrador STP
    Dado que se ingresa con el usuario "ajimmenezz@gmail.com"
    Dado envio una solicitud "GET" a "/api/modules/user"
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Ingresar como Administrador de Empresas STP
    Dado que se ingresa con el usuario "ajimmenezz+001@gmail.com"
    Dado envio una solicitud "GET" a "/api/modules/user"
    Entonces el codigo de estado de respuesta debe ser "200"