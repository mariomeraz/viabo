# language: es
Característica: Resetear password de propietario de tarjeta
  Yo como propietario de tarjeta
  Quiero resetear mi password
  Para poder volver tener acceso al sistema

  Escenario: reseteando password
    Dado que se ingresa con el usuario "fpalma+01@siccob.com.mx"
    Dado envio una solicitud "PUT" a "/api/card-owner/password/reset/8dfa554e-6fdd-4151-9577-3d800fbd6783"
    Entonces el codigo de estado de respuesta debe ser "200"
