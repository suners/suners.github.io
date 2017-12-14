[^_^]:
    title: Yii2 advanced 项目启动方法
    date: 2017-8-21
    tags: yii2
    ---END

## 安装完Yii2 advanced 项目时， 用yii serve启动的时候，会报类似下面的错误：

```
Document root "/Users/wuzebin/Sites/git/coding/yii2advanced/console/web" does not exist.

```
这是因为要指定Document root 的路径

## 正确的启动如下：

```
./yii serve --docroot="frontend/web/"

```
