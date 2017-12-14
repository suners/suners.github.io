[^_^]:
    title: git常用命令整理
    date: 2016-7-7
    tags: git
    ---END

## 修改用户信息

    $ git config --global user.name "abin"
    $ git config --global user.email "361115690@qq.com"

## 创建本地仓库

    $ git init
    $ git add 文件名|文件名1 文件名2|.
    $ git commit -m "xxxx"
    $ git commit -am "xxxxx"

## 查看修改了哪些内容

    $ git diff 文件名

## 查看log

    $ git log
    $ git log --pretty=oneline //简短信息
    $ git reflog //查看每一次的命令，包括回退后的log
    $ git log --graph --pretty=oneline --abbrev-commit

## 回退版本

    $ git reset --hard HEAD^ //直接回退到上一版本
    $ git reset --hard 版本id

## 放弃修改

    $ git checkout -- 文件名|.  //丢弃未缓存的修改
    $ git reset HEAD 文件名 //可以把暂存区的修改撤销掉

## 创建分支

    $ git checkout -b 分支名 // -b 参数是指创建并切换
    $ git branch

## 合并分支

    $ git merge 分支名
    $ git merge --no-ff -m "描述" 分支名 //用--no-ff 可以禁用Fast forward模式，既删除分支之后，还保留分支信息

## rebase合并

    $ git rebase 主分支
    $ git add 冲突文件名 //解决冲突后提交缓存
    $ git rebase --continue / --abort // rebase的时候，修改冲突后的提交不是使用commit命令，而是执行rebase命令指定 --continue选项。若要取消rebase，指定 --abort选项
    $ git checkout 主分支
    $ git merge 分支名

## 删除分支

    $ git branch -d 分支名

## 储存工作现场

    $ git stash //储存现场
    $ git stash list //查看储存的列表
    $ git stash apply //恢复stash内容， 但是要手动删除
    $ git stash pop //恢复stash内容，不需要手动恢复
    $ git stash drop //删除

## 远程库

    $ git remote //查看远程库信息
    $ git remote -v //显示更详细
    $ git push origin 分支名 //将本地推送到远端
    $ git checkout -b 分支名 origin/分支名  //将远程分支抓取到本地
    $ git branch --set-upstream 分支名 origin/分支名 //创建本地分支和远程分支的关联

## 本地仓库关联远程库

    git remote add origin http://g.tigger.com/abin/test.git
    git push -u origin master

## 标签

    $ git tag 标签名 [commit id]
    $ git show 标签名 //查看标签信息
    $ git tag -a 标签名 -m '描述信息' [commit id] // 创建一个带有描述信息的标签
    $ git tag -s 标签名 -m '描述信息' [commit id] // 创建一个私钥签名的标签
    $ git tag -d 标签名 //删除标签
    $ git push origin 标签名 // 推送标签到远端
    $ git push origin --tags //一次性推送所有标签
    $ git push origin :refs/tags/标签名 //删除远端标签，前提需要先删除本地

## 忽略文件(.gitignore)

    # Windows:
    Thumbs.db
    ehthumbs.db
    Desktop.ini

    # Python:
    *.py[cod]
    *.so
    *.egg
    *.egg-info
    dist
    build

    # My configurations:
    db.ini
    deploy_key_rsa

    $ git add -f 文件名 //将忽略的文件强制提交到git
    $ git check-ignore -v App.class


