<?php 
  $top250data = file_get_contents('http://top250.ml/top250api.php'); 
  $top250data = json_decode($top250data, true);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>IMDb TOP 250</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="http://libs.useso.com/js/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ol class="nav navbar-nav">
      <li class="disabled"><a class="navbar-brand" href="#">IMDb TOP 250</a></li>
      <li><p class="navbar-text">BT种子下载</p></li>
      <li><a href="#">关于</a></li>
      <li style="margin-top:16px; margin-left:10px;"><a class="github-button" href="https://github.com/xu42" data-style="mega" data-count-href="/xu42/followers" data-count-api="/users/xu42#followers" data-count-aria-label="# followers on GitHub" aria-label="Follow @xu42 on GitHub">Follow @xu42</a></li>
      <li style="margin-top:16px; margin-left:10px;"><a class="github-button" href="https://github.com/xu42/IMDbTop250/issues" data-icon="octicon-issue-opened" data-style="mega" data-count-api="/repos/xu42/IMDbTop250#open_issues_count" data-count-aria-label="# issues on GitHub" aria-label="Issue xu42/IMDbTop250 on GitHub">Issue</a></li>
      <li style="margin-top:16px; margin-left:10px;"><a class="github-button" href="https://github.com/xu42/IMDbTop250/archive/master.zip" data-icon="octicon-cloud-download" data-style="mega" aria-label="Download xu42/IMDbTop250 on GitHub">Download</a></li>
      <li style="margin-top:16px; margin-left:10px;"><iframe width="" height="20px" frameborder="0" scrolling="no" src="http://widget.weibo.com/relationship/followbutton.php?language=zh_cn&width=110&height=100&uid=2139086105&style=3"></iframe></li>
    </ol>
  </div>
</nav>

<div class="container">

  <div class="alert alert-info" role="alert">
  	<p>声明：本站数据来源于互联网，本站并未存储任何图片、视频等资源。如有侵犯您的正当权益，请与我们取得联系。</p>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>电影</th>
        <th>时间</th>
        <th>评分</th>
        <th>下载</th>
      </tr>
    </thead>
    <tbody id="top250list">
      <?php for ($i=0; $i < count($top250data); $i++) { ?>
      <tr>
        <th scope="row"><?php echo $i+1; ?></th>
        <td><a href="<?php echo $top250data[$i]['imdburl']; ?>" target="_bank" ><?php echo $top250data[$i]['name']; ?></a><br/><?php echo $top250data[$i]['tname']; ?></td>
        <td><?php echo $top250data[$i]['date']; ?></td>
        <td><?php echo $top250data[$i]['rating']; ?></td>
        <td><button name= "<?php echo $top250data[$i]['name']; ?>" id="<?php echo $top250data[$i]['titleid']; ?>" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"><?php echo $i+1; ?> 下载列表</button></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Modal begin -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">下载</h4>
        </div>
        <div class="modal-body">
        <form action="http://www.bttiantang.com/download.php" method="POST">
        	<input type="hidden" value="download" name="action" id="formaction">
        	<input type="hidden" value="" name="id" id="formid">
        	<input type="hidden" value="" name="uhash" id="formuhash">
        	<input type="hidden" value="64" name="imageField.x" id="formx">
        	<input type="hidden" value="32" name="imageField.y" id="formy">
        	<button type="submit" id="formdown" style="display:none"></button>
        </form>
          <ol id="downlist">
          </ol>
        </div>
      </div>
    </div>
  </div><!-- Modal end -->

</div> <!-- end class container -->
<script async defer id="github-bjs" src="https://buttons.github.io/buttons.js"></script>
<script src="http://libs.useso.com/js/jquery/1.10.2/jquery.min.js"></script>
<script src="top250.js"></script>
<script src="http://libs.useso.com/js/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<div style="display:none;" >
	<script src="http://s95.cnzz.com/stat.php?id=1255134694&web_id=1255134694"></script>
</div>	
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":["mshare","qzone","tsina","bdysc","weixin","renren","tqq","kaixin001","tieba","douban","sqq","ibaidu","fx","youdao","sdo","qingbiji","people","ty","fbook","twi"],"bdPic":"","bdStyle":"1","bdSize":"16"},"slide":{"type":"slide","bdImg":"0","bdPos":"left","bdTop":"100.5"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
</body>
</html>