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

CREATE TABLE `time_dimension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year_number` smallint(6) NOT NULL,
  `day_of_year` smallint(6) NOT NULL,
  `quarter_number` tinyint(4) NOT NULL,
  `month_number` tinyint(4) NOT NULL,
  `month_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `month_day_number` tinyint(4) NOT NULL,
  `week_number` tinyint(4) NOT NULL,
  `day_of_week_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_all` (`year_number`,`day_of_year`,`quarter_number`,`month_number`,`month_name`,`month_day_number`,`week_number`,`day_of_week_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This tables has the time dimension.Each day corresponds to one row in the table';
