(function(host, name, undefined) {
    var Main = function() {};
    host[name] = Main
})(this, "betgame");

(function(host, name, undefined) {
    touchEvent = ('ontouchstart' in window) ? 'tap' : 'click';
    host[name] = touchEvent
})(betgame, "touchEvent");

(function(host, name, $, undefined) {
    var BEFOREINIT = "beforeInit",
    AFTERINIT = "afterInit";
    var utilConstructor = function(Sub, cases, config) {
        var config = config || {};
        if (Sub.superClass && Sub.superClass.defConfig) {
            Sub.defConfig = $.extend({},
            Sub.superClass.defConfig, Sub.defConfig)
        }
        config = cases.defConfig = $.extend({},
        Sub.defConfig, config);
        if (config['expands']) {
            $.extend(cases, config['expands'])
        }
        if (Sub.superClass) {
            Sub.superClass.call(cases, config)
        }
        if ($.isFunction(Sub.prototype.init)) {
            var isSubSuper = cases.constructor === Sub;
            isSubSuper && $.isFunction(config[BEFOREINIT]) && config[BEFOREINIT].call(cases, config);
            Sub.prototype.init.call(cases, config);
            isSubSuper && $.isFunction(config[AFTERINIT]) && config[AFTERINIT].call(cases, config);
            if (isSubSuper) {
                for (var i = 0,
                len = cases._inits.length; i < len; i++) {
                    cases._inits[i].call(cases, cases.defConfig)
                }
            }
        }
    };
    var Class = function(pros, superClass) {
        var Main = function(config) {
            var me = this;
            me._inits = [];
            utilConstructor(Main, me, config)
        };
        if (arguments.length < 2) {
            Main.prototype = pros
        } else {
            var Cons = function() {};
            Cons.prototype = superClass.prototype;
            Main.prototype = new Cons();
            $.extend(Main.prototype, pros);
            Main.superClass = superClass
        }
        Main.prototype.constructor = Main;
        return Main
    };
    host[name] = Class
})(betgame, "Class", jQuery);



(function(host, name, undefined) {
    var stopEvent = function() {
        this._isStop = true
    };
    var pros = {
        init: function(config) {
            this._events = {}
        },
        addEvent: function(name, fn) {
            if (!fn || Object.prototype.toString.call(fn) !== "[object Function]") {
                throw "Event.addEvent\u7B2C\u4E8C\u4E2A\u53C2\u6570\u5FC5\u987B\u662F\u51FD\u6570";
            }
            var me = this,
            _evs = me._events;
            _evs[name] = _evs[name] || [];
            _evs[name].push(fn)
        },
        removeEvent: function(name, fn) {
            var me = this,
            _evs = me._events;
            if (!_evs[name]) {
                return
            }
            if (!fn) {
                delete _evs[name];
                return
            }
            var fns = _evs[name],
            i = fns.length;
            while (i) {
                i--;
                if (fns[i] === fn) {
                    fns.splice(i, 1)
                }
            }
            if (!fns.length) {
                delete _evs[name]
            }
        },
        fireEvent: function(name) {
            var me = this,
            _evs = me._events;
            if (!_evs[name]) {
                return
            }
            var fns = _evs[name];
            if (fns._isStop) {
                delete fns._isStop;
                return
            }
            var i = 0,
            len = fns.length,
            ev = {
                type: name,
                data: me,
                stopEvent: stopEvent
            },
            args = [ev].concat(Array.prototype.slice.call(arguments, 1));
            for (var i = 0; i < len; i++) {
                if (ev._isStop || fns[i].apply(me, args) === false) {
                    ev._isStop = false;
                    return
                }
            }
        },
        stopEvent: function(name) {
            var me = this,
            _evs = me._events;
            if (!_evs[name]) {
                return
            }
            _evs[name]._isStop = true
        }
    };
    var Main = host.Class(pros);
    host[name] = Main
})(betgame, "Event");

