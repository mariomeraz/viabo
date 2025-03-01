import {
  addDays,
  addMinutes,
  addMonths,
  addWeeks,
  addYears,
  differenceInHours,
  differenceInMinutes,
  eachDayOfInterval,
  endOfMonth,
  endOfWeek,
  endOfYear,
  format,
  formatDistanceToNow,
  formatDistanceToNowStrict,
  getTime,
  isWeekend,
  parseISO,
  startOfMonth,
  startOfWeek,
  startOfYear
} from 'date-fns'
import { es } from 'date-fns/locale'

export function fDate(date) {
  return format(new Date(date), 'dd MMMM, yyyy', { locale: es })
}

export function fDateTime(date) {
  return format(new Date(date), 'dd MMM yyyy HH:mm', { locale: es })
}

export function fTime(date) {
  return format(new Date(date), 'hh:mm a', { locale: es })
}

export function fTimestamp(date) {
  return getTime(new Date(date))
}

export function fDateTimeSuffix(date) {
  return format(new Date(date), 'dd/MM/yyyy hh:mm p', { locale: es })
}

export function fToNowStrict(date) {
  return formatDistanceToNowStrict(new Date(date), {
    addSuffix: true,
    locale: es
  })
}

export function normalizeDateString(dateString) {
  const dateObj = parseISO(dateString)

  const timeZoneOffset = new Date().getTimezoneOffset()

  const adjustedDateObj = addMinutes(dateObj, timeZoneOffset)

  return adjustedDateObj
}

export const monthOptions = [
  'Enero',
  'Febrero',
  'Marzo',
  'Abril',
  'Mayo',
  'Junio',
  'Julio',
  'Agosto',
  'Septiembre',
  'Octubre',
  'Noviembre',
  'Diciembre'
]

export function fToNow(date) {
  return formatDistanceToNow(new Date(date), {
    addSuffix: true,
    includeSeconds: true,
    locale: es
  })
}

export const getDateRange = (date = new Date()) => [
  {
    label: 'Hoy',
    startDate: date,
    endDate: date
  },
  {
    label: 'Ayer',
    startDate: addDays(date, -1),
    endDate: addDays(date, -1)
  },
  {
    label: 'Esta Semana',
    startDate: startOfWeek(date, { locale: es }),
    endDate: endOfWeek(date, { locale: es })
  },
  {
    label: 'Última Semana',
    startDate: startOfWeek(addWeeks(date, -1), { locale: es }),
    endDate: endOfWeek(addWeeks(date, -1), { locale: es })
  },
  {
    label: 'Últimos 7 Días',
    startDate: addWeeks(date, -1),
    endDate: date
  },
  {
    label: 'Este Mes',
    startDate: startOfMonth(date),
    endDate: endOfMonth(date)
  },
  {
    label: 'Último Mes',
    startDate: startOfMonth(addMonths(date, -1)),
    endDate: endOfMonth(addMonths(date, -1))
  },
  {
    label: 'Este Año',
    startDate: startOfYear(date),
    endDate: endOfYear(date)
  },
  {
    label: 'Último Año',
    startDate: startOfYear(addYears(date, -1)),
    endDate: endOfYear(addYears(date, -1))
  }
]

export function calculateTimeWithoutWeekends(startDate, endDate = new Date()) {
  const daysWithoutWeekends = eachDayOfInterval({ start: startDate, end: endDate }).filter(date => !isWeekend(date))

  const adjustedEndDate = addDays(endDate, daysWithoutWeekends.length - 1)

  if (adjustedEndDate > startDate) {
    const totalMinutes = differenceInMinutes(adjustedEndDate, startDate)
    return formatDistanceToNow(new Date(0, 0, 0, 0, totalMinutes))
  } else {
    const totalHours = differenceInHours(startDate, endDate)
    return formatDistanceToNow(new Date(0, 0, 0, totalHours))
  }
}
