# language: es
Característica: Api status Security
  Para saber si el servidor está en funcionamiento
  Con un healt check
  Quiero validar el estatus de la API

  Escenario: Check the api status
    Dado envio una solicitud "GET" a "/api/health-check"
    Entonces el codigo de estado de respuesta debe ser "201"
    Entonces el contenido de la respuesta debe contener
    """
    {
        "response": "Heal check security"
    }
    """
