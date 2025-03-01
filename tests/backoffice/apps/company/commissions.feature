# language: es
Característica: Establecer comisiones por empresa
  Yo como Administrador STP
  Quiero definir las comisiones por empresa
  Para retener los montos definidos por transacción

  Antecedentes:
    Dado que se ingresa con el usuario "fpalma+09@siccob.com.mx"

  Escenario: Crear empresa
    Dado envio una solicitud "POST" a "/api/backoffice/company/new" con datos:
    """
    {
      "fiscalName": "Company x",
      "rfc": "XXX00000ZZ",
      "commercialName": "",
      "isNewUser": false,
      "assignedUsers": ["6a22e4bf-eca3-4398-aebc-d477c9c21414"],
      "userName": "",
      "userLastName": "",
      "userEmail": "",
      "userPhone": "",
      "costCenters": [],
      "commissions": {
          "speiOut" : 20,
          "speiIn" : 20,
          "internal" : 20,
          "feetStp" : 20
      }
    }
    """
    Entonces el codigo de estado de respuesta debe ser "200"