(function(host, name, Event, $, undefined){
    var defConfig = {
            currClass:'current',
            currPanelClass:'panel-current',
            par:document,
            triggers:'.triggers li',
            panels:'.panel',
            eventType:'mouseenter',


            //初始
            isDefShow:true,
            index:0,
            isDefRandom:false,


            //延迟触发
            delay:150,


            //自动播放
            autoPlay:0,
            //鼠标划过是否停止自动切换
            autoPlayIsHoverStop:true,
            //每次切换的索引步长,可为负值
            autoPlayStep:1,


            //控制器
            controlStep:1,
            //触发控制器，自动播放暂停时间
            controlCancelAutoPlayTime:3000

        },


    //这里下面扩展部分，原则上应该使用继承来实现，为了不使继承层次过多，这里模拟插件机制
    //同时尽可能的将方法定义在局部作用域里,使用call调用，获得原型继承节约开销同样的效果，
    //另一方面也保护了这些私有方法和逻辑，仅对外暴露必要且健壮的方法


    //=============================================================
    //延迟触发
    //=============================================================
        delayEventMap = {mouseenter:'mouseleave',mouseover:'mouseout'},
        delayInit = function(cfg){
            var me = this;
            me.triggers.bind(cfg.eventType, me, function(e){
                var dom = this;
                delayCancel(e);
                me._delayTimer = setTimeout(function(){
                    triggersHander.call(dom, e);
                },cfg.delay);
            });

            if(delayEventMap[cfg.eventType]){
                me.triggers.bind(delayEventMap[cfg.eventType], me, delayCancel);
            }
        },
        delayCancel = function(e){
            clearTimeout(e.data._delayTimer);
        },

    //=============================================================
    //自动播放
    //=============================================================
        autoPlayInit = function(cfg){
            var me = this;
            //对外控制接口
            me.autoPlayStart = autoPlayStart;
            me.autoPlayStop = autoPlayCancel;
            //提供重写
            me._autoPlayGetIndex = autoPlayGetIndex;
            //鼠标进入停止自动播放
            if(cfg.autoPlayIsHoverStop){
                me.triggers.bind("mouseenter", me, autoPlayCancel).bind("mouseleave", me, autoPlayStart);
                me.panels.bind("mouseenter", me, autoPlayCancel).bind("mouseleave", me, autoPlayStart);
                //手动触发也停止自动播放
                //mouseenter 事件已注册过
                if(cfg.eventType != "mouseenter"){
                    me.triggers.bind(cfg.eventType, me, autoPlayCancel);
                }
            }

        },
        autoPlayStart = function(e){
            var me = e && e.data ? e.data : this, toEl = (e && e.relatedTarget) ? e.relatedTarget : false;
            if(toEl && ((me.triggers.index(toEl) != -1) || (me.panels.index(toEl) != -1))){
                return;
            }
            autoPlayFn.call(me);
            //console.log('start...');
        },
        autoPlayFn = function(){
            var me = this,cfg = me.defConfig;
            //autoPlayCancel.call(me);
            me._autoPlayTimer = setTimeout(function(){
                onSwitch.call(me, me._autoPlayGetIndex());
                autoPlayFn.call(me);
            }, cfg.autoPlay);
        },
        autoPlayCancel = function(e){
            var me = e && e.data ? e.data : this;
            clearTimeout(me._autoPlayTimer);
            //console.log('stop...');
        },
        autoPlayGetIndex = function(){
            var me = this,length = me.length, len = length - 1,i = me.index + me.defConfig.autoPlayStep;
            /**
             i = i > len ? (i+1)%length - 1 : i;
             i = i < 0 ? (i+1)%length - 1 : i;
             **/
            i = i > len ? 0 : i;
            i = i < 0 ? len : i;
            return me._index = i;
        },



    //=============================================================
    //辅助方法
    //=============================================================
        onSwitch = function(i){
            //console.log(i);
            var me = this,index = me.index;
            if(i === index && index != undefined){
                return;
            }

            me.index = index === undefined ? i : index;
            me._index = i;

            //me._index 在beforeSwitch中有可能会被修正
            me.fireEvent("beforeSwitch", me._index);
            me.fireEvent("onSwitch", me._index);
            me.fireEvent("afterSwitch", me._index);
        },
    //trigger监听事件
        triggersHander = function(e){
            var me = e.data,i = me.triggers.index(this);
            onSwitch.call(me, me._index = i < 0 ? 0 : i);
        },
        setIndex = function(e, i){
            var me = this;
            return me.index = me.getTriggerIndex();
        },
        show = function(e, i){
            this.show(i, this.index);
        };

    var pros = {
        init:function(cfg){
            var me = this;
            me.par = $(cfg.par);
            me.triggers = $(cfg.triggers, me.par);
            me.panels = $(cfg.panels, me.par);
            me.length = Math.max(me.triggers.length, me.panels.length);
            //jquery元素缓存
            me._cache = {triggers:{},panels:{}};
            //第一次不设置index属性
            //me.index = undefined;
            //
            //插件处理
            //=================================
            //默认显示,推迟到实例准备就绪后执行
            if(cfg.isDefShow){
                me._inits.push(function(cfg){
                    var me = this, i = cfg.isDefRandom ? parseInt(Math.random()*(me.length)) : cfg.index,cls = cfg.currClass,panel_cls = cfg.currPanelClass;
                    //默认显示控制操作显示/隐藏,方便后端程序输出无须初始化
                    me.getTrigger(i).addClass(cls);
                    me.getPanel(i).addClass(panel_cls);
                    //初始呈现
                    onSwitch.call(me, i);
                });
            }


            //自动播放
            if(!!cfg.autoPlay && me.length > 1){
                //这里有一个一般情况下无关紧要的逻辑bug，自动播放实际上会在实例未初始化完成之前已经启动
                //但通常自动播放使用了定时器启动，使得自动播放的执行列队到实例化之后
                //如果自动播放的启动不使用定时器启动；或者出现严重阻塞的情况，在实例化完成之前插入了执行列队，会出现问题
                //autoPlayInit.call(me, cfg);

                //autoPlayInit不能加入延迟执行，因为子类中有可能会来重写autoPlay定义的方法
                autoPlayInit.call(me, cfg);
                //使用延迟执行避免
                me._inits.push(function(){
                    me.autoPlayStart();
                });

            }

            //延迟触发
            if(!!cfg.delay || delayEventMap[cfg.eventType]){
                delayInit.call(me, cfg);
            }else{
                //添加triggers事件
                me.triggers.bind(cfg.eventType, me, _triggersHander);
            }

            me.addEvent("onSwitch", show);
            //自动更新当前索引
            me.addEvent("afterSwitch", setIndex);

        },
        //提供重写方法
        //控制器索引限定规则
        controlGetAdjustIndex:function(i){
            var me = this,length = me.length, len = length - 1;
            i = i > len ? 0 : i;
            i = i < 0 ? len : i;
            return i;
        },
        //controlTo 参数为负值有bug
        //优化标记
        controlTo:function(i){
            var me = this,len = me.length,mn = i > 0 ? 1 : -1,cfg = me.defConfig;

            //手动操作时，暂停自动播放一段时间
            if(!!cfg.autoPlay && !!cfg.controlCancelAutoPlayTime){
                me.autoPlayStop();
                clearTimeout(me._controlCancelAutoPlayTimer);
                me._controlCancelAutoPlayTimer = setTimeout(function(){
                    me.autoPlayStart();
                },cfg.controlCancelAutoPlayTime);
            }

            onSwitch.call(me, me.controlGetAdjustIndex(i));
        },
        controlPre:function(){
            var me = this;
            me.controlTo(me.index + Math.abs(me.defConfig.controlStep)*-1);
        },
        controlNext:function(){
            var me = this;
            me.controlTo(me.index + Math.abs(me.defConfig.controlStep));
        },
        show:function(i){
            var me = this, cls = me.defConfig.currClass,panelCls = me.defConfig.currPanelClass,ti = me.getTriggerIndex(),pi = me.getPanelIndex();
            me.getTrigger(me.index).removeClass(cls);
            me.getTrigger(ti).addClass(cls);
            me.getPanel(me.index).removeClass(panelCls);
            me.getPanel(pi).addClass(panelCls);
        },
        getTrigger:function(i){
            var me = this,cache = me._cache;
            return cache.triggers[i] || (cache.triggers[i] = me.triggers.eq(i));
        },
        getPanel:function(i){
            var me = this,cache = me._cache;
            return cache.panels[i] || (cache.panels[i] = me.panels.eq(i));
        },
        getTriggerIndex:function(i){
            return this._index;
        },
        getPanelIndex:function(i){
            return this._index;
        }

    };


    var Main = host.Class(pros, Event);
    Main.defConfig = defConfig;
    host[name] = Main;

})(betgame, "Tab", betgame.Event, jQuery);


