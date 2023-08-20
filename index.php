<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>接收测试</title>
<script src="https://cdn.staticfile.org/vue/2.2.2/vue.min.js"></script>
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
    <p>IP地址：http://8.210.45.36:4848/conn.php?ds_ip=【服务器地址】&ds_port=【服务器端口】</p>
</div>

<script>
new Vue({
  el: '#app',
  data: {
    ip:'',
    port:'',
  },methods:{
    cc(){
        // axios.post('./phprcon.php')
        // axios.post('./index.php')
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