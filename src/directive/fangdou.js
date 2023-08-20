// 点击防抖
const throttle = {
  bind: (el, binding) => {
    // console.log('防抖')
    let throttleTime = binding.value // 防抖时间
    if (!throttleTime) {
      // 用户若不设置防抖时间，则默认1s
      throttleTime = 1000
    }
    let timer
    let disable = false
    el.addEventListener(
      'click',
      (event) => {
        if (timer) {
          clearTimeout(timer)
        }
        if (!disable) {
          // 第一次执行(一点击触发当前事件)
          disable = true
        } else {
          event && event.stopImmediatePropagation()
        }
        timer = setTimeout(() => {
          timer = null
          disable = false
        }, throttleTime)
      },
      true
    )
  }
}

export default throttle
