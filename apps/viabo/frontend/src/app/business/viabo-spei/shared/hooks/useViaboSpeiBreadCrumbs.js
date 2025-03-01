import { useMemo } from 'react'

import { VIABO_SPEI_PATHS, VIABO_SPEI_ROUTES } from '../routes/viabo-spei-paths'

export const useViaboSpeiBreadCrumbs = () => {
  const thirdAccounts = useMemo(
    () => [
      { name: 'Inicio', href: '/' },
      { name: VIABO_SPEI_ROUTES.root.name, href: VIABO_SPEI_PATHS.third_accounts },
      { name: 'Cuentas de Terceros' }
    ],
    [VIABO_SPEI_ROUTES, VIABO_SPEI_PATHS]
  )

  const companies = useMemo(
    () => [
      { name: 'Inicio', href: '/' },
      { name: VIABO_SPEI_ROUTES.root.name, href: VIABO_SPEI_PATHS.companies },
      { name: 'Empresas' }
    ],
    [VIABO_SPEI_ROUTES, VIABO_SPEI_PATHS]
  )

  const costCenters = useMemo(
    () => [
      { name: 'Inicio', href: '/' },
      { name: VIABO_SPEI_ROUTES.root.name, href: VIABO_SPEI_PATHS.costCenters },
      { name: 'Centro de Costos' }
    ],
    [VIABO_SPEI_ROUTES, VIABO_SPEI_PATHS]
  )

  return {
    thirdAccounts,
    companies,
    costCenters
  }
}
