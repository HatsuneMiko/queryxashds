import request from '@/utils/request'

// 8v8获取排行榜
export function getRank (params) {
  return request({
    url: '/rank/8v8',
    method: 'GET',
    params
  })
}

// 8v8顶部搜索
export function getSearch (params) {
  return request({
    url: '/search/8v8',
    method: 'GET',
    params
  })
}

// FFA获取排行榜
export function getRankFFA (params) {
  return request({
    url: '/rank/ffa',
    method: 'GET',
    params
  })
}

// FFA顶部搜索
export function getSearchFFA (params) {
  return request({
    url: '/search/ffa',
    method: 'GET',
    params
  })
}

// AWP获取排行榜
export function getRankAWP (params) {
  return request({
    url: '/rank/awp',
    method: 'GET',
    params
  })
}

// AWP顶部搜索
export function getSearchAWP (params) {
  return request({
    url: '/search/awp',
    method: 'GET',
    params
  })
}
