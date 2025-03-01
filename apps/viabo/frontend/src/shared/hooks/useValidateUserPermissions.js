import { useEffect, useState } from 'react'

function validateUserPermission(userPermissions, routesAndActions) {
  for (const permission of userPermissions) {
    for (const key in routesAndActions) {
      if (routesAndActions[key]) {
        const action = Object.values(routesAndActions[key]).find(route => route?.permission === permission)
        if (action) {
          return true
        }
      }
    }
  }
  return false
}

export function useValidateUserPermissions(userPermissions, routesAndActions) {
  const [hasPermission, setHasPermission] = useState(false)

  useEffect(() => {
    const hasUserPermission = validateUserPermission(userPermissions, routesAndActions)
    setHasPermission(hasUserPermission)
  }, [userPermissions, routesAndActions])

  return hasPermission
}
