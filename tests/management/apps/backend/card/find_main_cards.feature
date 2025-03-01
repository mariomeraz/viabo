# language: es
Característica: Buscar tarjetas maestras
  Para listar las tarjetas maestras
  Con administrador de comercio
  Quiero ver la informacion de las tarjetas.

  Escenario: Buscar tarjetas maestras
    Dado envio una solicitud "GET" a "/api/main-cards/information"
    Entonces el codigo de estado de respuesta debe ser "200"
    Entonces el contenido de la respuesta debe contener
    """
    {
        "response": "Heal check security"
    }
    """
