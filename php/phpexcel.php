<?php 
function createExcel($array) {  
        if(empty($array)) return false;  
        /** Error reporting */  
        /*error_reporting(E_ALL); 
        ini_set('display_errors', TRUE); 
        ini_set('display_startup_errors', TRUE);*/  
        set_time_limit(0);  
        $o_ci = & get_instance();  
        $o_ci->load->library('PHPExcel');//引入PHPExcel类库  
        $objPHPExcel  = new PHPExcel();//实例化PHPExcel类  
        //设置文档基本属性  
        $objPHPExcel->getProperties()  
                 ->setCreator('Gary.F.Dong') //设置创建者  
                 ->setLastModifiedBy(date('Y-m-d',time())) //设置时间  
                 ->setTitle('Filters') //设置标题  
                 ->setSubject('产品Filters选项') //设置备注  
                 ->setDescription('导出所有产品的Filters') //设置描述  
                 ->setKeywords('Filters') //设置关键字 | 标记  
                 ->setCategory('Filters'); //设置类别  
        //$objPHPExcel->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中  
        // 循环所有的产品线，一个产品线作为一个sheet  
        $index = 0;  
        foreach ($array['prodlines'] as $key => $value) {  
            //设置默认行高  
            $objPHPExcel->getActiveSheet($index)->getDefaultRowDimension()->setRowHeight(20);  
            //设置单元格的对齐方式  
            $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//水平居右  
            //设置第一列的字体大小  
            $objPHPExcel->getActiveSheet()->getStyle("A1:A".(count($array['spectitle'][$value['conf_name']])+1))->getFont()->setSize(14);  
            //设置单元格保护  
            //$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);  // 为了使任何表保护，需设置为真  
            //$objPHPExcel->getActiveSheet()->protectCells("A1:A".(count($array['spectitle'][$value['conf_name']])+1), 'Gary' ); // 加密密码是 Gary  
            //取得当前行数和列数,然后取消中间部分的单元格保护  
            $all_rows_num = count($array['spectitle'][$value['conf_name']])+1;  
            $all_column_num = count($array['allprod'][$value['conf_name']])+1;  
            $columnString = PHPExcel_Cell::stringFromColumnIndex($all_column_num);  
            //$objPHPExcel->getActiveSheet()->getStyle("B2:".$columnString.$all_rows_num)->getProtection()->setLocked( PHPExcel_Style_Protection::PROTECTION_UNPROTECTED );  
            //如果当前产品线的attributes为空，跳过  
            if(empty($array['spectitle'][$value['conf_name']])) {continue;}  
            //if(in_array($value['conf_name'], array('led_lighting','lighting','monitor'))) continue;  
            //这只A1 栏位的标题  
            $objPHPExcel->setActiveSheetIndex($index)->setCellValue('A1','Filter');  
            $objPHPExcel->getActiveSheet()->getStyle( 'A1')->getFont()->setSize(14);  
            $objPHPExcel->getActiveSheet()->getStyle( 'A1')->getFont()->setBold(true);  
            $objPHPExcel->getActiveSheet()->getStyle( 'A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);  
            //由于列数多大上百列，所以采取动态循环的方式  
            $column = 2;  
            foreach($array['spectitle'][$value['conf_name']] as $spectitlekey => $rows){ //行写入,循环行数  
                //$span = ord("B"); //获取A的ASCII码  
                $span = 1;  
                //设置父级填充颜色  
                if($rows['parent_id'] ==0){  
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$column)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);  
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$column)->getFill()->getStartColor()->setRGB('cd99fe');  
                }else{  //否则按照单双号去设置颜色  
                    /*if($column%2==1){ 
                        $objPHPExcel->getActiveSheet($index)->getStyle('A'.$column)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
                        $objPHPExcel->getActiveSheet($index)->getStyle('A'.$column)->getFill()->getStartColor()->setRGB('ddddff'); 
                    }else{ 
                        $objPHPExcel->getActiveSheet($index)->getStyle('A'.$column)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
                        $objPHPExcel->getActiveSheet($index)->getStyle('A'.$column)->getFill()->getStartColor()->setRGB('efefef'); 
                    }*/  
  
                }  
                $objPHPExcel->setActiveSheetIndex($index)->setCellValue('A'.$column,$rows['search_item']);  
                // 设置宽度  
                $objPHPExcel->getActiveSheet($index)->getColumnDimension('A')->setAutoSize(true);  
                //$obpe->getActiveSheet()->getColumnDimension('B')->setWidth(10);  
                foreach($array['allprod'][$value['conf_name']] as $prodid=>$products){// 列写入  
                    if(empty($products)) continue;  
                    //$j = chr($span);  
                    $j = PHPExcel_Cell::stringFromColumnIndex($span);  
                    //写入每一列第一行产品名  
                    $objPHPExcel->setActiveSheetIndex($index)->setCellValue($j.'1',$products['model'] );  
                    //$objPHPExcel->getActiveSheet()->getStyle( $j.'1')->getFont()->setSize(14);  
                    //$objPHPExcel->getActiveSheet()->getStyle( $j.'1')->getFont()->setBold(true);  
                    //$objPHPExcel->getActiveSheet()->getStyle($j.'1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);  
  
                    $curSpecValue = $array['specvalues'][$value['conf_name']][$products['prod_id']][$rows['search_item']];  
                    if(empty($curSpecValue||!isset($curSpecValue))) $curSpecValue='';  
                    $objPHPExcel->setActiveSheetIndex($index)->setCellValue($j.$column,$curSpecValue );  
                    $objPHPExcel->getActiveSheet($index)->getColumnDimension($j)->setAutoSize(true);  
                    $span++;  
                }  
                $column++;  
            }   
            // Rename worksheet  
            $objPHPExcel->getActiveSheet($index)->setTitle($value['conf_name']);  
            $index++;  
            $objPHPExcel->createSheet();  
            $objPHPExcel->setActiveSheetIndex($index);  
            //if($index==3) break;  
  
        }  
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
        $objPHPExcel->setActiveSheetIndex(0);  
        ob_end_clean(); // Added by me  
        ob_start(); // Added by me  
        $filename = 'filters-'.date('Y-m-d',time()).'.xlsx';  
  
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
        $objWriter->save(BQ_ADM_ROOT.'/media/tmp/'.$filename);  
        return BQ_ADM_URL.'/media/tmp/'.$filename;  
  
    }  


// 所有单元格居中：

$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);