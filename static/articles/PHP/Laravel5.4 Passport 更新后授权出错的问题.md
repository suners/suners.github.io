[^_^]:
    title: Laravel5.4 Passport 更新后授权出错
    date: 2017-8-18
    tags: laravel
    ---END

## 运行了composer update 之后， passport授权出错， 报了如下错误：

```
You must set the encryption key going forward to improve the security of this library - see this page for more information https://oauth2.thephpleague.com/v5-security-improvements/

```

## 解决方法如下：

### 打开 vendor/laravel/passport/src/PassportServiceProvider.php， 找到 makeAuthorizationSever 方法，修改如下：

```
public function makeAuthorizationServer()
{
    $server =  new AuthorizationServer(
        $this->app->make(Bridge\ClientRepository::class),
        $this->app->make(Bridge\AccessTokenRepository::class),
        $this->app->make(Bridge\ScopeRepository::class),
        'file://'.Passport::keyPath('oauth-private.key'),
        'file://'.Passport::keyPath('oauth-public.key')
    );
    $server->setEncryptionKey(env('APP_KEY'));
    return $server;
}

```
