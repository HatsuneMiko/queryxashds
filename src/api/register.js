import request from '@/utils/request'

// 注册
export function register (data) {
  return request({
    url: '/register',
    method: 'POST',
    data
  })
}
