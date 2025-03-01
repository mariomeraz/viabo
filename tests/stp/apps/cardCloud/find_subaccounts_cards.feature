# language: es
Característica: Listar Tarjetas (Card Cloud)
  Yo como administrador de empresas
  Quiero ver la lista de tarjetas de una empresa
  Para ver informacion de cada una de las tarjetas

  Antecedentes:
    Dado que se ingresa con el usuario "ajimmenezz+001@gmail.com"

  Escenario: Lista de tarjetas
    Dado envio una solicitud "GET" a "/api/cardCloud/sub-account/018fc5c1-6438-7178-bfc2-38e3364f30d9/cards"
    Entonces el codigo de estado de respuesta debe ser "200"

  Escenario: Detalles de tarjeta
    Dado envio una solicitud "GET" a "/api/cardCloud/card/018fa8ec-7f9e-7005-876c-be04249c950f/details"
    Entonces el codigo de estado de respuesta debe ser "200"

