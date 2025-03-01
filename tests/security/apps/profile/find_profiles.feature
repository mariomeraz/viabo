# language: es
Característica: Catalogo de perfiles
  Para tener la lista de perfiles
  Como sistema frontend
  Quiero obtener la lista de perfiles en el sistema

  Antecedentes:
    Dado que se ingresa con el usuario "ramses@itravel.mx"

  Escenario: lista de perfiles
    Dado envio una solicitud "GET" a "/api/profiles"
    Entonces el codigo de estado de respuesta debe ser "200"
