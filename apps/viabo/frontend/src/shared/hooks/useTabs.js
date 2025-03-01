import { useState } from 'react'

export function useTabs(defaultValues) {
  const [currentTab, setCurrentTab] = useState(defaultValues || '')

  return {
    currentTab,
    onChangeTab: (event, newValue) => {
      setCurrentTab(newValue)
    },
    setCurrentTab
  }
}
