<?php

/*
 * 用于下载CSV文档的类
 * 
 */

class DownCSV {

    public $columnTitles = false;

    function __construct() {
        
    }

    /**
     * set the fist row of sheet
     * @param object $this->_Instance
     */
    public function setTitle($modelName, $aTitle) {
        foreach ($aTitle as $i => $sTitle) {
            $sNewTitle = __('_' . $modelName . '.' . $sTitle);
            $this->columnTitles[$i] = $sNewTitle;
        }
    }

    public function download($sFileName, $aData) {

        // 打开PHP文件句柄，php://output 表示直接输出到浏览器
        $fp = fopen($sFileName, 'a');

        // 将数据通过fputcsv写到文件句柄
        foreach ($this->columnTitles as $i => $v) {
            // CSV的Excel支持GBK编码，一定要转换，否则乱码
            $head[$i] = iconv('utf-8', 'gbk', $v);
        }
        fputcsv($fp, $head);

        // 计数器
        $cnt = 0;
        $limit = 100000;

        // 从数据库中获取数据，为了节省内存，不要把数据一次性读到内存，从句柄中一行一行读即可
        $i = 2;
        $count = 0;
        foreach ($aData as $key => $val) {
            $count ++;
            $cnt ++;
            //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小 ,大数据量时处理
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                flush();  //刷新buffer
                $cnt = 0;
            }
            foreach ($val as $k => $v) {
                $rows[$i + $k] = iconv('utf-8', 'gbk', $v);
            }
            fputcsv($fp, $rows);
        }
        return true;
    }

}
