[^_^]:
    title: Laravel5.4 Restful APi Cors.php
    date: 2017-3-6
    tags: laravel
    ---END

# Laravel5.4 Restful Api Cors.php

最近用laravel + vue2.0 开发一个项目，发现用vue-resource的PUT、PATCH的方式调用server端的Restful api 时一直无法成功，经过查找，后面发现是响应头信息的问题，解决方法如下：

### 修改 app/http/Middleware/Cors.php

```php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isCorsPath($request)) {
            // 设置允许访问的域地址
            $domains = ['http://localhost:8080'];
            // 判断请求头中是否包含ORIGIN字段
            if(isset($request->server()['HTTP_ORIGIN'])){
                $origin = $request->server()['HTTP_ORIGIN'];
                if (in_array($origin, $domains)) {
                    // 设置响应头信息
                    header('Access-Control-Allow-Origin: '.$origin);
                    header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');
                    // 设置允许的方法
                    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
                }
            }
        }

        return $next($request);
    }

    /**
     * Check for a CorsPath request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    protected function isCorsPath($request)
    {
        return $request->segment(1) == 'api';
    }

}

```

### 添加测试方法

```php
public function update($id)
{
        return response('OK', 200);
}
```

### 添加路径

```php
Route::put('/versions/{id}', 'VersionsController@update');
```

### Vue 调用api

```javascript
let url = this._appConf.TWS_RESTFUL_URL + '/api/versions/' + this.editData.id

this.$http.put(url, formData, {emulateJSON: true})
    .then(response => {
        console.log(response)
    })
```
