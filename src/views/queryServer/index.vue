<template>
  <div calss="box">
    <div class="main">
        <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <el-form-item label="IP:" prop="pass">
                <el-input type="text" v-model="ruleForm.pass" autocomplete="off" @input="clearArr"></el-input>
            </el-form-item>
            <el-form-item label="端口:" prop="checkPass">
                <el-input type="text" v-model="ruleForm.checkPass" autocomplete="off" @input="clearArr"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')">查询</el-button>
                <el-button @click="resetForm('ruleForm')">清空</el-button>
            </el-form-item>
        </el-form>
    </div>
    <div class="res">
        <!-- {{ queryOk }} -->
        <el-table
        :data="queryOk"
        style="width: 100%"
        v-show="queryOk!=null"
        >
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
  </div>
</template>

<script>
// 导入查询接口
import { getStatus8V8 } from '@/api/status'

export default {
  name: 'QueryServer',
  data () {
    const validatePass = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入服务器IP地址'))
      } else {
        if (this.ruleForm.checkPass !== '') {
          this.$refs.ruleForm.validateField('checkPass')
        }
        callback()
      }
    }
    const validatePass2 = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入端口号'))
      } else {
        callback()
      }
    }
    return {
      ruleForm: {
        pass: '',
        checkPass: ''
      },
      queryOk: null, // 查询结果
      rules: {
        pass: [
          { validator: validatePass, trigger: 'blur' }
        ],
        checkPass: [
          { validator: validatePass2, trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    async submitForm (formName) {
      this.$refs[formName].validate(async (valid) => {
        if (valid) {
          const res = await getStatus8V8({
            ds_ip: this.ruleForm.pass,
            ds_port: this.ruleForm.checkPass
          })
          this.queryOk = []
          this.queryOk.push(res.data)
          // console.log('查询结果', res)
          if (res.data === '') {
            this.queryOk = '查询失败'
            this.$message({
              message: '查询失败，该服务器无响应！',
              type: 'warning'
            })
          }
        } else {
          // console.log('error submit!!')
          return false
        }
      })
    },
    resetForm (formName) {
      this.$refs[formName].resetFields()
      this.queryOk = null
    },
    clearArr () {
      this.queryOk = null
    },
    fontColorShow (name) { // 符号渲染彩色的处理函数
      return name.replace(/\^[1-9]/g, function (e) {
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

<style lang='scss' scoped>
.main{
    width: 50%;
    margin: 0 auto;
}
</style>
