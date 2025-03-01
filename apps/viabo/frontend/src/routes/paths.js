// ----------------------------------------------------------------------

export function path(root, sublink) {
  return `${root}${sublink}`
}

const ROOTS_AUTH = '/auth'
const ROOTS_DASHBOARD = '/'

export const PATH_AUTH = {
  root: ROOTS_AUTH,
  login: path(ROOTS_AUTH, '/login')
}

export const PATH_DASHBOARD = {
  root: ROOTS_DASHBOARD,
  'dashboard-master': path(ROOTS_DASHBOARD, '/dashboard-master'),
  'funding-orders': path(ROOTS_DASHBOARD, '/funding-orders'),
  'expenses-control': path(ROOTS_DASHBOARD, '/expenses-control')
}

export const PUBLIC_PATHS = {
  privacy: '/privacy',
  policies: '/policies',
  payments: '/pagos/:slug'
}
