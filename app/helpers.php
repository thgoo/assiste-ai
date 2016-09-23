<?php

/**
 * Creates fancy flash messages.
 *
 * @param null $title
 * @param null $message
 * @return \App\AssisteAi\Flash|mixed
 */
function flash($title = null, $message = null)
{
    $flash = app('App\AssisteAi\Flash');

    if(func_num_args() == 0) {
        return $flash;
    }

    return $flash->info($title, $message);
}

/**
 * Creates relative time based on timestamp
 *
 * @param $ts
 * @return bool|string
 */
function time2str($ts)
{
    if(!ctype_digit($ts)) {
        $ts = strtotime($ts);
    }
    $diff = time() - $ts;
    if($diff == 0) {
        return 'agora';
    } elseif($diff > 0) {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0) {
            if($diff < 60) return 'alguns segundos atrás';
            if($diff < 120) return '1 minuto atrás';
            if($diff < 3600) return floor($diff / 60) . ' minutos trás';
            if($diff < 7200) return '1 hora atrás';
            if($diff < 86400) return floor($diff / 3600) . ' horas atrás';
        }
        if($day_diff == 1) {
            return 'ontem';
        }
        if($day_diff < 7) {
            return $day_diff . ' dias atrás';
        }
        if($day_diff == 7) {
            return 'semana passada';
        }
        if($day_diff < 31) {
            return ceil($day_diff / 7) . ' semanas atrás';
        }
        if($day_diff < 60) {
            return 'mês passado';
        }
        if($day_diff < 365) {
            return ceil($day_diff / 31) . ' meses atrás';
        }
        if($day_diff < 730) {
            return 'ano passado';
        } else {
            return ceil($day_diff / 365) . ' anos atrás';
        }
    } else {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0) {
            if($diff < 120) {
                return 'daqui um minuto';
            }
            if($diff < 3600) {
                return 'em ' . floor($diff / 60) . ' minutos';
            }
            if($diff < 7200) {
                return 'daqui uma hora';
            }
            if($diff < 86400) {
                return 'em ' . floor($diff / 3600) . ' horas';
            }
        }
        if($day_diff == 1) {
            return 'amanhã';
        }
        if($day_diff < 4) {
            return date('l', $ts);
        }
        if($day_diff < 7 + (7 - date('w'))) {
            return 'semana que vem';
        }
        if(ceil($day_diff / 7) < 4) {
            return 'em ' . ceil($day_diff / 7) . ' semanas';
        }
        if(date('n', $ts) == date('n') + 1) {
            return 'mês que vem';
        }

        return date('F Y', $ts);
    }
}

/**
 * Shorten given string and append "..." to the end.
 *
 * @param string $string
 * @param int    $max_size
 * @return string
 */
function shorten($string, $max_size)
{
    return rtrim(mb_substr($string, 0, $max_size), ' .,;:-/\\') . '...';
}