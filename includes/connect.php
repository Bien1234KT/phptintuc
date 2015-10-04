<?php
    /******************************************************************
     * CÁC HÀM TẠO KẾT NỐI, ĐÓNG KẾT NỐI  TỚI DATABASE
     * 
     *  Chú thích:
     *  $host           tên máy chủ
     *  $user           tên người dùng
     *  $password       mật khẩu
     *  $database       tên database
     *  $link           kết nối tới database
     ******************************************************************/
    // Hàm tạo kết nối đến database và trả về kết nối được tạo
   function getDatabaseLink($host, $user, $password, $database) {
       $link = mysqli_connect($host, $user, $password, $database);
       if (!$link) {
           return null;
       }
       return $link;   
   }
    // Hàm đóng kết nối đến database
   function closeDatabaseLink($link) {
       if ($link) {
           mysqli_close($link);
        }
    }
    
    /******************************************************************
     * CÁC HÀM TRUY VẤN DỮ LIỆU
     * 
     *  Chú thích
     *  $link           kết nối tới database
     *  $table          tên bảng
     *  $query          câu truy vấn
     *  $result         kết quả
     *  $condition(s)   (các) điều kiện
     *  $colmn(s)       tên (các) cột
     *  $value(s)       (các) giá trị
     ******************************************************************/
    // Hàm thực hiện một truy vấn và trả về kết quả
   function query($link, $query) {
       if (!$link) {
           return null;
       }
       $result = mysqli_query($link, $query);
       return $result;
   }   
   #################################################
   // Hàm tạo điều kiện compare column = value
   function equals($column, $value) {
       $condition = ' '.$column.' = \''.$value.'\'';
       return $condition;
   }
   //Hàm tạo điều kiện compare column like value
   function like($column, $value) {
       $condition = ' '.$column.' LIKE \'%'.$value.'%\'';
       return $condition;
   }
   // Hàm tạo điều kiện compare column condtion value
   function compare($column, $condition, $value) {
       $condition = ' '.$column.' '.$condition.' '.$value;
       return $condition;
   }
   // Hàm tạo mệnh đề IN (set)
   function wIN($column, $set) {
       return ' '.$column.' IN ('.$set.') ';
   }
   // Hàm tạo mệnh đề NOT IN (set)
   function wNOTIN($column, $set) {
       return ' '.$column.' NOT IN ('.$set.') ';
   }
   // Hàm tạo mệnh đề AND(conditions)
   function wAND($conditions) {
       return ' AND('.$conditions.') ';
   }
   // Hàm tạo mệnh đề OR(conditions)
   function wOR($conditions) {
       return ' OR('.$conditions.') ';
   }
   // Hàm tạo mệnh đề NOT(conditions)
   function wNOT($conditions) {
       return '  NOT('.$conditions.') ';
   }
   // Hàm tạo mệnh đề SELECT *
   function selectAll() {
       return "SELECT * ";
   }
   // Hàm tạo mệnh đề SELECT col1, col2,...
   function select($columns) {
       if (is_null($columns) or count($columns) == 0) {
           return selectAll();
       }
       if (is_array($columns)) {
           $select = 'SELECT '.$columns[0];
           for ($index = 1; $index < count($columns); $index++) {
               $select .= ', '.$columns[$index];
           }
           return $select;
       }
       return 'SELECT '.$columns;
   }
   // Hàm tạo mệnh đề FROM table
   function from($table) {
       return " FROM ".$table;
   }
   // Hàm tạo mệnh đề WHERE conditions
   function where($conditions) {
       if (is_null($conditions) or count_chars($conditions) == 0) {
           return;
       }
       return ' WHERE '.$conditions;
   }
   // Hàm tạo mệnh đề GROUP BY
   function groupBy($columns) {
       if (is_null($columns) or count($columns) == 0) {
           return;
       }
       if (is_array($columns)) {
           $groupby = ' GROUP BY '.$columns[0];
           for ($index = 1; $index < count($columns); $index++) {
               $groupby .= ', '.$columns[$index];
           }
           return $groupby;
       }
       return ' GROUP BY '.$columns;
   }
   // Hàm tạo mệnh đề ORDER BY
   function orderBy($columns) {
       if (is_null($columns) or count($columns) == 0) {
           return;
       }
       if (is_array($columns)) {
           $orderby = ' ORDER BY '.$columns[0];
           for ($index = 1; $index < count($columns); $index++) {
               $orderby .= ', '.$columns[$index];
           }
       return $orderby;
       }
       return ' ORDER BY '.$columns;
   }
   #######################################################
   // Hàm tạo truy vấn select * from table
   function selectAllFrom($table) {
       $query = selectAll().from($table);
       return $query;
   }
   // Hàm tạo truy vấn select * from table where conditions
   function selectAllFromWhere($table, $conditions) {
       $query = selectAllFrom($table).where($conditions);
       return $query;
   }
   // Hàm tạo truy vấn select * from table where column = value
   function selectAllFromWhereColumnEqualsValue($table, $column, $value) {
       $query = selectAllFrom($table).where(equals($column, $value));
       return $query;
   }
   // Hàm tạo truy vấn select * from table where column like value
   function selectAllFromWhereColumnLikeValue($table, $column, $value) {
       $query = selectAllFrom($table).where(like($column, $value));
       return $query;
   }
   // Hàm tạo truy vấn select * from table where column > value
   function selectAllFromWhereColumnGreaterThanValue($table, $column, $value) {
       $query = selectAllFrom($table).where(compare($column, '>', $value));
       return $query;
   }
   // Hàm tạo truy vấn select * from table where column < value
   function selectAllFromWhereColumnLessThanValue($table, $column, $value) {
       $query = selectAllFrom($table).where(compare($column, '<'), $value);
       return $query;
   }
   // Hàm tạo truy vấn select * from table where column <> value
   function selectAllFromWhereColumnDiffersToValue($table, $column, $value) {
       $query = selectAllFrom($table).where(compare($column, '<>', $value));
       return $query;
   }
   // Hàm tạo truy vấn select col1, col2,.. from table
   function selectColumnsFrom($table, $columns) {
       $query = select($columns).from($table);
       return $query;
   }
   // Hàm tạo truy vấn select col1, col2,.. from table where conditions
   function selectColumnsFromWhere($table, $columns, $conditions) {
       $query = select($columns).from($table).where($conditions);
       return $query;
   }
   // Hàm tạo truy vấn select col1, col2,.. from table where colx = value
   function selectColumnsFromWhereColumnEqualsValue($table, $columns, $column, $value) {
       $query = selectColumnsFrom($table, $columns)
               .where(equals($column, $value));
       return $query;
   }
   
// Hàm để test
   function test() {
       $name = 'Name';
       $gender = 'Gender';
       $studentInfo = array($name, $gender);
       $studentTbl = 'students';
       $classIdCol = 'classId';
       $classIdVal = '1';
       return select($studentInfo).from($studentTbl)
               .where(equals($classIdCol, $classIdVal))
               .orderBy($name);
       // should return:
       // SELECT Name, Gender FROM students WHERE classId = '1' ORDER BY Name
   }
   