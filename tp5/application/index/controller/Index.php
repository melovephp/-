<?php
namespace app\index\controller;

use think\Loader;
use think\Controller;
use think\Db;
use PHPMailer\PHPMailer\PHPMailer;
class Index extends Controller
{
    public function index()
    {
        $path = dirname(__FILE__); //找到当前脚本所在路径
        Loader::import('PHPExcel.PHPExcel'); //手动引入PHPExcel.php
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory'); //引入IOFactory.php 文件里面的PHPExcel_IOFactory这个类
        $PHPExcel = new \PHPExcel(); //实例化
        $iclasslist=db('iclass')->select();
        $letarr=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T',
                    'U','V','W','X','Y','Z','AA'
                    ];
        foreach($iclasslist as $key=> $v){
            $lists=Db::query('SHOW FULL COLUMNS from wx_users');
            $PHPExcel->createSheet();
            $PHPExcel->setactivesheetindex($key);
            $PHPSheet = $PHPExcel->getActiveSheet();
            $PHPSheet->setTitle($v['classname']); //给当前活动sheet设置名称
                        foreach ($lists as $key => $value) {
            $Comment=$lists[$key]['Comment']?$lists[$key]['Comment']:'id';
            $PHPSheet->setCellValue($letarr[$key].'1',$Comment);//表格数据
            $userlist=db('users')->where("iclass=".$v['id'])->select();
            $i=2;
            foreach($userlist as $t)
            {  
                $j=0;
                foreach ($t as $value)
                 {
                      $PHPSheet->setCellValue($letarr[$j].$i,$value);    //表格数据
                      $j++;
                 }
                $i++;
            }
            }
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007"); //创建生成的格式
        header('Content-Disposition: attachment;filename="学生列表'.time().'.xlsx"'); //下载下来的表格名
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }
    public function dao(){
        return $this->fetch();
    }
    public function do_dao(){
         if (!empty($_FILES)) {
   import("@.ORG.UploadFile");
   $config=array(
    'allowExts'=>array('xlsx','xls'),
    'savePath'=>'./Public/upload/',
    'saveRule'=>'time',
   );
   $upload = new UploadFile($config);
   if (!$upload->upload()) {
    $this->error($upload->getErrorMsg());
   } else {
    $info = $upload->getUploadFileInfo();
   }
   vendor("PHPExcel.PHPExcel");
    $file_name=$info[0]['savepath'].$info[0]['savename'];
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow(); // 取得总行数
    $highestColumn = $sheet->getHighestColumn(); // 取得总列数
    for($i=2;$i<=$highestRow;$i++)//这个地方根据需要,一般第一行是名称,所以从第二行开始循环,也可以从第一行开始
    {
     $data['lianjieid'] = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();//数据库字段和excel列相对应
     $data['yaoqingma'] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
     $data['dlmima']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
     $data['ljdizhi']= $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
     M('jdb')->add($data);//插入数据库
    }
     $this->success('导入成功！');
  }else
   {
    $this->error("请选择上传的文件");
   }
    }
    public function em(){
        return $this->fetch();
    }
    public function do_em(){
          $data=input('post.');print_r($data);

          exit;
        $email=input('post.email');
        $username=input('post.username');
        $title='亲爱的'.$username.', 您好：';
        $body='感谢您注册网易云帐号！请点击下面的链接完成注册：
https://yun.reg.163.com/urscloud/regist/confirm/67f27a6145c54854b344be60dde5e5251487574796049730669/nim/f716748640f34fae99d80454cba91b0c 
为了确保您的帐号安全，该链接仅48小时内访问有效，请勿直接回复该邮件。';
              sendmail($email,$title,$body);
    }
    public function a(){
        $a=3;
         $b=5;
         echo $a.'第一'."<br>";
         if($a=5 || $b=7){  //表达式0
            echo $a.'第二'."<br>";
            ++$a;
            echo $a.'第三';
            $b++;
         }
         echo $a.'一';
         echo $b.'第二';
    }

}
