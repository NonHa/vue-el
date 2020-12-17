import Cookies from 'js-cookie'

const session = 'userSession'
const UserInfo = 'userInfo'
const Common = 'common'
const IdxCity = "IdxCity"
export function getSession() {
  return Cookies.get(session)
}

export function setSession(token) {
  return Cookies.set(session, token)
}
export function setIdxCity(city) {
  return Cookies.set(IdxCity, city)
}
export function setUserInfo(userInfo) {
  return Cookies.set(UserInfo, userInfo)
}

export function getUserInfo() {
  return Cookies.get(UserInfo)
}

export function removeSession() {
  return Cookies.remove(session)
}

export function getEarId() {
  var data = JSON.parse(getUserInfo())
  const { earId } = data
  return earId
}
