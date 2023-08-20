<!DOCTYPE html>
<html>
<head>
<!--
  作者:Drive Kinght（马叉虫、HatsuneMiko）
  QQ：745483318
-->
<meta charset="utf-8">
<title>Xash服务器查询</title>
<!-- CDN引入vue -->
<script src="https://cdn.staticfile.org/vue/2.2.2/vue.min.js"></script>
<!-- CDN引入axios -->
<script src="https://cdn.bootcdn.net/ajax/libs/axios/0.21.1/axios.min.js"></script>
</head>
<body>
<div id="app">
  <form action="conn.php" method="get">
    服务器地址: <input v-model="ip" type="text" name="ds_ip"><br>
    服务器端口: <input v-model="port" type="text" name="ds_port"><br>
    <input type="submit" value="提交">
  </form>
    IP:{{ip}}<br>
    端口:{{port}}

    <h2>接口</h2>
    <p>IP地址：http://站点地址/conn.php?ds_ip=服务器地址&ds_port=服务器端口</p>
</div>

<script>
new Vue({
  el: '#app',
  data: {
    ip:'',
    port:'',
  },methods:{
    cc(){
        axios.post('./api.php')
            .then(function (res) {
                // 请求成功返回
                console.log(res);
                console.log(res.data);
            })
            .catch(function (err) {
                // 请求失败返回
                console.log(err);
            })
            .then(function () {
                // 不管成功失败都会执行，可以用来关闭加载效果等
            });  
    }
  },
  beforeCreate(){
    this.message=''
  }
})
</script>
</body>
</html>