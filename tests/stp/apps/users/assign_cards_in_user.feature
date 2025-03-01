# language: es
Característica: Asignar tarjetas a usuario (Card Cloud)
  Yo como administrador de empresas
  Quiero asignar tarjetas a un tarjetahabiente
  Para se pueda tener un registro de que tarjetahabiente tiene asignadas las tarjetas

  Antecedentes:
    Dado que se ingresa con el usuario "ajimmenezz+001@gmail.com"

  Escenario: Asignando tarjeta a un tarjetahabiente existen
    Dado que elimina el registro "96967896594625" para quitar la asignacion
    Dado envio una solicitud "PUT" a "/api/cardCloud/cards/assign-user" con datos:
    """
    {
      "companyId": "647fe4a8-a83c-40f4-bec9-df8772379156",
      "cards": ["96967896594625"],
      "user": "3cb5b8e0-962a-40dd-8fbb-049bc3cb7deb",
      "newUser": null,
      "isNewUser": false
    }
    """
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Asignando tarjeta y creando un tarjetahabiente
    Dado que elimina el registro "96967896594625" para quitar la asignacion
    Dado se limpia el registro del usuario "fpalma+02@siccob.com.mx" de la empresa "647fe4a8-a83c-40f4-bec9-df8772379156"
    Dado envio una solicitud "PUT" a "/api/cardCloud/cards/assign-user" con datos:
    """
    {
      "companyId": "647fe4a8-a83c-40f4-bec9-df8772379156",
      "cards": ["96967896594625"],
      "user": "",
      "newUser": {
          "name": "Test 02",
          "lastname": "T",
          "phone": "55555555",
          "email": "fpalma+02@siccob.com.mx"
      },
      "isNewUser": true
    }
    """
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Error al asignar una tarjeta ya registrada
    Dado envio una solicitud "PUT" a "/api/cardCloud/cards/assign-user" con datos:
    """
    {
      "companyId": "647fe4a8-a83c-40f4-bec9-df8772379156",
      "cards": ["96967896594625"],
      "user": "3cb5b8e0-962a-40dd-8fbb-049bc3cb7deb",
      "newUser": null,
      "isNewUser": false
    }
    """
    Entonces el codigo de estado de respuesta debe ser "400"
    Entonces el mensaje de error es "Ya esta asignadas las tarjetas"