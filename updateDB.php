<?php

	include 'top250.class.php';

	/**
	* 更新IMDB TOP 250 数据库
	* @author 许杨淼淼 http://blog.xuyangjie.cn/
	* @link https://github.com/xu42/IMDbTop250
	* 2015-05-16
	*/
	class updateDB{

		private $conn = NULL;
		private $top250 = NULL;

		/**
		 * 构造函数
		 * 初始化数据库连接资源和实例化类top250.class.php
		 */
		function __construct(){

			$this->top250 = new top250();
			$this->conn = mysqli_connect('localhost', 'top250', 'QeW4z6jeY4pzZPub','top250');
			mysqli_set_charset($this->conn, "utf8");
		}

		/**
		 * 更新 IMDB top250 列表
		 * @return int 插入行数
		 */
		public function updateTop250(){

			$webPage = $this->top250->getWebPageImdbTop250();
			$pureData = $this->top250->getPureData($webPage);
			$img = $this->top250->getImg($pureData);
			$hdimg = $this->top250->getHDImg($img);
			$name = $this->top250->getName($pureData);
			$date = $this->top250->getDate($pureData);
			$rating = $this->top250->getRating($pureData);
		 	$titleid = $this->top250->getTitleId($pureData);
		 	$imdburl = $this->top250->getImdbUrl($titleid);

		 	mysqli_query($this->conn, "TRUNCATE TABLE `top250`"); // 清空表信息
		 	for ($i=1; $i <= 250; $i++) { 
		 		$temp = mysqli_real_escape_string($this->conn, $name[$i]);
		 		$sql = "INSERT INTO `top250`(`name`, `date`, `rating`, `titleid`, `img`, `hdimg`, `imdburl`) VALUES ('$temp', '$date[$i]', '$rating[$i]', '$titleid[$i]', '$img[$i]', '$hdimg[$i]', '$imdburl[$i]') ";
		 		mysqli_query($this->conn, $sql);
		 	}

			$insertid = mysqli_insert_id($this->conn);
			mysqli_close($this->conn);
			return $insertid;
		}

		/**
		 * 更新 IMDB top250 BT种子下载 信息
		 * @return int 插入行数
		 */
		public function updateBtDown(){

			$sql = "SELECT titleid FROM top250";
			$rs = mysqli_query($this->conn, $sql);
			$rs = mysqli_fetch_all($rs, MYSQLI_NUM);

		 	mysqli_query($this->conn, "TRUNCATE TABLE `btdown`"); // 清空表信息
			for ($i=0; $i < count($rs); $i++) { 
				$imdb = $rs[$i][0];
				$id = $this->top250->getBttiantangId($rs[$i][0]);
				$subjectPage = $this->top250->getBttiantangSubjectPage($id);
				$pageDownList = $this->top250->getPageDownList($subjectPage);
				$uhash = $this->top250->getBttiantangUhash($pageDownList);
				$name = $this->top250->getBttiantangUhashName($pageDownList);

				for ($j=0; $j < count($uhash); $j++) { 
					$sql = "INSERT INTO `btdown`(`titleid`, `name`, `uhash`, `btid`, `page`) VALUES ('$imdb', '$name[$j]', '$uhash[$j]', '$id', '$subjectPage')";
					$this->insert($this->conn, $sql);
				}
			}

			$insertid = mysqli_insert_id($this->conn);
			mysqli_close($this->conn);
			return $insertid;
		}

		/**
		 * 解决数据库 insert 两层for循环出错(只能插入一次的未知错误)
		 */
		private function insert($conn,$sql){
			mysqli_real_query($conn,$sql);
		}
	}

	$updateDB = new updateDB();

	if (is_null(@$_GET['action'])) {
		exit('null param');
	} elseif (@$_GET['action'] == 'updateTop250') {
		$insertid = $updateDB->updateTop250();
		exit('updateTop250 '.$insertid);
	} elseif (@$_GET['action'] == 'updateBtDown') {
		$insertid = $updateDB->updateBtDown();
		exit('updateBtDown '.$insertid);
	} else{
		exit('error param');
	}

?>
