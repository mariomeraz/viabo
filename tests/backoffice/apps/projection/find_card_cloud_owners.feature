# language: es
Característica: Listar propietarios de tarjeta card cloud
  Yo como sistema frontend
  Quiero lista de propietarios de tarjeta card cloud
  Para utilizarla en funcionalidades del sistema.

  Antecedentes:
    Dado que se ingresa con el usuario "ajimmenezz+001@gmail.com"

  Escenario: lista de propietarios de tarjeta card cloud con empresa existente
    Dado envio una solicitud "GET" a "/api/company/users/card-cloud-owners/647fe4a8-a83c-40f4-bec9-df8772379156"
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: lista vacia de propietarios de tarjeta card cloud con empresa existente
    Dado envio una solicitud "GET" a "/api/company/users/card-cloud-owners/50950660-a7cb-40de-b0a4-8e7f9bb0ec1b"
    Entonces el codigo de estado de respuesta debe ser "200"
    Entonces el contenido de la respuesta debe contener
    """
    []
    """

  Escenario: Error al obtener la lista de propietarios de tarjeta cuando empresa no existe
    Dado envio una solicitud "GET" a "/api/company/users/card-cloud-owners/647fe4a8-a83c-40f4-bec9-df8772379177"
    Entonces el codigo de estado de respuesta debe ser "400"
    Entonces el mensaje de error es "El empresa no existe"
