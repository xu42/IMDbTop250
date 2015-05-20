# IMDbTop250

## 概述
- 抓取 [IMDb Top 250](http://www.imdb.com/chart/top) 的 Rank&Title 和 IMDb Rating 信息 (数据库表`top250`)
- 根据抓取到的imdb编号去 [BT天堂](http://www.bttiantang.com/) 查询，并抓取种子下载信息 (数据库表`btdown`)
- 整合，对外提供定时更新的IMDb Top 250列表和种子下载服务

## 安装
- 创建一个数据库，并执行 `install.sql`
- 修改`updateDB.php`和`top250api.php`的数据库连接信息

## 更新
- 更新数据库表top250 `http://example.org/updateDB.php?action=updateTop250`
- 更新数据库表btdown `http://example.org/updateDB.php?action=updateBtDown`

## 其它
- Github [https://github.com/xu42/IMDbTop250](https://github.com/xu42/IMDbTop250)
- demo [http://top250.ml/](http://top250.ml/)
![](http://ww2.sinaimg.cn/mw690/7f7fdd19jw1esagsjgz2qj211y0lc42o.jpg)
![](http://ww1.sinaimg.cn/mw690/7f7fdd19jw1esahtf0il2j211y0lcaeo.jpg)