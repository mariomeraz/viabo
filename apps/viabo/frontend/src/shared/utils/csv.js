import { ExportToCsv } from 'export-to-csv'

const generateCSVFile = (columns, rows, fileName = 'archivo') => {
  const fileNameFormated = `${fileName}_${new Date().toLocaleTimeString()}`
  const csvOptions = {
    fieldSeparator: ',',
    quoteStrings: '"',
    decimalSeparator: '.',
    showLabels: true,
    useBom: true,
    useKeysAsHeaders: false,
    headers: columns,
    showTitle: true,
    title: fileName,
    filename: fileNameFormated
  }

  const csvExporter = new ExportToCsv(csvOptions)

  return csvExporter.generateCsv(rows)
}

export { generateCSVFile }
