<template>
  <div>
    <el-card style="margin: 0 auto; margin-bottom: 0px">
      <div slot="header" class="Card-Top">
        <h1 style="display: inline;">Xash专用服务器查询</h1>
      </div>
    <!-- 导航START -->
      <el-tabs v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="服务器状态" name="ServerStatus">
          <StatusPage/>
        </el-tab-pane>
        <el-tab-pane label="服务器状态查询" name="QueryServerStatus">
          <QueryStatus/>
        </el-tab-pane>
        <el-tab-pane label="关于" name="SD">
          <ServiceDistribution/>
        </el-tab-pane>
      </el-tabs>
    <!-- 导航END -->
    </el-card>
    <TipsInfo/>
  </div>
</template>

<script>
// 提示弹框
import TipsInfo from '@/components/tips.vue'
// 关于
import ServiceDistribution from '@/views/author/index.vue'
// 服务器状态页
import StatusPage from '@/views/status/index'
// 服务器状态查询页
import QueryStatus from '@/views/queryServer/index'

export default {
  name: 'HomePage',
  components: {
    TipsInfo,
    StatusPage,
    QueryStatus,
    ServiceDistribution
  },
  data () {
    return {
      activeName: 'ServerStatus'
    }
  },
  methods: {
    handleClick (tab, event) {
      // console.log('导航', tab, event)
    }
  }
}
</script>

<style scoped>

::v-deep .el-card.is-always-shadow,
.el-card.is-hover-shadow:focus,
.el-card.is-hover-shadow:hover {
  width: 1000px;
}

::v-deep .el-tabs__active-bar{
  height: 7px;
  background-color:#66ccff !important;
  border-radius: 3.5px;
}

::v-deep .el-card__header{
  padding:0px 20px;
}
.Card-Top{
  height: 40px;
}

.Card-Top:after {
  clear: both
}
</style>
