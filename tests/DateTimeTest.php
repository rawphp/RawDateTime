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
 * @package   RawPHP/RawDateTime/Tests
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawDateTime\Tests;

use DateTimeZone;
use PHPUnit_Framework_TestCase;
use RawPHP\RawDateTime\DateTime;

/**
 * This class extends DateTime and provides useful utility methods.
 * 
 * @category  PHP
 * @package   RawPHP/RawDateTime/Tests
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class DateTimeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test converting a date time object to UTC timezone.
     */
    public function testGetUtcDateTime( )
    {
        $date     = new DateTime( );
        $expected = new DateTime( );
        $expected->setTimezone( new DateTimeZone( 'UTC' ) );
        
        $utc = DateTime::getUtcDateTime( $date );
        
        $this->assertEquals( $expected->getTimestamp( ), $utc->getTimestamp( ) );
    }
    
    /**
     * Test getting user time from UTC timezone.
     */
    public function testGetUserDateTime( )
    {
        $date = new DateTime( );
        $date->setTimezone( new DateTimeZone( 'UTC' ) );
        $expected = new DateTime( );
        
        $this->assertEquals( $expected->getTimestamp( ), $date->getTimestamp( ) );
    }
    
    /**
     * Test get span returns the correct time span.
     * 
     * @param string $mod  the modification string
     * @param int    $diff the difference
     * @param string $span the span name
     * 
     * @dataProvider spanProvider the data provider method
     */
    public function testGetSpan( $mod, $diff, $span )
    {
        $date = new DateTime( );
        $date->modify( $mod );
        
        $now = new DateTime( );
        
        $this->assertEquals( $diff, DateTime::getSpan( $now, $date, $span, FALSE ) );
    }
    
    /**
     * Data provider for testGetSpan().
     * 
     * @return array an array of test sets
     */
    public function spanProvider( )
    {
        return [
            // years
            [ '+ 10 years', 10, DateTime::SPAN_YEARS ],    // 0
            [ '- 10 years', -10, DateTime::SPAN_YEARS ],   // 1
            
            // months
            [ '+ 2 months', 2, DateTime::SPAN_MONTHS ],    // 2
            [ '+ 10 months', 10, DateTime::SPAN_MONTHS ],  // 3
            [ '- 12 months', -12, DateTime::SPAN_MONTHS ], // 4
            
            // weeks
            [ '+ 10 weeks', 10, DateTime::SPAN_WEEKS ],    // 5
            [ '- 10 weeks', -10, DateTime::SPAN_WEEKS ],   // 6
            
            // days
            [ '+ 2 days', 2, DateTime::SPAN_DAYS ],        // 7
            [ '+ 10 days', 10, DateTime::SPAN_DAYS ],      // 8
            [ '- 12 days', -12, DateTime::SPAN_DAYS ],     // 9
            
            // hours
            [ '+ 2 hours', 2, DateTime::SPAN_HOURS ],      // 10
            [ '+ 10 hours', 10, DateTime::SPAN_HOURS ],    // 11
            [ '- 12 hours', -12, DateTime::SPAN_HOURS ],   // 12
            
            // minutes
            [ '+ 2 minutes', 2, DateTime::SPAN_MINUTES ],      // 13
            [ '+ 122 minutes', 122, DateTime::SPAN_MINUTES ],  // 14
            [ '- 122 minutes', -122, DateTime::SPAN_MINUTES ], // 15
            
            // seconds
            [ '+ 2 seconds', 2, DateTime::SPAN_SECONDS ],      // 16
            [ '+ 10 seconds', 10, DateTime::SPAN_SECONDS ],    // 17
            [ '- 12 seconds', -12, DateTime::SPAN_SECONDS ],   // 18
        ];
    }
}