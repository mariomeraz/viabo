<?php

namespace Viabo\shared\domain\utils;


use DateTime;

class DatePHP
{
    private const FORMAT_DATETIME = 'Y-m-d H:i:s';

    private function timeZone(): void
    {
        date_default_timezone_set('America/Mexico_City');
    }

    public function now(): string
    {
        $this->timeZone();
        $format = 'Y-m-d';
        return date($format);
    }

    public function dateTime(): string
    {
        $this->timeZone();
        $format = self::FORMAT_DATETIME;
        return date($format);
    }

    public function formatDateTime(string $value, string $format = null): string
    {
        $this->timeZone();
        $dateTime = new \DateTime($value);
        return $dateTime->format($format ?? self::FORMAT_DATETIME);
    }

    public function hasFormatDateTime(string $value): false|int
    {
        return preg_match("/^(\d{4})-(\d{1,2})-(\d{1,2})\s(\d{1,2}):(\d{1,2}):(\d{1,2})$/", $value);
    }

    public function isOlderDate(string $date): bool
    {
        $this->timeZone();
        $dateEntered = $this->dateUnix(($date));
        $actual = $this->dateUnix(date("Y-m-d", time()));

        if ($dateEntered > $actual) {
            return true;
        }
        return false;
    }

    public function isMinorDate(string $date): bool
    {
        $this->timeZone();
        $dateEntered = $this->dateUnix(($date));
        $actual = $this->dateUnix((date("Y-m-d", time())));

        if ($dateEntered < $actual) {
            return true;
        }
        return false;
    }

    public function isSameDate(string $date): bool
    {
        $this->timeZone();
        $dateEntered = $this->dateUnix(($date));
        $actual = $this->dateUnix((date("Y-m-d", time())));

        if ($dateEntered == $actual) {
            return true;
        }
        return false;
    }

    public function dateUnix(string $date): string
    {
        $this->timeZone();
        return strtotime($date);
    }

    public function incrementWeeks(string $date, int $weeks): string
    {
        $this->timeZone();
        $date = date_create($date);
        date_add($date, date_interval_create_from_date_string($weeks . ' weeks'));
        return date_format($date, 'Y-m-d');
    }

    public function incrementDays(string $date, int $days): string
    {
        $this->timeZone();
        $date = date_create($date);
        date_add($date, date_interval_create_from_date_string($days . ' days'));
        return date_format($date, 'Y-m-d');
    }

    public function decreaseDays(string $date, int $days): string
    {
        $this->timeZone();
        $date = date_create($date);
        return date('Y-m-d', strtotime($date . '- ' . $days . ' days'));
    }

    public function decreasesWeeks(string $now, int $weeks): string
    {
        $this->timeZone();
        $date = date($now);
        return date('Y-m-d', strtotime($date . '- ' . $weeks . ' week'));
    }

    public function lastDayOfTheMonth(string $date): string
    {
        $this->timeZone();
        $date = new DateTime($date);
        return $date->format('Y-m-t');
    }

    public function lastDayOfWeek(string $date, string $dayOfWeek): string
    {
        $this->timeZone();
        $date = new DateTime($date);
        $date->modify('last ' . $dayOfWeek);
        return $date->format('Y-m-d');
    }

    /**
     * @param string $format Each format character must be prefixed with a percent sign (%), example %h %i %s
     */
    public function diffDates(string $date1, string $date2, string $format): string
    {
        $this->timeZone();
        $date1 = date_create($date1);
        $date2 = date_create($date2);
        $difference = $date1->diff($date2);

        return $difference->format($format);
    }

    public function diffInDays(string $date1, string $date2): int
    {
        $this->timeZone();
        $date1 = date_create($date1);
        $date2 = date_create($date2);
        $difference = $date1->diff($date2);

        return intval($difference->days);
    }

    public function diffInMinutes(string $date1, string $date2): float
    {
        $minutes = (strtotime($date1) - strtotime($date2)) / 60;
        return floor(abs($minutes));
    }

    public function diffNow(string $dateOld): string
    {
        $date = new DateTime($dateOld);
        $dateNow = new DateTime();
        $diff = date_diff($date, $dateNow);

        $timeDiff = '';
        if ($diff->y > 0) {
            $timeDiff .= $diff->y . ' año(s) ';
        }
        if ($diff->m > 0) {
            $timeDiff .= $diff->m . ' mes(es) ';
        }
        if ($diff->d > 0) {
            $timeDiff .= $diff->d . ' día(s) ';
        }
        if ($diff->h > 0) {
            $timeDiff .= $diff->h . ' hora(s) ';
        }
        if ($diff->i > 0) {
            $timeDiff .= $diff->i . ' minuto(s) ';
        }
        if ($diff->i === 0 && $diff->s > 0) {
            $timeDiff .= $diff->s . ' segundo(s) ';
        }

        return $timeDiff;
    }

    public function serializeDate(): string
    {
        $this->timeZone();
        $date = new DateTime();
        $timestamp = $date->getTimestamp();
        return sprintf("%07d", $timestamp % 10000000); // Obtiene los últimos 7 dígitos del timestamp
    }

    public function deserializeDate(int $serial): int
    {
        $timestamp = $serial + time(); // Recupera el timestamp original sumando el número serializado al timestamp actual
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        return $date->format(self::FORMAT_DATETIME);
    }

    public function convertTimestampToDate(string|int $timestamp, string $format = 'Y-m-d H:i:s'): string
    {
        $this->timeZone();
        $timestamp = is_string($timestamp) ? intval($timestamp) : $timestamp;
        $timestamp = strlen($timestamp) === 13 ? intval($timestamp / 1000) : $timestamp;
        return date($format, $timestamp);
    }

    public function firstDayMonth(string $date = ''): string
    {
        $this->timeZone();
        $firstDay = empty($date) ? new DateTime() : new DateTime($date);
        return $firstDay->modify('first day of this month')->format('Y-m-d');
    }

    public function lastDayMonth(string $date = ''): string
    {
        $this->timeZone();
        $lastDay = empty($date) ? new DateTime() : new DateTime($date);
        return $lastDay->modify('last day of this month')->format('Y-m-d');
    }
}
