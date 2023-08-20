import request from '@/utils/request'

// 查询服务器状态 ?ds_ip=1.13.245.142&ds_port=23333
export function getStatus8V8 (params) {
  return request({
    url: '/conn.php',
    method: 'GET',
    params
  })
}
