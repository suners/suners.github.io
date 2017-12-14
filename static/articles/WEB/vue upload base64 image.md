[^_^]:
    title: vue upload base64 image
    date: 2017-3-9
    tags: vue
    ---END

## vue 代码

```
// 模板
<input type="file" class="file-input" @change="imageUpload">
<img v-if="icon" :src="icon" class="gameIcon"/>

// js
createImage (file) {
    if (typeof window.FileReader === 'undefined') {
        window.alert('您的浏览器不支持图片上传，请升级您的浏览器')
        return false
    }
    let leng = file.length
    for (let i = 0; i < leng; i++) {
        let reader = new window.FileReader()
        reader.readAsDataURL(file[i])
        reader.onload = (e) => {
            this.icon = e.target.result
        }
    }
}


submit () {
    let formData = new window.FormData()
    formData.append('icon', this.icon)
    this.$http.post(this._appConf.TWS_RESTFUL_URL, formData, {emulateJSON: true})
    .then(response => {
        console.log(response)
    })
}

```

## server端代码
这里server是用了Laravel + Intervention image

```
if ($request->icon) {
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $request->icon, $imgRes)) {
        $type = $imgRes[2];
        if (in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))) {
            $filename = time() . '.' . $type;
            $path     = public_path('images/icons/' . $filename);
            Image::make($request->icon)->save($path);
        } else {
            return response('图片类型错误', 400);
        }
    }
}
```
