<?php
	
	/**
	* 提供异步获取uhash等数据提供查询API
	* @author 许杨淼淼 http://blog.xuyangjie.cn/
	* @link https://github.com/xu42/IMDbTop250
	* 2015-05-19
	*/
	class top250api{
		
		private $conn;

		/**
		 * 构造函数
		 * 初始化数据库连接资源
		 */
		function __construct() {
			$this->conn = mysqli_connect('localhost', 'top250', '','top250');
			mysqli_set_charset($this->conn, "utf8");
		}

		/**
		 * 获取 top250 表全部数据
		 * @return array top250 表数据
		 */
		public function getTop250(){
			$sql = "SELECT name,tname,titleid,date,rating,img,hdimg,imdburl FROM `top250`";
			$rs = mysqli_query($this->conn, $sql);
			$rs = mysqli_fetch_all($rs, MYSQLI_ASSOC);
			return $rs;
		}

		/**
		 * 查询获取 btdown 表符合条件的数据
		 * @param  string $titleid 电影在IMDB的编号
		 * @return array           在IMDB编号相同的电影的不同下载信息
		 */
		public function getBtDown($titleid){
			$sql = "SELECT name,uhash,btid FROM `btdown` WHERE titleid = '$titleid'";
			$rs = mysqli_query($this->conn, $sql);
			$rs = mysqli_fetch_all($rs, MYSQLI_ASSOC);
			return $rs;
		}

		/**
		 * 数组转换为json格式数据
		 * @param  array $rs 待转换的数组
		 * @return string    转换后的json格式字符串
		 */
		public function toJsonData($rs){
			return json_encode($rs, JSON_FORCE_OBJECT);
		}

	}

	$test = new top250api();
	if (is_null(@$_GET['id'])) {
		$rs = $test->getTop250(@$_GET['id']);
		$data = $test->toJsonData($rs);
	} else{
		$rs = $test->getBtDown(@$_GET['id']);
		$data = $test->toJsonData($rs);
	}

	echo $data;

?>