//模拟下拉框组件
(function(host, name, Event, $, undefined){
    var defConfig = {
        //最外层添加的class样式
        cls:'',
        valueKey: 'value',
        textKey: 'text',
        //是否同时能输入
        isInput:false,
        // 是否能作为计数器使用
        isCounter: false,
        // 计数器的最小值
        min: 1,
        // 计数器的最大值
        max: 99999,
        // 加减的步长
        step: 1,
        //对应的真实select
        realDom:'',
        //面板展开时的z-index值
        zIndex:100,
        //是否开启鼠标条
        isScroll:true,
        //滚动容器显示高度
        scrollHeight:310,
        //滚轮每次滚动面变移动距离
        scrollDis:31,
        //模拟select模板
        tpl:'<div class="choose-model"><div class="choose-list"><div class="choose-list-cont"><#=loopItems#></div></div><span class="choose-scroll" onselectstart="return false;"></span><span class="info"><input data-realvalue="<#=value#>" class="choose-input choose-input-disabled" disabled="disabled" type="text" value="<#=text#>" /></span><i></i></div>',
        //单行元素模板
        itemTpl:'<a data-value="<#=value#>" href="#"><#=text#></a>'
    };

    var pros = {
        init:function(cfg){
            var me = this;
            me.opts = cfg;
            me.realDom = $(cfg.realDom);
            me.realDom.hide();
            me.dom = null;
            me.listDom = null;
            me.buildSelect();
            // 计数器相关
            if( cfg.isCounter ){
                me.$ctrlDecrease = $('<span class="select-counter-action counter-decrease" data-counter-action="decrease">－</span>');
                me.$ctrlIncrease = $('<span class="select-counter-action counter-increase" data-counter-action="increase">+</span>');
                me.dom.before(me.$ctrlDecrease).after(me.$ctrlIncrease);
                me.$ctrl = me.$ctrlDecrease.add(me.$ctrlIncrease);
                me.setMinValue(cfg.min);
                me.setMaxValue(cfg.max);
                // me.checkCtrl();
                me.counterEvent(cfg);
            }
            me.initEvent();
        },
        show:function(){
            this.dom.show();
        },
        hide:function(){
            this.dom.hide();
        },
        showScroll:function(){
            var me = this;
            if(me.isScrollAble){
                this.getScrollDom().show();
            }
        },
        hideScroll:function(){
            var me = this,
                dom = me.getScrollDom();
            dom.hide();
            if(me.isScrollAble){
                me.scrollSetTop(0);
                dom.css('top', 0);
            }
        },
        getScrollDom:function(){
            var me = this;
            return me.scrollDom || (me.scrollDom = me.dom.find('.choose-scroll'));
        },
        initScroll:function(){
            var me = this,cfg = me.defConfig;
            if(me.getListContDomHeight() > cfg.scrollHeight){
                me.isScrollAble = true;
                me.getListDom().css({'height':cfg.scrollHeight, 'overflow':'hidden'});
                me.reBuildScroll();
            }else{
                me.isScrollAble = false;
            }
        },
        //计算滚动条相关参数
        reBuildScroll:function(){
            var me = this,cfg = me.defConfig,
                outerHeight = cfg.scrollHeight,
                innerHeight = me.getListContDomHeight();

            //最高内容器高度与显示区域高度比例
            me.scrollBl = innerHeight/outerHeight;
            //滚动条应显示的高度
            me.getScrollDom().css('height', outerHeight/me.scrollBl);
            me.scrollMin = 0;
        },
        scrollSetTop:function(top){
            var me = this;
            me.getListDom().scrollTop(top * me.scrollBl);
        },
        getListDom:function(){
            var me = this;
            return me.listDom || (me.listDom = me.dom.find('.choose-list'));
        },
        getListContDom:function(){
            var me = this;
            return me.listContDom || (me.listContDom = me.dom.find('.choose-list-cont'));
        },
        getListContDomHeight:function(){
            var me = this,h = 0;
            me.getListDom().css({'visibility':'hidden'}).show();
            h = me.getListContDom().height();
            me.getListDom().css({'visibility':'visible'}).hide();
            return h;
        },
        buildSelect:function(){
            var me = this,cfg = me.defConfig,tpl = cfg.tpl,itemTpl = cfg.itemTpl,items = me.getRealDom().options,len = items.length,i = 0,
                itemStrArr = [],
                currValue = '',
                currText = '';
            for(;i < len;i++){
                itemStrArr[i] = itemTpl.replace(/<#=value#>/g, items[i].value).replace(/<#=text#>/g, items[i].text);
                if(i == me.getRealDom().selectedIndex){
                    currValue = items[i].value;
                    currText = items[i].text;
                }
            }
            tpl = tpl.replace(/<#=text#>/g, currText).replace(/<#=loopItems#>/g, itemStrArr.join(''));
            me.dom = $(tpl);
            me.dom.addClass(cfg.cls);
            me.dom.insertBefore(me.getRealDom());

            if(cfg.isScroll){
                me.initScroll();
            }

            if(cfg.isInput){
                me.getInput().removeAttr('disabled');
                me.getInput().removeClass('choose-input-disabled');
                me.inputEvent();
            }
            me.setValue(currValue);

            me.reSetListWidth();
        },
        reSetListWidth:function(){
            var me = this,width = 0;
            if(host.util.isIE6){
                width = me.dom.width() + 8;
                me.getListDom().width(width);
            }
        },
        //data [{value:,text:,checked:true}]
        reBuildSelect:function(data){
            var me = this,cfg = me.defConfig,sel = $(me.getRealDom()),strArr = [],strArrOption = [],itemTpl = me.defConfig.itemTpl,selectIndex;
            $.each(data, function(i){
                strArr[i] = '<option value="'+ this[cfg.valueKey] +'">'+ this[cfg.textKey] +'</option>';
                strArrOption[i] = itemTpl.replace(/<#=value#>/g, this[cfg.valueKey]).replace(/<#=text#>/g, this[cfg.textKey]);
                if(this['checked']){
                    selectIndex = i;
                }
            });
            sel.html(strArr.join(''));
            me.getListContDom().html(strArrOption.join(''));

            if(typeof selectIndex != 'undefined'){
                me.setValue(data[selectIndex][cfg.valueKey]);
            }

            if(me.defConfig.isScroll){
                me.initScroll();
            }
        },
        initEvent:function(){
            var me = this,scrollDis = me.defConfig.scrollDis;


            $(document).on('touchstart',function(e){
                var el = e.target;
                if(!$.contains(me.dom.get(0), el)){
                    me.getListDom().hide();
                    me.hideScroll();
                    me.dom.css('zIndex', '');
                    me.dom.find('.open').removeClass('open');
                }
            });
            $(window).blur(function(){
                me.getListDom().hide();
                me.dom.css('zIndex', '');
                me.dom.find('.open').removeClass('open');
                me.hideScroll();
            });


            me.dom.on(betgame.touchEvent,function(e){
                var el = e.target,attr = el.getAttribute('data-value');
                //如果是选项点击
                if(attr != null){
                    me.setValue(attr);
                }
                if($.trim(me.getListDom().css('display').toLowerCase()) != 'none'){
                    me.dom.css('zIndex', '');
                    me.getListDom().hide();
                    me.hideScroll();
                    me.dom.find('.open').removeClass('open');
                }else{
                    me.dom.css('zIndex', me.defConfig.zIndex);
                    me.getListDom().show();
                    me.showScroll();
                    me.dom.find('i').addClass('open');
                }

                e.preventDefault();
            });

            var deltaAll = 0;



            var dragDom = me.getScrollDom(),donwX,donwY,isDraging = false,
                downEventFn = function(e){
                    isDraging = true;
                    donwY = e.clientY - parseInt(dragDom.css('top'));
                    if(dragDom.get(0).setCapture){
                        dragDom.get(0).setCapture();
                    }
                    $(document).bind('touchmove', moveEventFn);
                    $(document).bind('touchend', upEventFn);
                },
                moveEventFn = function(e){
                    var top = e.clientY - donwY,h = 0;
                    e.preventDefault();
                    if(!isDraging){
                        return false;
                    }
                    h = me.getListDom().height() - dragDom.height() - 4;
                    top = top < 0 ? 0 : top;
                    top = top > h ? h : top;

                    dragDom.css('top',top);

                    //到达极限时为防止误差，直接设很大的数字(scroll的设置对超出范围没有影响)
                    top = top == h ? top * 100 : top;
                    me.scrollSetTop(top);
                },
                upEventFn = function(e){
                    if(dragDom.get(0).releaseCapture){
                        dragDom.get(0).releaseCapture();
                    }
                    isDraging = false;
                    $(document).unbind('touchmove', moveEventFn);
                    $(document).unbind('touchend', upEventFn);
                };
            dragDom.on('touchestart',downEventFn);
            dragDom.click(function(e){
                e.preventDefault();
                e.stopPropagation();
            });

        },
        getInput:function(){
            var me = this;
            return me.input || (me.input = me.dom.find('.choose-input'));
        },
        //input校验函数
        inputEvent:function(){

        },
        getRealDom:function(){
            return this.realDom.get(0);
        },
        getItemList:function(){
            var me = this;
            return me.getListContDom().children();
        },
        //isStop 防止两个对象相互调用，相互触发形成死循环，例如：日期控件的面板渲染和Select的相互触发
        setValue:function(value, isStop){
            var me = this,dom = me.getRealDom(),index = dom.selectedIndex,options = dom.options,len = options.length,i = 0,text = '';
            for(;i < len;i++){
                if(value == options[i].value){
                    options[i].selected = true;
                    text = options[i].text;
                }else{
                    options[i].selected = false;
                }
            }
            value = '' + value;
            me.getInput().attr('data-realvalue', value);
            text = text == '' ? value : text;
            me.getInput().val(text);
            if(!isStop){
                me.fireEvent('change', value, text);
            }
            me.getItemList().removeClass('choose-item-current').parent().find('[data-value="'+ value +'"]').addClass('choose-item-current');
            if( me.opts.isCounter ){
                me.checkCtrl();
            }
        },
        getValue:function(){
            var me = this,dom = me.getRealDom(),index = dom.selectedIndex;
            if(me.defConfig.isInput){
                return me.getInput().attr('data-realvalue');
            }
            return dom.options[index].value;
        },
        getText:function(){
            var dom = this.getRealDom(),index = dom.selectedIndex;
            return dom.options[index].text;
        },
        setMinValue: function( num ){
            this.minValue = num;
            this.checkCtrl();
        },
        getMinValue: function(){
            return this.minValue;
        },
        setMaxValue: function( num ){
            this.maxValue = num;
            this.checkCtrl();
        },
        getMaxValue: function(){
            return this.maxValue;
        },
        setButtonStatus: function(button, status){
            if( !this.$ctrl ) return;
            var $ctrl = this.$ctrl.filter('[data-counter-action="' + button + '"]');
            if( status == 'disabled' ){
                $ctrl.addClass('disabled');
            }else{
                $ctrl.removeClass('disabled');
            }
        },
        checkCtrl: function() {
            var me = this, val = me.getValue();
            if (val <= me.getMinValue()) {
                me.setButtonStatus('decrease', 'disabled');
                val = me.getMinValue();
            } else {
                me.setButtonStatus('decrease');
            }
            if (val >= me.getMaxValue()) {
                me.setButtonStatus('increase', 'disabled');
                val = me.getMaxValue();
            } else {
                me.setButtonStatus('increase');
            }
            return val;
        },
        counterEvent: function() {
            var me = this, opts = me.opts;
            me.$ctrl.on('click', function(e) {
                if ($(this).hasClass('disabled')) return false;
                var val = parseInt(me.getValue()),
                    action = $(this).data('counter-action');
                if (action == 'increase') val += opts.step;
                else if (action == 'decrease') val -= opts.step;
                me.setValue(val);
            });
        }

    };

    var Main = host.Class(pros, Event);
    Main.defConfig = defConfig;
    host[name] = Main;


})(betgame, "Select", betgame.Event, jQuery);



//拖动条 类
(function(host, name, Event, $, undefined){
    var defConfig = {
        'minBound':10,
        'maxBound':100,
        'rangeBound': [],
        'value':50,
        'step':5,
        //是否只能往上调整
        'isUpOnly':false,
        'isDownOnly':false,
        'parentDom': null
    };

    var pros = {
        init:function(cfg){
            var me = this;
            me.parentDom = $(cfg.parentDom);
            if( me.parentDom.length ){
                me.minDom = $(cfg.minDom, me.parentDom);
                me.maxDom = $(cfg.maxDom, me.parentDom);
                me.contDom = $(cfg.contDom, me.parentDom);
                me.handleDom = $(cfg.handleDom, me.parentDom);
                me.innerDom = $(cfg.innerDom, me.parentDom);
                me.minNumDom = $(cfg.minNumDom, me.parentDom);
                me.maxNumDom = $(cfg.maxNumDom, me.parentDom);
            }else{
                me.minDom = $(cfg.minDom);
                me.maxDom = $(cfg.maxDom);
                me.contDom = $(cfg.contDom);
                me.handleDom = $(cfg.handleDom);
                me.innerDom = $(cfg.innerDom);
                me.minNumDom = $(cfg.minNumDom);
                me.maxNumDom = $(cfg.maxNumDom);
            }
            me.rangeBound = [cfg.rangeBound[0] || cfg.minBound, cfg.rangeBound[1] || cfg.maxBound];
            if( me.rangeBound[0] < cfg.minBound ){
                me.rangeBound[0] = cfg.minBound;
            }
            if( me.rangeBound[1] > cfg.maxBound ){
                me.rangeBound[1] = cfg.maxBound;
            }
            me.minBound = cfg.minBound;
            me.maxBound = cfg.maxBound;
            me.width = me.contDom.width() - me.handleDom.width();
            me.step = cfg.step;
            me.isDrag = false;
            me.dragX = 0;
            me.dragLeft = 0;
            me.value = cfg.value;
            me.minNumDom.text(me.minBound);
            me.maxNumDom.text(me.maxBound);
            me.initEvent();
            me.defaultValue = cfg.value;
            me.setValue(me.value);
        },
        getDom:function(){
            return this.parentDom;
        },
        getPosByValue:function(value){
            var me = this,value = Number(value) - me.minBound,pos = 0;
            pos = value / (me.maxBound - me.minBound) * me.width;
            return pos;
        },
        getValueByPos:function(pos){
            var me = this,pos = Number(pos),value = 0;
            value = pos / me.width * (me.maxBound - me.minBound);
            return Math.ceil(value + me.minBound);
        },
        initEvent:function(){
            var me = this,moveFn,upFn;
            me.handleDom.on('touchstart',function(e){
                var e =  e.originalEvent.targetTouches[0];
                me.isDrag = true;
                me.dragX = e.clientX;
                me.dragLeft = parseInt(me.handleDom.css('left'));
                if(me.handleDom.get(0).setCapture){
                    me.handleDom.get(0).setCapture();
                }
                $(document).bind('touchmove', moveFn);
                $(document).bind('touchend', upFn);
            });
            me.contDom.on('touchstart',function(e){
                var target = e.target || e.srcElement;
                var e =  e.originalEvent.targetTouches[0];
                if( !$(target).is(me.handleDom) ){
                    var pos = e.pageX - $(this).offset().left;
                    me.setValue(me.getValueByPos(pos));
                }
            });
            moveFn = function(e){
                var e =  e.originalEvent.targetTouches[0];
                var left = 0,
                //临时倍数
                    mul = 1,
                    value = 0;
                if(me.isDrag){
                    left = me.dragLeft + e.clientX - me.dragX;
                    if(left < 0 || (left > me.width)){
                        return;
                    }
                    value = me.getValueByPos(left);
                    mul = Math.ceil(value/me.step);
                    value = mul * me.step;
                    me.setValue(value);
                }
            };
            upFn = function(){
                me.isDrag = false;
                if(me.handleDom.get(0).releaseCapture){
                    me.handleDom.get(0).releaseCapture();
                }
                $(document).unbind('touchmove', moveFn);
                $(document).unbind('touchend', upFn);
            };

            me.minDom.click(function(){
                me.setValue(me.getValue() - me.step);
            });
            me.maxDom.click(function(){
                me.setValue(parseInt(me.getValue()) + me.step);
            });
        },
        //cfg {minBound:,maxBound,step,value}
        reSet:function(cfg){
            var me = this;
            me.minBound = typeof cfg.minBound != 'undefined' ? cfg.minBound : me.minBound;
            me.maxBound = typeof cfg.maxBound != 'undefined' ? cfg.maxBound : me.maxBound;
            me.step = typeof cfg.step != 'undefined' ? cfg.step : me.step;
            me.defaultValue = cfg.value;
            me.minNumDom.text(me.minBound);
            me.maxNumDom.text(me.maxBound);
            me.setValue(cfg.value);
        },
        setValue:function(value){
            var me = this,cfg = me.defConfig,pos = 0;
            value = value < me.rangeBound[0] ? me.rangeBound[0] : value;
            value = value > me.rangeBound[1] ? me.rangeBound[1] : value;

            //仅只能向下调整
            if(cfg.isDownOnly){
                value = value > me.defaultValue ? me.defaultValue : value;
            }
            //仅只能向上调整
            if(cfg.isUpOnly){
                //console.log(me.defaultValue);
                value = value < me.defaultValue ? me.defaultValue : value;
            }

            if( value <= me.rangeBound[0] ){
                me.minDom.addClass('disabled');
            }else{
                me.minDom.removeClass('disabled');
            }

            if( value >= me.rangeBound[1] ){
                me.maxDom.addClass('disabled');
            }else{
                me.maxDom.removeClass('disabled');
            }

            me.value = value;
            pos = me.getPosByValue(value);
            pos = pos < 0 ? 0 : pos;
            pos = pos > me.width ? me.width : pos;
            me.setPos(pos);
            me.fireEvent('change');
        },
        getValue:function(){
            return this.value;
        },
        setDefaultValue : function(value){
            var me = this;
            me.defaultValue = value;
        },
        setPos:function(pos){
            var me = this;
            pos = pos < 0 ? 0 : pos;
            pos = pos > me.width ? me.width : pos;
            me.handleDom.css('left', pos);
            me.innerDom.css('width', pos);
        }
    };


    var Main = host.Class(pros, Event);
    Main.defConfig = defConfig;
    host[name] = Main;

})(betgame, "SliderBar", betgame.Event, jQuery);


(function(host, name, $, undefined) {
    var Main = function() {};
    Main.win = $(window);
    Main.doc = $(document);
    Main.isIE = !!document.all;
    Main.isIE6 = window.ActiveXObject && navigator.userAgent.toLowerCase().match(/msie ([\d.]+)/)[1] == 6.0 ? true: false;
    Main.toViewCenter = function(el) {
        Main.toViewCenter.fn(el);
        Main.win.bind('resize',
        function() {
            Main.toViewCenter.fn(el)
        })
    };
    Main.toViewCenter.fn = function(el) {
        var el = $(el),
        w = el.width(),
        h = el.height(),
        allw = Main.win.width(),
        allh = Main.win.height(),
        scrollWidth = Main.isIE6 ? Main.win.scrollLeft() : 0,
        scrollHeight = Main.isIE6 ? Main.win.scrollTop() : 0;
        el.css({
            left: allw / 2 - w / 2 + scrollWidth,
            top: allh / 2 - h / 2 + scrollHeight
        })
    }
    Main.startFixed = function(el, time) {
        var el = $(el),
        fn,
        time = time || 500,
        top = parseInt(el.css('top')),
        sTop = Main.win.scrollTop(),
        _sTop = sTop,
        left = parseInt(el.css('left')),
        sLeft = Main.win.scrollLeft(),
        _sLeft = sLeft;
        fn = function() {
            var h = el.height(),
            w = el.width(),
            allw = Main.win.width(),
            allh = Main.win.height();
            _sTop = Main.win.scrollTop();
            _sLeft = Main.win.scrollLeft();
            el.stop();
            el.animate({
                top: allh / 2 - h / 2 + _sTop
            },
            50);
            sTop = _sTop;
            el.animate({
                left: allw / 2 - w / 2 + _sLeft
            },
            50);
            sLeft = _sLeft
        };
        return new host['Timer']({
            time: time,
            fn: fn
        });
    };
	Main.getRandom = function(n, m){
		return Math.floor(Math.random()*(m - n + 1) + n);
	};
    Main.getByteLen = function(str) {
        return str.replace(/[^\x00-\xff]/g, 'xx').length
    };
    Main.getParam = function(name) {
        var reg = new RegExp("(^|\\?|&)" + name + "=([^&]*)(\\s|&|$)", "i");
        if (reg.test(location.href)) {
            return unescape(RegExp.$2.replace(/\+/g, " "))
        } else {
            return null
        }
    };
    Main.template = function(tpl, data) {
        var me = this,
        o = data,
        p, reg;
        for (p in o) {
            if (o.hasOwnProperty(p)) {
                reg = RegExp('<#=' + p + '#>', 'g');
                tpl = tpl.replace(reg, o[p])
            }
        }
        return tpl
    };
    Main.formatMoney = function(num, digit) {
        var num = Number(num),
            digit = (digit == undefined || digit < 0) ? 2 : digit,
            re = /(-?\d+)(\d{3})/;
        if (Number.prototype.toFixed) {
            num = (num).toFixed(digit)
        } else {
            num = Math.round(num * Math.pow(10,digit)) / Math.pow(10,digit)
        }
        num = '' + num;
        while (re.test(num)) {
            num = num.replace(re, "$1,$2")
        }
        return num
    };
    host[name] = Main
})(betgame, "util", jQuery);



