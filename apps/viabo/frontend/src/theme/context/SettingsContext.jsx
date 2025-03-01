import { createContext } from 'react'

import PropTypes from 'prop-types'

import { defaultSettings } from '@theme/overrides/options'
import { colorPresets, getColorPresets } from '@theme/utils'

import { useLocalStorage } from '@/shared/hooks'

const initialState = {
  ...defaultSettings,
  onChangeMode: () => {},
  onToggleMode: () => {},
  onChangeDirection: () => {},
  onChangeColor: () => {},
  onToggleStretch: () => {},
  onChangeLayout: () => {},
  onResetSetting: () => {},
  setColor: {},
  colorOption: [],
  isCentralPayTheme: false
}

const SettingsContext = createContext(initialState)

SettingsProvider.propTypes = {
  children: PropTypes.node
}

function SettingsProvider({ children }) {
  const [settings, setSettings] = useLocalStorage('settings', {
    themeMode: initialState.themeMode,
    themeDirection: initialState.themeDirection,
    themeColorPresets: initialState.themeColorPresets,
    themeStretch: initialState.themeStretch,
    themeLayout: initialState.themeLayout,
    isCentralPayTheme: false
  })

  const onChangeMode = event => {
    setSettings({
      ...settings,
      themeMode: event.target.value
    })
  }

  const onToggleMode = () => {
    setSettings({
      ...settings,
      themeMode: settings.themeMode === 'light' ? 'dark' : 'light'
    })
  }

  const onChangeDirection = event => {
    setSettings({
      ...settings,
      themeDirection: event.target.value
    })
  }

  const onChangeColor = event => {
    setSettings({
      ...settings,
      themeColorPresets: event.target.value
    })
  }

  const onChangeLayout = event => {
    setSettings({
      ...settings,
      themeLayout: event.target.value
    })
  }

  const onToggleStretch = () => {
    setSettings({
      ...settings,
      themeStretch: !settings.themeStretch
    })
  }

  const onResetSetting = () => {
    setSettings({
      themeMode: initialState.themeMode,
      themeLayout: initialState.themeLayout,
      themeStretch: initialState.themeStretch,
      themeDirection: initialState.themeDirection,
      themeColorPresets: initialState.themeColorPresets,
      isCentralPayTheme: false
    })
  }

  const onChangeThemeToCentralPay = isCentralPay => {
    setSettings({
      ...settings,
      isCentralPayTheme: isCentralPay
    })
  }

  return (
    <SettingsContext.Provider
      value={{
        ...settings,
        // Mode
        onChangeMode,
        onToggleMode,
        // Direction
        onChangeDirection,
        // Color
        onChangeColor,
        onChangeThemeToCentralPay,
        setColor: getColorPresets(settings.themeColorPresets),
        colorOption: colorPresets.map(color => ({
          name: color.name,
          value: color.main
        })),
        // Stretch
        onToggleStretch,
        // Navbar Horizontal
        onChangeLayout,
        // Reset Setting
        onResetSetting
      }}
    >
      {children}
    </SettingsContext.Provider>
  )
}

export { SettingsContext, SettingsProvider }
