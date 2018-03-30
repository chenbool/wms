<?php
namespace app\service;
use app\model\OrderInfo,
	app\model\OrderGood,
	app\model\Product;

// 处理 Excel
class ExcelService
{
	public $PHPExcel;
	public $PHPReader;
	public $currentSheet;

    public function __construct()
    {
    	require_once ROOT_PATH.'/extend/Classes/PHPExcel.php';
    	// $this->PHPExcel = new \PHPExcel(); 
    }  


    public function read($filePath=''){
    	
    	// $filePath = ROOT_PATH.'/public/static/demo.xls'; 

		/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/ 
		$this->PHPReader = new \PHPExcel_Reader_Excel2007(); 

		if(!$this->PHPReader->canRead($filePath)){ 
			$this->PHPReader = new \PHPExcel_Reader_Excel5(); 
			if(!$this->PHPReader->canRead($filePath)){ 
				die('no Excel'); 
			} 
		} 

		$this->PHPExcel = $this->PHPReader->load($filePath); 
		/**读取excel文件中的第一个工作表*/ 
		$this->currentSheet = $this->PHPExcel->getSheet(0);

		$this->getData();
    }


    public function getData(){

		/**取得最大的列号*/ 
		$allColumn = $this->currentSheet->getHighestColumn(); 

		/**取得一共有多少行*/ 
		$allRow = $this->currentSheet->getHighestRow(); 
		
		//导入批次
		$batch_no = date('Ymdhis',time());

		/**从第二行开始输出，因为excel表中第一行为列名*/
		for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {

			$product = Product::get([
				'sn'	=>	$this->getVal('D',$currentRow)
			]);

			if( is_null($product) ){
				$product->id = 1;
			}

			$res = OrderGood::get([
				'order_sn'	=> $this->getVal('A',$currentRow),
			]);

			if( is_null($res) ){
				$res = new OrderGood();
				$res->order_sn 			= $this->getVal('A',$currentRow);
				$res->referer			= $this->getVal('B',$currentRow);
			    $res->waybillno 		= $this->getVal('C',$currentRow);
			    $res->batch_no 			= $batch_no;
			    $res->identify_no 		= $this->getVal('F',$currentRow);
			    $res->author 			= '';
			    $res->receiver_name 	= $this->getVal('E',$currentRow);
			    $res->receiver_phone 	= $this->getVal('K',$currentRow);
			    $res->receiver_province = $this->getVal('G',$currentRow);
			    $res->receiver_city 	= $this->getVal('H',$currentRow);
			    $res->receiver_district = $this->getVal('I',$currentRow);
			    $res->receiver_address 	= $this->getVal('J',$currentRow);
			    $res->sender_name 		= $this->getVal('L',$currentRow);
			    $res->sender_phone 		= $this->getVal('N',$currentRow);
			    $res->sender_address 	= $this->getVal('M',$currentRow);
			    $res->add_time 			= time();
				$res->save();
				// $res = OrderGood::create([
				// 	'order_sn'	=> $this->getVal('A',$currentRow),
				// 	'goods_id'	=> $product->id,
				// ]);
			}

			// dump($res->rec_id);
			// dump($this->getVal('A',$currentRow) );
			// die;

			OrderInfo::create([
				'o_id'				=>  $res->rec_id,
			    'batch_no'  		=>  $batch_no,
			    'order_sn'			=>  $this->getVal('A',$currentRow),
			    'referer'			=>	$this->getVal('B',$currentRow),
			    'waybillno'			=>	$this->getVal('C',$currentRow),
			    'product_no'		=>	$this->getVal('D',$currentRow),
			    'receiver_name'		=>	$this->getVal('E',$currentRow),
			    'identify_no'		=>	$this->getVal('F',$currentRow),
			    'receiver_province'	=>	$this->getVal('G',$currentRow),
			    'receiver_city'		=>	$this->getVal('H',$currentRow),
			    'receiver_district'	=>	$this->getVal('I',$currentRow),
			    'receiver_address'	=>	$this->getVal('J',$currentRow),
			    'receiver_phone'	=>	$this->getVal('K',$currentRow),
			    'sender_name'		=>	$this->getVal('L',$currentRow),
			    'sender_address'	=>	$this->getVal('M',$currentRow),
			    'sender_phone'		=>	$this->getVal('N',$currentRow),
			    'r_weight'			=>	$this->getVal('T',$currentRow),
			    'goods_number'		=>	$this->getVal('U',$currentRow),
			    'goods_amount'		=>	$this->getVal('V',$currentRow)*$this->getVal('U',$currentRow),
			    'currency'			=>	$this->getVal('V',$currentRow),
			    'remark'			=>	$this->getVal('X',$currentRow),
			    'add_time'			=>	time()
			]);

		}

    }
    

    public function getVal($val,$currentRow){
    	return $this->currentSheet->getCellByColumnAndRow(ord($val)-65, $currentRow)->getValue();
    }


}
