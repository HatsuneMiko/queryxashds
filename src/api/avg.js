import request from '@/utils/request'

// 获取8v8平均水平
export function getAvg () {
  return request({
    url: '/avg/8v8',
    method: 'GET'
  })
}
