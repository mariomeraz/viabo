import { path } from '@/routes'

export const VIABO_SPEI_ROUTES = {
  home: { route: '/', name: 'Inicio2' },
  root: { route: 'viabo-spei', name: 'Viabo Spei' },
  dashboard: { route: 'dashboard', name: 'Dashboard' },
  companies: { route: 'companies', name: 'Empresas' },
  costCenters: { route: 'cost-centers', name: 'Centros de Costos' },
  third_accounts: { route: 'third-accounts', name: 'Cuentas de Terceros' }
}

const ROOT = `/${VIABO_SPEI_ROUTES.root.route}`

export const VIABO_SPEI_PATHS = {
  root: ROOT,
  dashboard: path(ROOT, `/${VIABO_SPEI_ROUTES.dashboard.route}`),
  companies: path(ROOT, `/${VIABO_SPEI_ROUTES.companies.route}`),
  costCenters: path(ROOT, `/${VIABO_SPEI_ROUTES.costCenters.route}`),
  third_accounts: path(ROOT, `/${VIABO_SPEI_ROUTES.third_accounts.route}`)
}
