var form  = {

	delaytime : 0,

	config : {},

	list_table : {},

	status2 : '',

	lastStatus : '',

	resizeOriginX : 0,

	resizeOriginWith : 0,

	hasEnter : false,

	new_page_ini_table : function(tableId = 'table'){

		let h1 = parent.mainPage.height;
		let h2 = $('#' + tableId).offset().top;
		let tableWrapperHeight = h1 - h2 + 36;
		if($('#foot').length == 1) tableWrapperHeight -= $('#foot').height();
		if($('#page').length == 1) tableWrapperHeight -= $('#page').height();
		let headHeight = $('#' + tableId + ' thead').height();
		let tableWidth = $('#' + tableId).width();

		

		$('#' + tableId).wrap("<div id = 'aya-table-wrapper-container' style = 'height:"+tableWrapperHeight+"px;max-height:"+tableWrapperHeight+"px;min-height:"+tableWrapperHeight+"px;position:relative'></div>");

		let height1 = tableWrapperHeight - headHeight;


		$('#' + tableId).wrap("<div class = 'aya-table-wrapper-tbody' id = 'aya-table-wrapper-tbody' style = 'height:"+height1+"px;max-height:"+height1+"px;min-height:"+height1+"px;overflow:scroll;'></div>");

		let tableWrapperWidth = $('#aya-table-wrapper-container').width();
		let tableClone = $('#' + tableId).clone();
		
		let clone_table = "<div class = 'aya-table-wrapper-thead' style = 'position:fixed;top:"+$('#' + tableId).offset().top+"px;left:"+$('#' + tableId).offset().left+"px;z-index:999;opacity:1;;overflow:hidden;'><table class = '"+$('#' + tableId).prop('class')+" clone_thead' style = 'width:100%'><thead>";


		var clone_thead = $('#' + tableId).find('thead').clone();
		
		
		var table = '';
		for(var i = 0; i < $('#' + tableId+' thead').eq(0).children().length; i++){
			for(var j = 0; j < $('#' + tableId+' thead').eq(0).children().eq(i).children().length; j++){
				var tmp = $('#' + tableId+' thead').eq(0).children().eq(i).children().eq(j);
				
				let css = {
					'whiteSpace' : tmp.css('whiteSpace'),
					'fontSize' : tmp.css('fontSize'),
					'minWidth' : tmp.width(),
					
				};

				clone_thead.children().eq(i).children().eq(j).css(css);	
			}
		}
		clone_table += clone_thead.html();
		clone_table += "</thead></table></div>";

		$('#aya-table-wrapper-container').prepend("<div style = 'height:"+headHeight+"px'></div>").prepend(clone_table);

		$('.aya-table-wrapper-thead').css('max-width',$('.aya-table-wrapper-tbody').eq(0).width()).css('overflow','hidden');

		$('#' + tableId).css('margin-top','-' + headHeight + 'px');

		$('#aya-table-wrapper-tbody').scroll(function(e){
			let scrollLeft = $(this).scrollLeft();
			$('.aya-table-wrapper-thead').find('table').css('marginLeft', '-' + scrollLeft + 'px');
		});

		$('#flow').click(function(){
			if( $(this).hasClass('img_off') ) return false;
			let flowId = $(this).data('flowid');
			parent.layer.open({
				title:'<span style = "font-size:12px">流程查看</span>',
				type: 2,
				shadeClose:true,
				offset:'0',
				area: ['800px','100%'],
				content:  get_parent().mainUrl +  '/Fs/see?flowid='+flowId,
				isOutAnim: false,
			});
		});
		
		

		$('table.clone_thead thead tr th').mousemove(function(e){
			let x = e.pageX;
			if(form.status2 == 'resize'){

				let tmp = form.resizeOriginWidth + x - form.resizeOriginX;
				$('.resized').css('min-width', tmp ).css('max-width', tmp );

				$('table.clone_thead thead tr th').each(function(i,v){
					let css = {
						'min-width' : $(this).width(),
						'max-width' : $(this).width()
					};
					$('#' + tableId + ' thead tr th').eq(i).css(css);
				});
				
				$('table.clone_thead thead tr th').each(function(i,v){
					let css = {
						'min-width' : $(this).width(),
						'max-width' : $(this).width()
					};
					$('#' + tableId + ' thead tr th').eq(i).css(css);
				});

				$('#' + tableId + ' thead tr th').each(function(i,v){
					let css = {
						'min-width' : $(this).width(),
						'max-width' : $(this).width()
					};
					$('table.clone_thead thead tr th').eq(i).css(css);
				});



				

				return false;






				//let tmp = form.resizeOriginWidth + x - form.resizeOriginX;
				//$('.resized').css('min-width', tmp );
				
				// $('.resized').css('min-width', $('.resized').eq(0).width() );

				let index = $('.resized').eq(0).index();
				
				$('#' + tableId + ' thead tr th').eq(index).css('min-width', $('.resized').eq(0).width() ).css('max-width', $('.resized').eq(0).width() );


				
			}else{
				
				let left = $(this).offset().left;
				let right = left + $(this).width();
				if( x > right - 3){
					$(this).addClass('resize');
					leftDiv = "<div class = 'absolute resize-icon' style = 'left:0;bottom:0;border-left:1px solid red;width:6px;height:6px;-moz-transform-origin: 0 100% 0;transform:rotate(45deg);'></div><div class = 'absolute resize-icon' style = 'right:0px;bottom:0;border-right:1px solid red;width:6px;height:6px;-moz-transform-origin:right bottom;transform:rotate(-45deg);'></div>";
					$(this).append(leftDiv);
					$(this).find('img.aya-sort-img').hide();
				}else{
					$(this).removeClass('resize');
					$('.resize-icon').remove();
					$(this).find('img.aya-sort-img').show();
				}
			}

		});

		$('table.clone_thead thead tr th').mouseout(function(e){
			if(form.status2 == 'resize') return false;
			$(this).removeClass('resize');
			$('.resize-icon').remove();
			$(this).find('img.aya-sort-img').show();
		});


		$('table.clone_thead thead tr th').mousedown(function(e){
			if( $(this).find('.resize-icon').length > 0 ){
				$(this).addClass('resized');
				form.status2 = 'resize';
				form.resizeOriginX = e.pageX;
				form.resizeOriginWidth = $(this).width();
			}
		});

		$('.card').mouseup(function(){
			if(form.status2 == 'resize'){
				form.status2 = '';
				$('.resize-icon').remove();
				$('.resize').removeClass('resize');
				form.lastStatus = 'resize';
			}
		});


		$('.aya-table-wrapper-thead').mouseout(function(e){
			form.status2 = '';
			$('.resized').removeClass('resized');
		});

	},

	dlt_tr : function (id,callback = ''){
		
		$('#'+id+' tbody').on('click','img.tr_dlt',function(){
			if($(this).data('opr') == 'off') return false;
			if($('#'+id+' tbody tr').length > 1) $(this).parent().parent().remove();
			if(callback != ''){
				callback();
			}
			reindex(id);
		});
		$('#'+id+' tbody').on('click','img.tr_add_next',function(){
			let index =  $('#'+id+' tbody').eq(0).children().eq(0).find('img.tr_dlt').eq(0).parent('td').index();
			let opr   =  $('#'+id+' tbody').eq(0).children().eq(0).find('img.tr_dlt').eq(0).data('opr');
			if($(this).data('opr') == 'off') return false;
			let clone = $(this).parents('tr').clone();
			clone.find('input').not('.retain').val('').prop('title','').data('last','');
			clone.find('img.tr_dlt').eq(0).data('opr',opr);
			clone.find('img.tr_add_next').eq(0).data('opr',opr);
			$(this).parents('tr').after(clone);
			reindex(id);
		});
		
	},

	erp_select : function (type = '',t,mul = 1,index = true,hint = true,parent_erp_select_callBack = null,tianchong = true){
		let title;
		let updated_tr_index = [];
		switch(type){
			case 'inventory':
			title = '选择 - 存货档案';
			break;
			case 'vendor':
			title = '选择 - 供应商';
			break;
			case 'warehouse':
			title = '选择 - 仓库';
			break;
			case 'rd_style':
			title = '选择 - 收发类型';
			break;
			case 'rd_style2':
			title = '选择 - 收发类型';
			break;
			case 'user':
			title = '选择 - 账号';
			break;
			case 'department':
			title = '选择 - 部门';
			break;
		}
		
		var url = get_parent().mainUrl +  '/ErpBase/select'+type+'?mul='+mul;
		
		let width = get_width();
		top.layer.open({
			title:title,
			area: [get_width()+'px','100%'],
			offset:'1px',
			shadeClose:true,
			isOutAnim: false ,
			maxmin: true,
			type: 2, 
			content:url,
			success : function(layero,index){
				let iframeWin = top[layero.find('iframe')[0]['name']];
				iframeWin.P = window;
			}
		});

		$('#erp_hint').remove();
			
		if(tianchong == true){
			erp_select_callBack2 = function(data){

				let tr = $(t).parents('tr');
				let td = tr.find('td').eq(0);
				let tbody = tr.parent();
				let trIndex = tr.index();
				let trs = tbody.children().length;
				let id = tbody.parent('table').prop('id');
				if(mul == 1){  //多行
					let tmp = data.length - trs + trIndex ;
					if(tmp > 0) add_tr(id,tmp);
					for(let i = 0; i < data.length ; i++){
						tbody.children().eq(trIndex).find('.'+type+'_code').eq(0).val(data[i]['code']).data('last',data[i]['code']).data('d',data[i]['code']);
						tbody.children().eq(trIndex).find('.'+type+'_name').eq(0).val(data[i]['name']).data('d',data[i]['name']);
						if(type == 'inventory'){
							tbody.children().eq(trIndex).find('.inventory_std').val(data[i]['std']).prop('title',data[i]['std']);
							tbody.children().eq(trIndex).find('.inventory_unit').val(data[i]['unit']);
						}
						updated_tr_index.push(trIndex);
						trIndex++;
					}

				}else{    //单行

					updated_tr_index.push(trIndex);
					let p = $(t).parent().parent();

					p.find('.'+type+'_code').val(data[0]['code']).eq(0).data('last',data[0]['code']).data('d',data[0]['code']);
					p.find('.'+type+'_name').val(data[0]['name']).data('d',data[0]['name']);
					p.find('.'+type+'_name_text').text(data[0]['name']).prop('title',data[0]['name']);
					p.find('.'+type+'_code_text').text(data[0]['code']).prop('title',data[0]['code']);

					
					if(type == 'inventory'){
						p.find('.inventory_std').val(data[0]['std']).prop('title',data[0]['std']);
						p.find('.inventory_unit').val(data[0]['unit']);
						p.find('.inventory_std_text').text(data[0]['std']).prop('title',data[0]['std']);
						p.find('.inventory_unit_text').text(data[0]['unit']);
					}
				}

				if(index){
					reindex(tbody.parent().prop('id'));
				}

			}
		}
		
		
		
		if(parent_erp_select_callBack === null){
			if(tianchong == true) window.erp_select_callBack = erp_select_callBack2;
		}else{
			let erp_select_callBack3 = function(data){
				if(tianchong == true) erp_select_callBack2(data);
				//parent_erp_select_callBack(data);
				parent_erp_select_callBack(updated_tr_index);
			}
			window.erp_select_callBack = erp_select_callBack3;
		}
		
	},
	
	erp_hint : function(t,enter = false,keyCode = 0,type,mul = true,parent_erp_select_callBack = null){

		let query_url = '';
		let query_url2 = '';
		let thead = '';
		let field = [];
		let updated_tr_index = [];
		
		switch(type){
			//物料
			case 'inventory':
			query_url =  get_parent().mainUrl + '/ErpBase/getInventory';
			thead = "<table class = 'table-hint dataTable table-small'><thead><tr><th style =' white-space:nowrap'>物料编码</th><th style =' white-space:nowrap'>物料名称</th><th style =' white-space:nowrap'>规格型号</th><th style =' white-space:nowrap'>单位</th></tr></thead><tbody>";
			field = ['name','code','std','unit'];
			break;
			
			//供应商
			case 'vendor':

				         
			query_url =  get_parent().mainUrl + '/ErpBase/getVendor';
			thead = "<table class = 'table-hint dataTable table-small cell-border'><thead><tr><th style =' white-space:nowrap'>供应商编码</th><th style =' white-space:nowrap'>供应商名称</th><th>联系人</th><th>电话</th></tr></thead><tbody>";
			field = ['name','code'];
			break;

			case 'warehouse':
			query_url =  window.location.protocol + '//' + window.location.host + '/a1.php/index/U7/search_erp_warehouse';
			thead = "<table class = 'table-hint dataTable table-small'><thead><tr><th style =' white-space:nowrap'>仓库编码</th><th style =' white-space:nowrap'>仓库名称</th></tr></thead><tbody>";
			field = ['name','code'];
			break;

			case 'department':
			query_url =  window.location.protocol + '//' + window.location.host + '/a1.php/index/U7/search_erp_department';
			thead = "<table class = 'table-hint dataTable table-small'><thead><tr><th style =' white-space:nowrap'>部门编码</th><th style =' white-space:nowrap'>部门名称</th></tr></thead><tbody>";
			field = ['name','code'];
			break;

			case 'purchasetype':
			query_url =  window.location.protocol + '//' + window.location.host + '/a1.php/index/U7/search_erp_purchasetype';
			thead = "<table class = 'table-hint dataTable table-small'><thead><tr><th style =' white-space:nowrap'>采购类型编码</th><th style =' white-space:nowrap'>采购类型名称</th></tr></thead><tbody>";
			field = ['name','code'];
			break;
		}	


		
		
		query_url2 = get_parent().mainUrl + '/PublicGet/get_erp_by_text';

		let s = $.trim($(t).val());
		clearTimeout(form.delaytime);
		
		if(enter && keyCode == 13){
			var o = {};
			o.text = s;
			o.type = type;
			$('#erp_hint').remove();
			$(t).data('last',s);
			if(o.text == '') return false;
			let index = layer.load(1,{offset:'30%'});
			form.hasEnter = true;

			$.post(query_url2,o,function(d){
				layer.close(index);
				if(d.status == 's'){
					//多行
					let p = $(t).parent().parent();
					let data = d.data;
					if(mul){
						let trs = $(t).parents('tbody').children().length;
						let trIndex = $(t).parents('tr').index();
						let tbody = $(t).parents('tbody');
						let tmp = data.length - trs + trIndex ;
						if(tmp > 0){
							let id = $(tbody).parent().prop('id');
							add_tr(id,tmp);
						} 
					}else{
						//单行
					}

					for(var i = 0; i < data.length; i ++){
						updated_tr_index.push(p.index());
						$(field).each(function(ii,v){
							p.find('.'+type+'_'+v).eq(0).val(data[i][v]).data('d',data[i][v]);
							p.find('.'+type+'_'+v+'_text').text(data[i][v]);
						});
						p = p.next();
					}
					

					if(parent_erp_select_callBack !== null){
						parent_erp_select_callBack(updated_tr_index);
					}
				}else{
					let p = $(t).parent().parent();
					//p.find('.inventory_code').val('');
					for(let i in field){
						p.find('.'+type+'_'+field[i]).eq(0).val('').prop('title','').data('d','');
						p.find('.'+type+'_'+field[i]+'_text').text('').prop('title','');
					}
					layer.msg(d.info,{icon:2,time:2000,offset:'30%'});
				}
			});
			return false;
		}else{
			
			if(s != ''){
			
			form.delaytime = setTimeout(function(){
				
				let o = {};
				o.code = s;
				o.name = s;
				o.searchType = 3;
			
				if($(t).data('last') == s) return false;
				//$(t).data('last',s);
				
				$('#erp_hint').remove();

				form.hasEnter = false;
				$.post(query_url,o,function(d){
					if(form.hasEnter) return false;

					//if($(t).data('last') == s) return false;
					if(!$(t).is(':focus')){
						return false;
					}



					$(t).data('last',s);
					let offset = $(t).offset();
					let top = offset.top + $(t).height();
					let left = offset.left;

					if(d.data == null) return false;
		
					let p = $(t).parent().parent();
					
					if(d.info.length == 1){  //如果只有一条符合的记录，则自动填充

						
						

						let tmp = d.info[0];
						$(field).each(function(i,v){
							p.find('.'+type+'_'+v).eq(0).val(tmp[v]).data('d',tmp[v]);
							p.find('.'+type+'_'+v+'_text').text(tmp[v]);
							if(v == 'code'){
								 p.find('.'+type+'_code').data('last',tmp[v]);
							}
						});


						if(parent_erp_select_callBack !== null){
							updated_tr_index.push(p.index());
							parent_erp_select_callBack(updated_tr_index);
						}


						return false;
					}
					
					let div = "<div id='erp_hint' style = 'box-shadow: 0 6px 6px 0 rgba(0,0,0,0.14),0 1px 5px 0 rgba(0,0,0,0.12),0 3px 1px -2px rgba(0,0,0,0.2);white-space:nowrap;opacity:1;z-index:300;background:#ffffff;display:none;width:auto;border:1px solid #2aa515;z-index:20;position:absolute;top:"+$(t).height()+"px'><div style = 'position:relative'>" + thead + d.data + "</tbody></table><div style = 'background:#fff;position:absolute;top:-9px;right:-9px;height:18px;line-height:18px;cursor:pointer'><img src = '"+get_parent().publicUrl + '/image/erp/dlt.png'+"' style = 'height:18px;' /></div></div></div>";
					
					$(t).after(div);

					let tmp = $(window).height() - $(t).height() - top;

					if(tmp < $('#erp_hint').height()){
						$('#erp_hint').css('top',0 - $('#erp_hint').height());
					}

					$('#erp_hint').show();
					
					$('.card').click(function(){
						$('#erp_hint').remove();
						$('.card').unbind('click');
					});

					$('#erp_hint').find('img').click(function(){
						$(t).parent().find('img.select').hide();
						$('#erp_hint').remove();
						
					});
				
					$('#erp_hint table tbody tr').click(function(){
						
						$(t).parent().find('img.select').hide();
						let ttr = this;

						
								
						$(field).each(function(i,v){
							let tmp2 = $(ttr).find('.'+v).text();
							p.find('.'+type+'_'+v).eq(0).val(tmp2).data('d',tmp2);
							p.find('.'+type+'_'+v+'_text').text(tmp2);
						
							if(v == 'code'){
								 p.find('.'+type+'_code').data('last',tmp2);
							}
						});


						if(parent_erp_select_callBack !== null){
							updated_tr_index.push(p.index());
							parent_erp_select_callBack(updated_tr_index);
						} 
						$('#erp_hint').remove();
			
					});
					
				});
			},300);

		}else{
			
		
			$('#erp_hint').remove();
			$(t).data('last','');
			let p = $(t).parent().parent();
			for(let i in field){
				p.find('.'+type+'_'+field[i]).eq(0).val('').prop('title','').data('d','');
				p.find('.'+type+'_'+field[i]+'_text').text('').prop('title','');
			}
		}

		}
	},

	erp_get_qty : function(t,keyCode = 0){
		let query_url = window.location.protocol + '//' + window.location.host +  '/a1.php/index/erp/get_qty_by_text';
		if(keyCode == 13){
			var o = {};
			o.text = $.trim($(t).val());;
			if(o.text == '') return false;
			let index = layer.load(1,{offset:'30%'});
			$.post(query_url,o,function(d){
				
				layer.close(index);
				let p = $(t).parents('tr');
				if(d.data.length < 1) return false
				let index2 = $(t).parents('td').index();
				let j = 0;
				for(let i = p.index(); i < p.index() + d.data.length; i++){
					p.parent().children().eq(i).children().eq(index2).find('input').eq(0).val(d.data[j++]);
				}
			});
			return false;
		}
	},
	
	erp_focusout : function (t){
		if($.trim($(t).val()) != $(t).data('d')){
			$(t).val($(t).data('d'));
			if(typeof($(t).data('last')) != "undefined"){
				 $(t).data('last',$(t).data('d'));
			}
		}
	},

	_switch : function(type,status,h_or_b = 'head',bodyId = 'tbody' , input ){

		let callback = function(){};
		if(type.callback != '') callback = type.callback;


		
		switch( type.type ){
			case 'date' :
				if(status == 'on'){
					if($(input).data('hf') != 1){
						if($(input).data('hasdatefunction') != 'on'){
							laydate.render({
								elem : input,
								show : false,
								trigger : 'click'
							});
						}else{
							laydate.render({
								elem : input,
								show : true,
								trigger : 'click'
							});
						}
						$(input).data('hf',1);	
					}

					$(input).data('hasdatefunction','on');

					if($(input).val() == ''){
						let now = new Date();
						var year = now.getFullYear();
						var month = now.getMonth() + 1;
						var day = now.getDate();
						var clock = year + "-";
						if(month < 10) clock += "0";
						clock += month + "-";
						if(day < 10) clock += "0";
						clock += day;
						$(input).val(clock);
					}
					
				}else{
					$( container + ' input.date').each(function(){
						$(input).data('hasdatefunction','off');	
					});
				}
			break;
			case 'text' :

			break;

			case 'erp' :

				if( status == 'on' ){
					if( h_or_b  == 'head' ){

						// 两种方式
						// 1. code 和 name 都显示，在 code 里输入
						// 2. code 隐藏  ， name 显示 ， 在 name 里输入
						// 方式2
						$(input).keyup(function(e){
							form.erp_hint(this,true,e.keyCode,type.type2,true,callback);
						});
						$(input).blur(function(){
							form.erp_focusout(this);
						});

						$(input).parent().find('img.select').click(function(){
							form.erp_select(type.type2,this,0,false,true,callback); 
						});

					}else{
						$('#'+bodyId).on('click','img.img-'+type.type2,function(){
							form.erp_select(type.type2,this,1,true,true,callback);
						});
						$('#'+bodyId).on('keyup','input.'+type.type2+'_code',function(e){
							form.erp_hint(this,true,e.keyCode,type.type2,true,callback);
						});
						$('#'+bodyId).on('mouseenter','td.td-input-img',function(){
							if($(this).data('nohover') == 1) return false;
							$(this).find('img.select').show();
						});
						$('#'+bodyId).on('mouseleave','td.td-input-img',function(){
							if($(this).data('nohover') == 1) return false;
							$(this).find('img.select').hide();
						});
						$('#'+bodyId).on('blur','input.'+type.type2+'_code',function(){
							form.erp_focusout(this);
						});

					}

				}

			break;
			default:
				

		}




		return false;



		


		if(type.name == 'cmaker'){
			if(status == 'on'){
				$( container + ' input.cmaker').each(function(){
					if($(this).val() == ''){
						$(this).val($(this).data('df'));
					}
				});
			}else{
				$( container + ' input.date').each(function(){
					$(this).data('hasdatefunction','off');	
				});
			}
		}


		if(type.name == 'date'){
			
		}


		if(type.name == 'qty'){
			if(status == 'on'){
				if(h_or_b == 'body'){
					$('#'+bodyId).on('keyup','input.qty',function(e){
						form.erp_get_qty(this,e.keyCode);
					});
				}
			}
		}

		if(type.name == 'mul-num'){
			if(status == 'on'){
				if(h_or_b == 'body'){
					$('#'+bodyId).on('keyup','input.mul-num',function(e){
						form.erp_get_qty(this,e.keyCode);
					});
				}
			}
		}

	},
	
	m : function( ){

		for(let i = 0; i < form.config.head.length ; i++){
			form._switch(form.config.head[i],'on','head','','#' + form.config.head[i].id);
		}

		for(let i = 0; i < form.config.body.length ; i++){
			form._switch(form.config.body[i],'on','body');
		}
		
		//erp_switch('inventory','on','body','tbody');  // body 代表表体,tbody代表表体ID
		
		$('input.edit').prop('readonly',false);
		$('#tbody tr td input.date').each(function(){
			$(this).data('hasdatefunction','on');
		});
		$('#tbody tr td img.opr').data('opr','on');
		//status('modify');
	},

	n : function( type = ''){

		form.s();
		form.m();
		
		if(type != 'recoil') $('#tbody').find('input').not('.retain').val('');
		if(type != 'recoil') form.blue();
		$('#cmemo').val('');
		$('#sum').val('');
		$('#draft_id').val('');
		$('#ddh').val('');
		$('#ddh').data('d','');
		$('#ddh_hidden').val('');
		$('input.empty').val('');// empty ,开始的时候清楚

		$('#tbody').children().each(function(){
			$(this).data('listid','');
			if(type != 'recoil') $(this).data('resource_type','');
			if(type != 'recoil') $(this).data('resource_id','');
		});
		$('#tbody tr td input.edit').each(function(){
			$(this).data('d','');
		});
		$('.erp-head input').each(function(){
			if(typeof($(this).data('df')) != "undefined")	$(this).val($(this).data('df'));
			if(typeof($(this).data('last')) != "undefined")	$(this).data('last','');
		});
		form.status({status : 'new' });
	},

	
	s : function (){   //取消页面的各种选择框事件
		$('input.edit').prop('readonly',true);
		$('.erp-head input.date').each(function(){
			$(this).data('hasdatefunction','off');
		});

		$('.erp-head:not(#erp-head-ddh)').unbind();
		$('.erp-head img.input-hint').unbind('click');
		
		$('#tbody').off('click','img.img-inventory');
		$('#tbody').off('mouseenter','td.td-input-img');
		$('#tbody').off('mouseleave','td.td-input-img');
		$('#tbody tr td input.date').each(function(){
			$(this).data('hasdatefunction','off');
		});
		$('#tbody tr td img.opr').each(function(){
			$(this).data('opr','off');
		});	
	},
		
	img_do : function (type,on){
		
		var imgUrl = get_parent().publicUrl + '/image/erp/';

		if(on == 'on'){
			$('#'+type).removeClass('img_off').addClass('img_on');
			$('#'+type).find('img').prop('src',imgUrl+type+'_on.png');
		}else{
			$('#'+type).removeClass('img_on').addClass('img_off');
			$('#'+type).find('img').prop('src',imgUrl+type+'_off.png');
		}
	},

	red : function(){
		$('#bluered').removeClass('img_off').addClass('img_on hint2');
		$('#bluered').find('img').eq(0).attr('src','/a1/index/view/public/Image/o118.png');
		$('.qty').addClass('hint2 font-bold');
	},

	blue : function(){
		$('#bluered').removeClass('img_on hint2').addClass('img_off');
		$('#bluered').find('img').eq(0).attr('src','/a1/index/view/public/Image/o119.png');
		$('.qty').removeClass('hint2 font-bold');
	},

	new_page_ini : function ( config ){

		window.resource_layero = {};

		form.config = config;

		if(config.iniRows != undefined) add_tr('table',config.iniRows);

		$('#research').click(function(){
			if(ayaResearch.hasIni == false){
				 ayaResearch.ini(config);
			}else{
				 ayaResearch.show();
			}
		});

		$('#print').click(function(){form.print_prepare();window.print();});

		$('#tbody tr td img.opr').data('opr','off');

		$('#bluered').click(function(){
			if($('#save').hasClass('img_off')) return false;//只有修改状态才能
			if($(this).hasClass('img_off')){
				form.red();
			}else{
				form.blue();
			}
		});


		

		$('#stock').click(function(){
			let o = {};
			let oo = [];
			$('#tbody tr').each(function(){
				let tmp = {};
				let code = $(this).find('input.inventory_code').eq(0).val();
				if(code != ''){
					tmp.code = code;
				}else{
					return true;
				}
				let qty = $(this).find('input.qty').eq(0).val();
				tmp.qty = qty;
				oo.push(tmp);
				
			});
			if(oo.length == 0) return false;
			o.data = JSON.stringify(oo);
			o.warehouse_code = $('#warehouse_code').val();
			if(o.warehouse_code == '' || typeof o.warehouse_code == 'undefined'){
				layer.msg('请选择仓库！',{'icon':2,time:2000,offset:'30%'});
				return false;
			}
			let url1 = window.location.protocol + '//' + window.location.host +  '/a1.php/index/P/return_cache2';

			$.post(url1,o,function(d){
			
				if(d.status == 's'){
					parent.layer.open({
						title:'库存查询 - ' + $('#warehouse_name').val(),
						area: [top.mainPage.layerWidth,'100%'],
						offset:'1px',
						isOutAnim: false ,
						maxmin: true,
						type: 2, 
						content:window.location.protocol + '//' + window.location.host +  '/a1.php/index/U7/query_stock'
					});
				}else{
					layer.msg(d.info,{icon:2,time:1500,offset:'30%'});
				}
			});
		});
		
		$('div#erp-head-ddh').hover(function(){
			$(this).find('img').show();
		},function(){
			$(this).find('img').hide();
		});
		
		$('#ddh-prev').click(function(){
			$.post(form.config.nextPrev,{type:'prev',ddh:$('#ddh').val()},function(d){
				if(d.status == 's'){
					$('#ddh').val(d.data);
					form.ddh();
				}else{
					layer.msg(d.info,{icon:2,time:1500,offset:'30%'});
				}
			});
		});

		$('#ddh-next').click(function(){
			$.post(form.config.nextPrev,{type:'next',ddh:$('#ddh').val()},function(d){
				if(d.status == 's'){
					$('#ddh').val(d.data);
					form.ddh();
				}else{
					layer.msg(d.info,{icon:2,time:1500,offset:'30%'});
				}
				
			});
		});
		
		if(config.dltRrowCallback != undefined && config.dltRrowCallback != ''){
			form.dlt_tr('table',config.dltRrowCallback);
		}else{
			form.dlt_tr('table');
		}
		

		$('#new').click(function(){
			form.n();$(this).blur();
		});

		$('#save').click(function(){
			if($(this).hasClass('img_on') && form.config.save) form.save();
		});
		$('#check').click(function(){
			if($(this).hasClass('img_on')) form.check();
		});
		$('#uncheck').click(function(){
			if($(this).hasClass('img_on')) form.uncheck();
		});
		$('#modify').click(function(){
			if($(this).hasClass('img_on')) form.modify();
		});
		$('#dlt').click(function(){
			if($(this).hasClass('img_on')) form.dlt();
		});
		$('#giveup').click(function(){
			if($(this).hasClass('img_on')) form.giveup();
		});
		$('#recoil').click(function(){
			if($(this).hasClass('img_on')) form.recoil();
		});
		$('#ddh').keypress(function(e){
			if(e.keyCode==13) form.ddh();
		});

		$('#erp_opr_container').children().eq(1).width($('#erp_opr_container').width() - $('#erp_opr_container').children().eq(0).width() - 2);

		$('#ddh').blur(function(){
			form.erp_focusout(this);
		});

		$('#tbody').on('click','input.date',function(){
			if($(this).data('hf') != 1){
				if($(this).data('hasdatefunction') == 'off'){
					laydate.render({
						elem: this,
						show:false,
						trigger: 'click'
					});
				}else{
					laydate.render({
						elem: this,
						show:true,
						trigger: 'click'
					});
				}
				
				$(this).data('hf',1);	
			}
		});

		$('#tbody').on('click','tr',function(){
			let o = {};
			let code = '';
			code = $(this).find('input.inventory_code').eq(0).val();
			o.code = code;
			o.type = $('#erptips').data('type');
			
			if(o.type == undefined) return false;
			if(o.type == 'stock' && o.code == '') return false;

			let  url = window.location.protocol + '//' + window.location.host +  '/a1.php/index/U7/tips'

			$.post(url,o,function(d){
				
				$('#erptips').html(d.data);
			});
		});

		var imgUrl = './tp/view/public/image/erp/'; 
		let tmp = $('#new_resource').offset();
		let div = "<ul id='div_resource'>";

		if(typeof config != 'undefined'){
			for(let i in config.resource){
				let thisconfig = '';
				$(config.resource[i]['config']).each(function(i,v){
					thisconfig += v + ',';
					
				});
			
				if(config != '') thisconfig = thisconfig.substr(0,thisconfig.length - 1);
				div += "<li class = 'li_new_resource' data-config = '"+thisconfig+"' data-url = '"+config.resource[i]['url']+"' data-callback = '"+config.resource[i]['callback']+"'><img src = '"+imgUrl+"file01.png' /><span>"+config.resource[i]['name']+"</span></li>";
			}
			if(typeof config.research != 'undefined'){
				//ayaResearch.ini(config);
			}
		}
		
		
		div += "<li class = 'li_new_resource'  data-callback = '' data-url = ''><img src = '"+imgUrl+"blank.png' /><span>空白单据</span></li>";
		div += "</ul>";
		$('#new_resource').append(div);
		
		

		$('#new_resource').hover(function(){
			$('#div_resource').show();
		},function(){
			$('#div_resource').hide();
		});

		$('li.li_new_resource').click(function(){
			if($(this).data('url') == ''){
				if($(this).data('callback') == ''){
					form.n( config );
				}else{
					//$(this).data('callback');
					eval($(this).data('callback')+'()');
				}
			}else{

			//	if($('#uncheck').hasClass('img_on')) return false;  //已审核不能选单号
				//if($('#modify').hasClass('img_on')) return false;   //保存完或选单号后不能选单号

				//if($('#recoil').hasClass('img_on')) return false;

				let url = $(this).data('url');
				let name = $(this).text();
				let config2 = $(this).data('config').split(',');
				
				//let con = '';
				let conOb = {};
				if($('#save').hasClass('img_on') || ( $('#save').hasClass('img_off') && $('#check').hasClass('img_off') && $('#uncheck').hasClass('img_off') && $('#modify').hasClass('img_off') && $('#save').hasClass('img_off') && $('#dlt').hasClass('img_off')  )){
					
					$(config2).each(function(i,v){
						conOb[v] = $('#'+v).val();
			
						/*
						if(con == ''){
							 con += v+'='+$('#'+v).val();
						}else{
							 con += '&'+v+'='+$('#'+v).val();
						}*/
					});
				}
				
				conOb.resource = [];
				if($('#save').hasClass('img_on')){
					$('#table tr').each(function(){
						let tmp = {};
						tmp.resource_id   = $(this).data('resource_id');
						tmp.resource_type = $(this).data('resource_type');
						if(tmp.resource_id > 0 ) conOb.resource.push(tmp);
						
					});
				}
				
				window.condition = conOb;
			
				top.layer.open({
					title:'<span class	= "hint1" style = "font-size:12px">源单<span>',
					area: [top.mainPage.layerWidth,'100%'],
					shade1Close:false,
					isOutAnim: false ,
					maxmin: false,
					type: 2, 
					content:url,
					success:function(layero, index){
						resource_layero = top[layero.find('iframe')[0]['name']];
						resource_layero.config = config;
					}
				});
			}
			$('#div_resource').hide();
		});	

		form.new_page_ini_table();

		/*
		
		$('#inventory').click(function(){
			let o = {};
			let oo = [];
			$('#tbody tr').each(function(){
				let tmp = {};
				tmp.code = $.trim($(this).find('.inventory_code').eq(0).val());
				if(tmp.code != '') oo.push(tmp);
				
			});
			o.data = JSON.stringify(oo);
			let url1 = window.location.protocol + '//' + window.location.host +  '/a1.php/index/P/return_cache2';
			$.post(url1,o,function(d){
				if(d.status == 's'){
					parent.layer.open({
						title:'物料查询',
						area: [top.mainPage.layerWidth,'100%'],
						offset:'1px',
						isOutAnim: false ,
						maxmin: true,
						type: 2, 
						content:window.location.protocol + '//' + window.location.host +  '/a1.php/index/U7/query_inventory'
					});
				}else{
					layer.msg(d.info,{icon:2,time:1500,offset:'30%'});
				}
			});
		});
		*/

		if(config.bodySort == true){
			$('table.aya-sort thead tr th').addClass('relative');
	
			$('table.aya-sort thead tr th').click(function(){
				
				if(form.lastStatus == 'resize'){
					form.lastStatus = '';
					return false;
				}

				var imgUrl = './tp/view/public/image/erp/';
				
				let index = $(this).index();
				let length = $(this).parents('tr').children().length - 1;
				
				if(index == 0 || index == length) return false;

				$('table.aya-sort thead tr th img.aya-sort-img').remove();

				let tmp = $(this).data('sort');
				let order = 'desc';
				if(tmp == 'desc'){
					order = 'asc';
				}
				$(this).data('sort',order).append("<img class = 'aya-sort-img aya-sort-img-"+order+"'  src = '"+imgUrl+"sort_"+order+".png' />");
				let a = [];
				let tdType = new Map();
				let inputOfCode = new Map(); //记录哪些input是erpselect，防止点击后丢失
				let tmp1 = $('#table tbody tr').eq(0).children();

				for(let i = 1; i < length; i++){
					if(tmp1.eq(i).find('input').length > 0){
						tdType.set(i,'input');
						if(tmp1.eq(i).find('input').eq(0).prop('class').indexOf('_code') >= 0){
							inputOfCode.set(i,true);
						}else{
							inputOfCode.set(i,false);
						}
					}else if(tmp1.eq(i).find('select').length > 0){
						tdType.set(i,'select');
						inputOfCode.set(i,false);
					}else{
						tdType.set(i,'text');
						inputOfCode.set(i,false);
					}
				}

				

				$('#table tbody tr').each(function(ii,v){
					let child = $(this).children();
					let isAdd = false
					let tmpMap = new Map();
					for(let i = 1; i < length; i ++){
						let text = "";
					
						if(tdType.get(i) == 'text'){
							text = $.trim($(this).text());
						}else if(tdType.get(i) == 'select'){
							//text = $.trim(child.eq(i).find('select').eq(0).val());
						}else{

							text = $.trim(child.eq(i).find('input').eq(0).val());
						}
						tmpMap.set(i,text);

						if(text != ""){
							isAdd = true;
						}
					}
					if($(v).data('id') != undefined) tmpMap.set('id',$(v).data('id'));
					if($(v).data('resource_id')   != undefined) tmpMap.set('resource_id',$(v).data('resource_id'));
					if($(v).data('resource_type') != undefined) tmpMap.set('resource_type',$(v).data('resource_type'));
					if(isAdd){
						let c = {};
						if(tdType.get(index) == 'text'){
							c.k = child.eq(index).text();
						}else{
							c.k = $.trim(child.eq(index).find('input').eq(0).val());
						}
						c.index = ii;
						c.v = tmpMap;
						a.push(c);
					}
				});

				if(a.length > 1){
					$('#tbody').children().each(function(){
						$(this).data('id','');
						$(this).data('resource_type','');
						$(this).data('resource_id','');
					});

					$('#tbody input.edit').each(function(){
						$(this).data('d','');
					});
					$('#tbody').find('input').val('');
					
					a.sort(function(x,y){
						if(order == 'asc'){
							if( x.k < y.k ){
								return -1;
							}else if( x.k > y.k ){
								return 1;
							}
						}else{
							if( x.k > y.k ){
								return -1;
							}else if( x.k < y.k ){
								return 1;
							}
						}
					});
					let i = 0;
					a.forEach(function(vv,kk){
						let child = $('#tbody tr').eq(i).children();
						tdType.forEach(function(v,k){
							let tmpV = vv.v.get(k);
							if( v == 'input'){	
								if(inputOfCode.get(k)){
									child.eq(k).find('input').eq(0).val(tmpV).data('d',tmpV).data('last',tmpV);
								}else{
									child.eq(k).find('input').eq(0).val(tmpV);
								}
								
							}else if(v == 'text'){
								child.eq(k).text(tmpV);
							}
						});
						$('#tbody tr').eq(i).data('id',vv.v.get('id'));
						$('#tbody tr').eq(i).data('resource_id',vv.v.get('resource_id'));
						$('#tbody tr').eq(i).data('resource_type',vv.v.get('resource_type'));
						i++;
					});	
				}
			});
		}

		window.$status = 'new';
		//window.$table = table;


		if(window.location.href.indexOf('?') != -1){
			let tmp = window.location.href.substr(window.location.href.indexOf('?') + 1).split('=');
			$('#ddh').val(tmp[1]);
			form.ddh();
		}


		return table;
		
	},

	list_ini : function (config){

		app.searchOption = {};

		if(config.selectMulti == true){
			select_tr2('table');
		}else{
			select_tr('table');
		}

		form.config = config;

		let setting = {
			paging: false,
			scrollY: get_table_height('table',[]) ,
			info:false,
			dom:'t',
			scrollX: true,
			ordering:false,
			autoWidth: false,
			order : []
		};
		
		if(typeof config != 'undefined'){
			for(let i = 0; i < config.head.length ; i++){
				if(config.head[i]['type'] == 'erp'){
				
					form._switch(config.head[i],'on','head','','#' + config.head[i].id);
				}else if(config.head[i]['type'] == 'date'){
					laydate.render({elem: '#'+config.head[i]['name']});
				}
			}
			if(typeof config.dataTableConfig != 'undefined'){
				for (let key in config.dataTableConfig){
					setting[key] = config.dataTableConfig[key];
				};
			}
		}

		$('.erp-head').hover(function(){
			$(this).find('img.select').show();
		},function(){
			$(this).find('img.select').hide();
		});

		form.list_table = $('#table').DataTable(setting);

		$('#merge').click(function(){
			var imgUrl = get_parent().publicUrl + '/image/erp/';;
			if($(this).data('merge') == '0'){
				setting.ordering = false;
				$(this).prop('src',imgUrl+'o44.png');
				$(this).data('merge','1');	
			}else{
				setting.ordering = true;
				$(this).prop('src',imgUrl+'o45.png'); 
				$(this).data('merge','0');
			}
			form.list_table.destroy();
			$('#table tbody').empty();
			form.list_table = $('#table').DataTable(setting);
			form.research({changeType : true});
		});

		$('#check').click(function(){
			form.check(type = 'list',form.get_list_ddh());
			$(this).blur();
		});

		$('#uncheck').click(function(){
			form.uncheck(type = 'list',form.get_list_ddh());
			$(this).blur();
		});

		$('#dlt').click(function(){
			form.dlt(type = 'list',form.get_list_ddh());
			$(this).blur();
		});

		$('#table_research').keypress(function(e){
			let s = $.trim($(this).val());
			if(e.keyCode == 13){
				table.search(s).draw();
			}
			$(this).blur();
		});

		$('#search').click(function(){
			app.searchOption = form.get_option('.erp-head');;
			form.search();
			$(this).addClass('searchedButton').blur();
			$('#super_search').removeClass('searchedButton');
			

		});

		$('#super_search').click(function(){

			let imgUrl = get_parent().publicUrl + '/image/erp/';

			let content = "<div id = 'option-container'><div class = 'row' style = 'margin:0;padding:0'><div class = 'col s12'><div class = 'row' style = 'border-bottom:2px solid #428bca;padding:20px 20px'><div class = 'col s1'><img src = '"+imgUrl+"condition.png'  class = 'height24' /></div><div class = 'col s5'><select class = 'browser-default' id = 'condition'><option value = '' data-name = '无方案'>无方案</option></select></div><div class = 'col s6 btn-group'><button class = 'btn btn-primary height32' id = 'condition_confirm'>确认</button><button class = 'btn btn-default height32' id = 'condition_set_default'>设为默认</button><button class = 'btn btn-default height32' id = 'condition_save'>保存方案</button><button class = 'btn btn-default height32' id = 'condition_dlt'>删除方案</button></div></div></div></div>";
			

			$.each(form.config.search.superSearch,function(i,v){
		
				content += "<div class = 'row' style = 'padding:10px 20px'>";
				
				$.each(v,function(ii,vv){
					
					switch( vv.type ){
						case 'aa':
							
						break;
						case 'erp' :
							if(vv.relation){
								// 有关联的INPUT ，例如 inventory ,只显示inventory_name，而inventory_code 隐藏起来
								content += "<div class = 'col s2' style = 'text-align:right;line-height:32px'>"+vv.name+"</div><div class= 'col s4 relative option-container2' ><div><input type = 'text' data-type = '"+vv.type+"' data-type2 = '"+(vv.type2?vv.type2:'')+"'  data-option = '"+vv.option+"' class = 'aya-input border-bottom erp "+vv.clas+"' style = 'width:100%'   />";

								content += "<img src = '"+imgUrl+"selectu8.png' class = 'input-hint height14 img-vendor select'/>";

								content += "<input type = 'text' data-option = '"+vv.option+"' class = '"+vv.relation.clas+"' style = 'display:none'   />"

								content += "</div></div>";
							}else{

								

								content += "<div class = 'col s2' style = 'text-align:right;line-height:32px'>"+vv.name+"</div><div class= 'col s4 relative option-container2' ><input type = 'text' data-type = '"+vv.type+"' data-type2 = '"+(vv.type2?vv.type2:'')+"' data-option = '"+vv.option+"'  class = 'aya-input border-bottom erp "+vv.clas+"' style = 'width:100%'  "+(vv.readonly?'readonly':'')+" />";

								if(vv.type2) content += "<img src = '"+imgUrl+"selectu8.png' class = 'input-hint height14 img-vendor select'/>"; 

								content += "</div>";
							}
				
						break;
						default:
							content += "<div class = 'col s2' style = 'text-align:right;line-height:32px'>"+vv.name+"</div><div class= 'col s4' ><input type = 'text'  data-option = '"+vv.option+"' class = 'aya-input border-bottom ' style = 'width:100%'  /></div>";
					}
				});

				content += "</div>";
			});

			content += '</div>';

			parent.layer.open({
				//skin: 'layer-search-container',
				title:'<span style = "font-size:12px">高级查询</span>',
				area: ['800px','100%'],
				shadeClose:true,
				isOutAnim: false ,
				maxmin: true,
				type: 1, 
				content:content,
				success:function(layero, index){

					form.set_super_search_option( app.superSearchOption );

					$('#option-container').find('input.erp').each(function(){
						if( $(this).data('type2') ){
							form._switch({ type : $(this).data('type'), type2 : $(this).data('type2') },'on','head','',this);
						}
					});

					$('.option-container2').hover(function(){
						$(this).find('img.select').show();
					},function(){
						$(this).find('img.select').hide();
					});
					
					$('#condition_confirm').click(function(){

						app.superSearchOption = form.get_option('#option-container');

						app.searchOption = app.superSearchOption;

						$('#search').removeClass('searchedButton');

						$('#super_search').addClass('searchedButton');

						form.search();

						parent.layer.close(index);

					});
					

				}
			});
		});
		
		if(form.config.search) page(form.config.search.url,form.list_table,form.get_app_search_option);
		
		$('#tbody').click(function(e){
			if(top.mainPage.multiType == 1 && $(e.target).hasClass('detail')){
				let ddh = $(e.target).text();
				let id = form.config.detail.id;
				let url = top.$('#' + id).data('url')+'?ddh='+ddh;
				let ttl = top.$('#' + id).data('ttl');
				top.mainPage.add_iframe(url,ttl,id,ddh);
			}
		});

		if(config.number_page != undefined){
			$('#number_page').val(config.number_page);
			$('#number_page').data('d',config.number_page);
		}

		return table;
	},

	set_super_search_option : function(option){
		$('#option-container').find('input').each(function(){
			let tmp = $(this).data('option');
			if( tmp && option[ tmp ]){
				$(this).val(option[tmp]).data('d',option[tmp]);
			}
		});
	},

	get_option :function( container ){
		let o = {};
		$(container).find('input').each(function(){
			if( $(this).data('option') ){
				o[ $(this).data('option') ] = $.trim( $(this).val() );
			}
		});

		return o;
	},

	get_app_search_option(){
		if(app && app.searchOption){
			return app.searchOption;
		}else{
			return {};
		}
	},

	giveup : function (){
		if($('#ddh_hidden').data('d') == ''){
			form.n();
		}else{
			$('#ddh').val($('#ddh_hidden').data('d'));
			form.ddh();
		}
	},
	
	ddh : function (type = ''){

		let o = {};
		o.ddh = $.trim($('#ddh').val());

		o.type = type;          //回冲或者不是回冲
		if(typeof $('#bill_type').val() != 'undefined'){
			o.bill_type = $('#bill_type').val(); 
		}

		if(o.ddh == '') return false;

		let index = parent.layer.load(2,{offset:'30%'});

		$.post(form.config.get.url,o,function(d){
			parent.layer.close(index);
			if(d.status == 's'){
				$('#erptips').html('');
				$('#tbody').children().each(function(){
					$(this).data('id','');
					$(this).data('resource_type','');
					$(this).data('resource_id','');
				});
				$('#tbody input.edit').each(function(){
					$(this).data('d','');
				});
				$('#tbody').find('input').val('');
				let tmp = d.data.length - $('#tbody').children().length + 0;
				if(tmp > 0){
					add_tr('table',tmp);
				}

				$(d.data).each(function(i,v){
					let c = $('#tbody').children().eq(i);
					for(let key in v){
						if(key == 'listid' || key == 'resource_id' || key == 'resource_type') continue;
						let ipt = c.find('.' + key).eq(0);
						ipt.val(v[key]);
						if(ipt.hasClass('edit')){
							ipt.data('d',v[key]);
						}
					}
					c.data('listid',v['listid']);
					c.data('resource_id',v['resource_id']);
					c.data('resource_type',v['resource_type']);
					for(let ii in form.config.getData){
						c.data(form.config.getData[ii],v[form.config.getData[ii]]);
					}
				});

				for(let i in d.info){

					if(document.getElementById(i) != null){
						
						if(document.getElementById(i).tagName == 'INPUT'){
							$('#'+i).val(d.info[i]);
							$('#'+i).data('d',d.info[i]);
						}else{
							$('#'+i).text(d.info[i]);
						}
						
					}
				}
				
				if(type == 'recoil'){
					form.n('recoil');
					form.img_do('recoil','off');
					
					let imgUrl =get_parent().publicUrl + '/image/erp/';
					if(d.info.red == 1){
						$('#'+type).removeClass('img_on').addClass('img_off');
						$('#'+type).find('img').prop('src',imgUrl+type+'_on2.png');
					}else{
						$('#'+type).removeClass('img_on').addClass('img_off');
						$('#'+type).find('img').prop('src',imgUrl+type+'_off.png');
					}
				}else{

				
					form.status(d.info);

					$('#ddh').data('d',o.ddh);
					$('#ddh_hidden').val(o.ddh);
					$('#ddh_hidden').data('d',o.ddh);
					form.s();
				}

				if(d.info.flow_id){
					form.img_do('flow','on');
					$('#flow').data('flowid',d.info.flow_id);
				}else{
					form.img_do('flow','off');
					$('#flow').data('flowid','');
				}

				

				if(d.info.red == 1){
					form.red();
					$('#tbody input.qty').addClass('hint2 font-bold');
					layer.msg("<span class = '' >红字订单</span>",{'icon':7,time:2000,offset:'30%'});
				}else{
					form.blue();
					$('#tbody input.qty').removeClass('hint2 font-bold');
				}
				
				$('#draft_id').val('');
				
				form.print_prepare();
				if(typeof ayaResearch != 'undefined') ayaResearch.close();

				
				if(form.config.get.callback != undefined && form.config.get.callback != ''){
					
					form.config.get.callback(d);
				}

				


			}else{
				layer.msg(d.info,{'icon':2,time:2000,offset:'30%'});
			}
		});
	},

	recoil : function (){
		let ddh2 = $('#ddh_hidden').val();
		if(ddh2 == '') return false;
		$('#ddh').val(ddh2);
		form.ddh('recoil'); 
	},	

	check2 : function (type = 'bill',ddh = [],selected = 'selected'){ 
		let o = {};
		if(type == 'bill'){
			let tmp = [];
			tmp.push($('#ddh_hidden').val());
			o.ddh = JSON.stringify(tmp);
		}else{
			o.ddh = JSON.stringify(ddh);
		}
		if(typeof $('#bill_type').val() != 'undefined'){
			o.bill_type = $('#bill_type').val(); 
		}
		
		o.type = 'check';
		let index = layer.load(2,{offset:'30%'});
		
		$.post(form.config.canModify.url,o,function(d){
			if(d.status == 's'){
				$.post(form.config.check.url,o,function(d){
					layer.close(index);
					if(d.status == 's'){
						layer.msg('审核成功！',{icon:1,time:1500,offset:'30%'});
						if(type == 'bill'){

							form.status( {status : 9} );
						}else{
							var imgUrl =get_parent().publicUrl + '/image/erp/';;
							$(ddh).each(function(i,v){
								$('#tbody tr.c' + v).each(function(){
									if($(this).children().eq(0).text() != ''){
										$(this).children().eq(1).find('img').eq(0).prop('src',imgUrl + 'o10.png');
									}
								});
								//$('#tbody tr.c' + v).eq(0).children().eq(1).find('img').eq(0).prop('src',imgUrl + 'o10.png');
							});
						}
						if(form.config.check.callback != undefined && form.config.check.callback != ''){
							form.config.check.callback();
						}
					}else{
						layer.msg(d.info,{icon:2,time:2000,offset:'30%'});
					}

				});
			}else{
				layer.close(index);
				layer.msg(d.info,{icon:2,time:3000,offset:'30%'});
			}
		});
	},
	

	

	check : function( type = 'bill',ddh = [],selected = 'selected' ){

			//let index1 = layer.load(2);

		let obj = {};

		

		if(type == 'bill'){
			let tmp = [];
			tmp.push($('#ddh_hidden').val());
			obj.ddh = JSON.stringify(tmp);
		}else{
			obj.ddh = JSON.stringify(ddh);
		}
		if(typeof $('#bill_type').val() != 'undefined'){
			obj.bill_type = $('#bill_type').val(); 
		}

		obj.type = 'check';
	
		$.post(form.config.canModify.url,obj,function(d){
			if(d.status == 's'){
				form.check_do(obj);
			}else{
				layer.close(index);
				layer.msg(d.info,{icon:2,time:3000,offset:'30%'});
			}
		});
	},

	check_do : function( obj ,exc = '' ){
			
			if(exc != '') obj.executor = exc;
			$.post(form.config.check.url,obj,function(d){

				//layer.close(index1);
				if(d.status == 's'){
					form.ddh();
					layer.msg('审核成功！',{icon:1,time:1500,offset:'30%'});
				}else if(d.status == 'm'){
					form.tmp = new Map();
					let c = "<div style = 'font-size:12px;'>";
					for(let i in d.data){
						let zxmsName = '';
						if(d.data[i]['zxms'] == 1) zxmsName = '单人执行';
						if(d.data[i]['zxms'] == 2) zxmsName = '多人执行';
						c += "<div class = 'row' style = 'margin:0;padding:20px 10px;border-bottom:1px solid #bfbfbf'>"
						c += "<div class = 'col s3 hint1'>"+d.data[i]['name']+"</div><div class = 'col s3'>"+zxmsName+"</div><div class = 'col s6'><input placeholder = '点击选择执行人' id = '"+i+"' data-id = '"+i+"'  data-zxms = '"+d.data[i]['zxms']+"' type = 'text' class = 'aya-input xzfzclr' style = 'height:24px' readonly /></div>";
						c += "</div>";
						form.tmp.set(i,d.data[i]['list']);
					}
					c += "</div>";		

					let index = parent.layer.open({
						title : '<span style = "font-size:12px">选择分支处理人</span>',
						offset : ['48px'],
						area  : ['900px','660px'],
						type  : 1,
						btn   : ['确定'], //aya_mom_moallocate_change
						shadeClose:true,
						content : c,
						yes : function(){
							let a = [];
							let allSelected = true;
							parent.$('input.xzfzclr').each(function(){
								let tmp = {};
								tmp.id = $(this).data('id');
								if($(this).data('executor') == undefined || $(this).data('executor') == '[]'){
									allSelected = false;
									return false;
								}else{
									tmp.executor = $(this).data('executor');
								}
								a.push(tmp);
							});

							if(allSelected == false){
								layer.msg('请选择执行人',{icon:2,time:1500,offset:'30%'});
								return false;
							}
							form.check_do(obj,JSON.stringify(a));
							layer.close(index);

						},
						success : function(layero, index){
							parent.$('input.xzfzclr').click(function(){

								let t = $(this).parent().prev().prev().text();

								let id = $(this).data('id');

								form.mSelected = id;

								let zxms = $(this).data('zxms');


								let n = "<div class = 'row' style = 'margin:0'><div class = 'col s12' id = 'top123'><div style = 'display:inline-block;width:50%;position:relative'><input id = 'i20191119' placeholder = '按回车搜索' type = 'text' class = 'aya-input' style = 'height:24px;width:100%' /><img class = 'height18' src = '/a1/index/view/public/Image/o25.png' style = 'position:absolute;right:0;top:3px;'/></div></div><div class = 'col s12'><table id = 't20191119' class = 'centered dataTable row-border noselect table-small'><thead><tr></tr><tr><th></th><th>工号</th><th>姓名</th></tr></thead><tbody>";

								let selected = new Map();
								if(parent.$('#' + form.mSelected).data('executor') != undefined){
									JSON.parse(parent.$('#' + form.mSelected).data('executor')).forEach(function(v,k){
										selected.set(v.k,1);	
									});
								}
								
								let tmp1 = '',tmp2 = '';

		
								
								
								$.each(form.tmp.get(id),function(k,v){
									if(selected.get(v.k) == undefined){
										tmp1 += "<tr><td><input type = 'checkbox' class = 'aya-checkbox' /></td><td>"+v.k+"</td><td>"+v.v+"</td></tr>";
									}else{
										tmp2 += "<tr class = 'selected'><td><input type = 'checkbox' class = 'aya-checkbox' checked /></td><td>"+v.k+"</td><td>"+v.v+"</td></tr>";
									}
										
								});

								

								n = n + tmp2 + tmp1;

								n += "</tbody></table></div><div class = 'col s12 center' style = 'padding:8px' ><button class = 'btn btn-primary height32' id = 'btn20191119'>确定</button></div></div>";


						
								parent.layer.open({
									title : '<span class = "hint2" style = "font-size:12px">选择分支处理人（'+t+'）</span>',
									offset : ['48px'],
									area  : ['500px','660px'],
									type  : 1,
									shadeClose:false,
									content: n,
									success : function(layero2, index2){
										
										let scrollY = 562 - $('#top123').height()  - top.$('#btn20191119').parent().height();
										if(top.mainPage.multiType == 1) scrollY -= 26;

										let setting = {
											paging: false,
											scrollY: scrollY ,
											info:false,
											ordering:false,
											dom:'t',	
										};

										let t20191119 = parent.$('#t20191119').DataTable(setting);

										if(zxms == 1){
											parent.select_tr('t20191119');
										}else{
											parent.select_tr2('t20191119');
										}
										

											
										parent.$('#i20191119').keypress(function(e){
										
											let text = $.trim(parent.$('#i20191119').val());
											
											if(e.keyCode == 13){
												t20191119.search(text).draw();
											}
										});
											
										parent.$('#btn20191119').click(function(){
											let a = [];
											parent.$('#t20191119 tbody tr.selected').each(function(){
												let tmp = {};
												tmp.k = $(this).children().eq(1).text();
												tmp.v = $(this).children().eq(2).text();
												a.push(tmp);
											});
											if(a.length == 0){
												layer.msg('请选择执行人',{icon:2,time:1500,offset:'30%'});
											}else{
												parent.$('#'+form.mSelected).data('executor',JSON.stringify(a));
												let tmp = ''
												for(let i = 0; i < a.length; i++){
													if( i == a.length - 1){
														tmp += a[i]['v'];
													}else{
														tmp = tmp + a[i]['v'] + ',';
													}
												}
												$('#'+form.mSelected).val(tmp);
												parent.layer.close(index2);
											}
										});

									}
										
								});

							});

						},
					});
						

				}else{
					layer.alert(d.info,{shadeClose:true,'title' : "<span style = 'font-size:12px'>错误信息</span>",area:['500px'],icon:2,offset:'20%'});
				}		
			});

	},


	uncheck : function (type = 'bill',ddh = [],selected = 'selected'){

		let o = {};
		if(type == 'bill'){
			let tmp = [];
			tmp.push($('#ddh_hidden').val());
			o.ddh = JSON.stringify(tmp);
		}else{
			o.ddh = JSON.stringify(ddh);
		}
		if(typeof $('#bill_type').val() != 'undefined'){
			o.bill_type = $('#bill_type').val(); 
		}
		o.type = 'uncheck';
		let index = layer.load(2,{offset:'30%'});

		$.post(form.config.canModify.url,o,function(d){
			if(d.status == 's'){
				$.post(form.config.uncheck.url,o,function(d){
					layer.close(index);
					if(d.status == 's'){
						layer.msg('弃审成功！',{icon:1,time:1500,offset:'30%'});
						if(type == 'bill'){
							form.ddh();
						}else{
							var imgUrl =get_parent().publicUrl + '/image/erp/';;
							$(ddh).each(function(i,v){
								
								$('#tbody tr.c' + v).each(function(){
									if($(this).children().eq(0).text() != ''){
										$(this).children().eq(1).find('img').eq(0).prop('src',imgUrl + 'o9.png');
									}
								});

								//$('#tbody tr.c' + v).eq(0).children().eq(1).find('img').eq(0).prop('src',imgUrl + 'o9.png');
							});
						}
						if(form.config.uncheck.callback != undefined && form.config.uncheck.callback != ''){
							form.config.uncheck.callback(d);
						}
					}else{
						layer.msg(d.info,{icon:2,time:1500,offset:'30%'});
					}
				});
			}else{
				layer.close(index);
				layer.msg(d.info,{icon:2,time:1500,offset:'30%'});
			}
		});
	},

	dlt : function (type = 'bill',ddh = [],selected = 'selected'){

		parent.layer.confirm('确定删除?', {icon: 3, title:'提示',offset:'30%'}, function(index){
			let o = {};
			if(type == 'bill'){
				let tmp = [];
				tmp.push($('#ddh_hidden').val());
				o.ddh = JSON.stringify(tmp);
			}else{
				o.ddh = JSON.stringify(ddh);
			}
			o.type = 'dlt';
			if(typeof $('#bill_type').val() != 'undefined'){
				o.bill_type = $('#bill_type').val(); 
			}

			parent.layer.close(index);
			let index2 = parent.layer.load(2,{offset:'30%'});
			
			$.post(form.config.canModify.url,o,function(d){
				if(d.status == 's'){
					$.post(form.config.dlt.url,o,function(d){
						parent.layer.close(index2);
						if(d.status == 's'){
							parent.layer.msg('删除成功',{icon:1,time:2000,offset:'30%'});
							if(type == 'bill'){
								$('#ddh').val('');
								$('#ddh').data('d','');
								$('#ddh_hidden').val('');
								$('#ddh_hidden').data('d','');
								form.n();
							}else{
								$(ddh).each(function(i,v){
									let tmp = $('#tbody tr.c' + v).eq(0);
									let ddh = tmp.data('ddh');
									while(tmp.next().data('ddh') == ddh){
										tmp.next().remove();
									}
									$('#tbody tr.c' + v).eq(0).remove();
								});

							}
						}else{
							parent.layer.msg(d.info,{icon:2,time:1500,offset:'30%'});
						}
					

					});
				}else{
					parent.layer.close(index2);
					parent.layer.msg(d.info,{icon:2,time:2000,offset:'30%'});

				}
			});	
		});	
	},
	
	modify : function (){
		let o = {};
		let tmp = [];
		tmp.push($('#ddh_hidden').data('d'));
		o.ddh = JSON.stringify(tmp);
		o.type = 'modify';
		$.post(form.config.canModify.url,o,function(d){
			if(d.status == 's'){
				form.m();
				form.status({status : 'modify'});
			}else{
				layer.msg(d.info,{icon:2,time:1500,offset:'30%'});
			}
		});
	},
	
	status : function (info){

		status = info.status;

		var imgUrl =get_parent().publicUrl + '/image/erp/';

		if(status == 'new' || status == 'modify'){
			form.img_do('save','on');form.img_do('giveup','on');
			form.img_do('check','off');form.img_do('uncheck','off');form.img_do('dlt','off');form.img_do('modify','off');form.img_do('recoil','off');
			$('#state_info').hide();
			$('#tbody tr td img.opr').data('opr','on');
		}

		if(status == '5'){
			form.img_do('modify','on');form.img_do('dlt','on');form.img_do('recoil','on');
			form.img_do('save','off');form.img_do('giveup','off');
			$('#state_info_img').find('img').eq(0).prop('src',imgUrl+'status_5.png');
			
			if(info.flow_id == 0 ){
				form.img_do('uncheck','off');
				form.img_do('check','on');
			}else{
				form.img_do('uncheck',info.canRetrieve?'on':'off');
				form.img_do('check',info.canCheck?'on':'off');
			}
			$('#state_info_text').text('已保存').css('color','#2aa515');
			$('#state_info').show();
			$('#tbody tr td img.opr').data('opr','off');
		}

		if(status == '9'){
			form.img_do('uncheck','on');form.img_do('recoil','on');
			form.img_do('save','off');form.img_do('dlt','off');form.img_do('giveup','off');form.img_do('check','off');form.img_do('modify','off');
			$('#state_info_img').find('img').eq(0).prop('src',imgUrl+'status_9.png');
			$('#state_info_text').text('已审核').css('color','#d81e06');
			$('#state_info').show();
			$('#tbody tr td img.opr').data('opr','off');
		}

		if(status == '20'){
			form.img_do('recoil','on');
			form.img_do('uncheck','off');form.img_do('save','off');form.img_do('dlt','off');form.img_do('giveup','off');form.img_do('check','off');form.img_do('modify','off');
			$('#state_info_img').find('img').eq(0).prop('src',imgUrl+'status_20.png');
			$('#state_info_text').text('已关闭').css('color','#707070');
			$('#state_info').show();
			$('#tbody tr td img.opr').data('opr','off');
		}
		window.$status = status ;
	},

	save : function(){
		flowsave(form.save_do);
	},

	save_do : function( resolve , executor = '' ){
		let o = form.get_field();
		$.post(form.config.save.url,o,function(d){
			if(d.status == 's'){
				layer.msg( '保存成功', {icon:1,time:1500,offset:'30%'}	);
				$('#ddh').val(d.data);
				form.ddh();
			}
			resolve(d);
		});
	},

	saved : function (d,index){
		if(d.status == 's'){
			layer.msg('保存成功！',{icon:1,time:1500,offset:'30%'});
			$('#ddh').val(d.data);
			form.ddh();
		}else{
			layer.msg(d.info,{icon:2,time:3000,offset:'30%'});
		}
		layer.close(index);
	},

	resource_fill : function (o){
		let P = get_parent();
		if(o.data.length == 0) return false;
		if(P.$('#save').hasClass('img_off')){
				P.form.n();
		}
		for(let k in o){
			if(k != 'data'){
				if(P.$('#'+k).data('last') != undefined){
					P.$('#'+k).data('last',o[k]);
					P.$('#'+k).data('d',o[k]);
				}
				P.$('#'+k).val(o[k]);
			}else{
				let trLength = P.$('#tbody tr').length;
				let firstIndex = -1;
				let needAdd = 0;
				P.$('#tbody tr').each(function(i,v){
					if($(this).find('.inventory_code').eq(0).val() != '' ){
						firstIndex = $(this).index();
					}	
				});
				needAdd = o.data.length - (trLength - (firstIndex + 1)) ;
				if(needAdd > 0){
					add_tr('table',needAdd);
				}
				let i = firstIndex + 1;
				for(let k in o.data){
					let data = o.data[k];
					for(let kk in data){
						if(kk == 'resource_type'){
							 P.$('#tbody tr').eq(i).data('resource_type',data[kk]);
						}else if(kk == 'resource_id'){
							 P.$('#tbody tr').eq(i).data('resource_id',data[kk]);
						}else{
							let ipt = P.$('#tbody tr').eq(i).find('.'+kk).eq(0);
							if(ipt.data('last') != undefined){
								ipt.data('last',data[kk]);
								ipt.data('d',data[kk]);
							}
							ipt.val(data[kk]);
							if(ipt.hasClass('resource')){   //input的resource，表示此input可以通过选单号返回，当选单号后，禁止写入
								ipt.prop('readonly',true);  //input的父td，加上data(nohover),1表示不HOVER
								ipt.parent().data('nohover',1);	
							}
						}
					}
					i++;
				}
			}
		}
	},

	get_list_ddh : function (selected = 'selected'){
		let r = new Array();
		$('#tbody tr.' + selected).each(function(){
			let ddh = $(this).data('ddh');
			if(ddh != '' && $.inArray(ddh,r) == -1 ){
				r.push(ddh);
			}
		});
		return r;
	},

	search : function (o = {}){
		
		o = $.extend(o,app.searchOption);
		o = $.extend(o,get_page());

		if(typeof $('#merge').data('merge') != 'undefined' && $('#merge').data('merge') != 0){
			o.merge = form.config.merge;
		}else{
			o.merge = 0;
		}

		form.query(o);	
	},

	query : function (o){

		

		if(typeof o.page == 'undefined') o.page = 1;
		let index = parent.layer.load(2,{offset:['20%']});
		$.post(form.config.search.url,o,function(d){
			if(d.status == 's'){
				let page = d.data.page;
				form.list_table.clear();
				form.list_table.rows.add($(d.data.tbody)).draw();
				set_page(page);
				
			}else{
				
				layer.msg(d.info,{'icon':2,time:2000,offset:'30%'});
			}
			
			if(typeof o.changeType != 'undefined'){
				if($('#merge').data('merge') == 0){
					layer.msg('详细表头模式',{'icon':1,time:1000,offset:'30%'});
				}else{
					layer.msg('合并表头模式',{'icon':1,time:1000,offset:'30%'});
				}
			}
			parent.layer.close(index);
		});
	},

	get_field : function(){
		let o = {};
		let oo = [];
		o.ddh  = $('#ddh_hidden').val();
		$(form.config.saveField.main).each(function(i,v){
			o[v] = $.trim($('#' + v).val());
		});
		$('#tbody tr').each(function(){
			let tmp = {};
			let that = this;
			$(form.config.saveField.list).each(function(i,v){
				tmp[v] = $.trim( $(that).find('.' + v).eq(0).val() );
			});
			tmp.index =   $(this).children().eq(0).text();
			tmp.listid = $(this).data('listid')?$(this).data('listid'):'';
			let a = true;
			$(form.config.saveField.listMust).each(function(i,v){
			
				if(tmp[v] == ''){
					 a = false;
					 return false;
				}
			});
			
			if(a) oo.push(tmp);
		});
		o.data = JSON.stringify(oo);

		return o;
	},

	print_prepare : function (){
		if(typeof form.config.print == 'undefined') return false;

		parent.$('#print_content').remove();
		
		let printContent = "<div id = 'print_content' class = 'print_block' style = 'padding:2px;'>";

		let title = "";

		let tmp1 = "";

		tmp1 += "<table class = 'print_content_thead_table' style = 'border:0;width:100%;table-layout:fixed'><tbody>";

		for(let i in form.config.print.head){
			tmp1 += '<tr>';

			let tmp = form.config.print.head[i];
			
			for(let j in tmp){
				if(tmp[j]['id'] == ''){
					tmp1 += "<td style = 'text-align:left;border-width:0;font-size:11px;font-weight:normal'>"+tmp[j]['name']+"</td>";
				}else{
					tmp1 += "<td style = 'text-align:left;border-width:0;font-size:11px;font-weight:normal'>"+tmp[j]['name']+""+$('#'+tmp[j]['id']).val()+"</td>";
				}
			}
			
			tmp1 += '</tr>';
		}

		tmp1 += "</tbody></table>";

		let tmp2 = "<table style = 'width:100%' id = 'print_content_table'><thead><tr><th style = 'border:0;font-size:16px' colspan = "+form.config.print.body.length+" >"+form.config.print.title+"</th></tr><tr><th style = 'border:0;padding:0 0 6px 0;' colspan = "+form.config.print.body.length+" >"+tmp1+"</th></tr><tr>";
		
		let pd = [];
		for(let i in form.config.print.body){
			if(typeof form.config.print.body[i].key != 'undefined') pd.push(form.config.print.body[i].index);

			let ttt = "";

			if(typeof form.config.print.body[i].width != 'undefined'){
				ttt = ";width:"+form.config.print.body[i].width+"px";
			}

			tmp2 += "<th style = 'border:1px solid #000;font-weight:normal;font-size:11px"+ttt+"'>"+form.config.print.body[i].name+"</th>";
		}	

		tmp2 += "</tr></thead><tbody id = 'print_content_tbody'>";

		$('#tbody tr').each(function(ii,vv){
			let flag = true;
			let t = $(this).children();
			for(let i in pd){
				if(t.eq(pd[i]).find('input').eq(0).val() == '') flag = false;
			}
			if(!flag) return true;

			tmp2 += "<tr>";
			for(let i in form.config.print.body){

				if(isNaN(parseInt(form.config.print.body[i].index))){
					if(form.config.print.body[i].index == 'index'){
						tmp2 += "<td>"+(ii + 1)+"</td>";
					}else{
						if(form.config.print.body[i].align == 'left'){
							tmp2 += "<td style = 'text-align:left; text-indent:5px'>"+$(this).data(form.config.print.body[i].index)+"</td>";
						}else{
							tmp2 += "<td>"+$(this).data(form.config.print.body[i].index)+"</td>";
						}
					}
					
				}else{
					if(form.config.print.body[i].align == 'left'){
						tmp2 += "<td style = 'text-align:left; text-indent:5px'>"+t.eq(form.config.print.body[i].index).find('input').eq(0).val()+"</td>";
					}else{
						tmp2 += "<td>"+t.eq(form.config.print.body[i].index).find('input').eq(0).val()+"</td>";
					}
					
				}
			}
			tmp2 += "</tr>";
		});		

		tmp2 += "</tbody>";

		tmp1 = "";

		tmp1 += "<table class = 'print_content_thead_table' style = 'border:0;width:100%;table-layout:fixed'><tbody>";

		for(let i in form.config.print.foot){
			tmp1 += '<tr>';

			let tmp = form.config.print.foot[i];
			for(let j in tmp){
				if(tmp[j]['id'] == ''){
					tmp1 += "<td style = 'text-align:left;border-width:0;font-size:11px;font-weight:normal'>"+tmp[j]['name']+"</td>";
				}else{
					tmp1 += "<td style = 'text-align:left;border-width:0;font-size:11px;font-weight:normal'>"+tmp[j]['name']+""+$('#'+tmp[j]['id']).val()+"</td>";
				}
				
			}
			
			tmp1 += '</tr>';
		}

		tmp1 += "</tbody></table>";


		tmp2 += "<tfoot><tr><td style = 'border:0' colspan = "+form.config.print.body.length+"  >"+tmp1+"</td></tr></tfoot>";

		tmp2 += "</table>";

		printContent += tmp2;
		printContent += '</div>';

		parent.$('body').append(printContent);	

		
	}
};

/*
erp_inventory
例如：
<td> <input /><img></td>
点击img，弹出选择框，选择后弹框消失，数据填入input，支持多选
如果是多选，一定是在table  tbody  tr  td 中的input的方式

erp_inventory()
参数说明：
t 触发元素
mul 是否多行
index 是否对第一列重新index
hint  输入值是否弹出候选框
erp_inventory_callBack 回调函数
tianchong 需不需要填充
*/

//数据返回，input要包含在2个外层内
//enter 按回车键是否多行自动完成
//focustOUt 失去焦点是否比较数据


//h_or_b 表头还是表体 head or body
