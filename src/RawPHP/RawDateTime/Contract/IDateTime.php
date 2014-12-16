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
 * @package   RawPHP\RawDateTime\Contract
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawDateTime\Contract;

use DateTime;

/**
 * This Raw Date Time interface.
 *
 * @category  PHP
 * @package   RawPHP\RawDateTime\Contract
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
interface IDateTime
{
    /**
     * Converts the current date time object to UTC time.
     *
     * @param DateTime $date the date time object to convert
     *
     * @return DateTime the UTC date time object
     */
    public static function getUtcDateTime( DateTime $date );

    /**
     * Converts the UTC date time object to user time.
     *
     * @param DateTime $date     the date time to convert
     * @param string   $timezone the time zone
     *
     * @return DateTime the user timezone date time object
     */
    public static function getUserDateTime( DateTime $date, $timezone = '' );

    /**
     * Returns the span between the two dates.
     *
     * @param DateTime $date1     first date
     * @param DateTime $date2     second date
     * @param string   $type      the scale of span output
     *                            [ years, months, days, hours, minutes, seconds ]
     * @param bool     $absolute  should the output be forced to be positive
     *
     * @return mixed the span between the dates or FALSE on error
     */
    public static function getSpan( DateTime $date1, DateTime $date2,
                                    $type = 'hours', $absolute = TRUE
    );
}