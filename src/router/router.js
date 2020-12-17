import App from '../App'

const footBom = r => require.ensure([], () => r(require('../page/components/bottomView/index')), 'main')
const main = r => require.ensure([], () => r(require('../page/components/main')), 'main')
const home = r => require.ensure([], () => r(require('../page/home/home')), 'home')
const active = r => require.ensure([], () => r(require('../page/active/index')), 'active')
const activeDoing = r => require.ensure([], () => r(require('../page/active/activeDoing')), 'active')
const mine = r => require.ensure([], () => r(require('../page/mine/index')), 'mine')
const message = r => require.ensure([], () => r(require('../page/message/index')), 'message')
const chat = r => require.ensure([], () => r(require('../page/message/chat')), 'message')
const visite = r => require.ensure([], () => r(require('../page/message/visite')), 'message')
const search = r => require.ensure([], () => r(require('../page/search/index')), 'search')
const article = r => require.ensure([], () => r(require('../page/article/index')), 'article')
const articleMes = r => require.ensure([], () => r(require('../page/article/message')), 'article')
const customer = r => require.ensure([], () => r(require('../page/customer/index')), 'customer')
const customerVisite = r => require.ensure([], () => r(require('../page/customer/visite')), 'customer')
const visiteSuccess = r => require.ensure([], () => r(require('../page/customer/visiteSuccess')), 'customer')
const mineCheck = r => require.ensure([], () => r(require('../page/mine/check/index')), 'check')
const nameCheck = r => require.ensure([], () => r(require('../page/mine/check/name')), 'check')
const educationCheck = r => require.ensure([], () => r(require('../page/mine/check/education')), 'check')
const checkMain = r => require.ensure([], () => r(require('../page/mine/check/main')), 'check')
const login = r => require.ensure([], () => r(require('../page/login/index')), 'login')
const love = r => require.ensure([], () => r(require('../page/love/index')), 'love')
const loveMes = r => require.ensure([], () => r(require('../page/love/myLove')), 'love')
const myLove = r => require.ensure([], () => r(require('../page/mine/edit/myLove')), 'love')
const vip = r => require.ensure([], () => r(require('../page/saleVip/index')), 'vip')
const editMain = r => require.ensure([], () => r(require('../page/mine/edit/main')), 'edit')
const homeMain = r => require.ensure([], () => r(require('../page/mine/main')), 'edit')
const mineEdit = r => require.ensure([], () => r(require('../page/mine/edit/index')), 'edit')
const report = r => require.ensure([], () => r(require('../page/mine/report')), 'mine')
const setting = r => require.ensure([], () => r(require('../page/mine/setting')), 'mine')
const reportMessage = r => require.ensure([], () => r(require('../page/mine/reportMessage')), 'mine')
const translator = r => require.ensure([], () => r(require('../page/translator/index')), 'translator')
const translatorPay = r => require.ensure([], () => r(require('../page/translator/pay')), 'translator')
const order = r => require.ensure([], () => r(require('../page/order/index')), 'order')
const orderMessage = r => require.ensure([], () => r(require('../page/order/message')), 'order')

