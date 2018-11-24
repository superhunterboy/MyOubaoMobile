

(function(host, name, Event, undefined){
	var defConfig = {
		//主面板dom
		panel:'#J-panel-gameTypes'
	},
	//渲染实例
	instance,
	//游戏实例
	Games = host.Games;

	//渲染方法
	var pros = {
		init:function(cfg){
			var me = this;
			//缓存方法
			Games.setCurrentGameTypes(me);
			me.container = $(cfg.panel);
			//玩法数据
			me.data = Games.getCurrentGame().getGameConfig().getInstance().getMethods();
			me.buildDom();
			me.initEvent();
		},
		buildDom:function(){
			var me = this,it,it2,it3,strArr = [],strArrAll = [],modeArr = [];
			$.each(me.data, function(){
				strArr = [];
				it = this;
				strArr.push('<li class="gametypes-menu-'+ it['name_en'] +'">');
					strArr.push('<div class="title">');
						strArr.push(it['name_cn']);
						modeArr[0] = it['name_en'];
						strArr.push('<span></span>');
					strArr.push('</div>');
					// strArr.push('<div class="content">');

					// $.each(it['children'], function(){
					// 	it2 = this;
					// 	modeArr[1] = it2['name_en'];
					// 	strArr.push('<dl>');
					// 		strArr.push('<dd class="types-node types-node-'+ it2['name_en'] +'">'+ it2['name_cn'] +'</dd>');
					// 		$.each(it2['children'], function(){
					// 			it3 = this;
					// 			modeArr[2] = it3['name_en'];
					// 			strArr.push('<dd class="types-item" data-id="'+ it3['id'] +'">'+ it3['name_cn'] +'</dd>');
					// 		});
					// 	strArr.push('</dl>');
					// });
					// strArr.push('</div>');
				strArr.push('</li>');

				strArrAll.push(strArr.join(''));
			});
			me.getContainerDom().html(strArrAll.join(''));

			//构建平板面板菜单
			me.buildPanelMenu();

			setTimeout(function(){
				me.fireEvent('endShow');
			}, 20);

		},
		buildPanelMenu:function(){
			var me = this,it,it2,it3,strArr = [],strArrAll = [],modeArr = [],
				panelDom = me.getPanelDom();
			$.each(me.data, function(){
				strArr = [];
				it = this;
				strArr.push('<li class="gametypes-sort gametypes-menu-'+ it['name_en'] +'">');
					/**
					strArr.push('<div class="title">');
						strArr.push(it['name_cn']);
						modeArr[0] = it['name_en'];
						strArr.push('<span></span>');
					strArr.push('</div>');
					**/
					strArr.push('<div class="content clearfix">');
					
					$.each(it['children'], function(){
						it2 = this;
						modeArr[1] = it2['name_en'];
						strArr.push('<dl>');
							strArr.push('<dt class="types-node types-node-'+ it2['name_en'] +'">'+ it2['name_cn'] +'</dt>');
							$.each(it2['children'], function(){
								it3 = this;
								modeArr[2] = it3['name_en'];
								strArr.push('<dd class="types-item" data-id="'+ it3['id'] +'">'+ it3['name_cn'] +'</dd>');
							});
						strArr.push('</dl>');
					});
					strArr.push('</div>');
				strArr.push('</li>');
				
				strArrAll.push(strArr.join(''));
			});
			panelDom.html(strArrAll.join(''));
		},
		initEvent:function(){
			var me = this;
			// me.container.on('click', '.types-item', function(){
			// 	var el = $(this),id = el.attr('data-id');
			// 	if(id){
			// 		me.changeMode(id, el);
			// 	}
			// });
			me.getPanelDom().on('click', '.types-item', function() {
				var el = $(this),id = el.attr('data-id');
				if(id){
					me.changeMode(id, el);
				}
			});

			/*Games.getCurrentGame().addEvent('afterSwitchGameMethod', function(obj, id){
				// console.log('daf');
				var el = me.getPanelDom().find('dd[data-id=' + id + ']'),
					cls = 'types-item-current',
					cls2 = 'gametypes-sort-current';
				me.getPanelDom().find('.types-item').removeClass(cls);
				el.addClass(cls);
				// console.log(el)
				//显示大面板
				me.getPanelDom().children().removeClass(cls2);
				el.parents('.gametypes-sort').addClass(cls2);
			});*/

			me.container.on('click', '.title', function(){
				// $(this).parents('ul').find('li').removeClass('hover')

				// me.container.find('.content').hide();
				// $(this).parents('li').find('.content').show();
				// $(this).parents('li').addClass('hover');
				// var id =$(this).next('div.content').find('dd.types-item:first').attr('data-id');

				

				// Games.getCurrentGame().getCurrentGameMethod().container.find('.number-select-link').hide();
				// me.changeMode(id);
				var idx = $(this).parent().index(),
					$parent = $(this).parents('ul').find('li'),
					$panel = me.getPanelDom().find('.gametypes-sort');
				$parent.removeClass('current').eq(idx).addClass('current');
				$panel.hide().removeClass('current').eq(idx).addClass('current').show();

				var id = $panel.eq(idx).find('dd.types-item:first').attr('data-id');

				
				// Games.getCurrentGame().getCurrentGameMethod().container.find('.number-select-link').hide();
				me.changeMode(id);


				/*var el = $(this),
					parent = el.parent(),
					lis = parent.parent().children(),
					index = lis.index(parent.get(0)),
					panel = me.getPanelDom().find('.gametypes-sort').eq(index),
					dom = panel.find('.types-item').eq(0),
					id = dom.attr('data-id');
				// console.log(id,index, dom)
				me.changeMode(id, dom);*/
			});			
		},
		//获取外部容器DOM
		getContainerDom: function(){
			return this.container;
		},
		getPanelDom:function(){
			return this.panelDom || (this.panelDom = $('#J-gametyes-menu-panel'));
		},
		//切换事件
		changeMode: function(mode, el){
			var me = this,
				container = me.getContainerDom();

			//执行自定义事件
			me.fireEvent('beforeChange', mode);
			try{
				if(mode == Games.getCurrentGame().getCurrentGameMethod().getGameMethodName()){
					return;
				}
			}catch(e){
			}
			//执行切换
			Games.getCurrentGame().switchGameMethod(mode);
		}
	};

	var Main = host.Class(pros, Event);
		Main.defConfig = defConfig;
		Main.getInstance = function(cfg){
			return instance || (instance = new Main(cfg));
		};
	host[name] = Main;

})(dsgame, "GameTypes", dsgame.Event);










