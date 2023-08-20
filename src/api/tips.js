import request from '@/utils/request'

// 获取主页弹框通知
export function getTips (params) {
  return request({
    url: '/tips',
    method: 'GET',
    params
  })
}