// const reportMessage = r => require.ensure([], () => r(require('../page/mine/reportMessage')), 'mine')
export default [
    {
    path: '/',
    name: 'Main',
    redirect: '/home',
    component: footBom,
    children: [
        {
            path: 'home',
            component: home,
            meta: {
                title: '首页'
            },
           
        },
        {
            path: 'active',
            component: active,
            name: 'Active',
            meta: { title: '活动' }
        },
        {
            path: 'message',
            component: message,
            name: 'Message',
            meta: { title: '消息' }
        },
        {
            path: 'mine',
            component: mine,
            name: 'Mine',
            meta: { title: '我的' },
            
        },
        
        
        ]
    },
    {
        path: '/customer',
				component: homeMain,
        redirect: '/customer/index',
        name: 'customerMain',      
        children: [
            {
                path: 'index',
                name: 'customer',
                component: customer,
                meta: { title: '个人详情' }
            },
            {
                path: 'visite',
                name: 'customerVisite',
                component: customerVisite,
                meta: { title: '个人邀请' }
            },
            {
                name: 'success',
                path: 'success',
                component: visiteSuccess,
                meta: { title: '发送消息' }
        
            },
        ]

    },
    {
        path: '/edit',
				component: footBom,
        redirect: '/edit/index',
        name: 'Edit',      
        children: [
            {
                path: 'index',
                name: 'mineEdit',
                component: mineEdit,
                meta: { title: '编辑消息' }
            },
           
        ]

		},
    {   
        path: '/check',
        redirect: '/check/index',
				component: footBom,
				name: 'Check',
        children: [
					{
						path: 'index',
						name: 'mineCheck',
						component: mineCheck,
						meta: { title: '认证' }
					},
					{
						path: '/check/name',
						name: 'nameCheck',
						component: nameCheck,
						meta: { title: '实名认证' }
					},
					{
						name: 'educationCheck',
						path: '/check/education',
						component: educationCheck,
						meta: { title: '学历认证' }
						
				},
        ]
		},
		{   
			path: '/translator',
			redirect: '/translator/index',
			component: footBom,
			children: [
				{
					path: 'index',
					name: 'Translator',
					component: translator,
					meta: { title: '牵线' }
				},
				{
					path: 'pay',
					name: 'TranslatorPay',
					component: translatorPay,
					meta: { title: '牵线订单确认' }
				}
			]
	},
	{   
		path: '/order',
		redirect: '/order/index',
		component: footBom,
		children: [
			{
				path: 'index',
				name: 'Order',
				component: order,
				meta: { title: '订单' }
			},
			{
				path: 'message',
				name: 'OrderMessage',
				component: orderMessage,
				meta: { title: '订单详情' }
			},
		
		]
},
    {
        
				path: '/edit',
        redirect: '/edit/index',
				component: footBom,
				name: 'mineEdit',
				meta: { title: '编辑消息' },
				children: [
					{
						path: 'index',
						name: 'mineCheck',
						component: mineCheck,
						meta: { title: '认证' }
					},
					{
						path: '/check/name',
						name: 'nameCheck',
						component: nameCheck,
						meta: { title: '实名认证' }
					},
					{
						name: 'educationCheck',
						path: '/check/education',
						component: educationCheck,
						meta: { title: '学历认证' }
						
				},
        ]
    },
    {
        path: '/search',
        component: search,
        meta: { title: '搜索' }

    },
    {
        path: '/searchMessage',
        component: articleMes,
        meta: { title: '情感资讯' }

    },
    {
        path: '/article',
        component: article,
        meta: { title: '情感资讯' }

    },
		{
			path: '/report',
			component: report,
			name: 'Report',
			meta: { title: '黑名单' }
			
		},
		{
			path: '/setting',
			component: setting,
			name: 'setting',
			meta: { title: '设置' }
			
		},
		{
			path: '/report/message',
			component: reportMessage,
			name: 'reportMessage',
			meta: { title: '举报信息' }
			
		},
   
    {   
        name: 'chat',
        path: '/message/chat',
        component: chat,
        meta: { title: '发出邀约' }

    },
    {   
        name: 'visite',
        path: '/message/visite',
        component: visite,
        meta: { title: '接收邀约' }

    },
    {
        path: '/active/doing',
        component: activeDoing
		},
		{
			name: 'myLove',
			path: '/myLove',
			component: myLove,
			meta: { title: '我的爱好' }
			
		},
    {
        name: 'love',
        path: '/love',
        component: love,
        meta: { title: '爱情定制' }

		},
		{
			name: 'love',
			path: '/love/message',
			component: loveMes,
			name: 'loveNum',
			meta: { title: '爱情定制' }

		},
    {
        name: 'vip',
        path: '/vip',
        component: vip,
        meta: { title: '购买会员' }
        
    },
    
]