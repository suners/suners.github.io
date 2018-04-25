[^_^]:
    title: Javascript 工具函数整理
    date: 2018-4-25
    tags: javascript
    ---END


## 动态加载JS
```javascript

function loadScript(url, callback){
    var script = document.createElement("script");
    script.type = "text/javascript";
    if(script.readyState){ //IE浏览器
        script.onreadystatechange = function(){
            if(script.readyState == "loaded" || script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    }else{ //FF, Chrome, Opera, ...
        script.onload = function(){
            callback();
        };
    }
    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

```

## 获取链接的参数
```javascript

function getHttpParams(name){
    var r = new RegExp("(\\?|#|&)"+name+"=([^&#]*)(&|#|$)");
    var m = location.href.match(r);
    return decodeURIComponent(!m?"":m[2]);
}

```

## 原生API实现Ajax的方法
```javascript

var Ajax={
    get: function(url, fn) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200 || xhr.status == 304) {
                fn.call(this, xhr.responseText);
            }
        };
        xhr.send();
    },
    post: function (url, data, fn) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 304)) {
                fn.call(this, xhr.responseText);
            }
        };
        xhr.send(data);
    }
}

```
