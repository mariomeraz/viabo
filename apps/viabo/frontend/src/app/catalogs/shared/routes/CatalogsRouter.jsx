import { CATALOGS_PATHS, CATALOGS_ROUTES_NAMES } from './catalogsPaths'

export const CatalogsRouter = {
  path: CATALOGS_PATHS.root,
  children: [
    {
      path: CATALOGS_ROUTES_NAMES.causes.route,
      async lazy() {
        const { CatalogCauses } = await import('../../causes/pages/CatalogCauses')
        return { Component: CatalogCauses }
      }
    }
  ]
}
