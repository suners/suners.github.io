# Mac 下创建隐藏用户

### Mac 下创建隐藏用户, 例如 nobody, nginx, mysql 用户等等, 这些是 Apache, Nginx, Mysql, PHP-fpm 等软件要用到的. 但是, 这些用户又不想它能登录系统.

    sudo dscl . create /Groups/nginx PrimaryGroupID 390
    sudo dscl . create /Users/nginx UniqueID 390
    sudo dscl . create /Users/nginx PrimaryGroupID 390
    sudo dscl . create /Users/nginx UserShell /bin/false
    sudo dscl . create /Users/nginx RealName nginx
    sudo dscl . create /Users/nginx NFSHomeDirectory /dev/null
    sudo dscl . create /Groups/nginx GroupMembership nginx

### 查看用户列表

    dscacheutil -q group

## 创建git用户实例

### 创建组

    1、 dscl . -list /Groups PrimaryGroupID | awk '{print $2}' | sort -n  // 列出已经被用的组ID
    2、 sudo dscl . -create /Groups/git
    3、 sudo dscl . -create /Groups/git PrimaryGroupID 1000   // 这里设置ID为1000 （可以选择其他未被用到的ID）

### 创建用户

    1、 dscl . -list /Users UniqueID | awk '{print $2}' | sort -n  // 列出已经被用的用户ID
    2、 sudo dscl . -create /Users/git
    3、 sudo dscl . -create /Users/git UserShell /bin/bash
    4、 sudo dscl . -create /Users/git UniqueID "503"  // 这里设置ID为503
    5、 sudo dscl . -create /Users/git PrimaryGroupID 1000  // 选择刚刚创建的组ID
    6、 sudo dscl . -create /Users/git NFSHomeDirectory /Users/git
    7、 sudo mkdir /Users/git
    8、 sudo chown -R git:git /Users/git
