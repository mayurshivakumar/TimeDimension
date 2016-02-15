<?php
/*
    Copyright (C) Mayur Shivakumar (sk.mayur@gmail.com)
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU Lesser General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once 'vendor/sergeytsalkov/meekrodb/db.class.php';

DB::$host = "your_host";
DB::$port = "your_port";
DB::$user = 'user';
DB::$password = 'password';
DB::$dbName = 'databse name';
DB::$error_handler = false;
DB::$throw_exception_on_error = true;


$td = new TimeDimension();
$date = date("Y-m-d");
$td->insertToTimeDimensionTable($date, 1);

class TimeDimension
{

    public function __construct() {}

    /**
     * Truncates the time dimension table.
     */
    public function truncateTimeDimensionTable()
    {
        try {
            DB::query('truncate table time_dimension');

        } catch (MeekroDBException $e) {
            echo "Error: " . $e->getMessage() . "\n";
            echo "SQL Query: " . $e->getQuery() . "\n";
        }
        // this is a fun work around before php 5.5 for finally block.
        if($e) {
            // finally block if there is a exception
        }
    }

    /**
     * @param int year_number, int month_number, int month_day_number
     * @return int time_dimension_id
     */
    public function getTimeDimensionId($year_number, $month_number, $month_day_number)
    {
        try {
            $where = new WhereClause('and');
            $where->add('year_number=%i', $year_number);
            $where->add('month_number=%i', $month_number);
            $where->add('month_day_number=%i', $month_day_number);

            $time_dimesnion_id = DB::queryFirstRow("SELECT id FROM time_dimension WHERE %l", $where);

            return $time_dimesnion_id['id'];

        } catch (MeekroDBException $e) {
            echo "Error: " . $e->getMessage() . "\n";
            echo "SQL Query: " . $e->getQuery() . "\n";
        } // this is a fun work around before php 5.5 for finally block.
        if($e) {
            // finally block if there is a exception
        }
    }

    /**
     * Insert intotime dimension table.
     * @params date date, int number_of_years
     */
    public function insertToTimeDimensionTable($date, $number_of_years)
    {
        try {
            $years_from_now = date('Y-m-d', strtotime($date . "+{$number_of_years} Years"));
            while ($date <= $years_from_now )
            {
                $day_of_year = 1 + date('z', strtotime($date));
                $month_name = date('F', strtotime($date));
                $day_of_week_name = date('l', strtotime($date));
                DB::insert(
                    'time_dimension',
                    array(
                        'year_number' => date('Y', strtotime($date)),
                        'day_of_year' => $day_of_year,
                        'quarter_number' => ceil(date('m', strtotime($date))/3),
                        'month_number' => date('m', strtotime($date)),
                        'month_name' => $month_name,
                        'month_day_number' => date('j', strtotime($date)),
                        'week_number' => date('W', strtotime($date)),
                        'day_of_week_name' => $day_of_week_name,
                    )
                );
                $date = date('Y-m-d', strtotime($date.' +1 day'));
            }
        }
        catch(MeekroDBException $e) {
            echo "Error: " . $e->getMessage() . "\n";
            echo "SQL Query: " . $e->getQuery() . "\n";
        }
        // this is a fun work around before php 5.5 for finally block.
        if($e) {
            // finally block if there is a exception
        }
    }
}
