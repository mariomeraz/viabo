# language: es
Característica: Ver tarjetas como propietario (Card Cloud)
  Yo como tarjetahabiente
  Quiero ingresar al sistema
  Para poder ver la informacion de mis tarjetas

  Antecedentes:
    Dado que se ingresa con el usuario "fpalma+03@siccob.com.mx"

  Escenario: Listar tarjetas
    Dado envio una solicitud "GET" a "/api/cardCloud/user-cards"
    Entonces el codigo de estado de respuesta debe ser "200"
