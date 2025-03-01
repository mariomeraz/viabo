import { createStore } from '@/app/shared/store'

const initialState = {
  openChangePassword: false,
  openTwoAuthConfig: false
}
const uiSharedStore = (set, get) => ({
  ...initialState,
  setOpenChangePassword: open => {
    set(
      state => ({
        openChangePassword: open
      }),
      false,
      'UI_SHARED_STORE:SET_OPEN_CHANGE_PASSWORD'
    )
  },
  setOpenTwoAuthConfig: open => {
    set(
      state => ({
        openTwoAuthConfig: open
      }),
      false,
      'UI_SHARED_STORE:SET_OPEN_2FA_CONFIG'
    )
  }
})

export const useUiSharedStore = createStore(uiSharedStore)
