import { SUPPORT_PATHS, SUPPORT_ROUTES_NAMES } from './support-paths'

export const SupportRouter = {
  path: SUPPORT_PATHS.root,
  children: [
    {
      path: SUPPORT_ROUTES_NAMES.incidences.route,
      async lazy() {
        const { SupportIncidences } = await import('../../ticket-support-list/pages/SupportIncidences')
        return { Component: SupportIncidences }
      }
    }
  ]
}
