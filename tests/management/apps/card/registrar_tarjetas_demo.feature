# language: es
Característica: Crear Registro de tarjetas Demos
  Yo como cliente nuevo
  Quiero registrar la tarjeta demo que recibi
  Para poder utilizarlo y conocer la plataforma de viabo.

  Escenario: Registrar tarjeta demo
    Dado Envio una solicitud "GET" a "/api/card-demo/information/00037340"
    Entonces el codigo de estado de respuesta debe ser "200"
    Entonces se recibe el token de la informacion
    Y Envio una solicitud "POST" a "/api/security/commerce-demo/user/new" con datos:
    """
    {
      "name":"Test Demo",
      "phone" : "5555555555",
      "email" : "fpalma+04@siccob.com.mx"
    }
    """
    Entonces el codigo de estado de respuesta debe ser "200"
    Entonces se recibe el token de la informacion
    Y Envio una solicitud "PUT" a "/api/assign/commerce-demo-card/to/user" con datos:
    """
      {
        "ciphertext": "oJ2rgR1WK2cn9CTlwu3l04k77m3qdfDjryXXt5Qv+0NzqIwclqgfvvezwRpc2w3m",
        "iv": "aetUhzT0m2X21b6njQTszw=="
      }
    """
    Entonces el codigo de estado de respuesta debe ser "200"