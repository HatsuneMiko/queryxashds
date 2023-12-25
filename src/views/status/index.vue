<!--
  作者:Drive Kinght（马叉虫、HatsuneMiko）
 -->
 <template>
  <div>
    <div style="display: flex;justify-content: space-between;">
      <div style="line-height: 40px;">
        <span style="margin-right: 50px;">服务器总数:{{ queryList.length }}</span>
        <span style="margin-right: 50px;">服务器最大人数总和:{{ serverPlayerNumMax }}</span>
        <span>当前在线人数:{{ serverPlayerNum }}</span>
      </div>
      <el-button type="primary" v-throttle="2000" @click="getQueryAll()">刷新</el-button>
    </div>
    <el-table
        :data="queryList"
        style="width: 100%">
        <el-table-column type="expand">
          <template #default="scope">
              <span style="margin-left: 10%;">服务器地址：</span><span>{{ scope.row.ip }}:{{ scope.row.port }}</span>
          </template>
        </el-table-column>
        <el-table-column
          prop="area"
          label="地区"
          width="50%"
        >
        </el-table-column>
        <el-table-column
          label="服务器"
        >
          <template #default="scope">
            <span style="color:rgb(255, 140, 0)" v-html="fontColorShow(scope.row.name)"></span>
          </template>
        </el-table-column>
        <el-table-column
          prop="mod"
          label="服务器类型"
          width="100%"
        >
        </el-table-column>
        <el-table-column
          prop="map"
          label="当前地图"
          width="150%"
        >
        </el-table-column>
        <el-table-column
          label="在线人数"
          width="100%"
          align="center"
        >
          <template #default="scope">
              <span>{{ scope.row.activeplayers }}/{{ scope.row.maxplayers }}</span>
          </template>
        </el-table-column>
    </el-table>
  </div>
</template>

<script>
// 导入接口
import { getStatus8V8 } from '@/api/status.js'
// 导入服务器参数
import xashdslist from '@/xashds/config'

export default {
  name: 'StatusPage',
  data () {
    return {
      // 服务器IP端口数组
      ServerList: xashdslist,
      queryList: [], // 查询结果列表
      serverPlayerNum: 0, // 服务玩家总和
      serverPlayerNumMax: 0, // 服务器玩家最大人数总和
      timer: null, // 定时器
      queryFlag: true // 判断是否查询完
    }
  },
  async mounted () {
    await this.getQueryAll()
    this.QueryIng()
  },
  methods: {
    async getQueryAll () { // 查询所有服务器
      if (this.queryFlag === false) {
        return
      }
      this.queryFlag = false
      this.queryList = []
      this.serverPlayerNum = 0
      this.serverPlayerNumMax = 0
      for (let i = 0; i < this.ServerList.length; i++) {
        const res = await this.getQueryStatus(this.ServerList[i].ds_ip, this.ServerList[i].ds_port)
        // console.log(i, '服务器查询', res.data)
        if (res.data === '') continue
        this.serverPlayerNum += Number(res.data.activeplayers)
        this.serverPlayerNumMax += Number(res.data.maxplayers)
        res.data.area = this.ServerList[i].area
        this.queryList.push(res.data)
      }
      this.queryFlag = true
    },
    async getQueryStatus (ip, port) { // 服务器查询
      const res = await getStatus8V8({
        ds_ip: ip,
        ds_port: port
      })
      return res
    },
    QueryIng () { // 25秒刷新数据
      this.timer = setInterval(() => {
        this.getQueryAll()
      }, 25000)
    },
    fontColorShow (name) { // 符号渲染彩色的处理函数
      return name.replace(/\^[1-9]/g, function (e) {
        if (e === '^0') {
          return '<span style="color:black">'
        }
        if (e === '^1') {
          return '<span style="color:red">'
        }
        if (e === '^2') {
          return '<span style="color:green">'
        }
        if (e === '^3') {
          return '<span style="color:gold">'
        }
        if (e === '^4') {
          return '<span style="color:blue">'
        }
        if (e === '^5') {
          return '<span style="color:aqua">'
        }
        if (e === '^6') {
          return '<span style="color:rgb(255, 140, 0)">'
        }
        if (e === '^7') {
          return '<span style="color:rgb(255, 140, 0)">'
        }
        if (e === '^8') {
          return '<span style="color:black">'
        }
        if (e === '^9') {
          return '<span style="color:red">'
        }
      })
    }
  }
}
</script>

<style scoped></style>
