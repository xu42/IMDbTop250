<?php
error_reporting(0);
	/**
	* 获取IMDB top 250列表和下载信息
	* 数据来源于下列两个站点
	* 1. http://www.imdb.com/chart/top
	* 2. http://www.bttiantang.com/
	* @author 许杨淼淼 http://blog.xuyangjie.cn/
	* @link https://github.com/xu42/IMDbTop250
	* 2015-05-16
	*/
	class top250 {
		
		/**
		 * 抓取网页函数
		 * @param  string $url 待抓取网页地址
		 * @return string      待抓取网页源代码
		 */
		private function getWebPage($url){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36');
			$webPage = curl_exec($ch);
			curl_close($ch);
			return $webPage;
		}

		/**
		 * 抓取IMDB top 250 网页
		 * @return string 网页http://www.imdb.com/chart/top源代码
		 */
		public function getWebPageImdbTop250(){
			$url = 'http://www.imdb.com/chart/top';
			return $this->getWebPage($url);
		}

		/**
		 * 正则表达式 获取IMDB top 250 主要源代码
		 * @param  string $webPage 网页源代码
		 * @return string          [description]
		 */
		public function getPureData($webPage){
			$pureData = array();
			preg_match_all('#<tr(.|\s)*?</tr>#', $webPage, $pureData);
			return $pureData;
		}

		/**
		 * 正则表达式 获取IMDB TOP 250 的250个电影名
		 * @param  string $pureData 网页源代码
		 * @return array           250个电影名 索引从1开始的数组
		 */
		public function getName($pureData){
			$movieName = array();
			for ($i=0; $i < count($pureData[0]); $i++) { 
				preg_match_all('#"\s>([^<]*?)<\/a>#i', $pureData[0][$i], $temp_name);
				$movieName[] = @trim($temp_name[1][0]);
			}
			return array_filter($movieName);
		}

		/**
		 * 正则表达式 获取IMDB TOP 250的250个电影的上映年份
		 * @param  string $pureData 网页源代码
		 * @return array           250个电影对应的上映年份 索引从1开始的数组
		 */
		public function getDate($pureData){
			$movieDate = array();
			for ($i=0; $i < count($pureData[0]); $i++) { 
				preg_match_all('#secondaryInfo">\((\d{4})\)#i', $pureData[0][$i], $temp_date);
				$movieDate[] = @trim($temp_date[1][0]);
			}
			return array_filter($movieDate);
		}

		/**
		 * 正则表达式 获取IMDB TOP 250的250个电影的评分
		 * @param  string $pureData 网页源代码
		 * @return array           250个电影对应的评分 索引从1开始的数组
		 */
		public function getRating($pureData){
			$movieRating = array();
			for ($i=0; $i < count($pureData[0]); $i++) { 
				preg_match_all('#votes">(\d?\.\d?)</strong>#i', $pureData[0][$i], $temp_rating);
				$movieRating[] = @trim($temp_rating[1][0]);
			}
			return array_filter($movieRating);
		}

		/**
		 * 正则表达式 获取IMDB TOP 250的250个电影的imdb编号
		 * @param  string $pureData 网页源代码
		 * @return array           250个电影对应的imdb编号 索引从1开始的数组
		 */
		public function getTitleId($pureData){
			$movieTitleId = array();
			for ($i=0; $i < count($pureData[0]); $i++) { 
				preg_match_all('#data-titleid="(tt\d{7})">#i', $pureData[0][$i], $temp_titleid);
				$movieTitleId[] = @trim($temp_titleid[1][0]);
			}
			return array_filter($movieTitleId);
		}

		/**
		 * 获取IMDB TOP 250的250个(34*50)的电影海报图片源站URL
		 * @param  string $pureData 网页源代码
		 * @return array           250个电影对应的海报图片地址 索引从1开始的数组
		 */
		public function getImg($pureData){
			$img_url = array();
			for ($i=0; $i < count($pureData[0]); $i++) { 
				preg_match_all('#src="([^"]*?)"#i', $pureData[0][$i], $temp_img);
				$img_url[] = @trim($temp_img[1][0]);
			}
			return array_filter($img_url);
		}

		/**
		 * 获取IMDB TOP 250的250个(高清)的电影海报图片源站URL
		 * @param  array $img_url  250个(34*50)的电影海报图片地址 索引从1开始的数组
		 * @return array           250个电影对应的海报图片地址 索引从1开始的数组
		 */
		public function getHDImg($img_url){
			$str1 = '.jpg';
			$movieImg = array(0=>'');
			for ($i=0; $i < count($img_url); $i++) { 
				$str2 = substr($img_url[$i+1], 0, -22);
				$movieImg[] = $str2.$str1;
			}
			return array_filter($movieImg);
		}

		/**
		 * 获取IMDB TOP 250展示页的250个电影的详情页地址
		 * @param  array $movieTitleId  top250在IMDB的编号 索引从1开始的数组
		 * @return arr                  电影的详情页地址 索引从1开始的数组
		 */
		public function getImdbUrl($movieTitleId){
			$imdbUrl = array();
			for ($i=0; $i < count($movieTitleId)+1; $i++) { 
				$imdbUrl[] = 'http://www.imdb.com/title/'. $movieTitleId[$i] .'/';
			}
			$imdbUrl[0] = '';
			return array_filter($imdbUrl);
		}


		/**
		 * 获取一部电影在IMDB的编号(tt0000000)对应bttiantang的subject编号id
		 * @param  string $imdb 电影在IMDB的编号(tt0000000)
		 * @return string       电影对应bttiantang的subject编号id
		 */
		public function getBttiantangId($imdb){
			$url = 'http://www.bttiantang.com/s.php?q='.$imdb;
			$pageSearchResult = $this->getWebPage($url);
			preg_match_all('#又名：<a href="/subject/(\d{4,6})\.html"#i', $pageSearchResult, $temp_url);
			$id = $temp_url[1][0];
			return $id;
		}

		/**
		 * 获取www.bttiantang.com的下载页地址
		 * @param  string $id 电影在bttiantang的subject编号id
		 * @return string     电影在bttiantang的下载页地址
		 */
		public function getBttiantangSubjectPage($id){
			$subjectPage = 'http://www.bttiantang.com/subject/' . $id . '.html';
			return $subjectPage;
		}

		/**
		 * 抓取bttiantang的下载页面源代码
		 * @param  string $subjectPage 电影在bttiantang的下载页地址
		 * @return string              电影在bttiantang的下载页地址源代码
		 */
		public function getPageDownList($subjectPage){
			$pageDownList = $this->getWebPage($subjectPage);
			return $pageDownList;
		}

		/**
		 * 正则表达式 获取bttiantang下载页面的uhash参数(不止一个、用于下载)
		 * @param  string $pageDownList 电影在bttiantang的下载页地址源代码
		 * @return string               电影在bttiantang的下载页uhash参数
		 */
		public function getBttiantangUhash($pageDownList){
			preg_match_all('#uhash=(\w{24})"#', $pageDownList, $temp_url);
			$uhash = $temp_url[1];
			return $uhash;
		}

		/**
		 * 正则表达式 获取bttiantang下载页面的BT种子文件名
		 * @param  string $pageDownList 电影在bttiantang的下载页地址源代码
		 * @return string               电影在bttiantang的下载页BT种子文件名
		 */
		public function getBttiantangUhashName($pageDownList){
			preg_match_all('#uhash=\w{24}"\stitle="(.*?)BT种子下载#', $pageDownList, $temp_name);
			$uhashName = $temp_name[1];
			return $uhashName;
		}

	}

?>
