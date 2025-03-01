function isHTML(str) {
  const doc = new DOMParser().parseFromString(str, 'text/html')
  return Array.from(doc.body.childNodes).some(node => node.nodeType === 1)
}

const copyToClipboard = text => {
  if (isMobile) {
    // Crea un elemento de texto temporal
    const tempTextArea = document.createElement('textarea')
    tempTextArea.value = text
    document.body.appendChild(tempTextArea)

    // Selecciona el texto en el elemento de texto
    tempTextArea.select()

    try {
      // Copia el texto al portapapeles
      document.execCommand('copy')
    } catch (err) {
      console.error('Error al copiar al portapapeles:', err)
    } finally {
      // Elimina el elemento de texto temporal
      document.body.removeChild(tempTextArea)
    }
  } else {
    navigator.clipboard
      .writeText(text)
      .then(() => {})
      .catch(err => {
        console.error('Error al copiar al portapapeles:', err)
      })
  }
}

const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)

export { copyToClipboard, isHTML, isMobile }
