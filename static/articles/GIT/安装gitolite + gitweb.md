[^_^]:
    title: 安装gitolite
    date: 2016-7-7
    tags: git
    ---END

## 安装gitolite

    1、ssh-keygen -b2048 //生成.pub
    2、cp .ssh/id_rsa.pub yourname.pub
    3、touch .ssh/authorized_keys && chmod 600 .ssh/authorized_keys
    4、mkdir -p ~/bin
    5、export PATH=/Users/yourname/bin:$PATH  // 将这段shell加入到.bash_profile中
    6、git clone git://github.com/sitaramc/gitolite
    7、gitolite/install -ln ~/bin          // please use absolute path here
    8、gitolite setup -pk yourname.pub     // 这里的pub key是管理员的key

如果出现 WARNING: keydir/git_key.pub duplicates a non-gitolite key, sshd will ignore it
这种警告，说明配置有些问题，需要删除/home/git目录下的
.gitolite 和.gitolite.rc 和 repositories 和 ~/.ssh/authorized_keys四个文件！！

## 管理员使用gitolite

    1、git clone git@server:gitolite-admin
    2、cd gitolite-admin
    3、cp xxxuser.pub keydir/    // 添加用户的pub key 到 gitolite-admin/keydir 目录


## 安装gogs

    1、到 gogs.io ，选择二进制安装，下载好安装包，解压 后进入
    2、执行 ./gogs web 或者 nohup ./gogs web & tail -f nohup.out //后台运行
    3、sudo lsof -i :3000 //搜索占用3000 的端口
    4、sudo kill -9 进程ID
    5、配置文件在 gogs/gogs/custom/app.ini

` ps: 事先需要先安装MySQL或者PostgreSQL， 然后创建好gogs数据库， utf8_general_ci `



