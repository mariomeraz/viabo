import { isFunction as isLodashFunction } from 'lodash'

export function matchIsNumeric(text) {
  const isNumber = typeof text === 'number'
  const isString = matchIsString(text)
  return (isNumber || (isString && text !== '')) && !isNaN(Number(text))
}

export function matchIsString(text) {
  return typeof text === 'string' || text instanceof String
}

export const convertCatalogToReactSelect = (data, valueObject, label, disabledProperty) =>
  data.map((item, index) => ({
    value: getValueFromNestedObject(item, valueObject),
    label: getValueFromNestedObject(item, label),
    isDisabled: getValueFromNestedObject(item, disabledProperty) === '0' || false,
    index,
    ...item
  }))
const getValueFromNestedObject = (object, propertyPath) => {
  if (!propertyPath) return object
  const properties = propertyPath.split('.')
  let value = object
  for (const property of properties) {
    if (value && value.hasOwnProperty(property)) {
      value = value[property]
    } else {
      return undefined // or whatever default value you want to return if property doesn't exist
    }
  }
  return value
}
export const isFunction = posibleFunction => isLodashFunction(posibleFunction)
