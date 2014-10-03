<?php

/**
 * This file is part of RawPHP - a PHP Framework.
 * 
 * Copyright (c) 2014 RawPHP.org
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * 
 * PHP version 5.3
 * 
 * @category  PHP
 * @package   RawPHP/RawDateTime
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawDateTime;

use RawPHP\RawDateTime\IDateTime;

/**
 * This class extends DateTime and provides useful utility methods.
 * 
 * @category  PHP
 * @package   RawPHP/RawDateTime
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class DateTime extends \DateTime implements IDateTime
{
    /**
     * Converts the current date time object to UTC time.
     * 
     * @param \DateTime $date the date time object to convert
     * 
     * @return \DateTime the UTC date time object
     */
    public static function getUtcDateTime( \DateTime $date )
    {
        $newDate = new \DateTime( );
        $newDate->setTimestamp( $date->getTimestamp() );
        $newDate->setTimezone( new \DateTimeZone( 'UTC' ) );
        
        return $newDate;
    }
    
    /**
     * Converts the UTC date time object to user time.
     * 
     * @param \DateTime $date     the date time to convert
     * @param string    $timezone the time zone
     * 
     * @return \DateTime the user timezone date time object
     */
    public static function getUserDateTime( \DateTime $date, $timezone = '' )
    {
        $newDate = new \DateTime( );
        $newDate->setTimestamp( $date->getTimestamp() );
        
        if ( is_string( $timezone ) && !empty( $timezone ) )
        {
            $timezone = new \DateTimeZone( $timezone );
        }
        if ( empty( $timezone ) )
        {
            $timezone = new \DateTimeZone( ini_get( 'date.timezone' ) );
        }
        
        $newDate->setTimezone( $timezone );
        
        return $newDate;
    }
    
    /**
     * Returns the span between the two dates.
     * 
     * @param \DateTime $date1    first date
     * @param \DateTime $date2    second date
     * @param string    $type     the scale of span output 
     *                            [ years, months, days, hours, minutes, seconds ]
     * @param bool      $absolute should the output be forced to be positive
     * 
     * @return mixed the span between the dates or FALSE on error
     */
    public static function getSpan( \DateTime $date1, \DateTime $date2, 
        $type = self::SPAN_HOURS, $absolute = TRUE
    )
    {
        $diff = $date1->diff( $date2, $absolute );

        $span = 0;
        
        switch( $type )
        {
            case self::SPAN_YEARS:
                $span = ( int )$diff->y;
                break;
            
            case self::SPAN_MONTHS:
                $span  = $diff->y * 12;
                $span += $diff->m;
                $span  = ( int )$span;
                break;
            
            case self::SPAN_WEEKS:
                $span += $diff->days;
                $span  = ( int )( $span / 7 );
                break;
            
            case self::SPAN_DAYS:
                $span = ( int )$diff->days;
                break;
            
            case self::SPAN_HOURS:
                $span  = ( $diff->days * 24 );
                $span += $diff->h;
                $span  = ( int )$span;
                break;
            
            case self::SPAN_MINUTES:
                $span  = ( $diff->days * 24 );
                $span += $diff->h;
                $span  = ( $span * 60 );
                $span += $diff->i;
                $span  = ( int )$span;
                break;
            
            case self::SPAN_SECONDS:
                $span  = ( $diff->days * 24 );
                $span += $diff->h;
                $span  = ( $span * 60 );
                $span += $diff->i;
                $span  = ( int )( $span * 60 );
                $span += $diff->s;
                break;
            
            default:
                $span = FALSE;
                break;
        }
        
        if ( FALSE === $span )
        {
            return $span;
        }
        
        if ( 1 == $diff->invert )
        {
            return ( $span * -1 );
        }
        
        return $span;
    }
    
    const SPAN_YEARS    = 'years';
    const SPAN_MONTHS   = 'months';
    const SPAN_WEEKS    = 'weeks';
    const SPAN_DAYS     = 'days';
    const SPAN_HOURS    = 'hours';
    const SPAN_MINUTES  = 'minutes';
    const SPAN_SECONDS  = 'seconds';
    
    public static $timezones = array(
        'Kwajalein' => '(GMT-12:00) International Date Line West',
        'Pacific/Midway' => '(GMT-11:00) Midway Island',
        'Pacific/Samoa' => '(GMT-11:00) Samoa',
        'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
        'America/Anchorage' => '(GMT-09:00) Alaska',
        'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US &amp; Canada)',
        'America/Tijuana' => '(GMT-08:00) Tijuana, Baja California',
        'America/Denver' => '(GMT-07:00) Mountain Time (US &amp; Canada)',
        'America/Chihuahua' => '(GMT-07:00) Chihuahua',
        'America/Mazatlan' => '(GMT-07:00) Mazatlan',
        'America/Phoenix' => '(GMT-07:00) Arizona',
        'America/Regina' => '(GMT-06:00) Saskatchewan',
        'America/Tegucigalpa' => '(GMT-06:00) Central America',
        'America/Chicago' => '(GMT-06:00) Central Time (US &amp; Canada)',
        'America/Mexico_City' => '(GMT-06:00) Mexico City',
        'America/Monterrey' => '(GMT-06:00) Monterrey',
        'America/New_York' => '(GMT-05:00) Eastern Time (US &amp; Canada)',
        'America/Bogota' => '(GMT-05:00) Bogota',
        'America/Lima' => '(GMT-05:00) Lima',
        'America/Rio_Branco' => '(GMT-05:00) Rio Branco',
        'America/Indiana/Indianapolis' => '(GMT-05:00) Indiana (East)',
        'America/Caracas' => '(GMT-04:30) Caracas',
        'America/Halifax' => '(GMT-04:00) Atlantic Time (Canada)',
        'America/Manaus' => '(GMT-04:00) Manaus',
        'America/Santiago' => '(GMT-04:00) Santiago',
        'America/La_Paz' => '(GMT-04:00) La Paz',
        'America/St_Johns' => '(GMT-03:30) Newfoundland',
        'America/Argentina/Buenos_Aires' => '(GMT-03:00) Georgetown',
        'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
        'America/Godthab' => '(GMT-03:00) Greenland',
        'America/Montevideo' => '(GMT-03:00) Montevideo',
        'Atlantic/South_Georgia' => '(GMT-02:00) Mid-Atlantic',
        'Atlantic/Azores' => '(GMT-01:00) Azores',
        'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
        'Europe/Dublin' => '(GMT) Dublin',
        'Europe/Lisbon' => '(GMT) Lisbon',
        'Europe/London' => '(GMT) London',
        'Africa/Monrovia' => '(GMT) Monrovia',
        'Atlantic/Reykjavik' => '(GMT) Reykjavik',
        'Africa/Casablanca' => '(GMT) Casablanca',
        'Europe/Belgrade' => '(GMT+01:00) Belgrade',
        'Europe/Bratislava' => '(GMT+01:00) Bratislava',
        'Europe/Budapest' => '(GMT+01:00) Budapest',
        'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
        'Europe/Prague' => '(GMT+01:00) Prague',
        'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
        'Europe/Skopje' => '(GMT+01:00) Skopje',
        'Europe/Warsaw' => '(GMT+01:00) Warsaw',
        'Europe/Zagreb' => '(GMT+01:00) Zagreb',
        'Europe/Brussels' => '(GMT+01:00) Brussels',
        'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
        'Europe/Madrid' => '(GMT+01:00) Madrid',
        'Europe/Paris' => '(GMT+01:00) Paris',
        'Africa/Algiers' => '(GMT+01:00) West Central Africa',
        'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
        'Europe/Berlin' => '(GMT+01:00) Berlin',
        'Europe/Rome' => '(GMT+01:00) Rome',
        'Europe/Stockholm' => '(GMT+01:00) Stockholm',
        'Europe/Vienna' => '(GMT+01:00) Vienna',
        'Europe/Minsk' => '(GMT+02:00) Minsk',
        'Africa/Cairo' => '(GMT+02:00) Cairo',
        'Europe/Helsinki' => '(GMT+02:00) Helsinki',
        'Europe/Riga' => '(GMT+02:00) Riga',
        'Europe/Sofia' => '(GMT+02:00) Sofia',
        'Europe/Tallinn' => '(GMT+02:00) Tallinn',
        'Europe/Vilnius' => '(GMT+02:00) Vilnius',
        'Europe/Athens' => '(GMT+02:00) Athens',
        'Europe/Bucharest' => '(GMT+02:00) Bucharest',
        'Europe/Istanbul' => '(GMT+02:00) Istanbul',
        'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
        'Asia/Amman' => '(GMT+02:00) Amman',
        'Asia/Beirut' => '(GMT+02:00) Beirut',
        'Africa/Windhoek' => '(GMT+02:00) Windhoek',
        'Africa/Harare' => '(GMT+02:00) Harare',
        'Asia/Kuwait' => '(GMT+03:00) Kuwait',
        'Asia/Riyadh' => '(GMT+03:00) Riyadh',
        'Asia/Baghdad' => '(GMT+03:00) Baghdad',
        'Africa/Nairobi' => '(GMT+03:00) Nairobi',
        'Asia/Tbilisi' => '(GMT+03:00) Tbilisi',
        'Europe/Moscow' => '(GMT+03:00) Moscow',
        'Europe/Volgograd' => '(GMT+03:00) Volgograd',
        'Asia/Tehran' => '(GMT+03:30) Tehran',
        'Asia/Muscat' => '(GMT+04:00) Muscat',
        'Asia/Baku' => '(GMT+04:00) Baku',
        'Asia/Yerevan' => '(GMT+04:00) Yerevan',
        'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
        'Asia/Karachi' => '(GMT+05:00) Karachi',
        'Asia/Tashkent' => '(GMT+05:00) Tashkent',
        'Asia/Kolkata' => '(GMT+05:30) Calcutta',
        'Asia/Colombo' => '(GMT+05:30) Sri Jayawardenepura',
        'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
        'Asia/Dhaka' => '(GMT+06:00) Dhaka',
        'Asia/Almaty' => '(GMT+06:00) Almaty',
        'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk',
        'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)',
        'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
        'Asia/Bangkok' => '(GMT+07:00) Bangkok',
        'Asia/Jakarta' => '(GMT+07:00) Jakarta',
        'Asia/Brunei' => '(GMT+08:00) Beijing',
        'Asia/Chongqing' => '(GMT+08:00) Chongqing',
        'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
        'Asia/Urumqi' => '(GMT+08:00) Urumqi',
        'Asia/Irkutsk' => '(GMT+08:00) Irkutsk',
        'Asia/Ulaanbaatar' => '(GMT+08:00) Ulaan Bataar',
        'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
        'Asia/Singapore' => '(GMT+08:00) Singapore',
        'Asia/Taipei' => '(GMT+08:00) Taipei',
        'Australia/Perth' => '(GMT+08:00) Perth',
        'Asia/Seoul' => '(GMT+09:00) Seoul',
        'Asia/Tokyo' => '(GMT+09:00) Tokyo',
        'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
        'Australia/Darwin' => '(GMT+09:30) Darwin',
        'Australia/Adelaide' => '(GMT+09:30) Adelaide',
        'Australia/Canberra' => '(GMT+10:00) Canberra',
        'Australia/Melbourne' => '(GMT+10:00) Melbourne',
        'Australia/Sydney' => '(GMT+10:00) Sydney',
        'Australia/Brisbane' => '(GMT+10:00) Brisbane',
        'Australia/Hobart' => '(GMT+10:00) Hobart',
        'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
        'Pacific/Guam' => '(GMT+10:00) Guam',
        'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
        'Asia/Magadan' => '(GMT+11:00) Magadan',
        'Pacific/Fiji' => '(GMT+12:00) Fiji',
        'Asia/Kamchatka' => '(GMT+12:00) Kamchatka',
        'Pacific/Auckland' => '(GMT+12:00) Auckland',
        'Pacific/Tongatapu' => '(GMT+13:00) Nukualofa'
    );
}