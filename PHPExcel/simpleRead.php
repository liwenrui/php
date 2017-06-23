<?php
    header("Content-type: text/html; charset=utf-8");
    set_time_limit(0); //设置页面等待时间
    $type = 'xlsx';
    $uploadfile = '1.xlsx';
    if ($uploadfile) {
        require './PHPExcel/IOFactory.php';
        if($type=='xlsx'||$type=='xls' ){
            $reader = \PHPExcel_IOFactory::createReader('Excel2007'); // 读取 excel 文档
        }else if( $type=='csv' ){
            $reader = \PHPExcel_IOFactory::createReader('CSV'); // 读取 excel 文档
        }else{
            die('Not supported file types!');
        }

        $PHPExcel = $reader->load($uploadfile); // 文档名称
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数

        /** 循环读取每个单元格的数据 */
        //一条sql
        $str = 'insert into openbuy_admin(`name`,`email`,`pwd`,`alliance_id`,`status`,`role_id`,`create_time`) values ';
        for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
            $str .='(';
            for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                if($column =='D'){
                    $str .= $sheet->getCell($column.$row)->getValue().",1,3,1498200780),";
                }else{
                    $str .= "'".$sheet->getCell($column.$row)->getValue()."',";
                }
            }
        }
        echo $str;

        //多条sql
        for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
            $str = 'insert into openbuy_admin(`name`,`email`,`pwd`,`alliance_id`,`status`,`role_id`,`create_time`) values (';
            for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                if($column =='D'){
                    $str .= $sheet->getCell($column.$row)->getValue().",1,3,1498200780);";
                }else{
                    $str .= "'".$sheet->getCell($column.$row)->getValue()."',";
                }
            }
            echo $str;
            echo '<br>';
        }

    }
