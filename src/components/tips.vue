<template>
    <div id="app">
      <!-- 弹出框start -->
      <el-dialog title="本站消息" :visible.sync="dialogVisible" width="30%">
        <span>&emsp;&emsp;哈喽！~，我是马叉虫，你可以叫我骚哥！<br/>
          <p>本站仓库地址：</p><a href="https://github.com/HatsuneMiko/queryxashds.git">https://github.com/HatsuneMiko/queryxashds.git</a>
          <p style="text-align: right; padding-right: 30px; margin-bottom: 40px">
            祝您愉快! : )
          </p>
          <p style="text-align: right; padding-right: 60px; font-size: 12px">
            马叉虫
          </p>
          <p style="text-align: right; padding-right: 40px; font-size: 12px">
            2023.08.20
          </p>
        </span>
        <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="dialogVisible = false"
            >确 定</el-button
          >
        </span>
      </el-dialog>
      <!-- 弹出框start -->
    </div>
  </template>

<script>
export default {
  name: 'TipsInfo',
  data () {
    return {
      dialogVisible: true // 弹出框布尔变量
    }
  },
  methods: {

  }
}
</script>

<style scoped lang='scss'>
</style>
