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
<link rel="stylesheet" href="https://lib.sinaapp.com/js/bootstrap/v3.0.0/css/bootstrap.css">
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ol class="nav navbar-nav">
      <li class="disabled"><a class="navbar-brand" href="index.php">IMDb TOP 250</a></li>
      <li><a href="http://blog.xuyangjie.cn/" target="_bank">作者</a></li>
      <li><a href="https://github.com/xu42/IMDbTop250" target="_bank">GitHub</a></li>
    </ol>
  </div>
</nav>

<div class="container">

  <div class="alert alert-info" role="alert">
  	<p>声明：本站数据来源于互联网，本站并未存储任何视频等资源。如有侵犯您的正当权益，请与我们取得联系。</p>
  </div>

<img src="" id="hdimg"/>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>电影</th>
        <th>时间</th>
        <th>评分</th>
        <th>影评</th>
        <th>下载</th>
      </tr>
    </thead>
    <tbody id="top250list">
      <?php for ($i=0; $i < count($top250data); $i++) { ?>
      <tr>
        <th scope="row"><?php echo $i+1; ?></th>
        <td><a class="top250name" href="<?php echo $top250data[$i]['imdburl']; ?>" target="_bank" id="<?php echo $top250data[$i]['titleid']; ?>"><?php echo $top250data[$i]['name']; ?></a><br/><?php echo $top250data[$i]['tname']; ?></td>
        <td><?php echo $top250data[$i]['date']; ?></td>
        <td><?php echo $top250data[$i]['rating']; ?></td>
        <td><a href="<?php echo $top250data[$i]['douban']; ?>" target="_bank"><img src="douban_logo.png" width="40px"></a></td>
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
          <h4 class="modal-title" id="myModalLabel">About</h4>
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
<script src="https://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
<script src="top250.js"></script>
<script src="https://lib.sinaapp.com/js/bootstrap/v3.0.0/js/bootstrap.min.js"></script>
<div style="display:none;" >
	<script src="https://s95.cnzz.com/stat.php?id=1255134694&web_id=1255134694"></script>
</div>
<footer style="text-align:center;">
  Powered by <a href="https://blog.xuyangjie.cn/" target="_bank">许杨淼淼</a>
</footer>
</body>
</html>