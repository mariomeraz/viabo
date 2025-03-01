# language: es
Característica: Resetear password de usuario por url
  Yo como administrador de sistema
  Quiero resetear una password desde una url
  Para crear un nuevo password a un usuario y mandarselo por correo

  Escenario: reseteando password
    Dado envio una solicitud "GET" a "/api/user/password/reset/8dfa554e-6fdd-4151-9577-3d800fbd6783"
    Entonces el codigo de estado de respuesta debe ser "200"
