import { createStore } from '@/app/shared/store'

const initialState = {
  company: null,
  openNewCompany: false
}
const speiCompaniesStore = (set, get) => ({
  ...initialState,
  setSpeiCompany: company => {
    set(
      state => ({
        company
      }),
      false,
      'SET_SPEI_COMPANY'
    )
  },
  setOpenNewSpeiCompany: open => {
    set(
      state => ({
        openNewCompany: open
      }),
      false,
      'SET_OPEN_SPEI_NEW_COMPANY'
    )
  }
})

export const useSpeiCompaniesStore = createStore(speiCompaniesStore)
