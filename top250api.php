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
			$this->conn = mysqli_connect('localhost', 'top250', 'CdU7pG7cMUyPT2aQ','top250');
			mysqli_set_charset($this->conn, "utf8");
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
		 * 查询获取 top250 的关键信息
		 * @return array 所有信息
		 */
		public function getTop250AndTop250Ext(){
			$sql = "SELECT top250.name, top250_ext.tname, top250.titleid, top250.date, top250.rating, top250_ext.douban, top250.hdimg, top250.imdburl FROM `top250`, `top250_ext` WHERE top250.titleid = top250_ext.titleid";
			$rs = mysqli_query($this->conn, $sql);
			$rs = mysqli_fetch_all($rs, MYSQLI_ASSOC);
			return $rs;
		}

		/**
		 * 获取 Top 250 某一条全部信息
		 * @param  string $titleid 电影在IMDB的编号
		 * @return array 此电影在表Top250的所有信息
		 */
		public function getOneTop250($titleid){
			$sql = "SELECT * FROM `top250` WHERE titleid = '$titleid'";
			$rs = mysqli_query($this->conn, $sql);
			$rs = mysqli_fetch_all($rs, MYSQLI_ASSOC);
			return $rs;
		}

		/**
		 * 获取 海报图片URL地址
		 * @param  string $titleid 电影在IMDB的编号
		 * @return array          [description]
		 */
		public function getMoviePoster($titleid){
			$sql = "SELECT poster FROM `top250_movieposterdb` WHERE titleid = '$titleid'";
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

	if (@$_GET['down']) {
		$rs = $test->getBtDown(@$_GET['down']);
		$data = $test->toJsonData($rs);
	} elseif (@$_GET['id']) {
		$rs = $test->getOneTop250(@$_GET['id']);
		$data = $test->toJsonData($rs);
	} elseif (@$_GET['poster']) {
		$rs = $test->getMoviePoster(@$_GET['poster']);
		$data = $test->toJsonData($rs);
	} else{
		$rs = $test->getTop250AndTop250Ext();
		$data = $test->toJsonData($rs);
	}
	
	echo $data;

?>
