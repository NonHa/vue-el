import fetch from '../config/fetch'
import { getStore } from '../config/mUtils'

/**
 * 获取首页默认地址
*/

export const getTest = data => fetch( '/webapi.php', data );
// 是否登录
// 
export const getAuthenticate = data => fetch(null , data);

export const isRegistered = data => fetch(null , data);
export const getIndexData = data => fetch(null , data);
export const GetSlideUrl = data => fetch(null , data);
// 根据id 获取用户信息
export const getUserByID = data => fetch(null , data);
// 获取邀约信息人数总和
export const getMessageCount = data => fetch(null , data);
// 获取邀约信息 - 收到
export const getInviteMsgList = data => fetch(null , data);
// 获取邀约信息 - 发出
export const getChatMsgList = data => fetch(null , data);
// 获取用户基本资料
export const getBasicInfo = data => fetch(null , data);
// 获取用户择偶条件
export const getSpouseCondition = () => fetch(null , {"operate":"getSpouseCondition","type":1});
export const getMyLoveCount = () => fetch(null , {"operate":"getMyLoveCount"});
export const getByLoveCount = () => fetch(null , {"operate":"getByLoveCount"});
export const getInviteCount = data => fetch(null , data);
export const getBeLoveCountById = data => fetch(null , data);
// 获取评论
export const getRecommend = data => fetch(null , data);
// 搜索
export const getSearch = data => fetch(null ,data);
// 上传图片

export const addImg = data => fetch('upload' , data);
// 更新上传图片
export const updateImg = data => fetch(null , data);

// 删除上传图片
export const delImg = data => fetch(null , data);
// 密码登录
export const pwLogin = data => fetch(null , data);

export const getSessionApi = () => fetch(null , { "operate": "getSession"});
// 发生邀约
export const sendMsg = data => fetch(null , data);
// 获取修改绑定手机号码 的验证码
export const getUpdateBindRealTelCheckCode = () => fetch(null , {"operate":"getUpdateBindRealTelCheckCode"});
// 提交修改手机号码信息
export const doUpdateBindRealTel = data => fetch(null ,data);
// 根据id 获取用户信息
export const doBindRealTel = data => fetch(null ,data);
// 根据id 获取用户信息
export const getBindRealTelCheckCode = data => fetch(null , data);

// 获取推荐人列表
export const getVVIPList = () => fetch(null , {"operate":"getVVIPList"});
// 提交推荐人
export const addRealReferrerVerify = data => fetch(null , data);
// 更新用户基本资料
export const updateBasicInfo = data => fetch(null , data);
export const updateMyInfo = data => fetch(null , data);
// 更新用户择偶条件
export const updateSpouseCondition = data => fetch(null , data);
// 根据id 获取发出的用户的信息
export const getChatById = data => fetch(null , data);
// 根据id 获取收到的用户的信息
export const getInviteById = data => fetch(null , data);
// 更新用户信息
export const updateUser = () => fetch(null , {"operate":"updateUser","type":1});
// 修改密码
export const ModifyPassword = data => fetch(null , data);
// 忘记密码后用openid修改
export const pwdChangeWithOpenid = () => fetch(null , {"operate":"pwdChangeWithOpenid","type":1});
// 获取忘记的密码
export const getforgotPwd = () => fetch(null , {"operate":"getforgotPwd","type":1});
// 修改密码验证码 判断
export const checkforgotpwd = data => fetch(null , data);
// 喜欢 判断
export const addLove = data => fetch(null , data);
// 取消喜欢 判断
export const delLove = data => fetch(null , data);
export const getBeLovedCountById = data => fetch(null , data);

// 根据id 获取用户信息
export const addRealEduVerify = data => fetch(null , data);
// 根据id 获取用户信息
export const addRealNameVerify = data => fetch(null , data);
export const doAddOrUpdateHobby = data => fetch(null , data);
export const getHobby = data => fetch(null , data);

  // 根据id 获取用户信息
  export const preciseSearch = data => fetch(null , data);

export const WebLogin = data => fetch(null , data);
export const getInviteList = () => fetch(null , {"operate":"getInviteList"});
export const getBeInvitedList = () => fetch(null , {"operate":"getBeInvitedList"});
export const getInviteMsg = data => fetch(null , data);
export const createInviteMsg = data => fetch(null , data);
export const updateInviteMsg = data => fetch(null , data);
export const homeMessage = () => fetch(null , {"operate":"getRecommend","type":1});
export const GetMyId = () => fetch(null , {"operate":"GetMyId","type":1});
// 根据id 获取用户信息
export const addUserVip = data => fetch(null , data);
// 根据id 获取用户信息
export const getActivityList = data => fetch(null , {"operate": "getActivityList"});
export const getActivityDetailsById = data => fetch(null , data);
export const activityApplicants = data => fetch(null , data);
// 更新上传图片
export const getVipList = () => fetch(null , {"operate":"getVipList","type":1});

// 判断用户是否存在
export const orderReservation = () => fetch(null , {"operate":"orderReservation","type":1});




// 根据id 获取用户信息
export const getScreen = () => fetch(null , {"operate":"getScreen","type":1});

