---
title: Sublime Text3 安装命令行支持
date: 2016-07-28 18:15:48
tags: tool
---

#Sublime Text3 安装命令行支持

## 1. 安装[Command Line](http://www.sublimetext.com/docs/3/osx_command_line.html)

*   如果不存在bin目录，就要新建个bin目录
`mkdir ~/bin`
*   建立软连接
`ln -s "/Applications/Sublime Text.app/Contents/SharedSupport/bin/subl" ~/bin/subl`
*   运行
`subl --help`
*   成功记说安装完成

## 2.安装[Terminal](https://packagecontrol.io/packages/Terminal)

*   用 command+shift+p 打开 Package Control 并输入 Install Package
*   找到 Terminal 并安装
*   成功后可以使用 command+shift+t 打开 Terminal 默认是使用系统自带的 Terminal
*   如果要使用iTerm2需要进行下面的修改
*   先修改插件的配置
```
{
  "terminal": "iTerm.sh",
  "parameters": ["--open-in-tab"]
}
```
*   修改iTerm.sh 使之支持iTerm2

`~/Library/Application Support/Sublime Text 3/Packages/Terminal/iTerm.sh`

改成
```
#!/bin/bash

# Modified following this issue: https://github.com/wbond/sublime_terminal/issues/89

CD_CMD="cd "\\\"$(pwd)\\\"" && clear"
if echo "$SHELL" | grep -E "/fish$" &> /dev/null; then
  CD_CMD="cd "\\\"$(pwd)\\\""; and clear"
fi
VERSION=$(sw_vers -productVersion)
OPEN_IN_TAB=0

while [ "$1" != "" ]; do
    PARAM="$1"
    VALUE="$2"
    case "$PARAM" in
        --open-in-tab)
            OPEN_IN_TAB=1
            ;;
    esac
    shift
done

if (( $(expr $VERSION '<' 10.7) )); then
    RUNNING=$(osascript<<END
    tell application "System Events"
        count(processes whose name is "iTerm")
    end tell
END
)
else
    RUNNING=1
fi

if (( ! $RUNNING )); then
    osascript<<END
    tell application "iTerm"
            tell current window
                tell current session of (create tab with default profile)
                    write text "$CD_CMD"
                end tell
            end tell
            activate
    end tell
END
else
    if (( $OPEN_IN_TAB )); then
        osascript &>/dev/null <<EOF
        tell application "iTerm"
                    if (count of windows) = 0 then
                        set theWindow to (create window with default profile)
                        set theSession to current session of theWindow
                    else
                        set theWindow to current window
                        tell current window
                            set theTab to create tab with default profile
                            set theSession to current session of theTab
                        end tell
                    end if
                    tell theSession
                        write text "$CD_CMD"
                    end tell
                    activate
        end tell
EOF
    else
        osascript &>/dev/null <<EOF
        tell application "iTerm"
                    tell (create window with default profile)
                        tell the current session
                            write text "$CD_CMD"
                        end tell
                    end tell
                    activate
        end tell
EOF
    fi
fi
```
