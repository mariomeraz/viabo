export function getColorName(hex) {
  let color

  switch (hex) {
    case '#00AB55':
      color = 'Green'
      break
    case '#000000':
      color = 'Black'
      break
    case '#FFFFFF':
      color = 'White'
      break
    case '#FFC0CB':
      color = 'Pink'
      break
    case '#FF4842':
      color = 'Red'
      break
    case '#1890FF':
      color = 'Blue'
      break
    case '#94D82D':
      color = 'Greenyellow'
      break
    case '#FFC107':
      color = 'Orange'
      break
    default:
      color = hex
  }

  return color
}

export const contrastColor = color => {
  const lum = [0.299 /* red */, 0.587 /* green */, 0.114 /* blue */].reduce((result, value, index) => {
    // with reduce() we can convert an array of numbers into a single number
    // result = previous result returned by this function
    // value = https://www.w3.org/TR/AERT/#color-contrast
    // index = current position index in the array
    // num = decimal number of Red, Green or Blue color
    const num = parseInt(color.substr(index * 2 + 1, 2), 16)
    return num * value + result
  }, 0 /* result = 0 */)

  const isDark = lum < 128
  const index = ~~isDark // convert boolean into 0 or 1
  return ['#000', '#fff'][index]
}
