var chat = {
	messageToSend: '',
	messageResponses: [],
	send_name: '',
	response_name: '',
	to: '',
	init: function() {
		this.cacheDOM();
		this.bindEvents();
		this.render();
	},
	initVal:function(obj) {
		this.send_name = decodeURIComponent(obj.send_name);
		this.response_name = decodeURIComponent(obj.response_name);
		this.to = decodeURIComponent(obj.to);
	},
	cacheDOM: function() {
		this.$chatHistory = $('.chat-history');
		this.$button = $('button');
		this.$textarea = $('#message-to-send');
		this.$chatHistoryList = this.$chatHistory.find('ul');
	},
	bindEvents: function() {
		this.$button.on('click', this.addMessage.bind(this));
		this.$textarea.on('keyup', this.addMessageEnter.bind(this));
	},
	render: function() {
		this.scrollToBottom();
		if (this.messageToSend.trim() != '' && this.to != '') {
			if(this.messageToSend=="invite"){
				this.messageToSend="intite.";
			}
			var data = {
				"operate": "sendMsg",
				"lab": this.messageToSend,
				"to": this.to,
				"msg_key": 1
			};
			layer.load();
			Ajax(function(obj) {
				if (obj.Code > 0) {
					layer.closeAll();
					layer.msg(obj.Msg);
					return;
				} else {
					layer.closeAll();
				}
			
			}, data)
			var template = Handlebars.compile($("#message-template").html());
			var context = {
				messageOutput: this.messageToSend,
				time: this.getCurrentTime(),
				name: this.send_name
			};

			this.$chatHistoryList.append(template(context));
			this.scrollToBottom();
			this.$textarea.val('');

			// responses
			// var templateResponse = Handlebars.compile( $("#message-response-template").html());
			// var contextResponse = { 
			//   response: this.getRandomItem(this.messageResponses),
			//   time: this.getCurrentTime()
			// };

			// setTimeout(function() {
			//   this.$chatHistoryList.append(templateResponse(contextResponse));
			//   this.scrollToBottom();
			// }.bind(this), 1500);

		}

	},
	renderImg: function() {
		this.scrollToBottom();

		var data = {
					"operate": "sendMsg",
					"to":this.to,
					"lab": "img",
					"url":this.messageToSend,
					};
		layer.load();
		Ajax(function(obj) {
			if (obj.Code > 0) {
				layer.closeAll();
				layer.msg(obj.Msg);
				return;
			} else {
				layer.closeAll();
			}
		
		}, data)
		var template = Handlebars.compile($("#message-template").html());
		var context = {
			messageOutput: decodeURIComponent(this.messageToSend),
			time: this.getCurrentTime(),
			name: this.send_name,
			img:"img"
		};

		this.$chatHistoryList.append(template(context));
		this.scrollToBottom();
		this.$textarea.val('');
	
			
	},

	addMessage: function() {
		this.messageToSend = this.$textarea.val()
		this.render();
	},
	addMessageEnter: function(event) {
		// enter was pressed
		if (event.keyCode === 13) {
			this.addMessage();
		}
	},
	scrollToBottom: function() {
		this.$chatHistory.scrollTop(this.$chatHistory[0].scrollHeight);
	},
	getCurrentTime: function() {
		return new Date().toLocaleTimeString().
		replace(/([\d]+:[\d]{2})(:[\d]{2})(.*)/, "$1$3");
	},
	getRandomItem: function(arr) {
		return arr[Math.floor(Math.random() * arr.length)];
	}

};

chat.init();

var searchFilter = {
	options: {
		valueNames: ['name']
	},
	init: function() {
		var userList = new List('people-list', this.options);
		var noItems = $('<li id="no-items-found">No items found</li>');

		userList.on('updated', function(list) {
			if (list.matchingItems.length === 0) {
				$(list.list).append(noItems);
			} else {
				noItems.detach();
			}
		});
	}
};

searchFilter.init();
