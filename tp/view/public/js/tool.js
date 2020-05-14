/*------------------------------------------------------
---------------------------------------------------------  */
function create_new_div( div ){
	let content = "<div class = 'row new-container' >";
	for(let d of div){
	
		if(d.type == 'text'){
			let readonly = d.readonly?' readonly ' :'';
			content += "<div class = 'col s4 font-bold'>"+d.name+"</div><div class = 'col s8'><input "+readonly+" id = '"+d.id+"' class = 'aya-input' type = 'text' /></div>";
		}else if(d.type == 'select'){
			if(d.mul == true){
				content += "<div class = 'col s4 font-bold'>"+d.name+"</div><div class = 'col s8'><select multiple class = 'browser-default' id = '"+d.id+"'>";
			}else{
				content += "<div class = 'col s4 font-bold'>"+d.name+"</div><div class = 'col s8'><select class = 'browser-default' id = '"+d.id+"'>";
			}
			if(d.empty) content += "<option value = ''></option>";
			for(let s of d.data){
				content += "<option value = '"+s.id+"' >"+s.name+"</option>";
			}
			content += "</select></div>";
		}else if(d.type == 'hidden'){
			content += "<input  id = '"+d.id+"' class = 'aya-input' type = 'hidden' />";
		}else if(d.type == 'checkbox'){
			content += "<div class = 'col s4 font-bold'>"+d.name+"</div><div class = 'col s8' style = 'text-align:left'><input id = '"+d.id+"' class = 'aya-checkbox' type = 'checkbox' /></div>";
		}
	}
	content += "</div>";
	return content;
}

function layer_error(d,time = 2000){
	layer.msg(d.info,{icon:2,time:time,offset:'30%'});
}
function layer_success(info = '操作成功',time = 1000){
	layer.msg(info,{icon:1,time:time,offset:'30%'});

	
}

function d_table(setting = {},id = 'table',select = select_tr){


	let setting1 = {
		paging: false,
		scrollY:  get_table_height() ,
		info:false,
		dom:'t',
		order : []
	};

	

	if(select_tr != ''){
	
		select_tr(id);
	}
	
	

	return $('#' + id).DataTable($.extend(setting1,setting));
}



function get_width(widthMax = 1000){
	let width1 = $(window).width();
	let width2 = window.screen.width;
	let width;
	if(width1 == width2){
		width = width1 * 0.9;
		if(width > widthMax ) width = widthMax;
	}else{
		width = width1;
	}
	return width;
}

function get_table_height(tableid = 'table',exclude = []){
	let h1 = parent.mainPage.height;
	let h2 = $('#' + tableid).offset().top;
	let r = h1 - h2;
	if($('#page').length > 0) r = r - $('#page').height();
	if($('#' + tableid + ' tfoot').length > 0){
		r = r - 48;
	}
	if(exclude.length > 0){
		for(let i in exclude){
			r = r - $('#'+exclude).height();
		}
	}
	return r;
}

function get_parent(){
	
	if(top.mainPage.multiType == 1){
		return top.frames[top.mainPage.currentPageId];
	}else{
		return parent;
	}
}
	


function maxheight(cont = '',scroll = true){
	let tmpheight = parent.$('#page-inner').height() - 6;

	if(scroll){
		$('.card').eq(0).css('overflow-y','scroll');
	}
	if(cont == ''){
		$('.card').eq(0).css('minHeight',tmpheight).css('maxHeight',tmpheight);
	}else{
		tmpheight -= 46;
		$('#'+cont).css('minHeight',tmpheight).css('maxHeight',tmpheight);
	}
}

function max_height(id,scroll = true,percent = 1,borderRight = true){
	if(scroll) $('#' + id).css('overflow-y','auto');

	if(borderRight) $('#' + id).css('border-right','1px solid #D3D3D3');
	
	height = parent.mainPage?parent.mainPage.height:$(window).height();
	
	let tmpheight = height - $('#' + id).offset().top + 38;
	
	tmpheight = tmpheight * percent;

	$('#' + id).css('minHeight',tmpheight).css('maxHeight',tmpheight);
}



function clone_thead(id,c = '',zIndex = 20){
	var clone_table = '';
	clone_table = "<table class = '"+$('#'+id).prop('class')+" clone_thead' style = 'position:fixed;top:"+$('#'+id).offset().top+"px;left:"+$('#'+id).offset().left+"px;background:#ffffff;z-index:"+zIndex+";opacity:1;width:"+$('#'+id).width()+"px'><thead>";
	
	$('#'+id+'_clone').remove();

	var clone_thead = $('#'+id).find('thead').clone();
	clone_thead.prop('id',id + '_clone');
	
	var table = '';

	for(var i = 0; i < $('#'+id+' thead').eq(0).children().length; i++){
		for(var j = 0; j < $('#'+id+' thead').eq(0).children().eq(i).children().length; j++){
			var tmp = $('#'+id+' thead').eq(0).children().eq(i).children().eq(j);
			clone_thead.children().eq(i).children().eq(j).width(tmp.width()).css('whiteSpace',tmp.css('whiteSpace')).css('fontSize',tmp.css('fontSize'));	
		}
	}
	clone_table += clone_thead.html();
	clone_table += "</thead></table>";
	$('body').append(clone_table);
}


//自动clone一行，
function auto_add_tr(id,index = false){
	$('#'+id+' tbody').on('click','tr',function(){
		let len = $('#'+id+' tbody tr').length - 1;
		if($(this).index() == len){
			let clone = $(this).clone();
			clone.find('input').val('').prop('title','');
			$('#'+id+' tbody').append(clone);
			if(index){
				reindex(id);
			}
		}
	});
}



function add_tr(id,n,P = window){
	let clone = P.$('#'+id+' tbody tr').eq(0).clone();
	clone.find("input[type=text]").eq(0).val('3');
	clone.find('td.dlt-text').text('');
	let html = clone.prop("outerHTML");
	let tmp = '';
	for(let i = 0;i < n;i++){
		tmp += html;
	}
	P.$('#'+id+' tbody').append(tmp);
	reindex(id,P);
}

function reindex(id,type = 'id',P = window){
	if(type == 'id'){
		P.$('#'+id+' tbody tr').each(function(i,v){
			$(this).children().eq(0).text(i + 1);
		});
	}else if(type = 'object'){
		P.$(id).find('tbody').eq(0).children().each(function(i,v){
			$(this).children().eq(0).text(i + 1);
		});
	}	
}

function select_tr(tableid,selectClass = 'selected',callback = function(){}){

	$('#'+tableid+' tbody').on('click','tr',function(){

		$('#'+tableid+' tbody tr').removeClass(selectClass);
		$('#'+tableid+' tbody tr td input').prop('checked',false);
		$(this).addClass(selectClass).children().eq(0).find('input').prop('checked',true);
	});
	callback();
}

//flag 不按ctrl 和shift的时候，时候去掉所有的选择项，默认 是
function select_tr2(tableid,selectClass = 'selected',callback = function(){},flag = true){
	window.isShift = false;
	window.isCtrl  = false;
	window.firstTr = 0;
	window.lastShift = -1;

	$(window).keydown(function(e){
		if(e.keyCode == 16){
			isShift = true;
		}else if(e.keyCode == 17){
			isCtrl = true;
		}
	});

	$(window).keyup(function(e){
		isShift = false;
		isCtrl  = false;
	});
	
	$('#'+tableid+' tbody').on('click','tr',function(){
		if(!isShift && !isCtrl){
			if(flag) $('#'+tableid+' tbody tr').removeClass(selectClass);
			if(flag) $('#'+tableid+' tbody tr td input').prop('checked',false);

			if($(this).hasClass(selectClass)){

				$(this).removeClass(selectClass).children().eq(0).find('input').prop('checked',false);
			}else{

				$(this).addClass(selectClass).children().eq(0).find('input').prop('checked',true);
			}
			
			firstTr = $('#'+tableid+' tbody tr').index(this);
			lastShift = -1;
		}else if(isCtrl){

			if($(this).hasClass(selectClass)){
				$(this).removeClass(selectClass).children().eq(0).find('input').prop('checked',false);
			}else{
				$(this).addClass(selectClass).children().eq(0).find('input').prop('checked',true);
				firstTr = $('#'+tableid+' tbody tr').index(this);
			}

			
			
			lastShift = -1;
		}else{
			let s = firstTr;
			let e = $('#'+tableid+' tbody tr').index(this);
			if(lastShift >= 0){
				let s1 = firstTr;
				let e1 = lastShift;
				if(s1 > e1){
					let tmp = s1;
					s1 = e1;
					e1 = tmp;
				}
				for(let j = s1; j <= e1; j++){
					if(j != e) $('#'+tableid+' tbody tr').eq(j).removeClass(selectClass).children().eq(0).find('input').prop('checked',false);
				}
			}

			lastShift = e;
			if(s > e){
				let tmp = s;
				s = e;
				e = tmp;
			}
			
			for(let i = s; i <= e; i++){
				$('#'+tableid+' tbody tr').eq(i).addClass(selectClass).children().eq(0).find('input').prop('checked',true);
			}
		}

		callback();
	});

}

function select_tr3(tableid,selectClass = 'selected',callback = function(){}){
	
	$('#'+tableid+' tbody').on('click','tr',function(){
		t = $(this);
		if(t.hasClass(selectClass)){
			$(t).removeClass(selectClass).children().eq(0).find('input').prop('checked',false);
		}else{
			$(t).addClass(selectClass).children().eq(0).find('input').prop('checked',true);
		}
		callback();
	});
	$('#'+tableid+' tbody').on('click','input.aya-checkbox',function(e){
		e.stopPropagation();
		$(this).parents('tr').trigger('click'); 
		
	});
}

function log(s,clear = true){
	if(clear) console.clear();
	console.log(s);
}

function page(url,table = '',option = {}){
	
	
	
	$('#first_page').click(function(){
		let current_page = parseInt($('#current_page').text());
		let totle_page   = parseInt($('#totle_page').text());
		let o = typeof option == 'function'?option():option;
		$('#number_page').val($('#number_page').data('d'));
		if(current_page == 1) return false;
		if(totle_page == 1) return false;
		o.page = 1;
		o.n = $('#number_page').data('d');
		page_callback(o,url,table);
	});

	$('#last_page').click(function(){
		let current_page = parseInt($('#current_page').text());
		let totle_page   = parseInt($('#totle_page').text());
		let o = typeof option == 'function'?option():option;
		$('#number_page').val($('#number_page').data('d'));
		if(current_page == totle_page || totle_page == 0) return false;
		o.page = totle_page;
		o.n = $('#number_page').data('d');
		page_callback(o,url,table);
	});
	
	$('#prev_page').click(function(){
		let current_page = parseInt($('#current_page').text());
		let totle_page   = parseInt($('#totle_page').text());
		let o = typeof option == 'function'?option():option;
		$('#number_page').val($('#number_page').data('d'));
		if(current_page == 1) return false;
		if(totle_page == 1) return false;
		o.page = current_page - 1;
		o.n = $('#number_page').data('d');
		page_callback(o,url,table);
	});

	$('#next_page').click(function(){
		let current_page = parseInt($('#current_page').text());
		let totle_page   = parseInt($('#totle_page').text());
		let o = typeof option == 'function'?option():option;
		$('#number_page').val($('#number_page').data('d'));
		if(current_page == totle_page || totle_page == 0) return false;
		o.page = current_page + 1;
		o.n = $('#number_page').data('d');
		page_callback(o,url,table);
	});
	
	$('#modify_number_page').click(function(){
		let o = typeof option == 'function'?option():option;
		let totles =  parseInt($('#totles').text());
		let n = parseInt($('#number_page').val());
		if(isNaN(n) || n <= 0 ) n = $('#number_page').data('d');
		$('#number_page').val(n);
		$('#number_page').data('d',n);
		o.page = 1;
		o.n = n;
		page_callback(o,url,table);
	});
}
function page_callback(o,url,table){
	let index = layer.load(1,{offset:['30%']});
	$.post(url,o,function(d){
		if(d.status == 's'){
			set_page(d.data.page);
			if(table != ''){
				table.clear();
				table.rows.add($(d.data.tbody)).draw();
			}
		}else{
			
		}
		layer.close(index);
	});
}

function get_page(){
	let o = {};
	o.page = 1;
	$('#number_page').val($('#number_page').data('d'));
	o.n = $('#number_page').data('d');
	return o;
}

function set_page(page){
	
	$('#current_page').text(page.current_page);
	$('#totles').text(page.totles);
	$('#totle_page').text(page.totle_page);
}




function decimal(num,n){
	return Math.round(parseFloat(num) * Math.pow(10,n))/Math.pow(10,n);
}




function flowsave(save,executor = '' ){

	let p = new Promise(function(resolve){
		save(resolve,executor);
	});

	p.then(function(d){
		if(d.status == 's'){
			if(d.info != '') layer.msg( d.info, {icon:1,time:1500,offset:'30%'}	);
			
		}else if(d.status == 'e'){
			layer.msg( d.info , {icon:2,time:3000,offset:'30%'} );
		}else if(d.status == 'm'){
			let map = new Map();
			let mSelected;
			let c = "<div style = 'font-size:12px;'>";
			for(let i in d.data){
				let zxmsName = '';
				if(d.data[i]['zxms'] == 1) zxmsName = '单人执行';
				if(d.data[i]['zxms'] == 2) zxmsName = '多人执行';

				c += "<div class = 'row' style = 'margin:0;padding:20px 10px;border-bottom:1px solid #bfbfbf'>"
				c += "<div class = 'col s3 hint1'>"+d.data[i]['name']+"</div><div class = 'col s3'>"+zxmsName+"</div><div class = 'col s6'><input id = '"+i+"' data-id = '"+i+"'  data-zxms = '"+d.data[i]['zxms']+"' type = 'text' class = 'aya-input xzfzclr' style = 'height:24px' readonly /></div>";
				c += "</div>";
				map.set(i,d.data[i]['list']);
			}
			c += "</div>";

			let index = top.layer.open({
				title : '<span style = "font-size:12px">选择分支处理人</span>',
				offset : ['50px'],
				area  : ['900px','660px'],
				type  : 1,
				btn   : ['确定'],
				shadeClose:true,
				content : c,
				yes : function(){
					let a = [];
					let allSelected = true;		
					top.$('input.xzfzclr').each(function(){
						
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
						top.layer.msg('请选择执行人',{icon:2,time:1500,offset:'30%'});
						return false;
					}
					

					flowsave(save,JSON.stringify(a));
					top.layer.close(index);
				},
				success : function(layero, index){
					top.$('input.xzfzclr').click(function(){
						
						let t = $(this).parent().prev().prev().text();

						let id = $(this).data('id');

						mSelected = id;

						let zxms = $(this).data('zxms');
						
						let n = "<div class = 'row' style = 'margin:0'><div class = 'col s12' id = 'top123'><div style = 'display:inline-block;width:50%;position:relative'><input id = 'i20191119' placeholder = '按回车搜索' type = 'text' class = 'aya-input' style = 'height:24px;width:100%' /><img class = 'icon4' src = '/a1/index/view/public/Image/o25.png' style = 'position:absolute;right:0;top:3px;'/></div></div><div class = 'col s12'><table id = 't20191119' class = 'centered row-border noselect table-small'><thead><tr></tr><tr><th></th><th>工号</th><th>姓名</th></tr></thead><tbody>";

						let selected = new Map();
						
						if(top.$('#' + mSelected).data('executor') != undefined){
							let tmp3 = top.$('#' + mSelected).data('executor');
							if(typeof tmp3 == 'string'){
								tmp3 = JSON.parse( top.$('#' + mSelected).data('executor') );
							}
							tmp3.forEach(function(v,k){
								selected.set(v.k,1);	
							});
						}
									
						let tmp1 = '',tmp2 = '';
		
						map.get(id).forEach(function(v,k){
							if(selected.get(v.k) == undefined){
								tmp1 += "<tr><td><input type = 'checkbox' class = 'aya-checkbox' /></td><td>"+v.k+"</td><td>"+v.v+"</td></tr>";
							}else{
								tmp2 += "<tr class = 'selected'><td><input type = 'checkbox' class = 'aya-checkbox' checked /></td><td>"+v.k+"</td><td>"+v.v+"</td></tr>";
							}				
						});

						n = n + tmp2 + tmp1;

						n += "</tbody></table></div><div class = 'col s12 center' style = 'padding:8px'><button class = 'btn btn-primary height32' id = 'btn20191119'>确定</button></div></div>";
						
						top.layer.open({
							title : '<span class = "hint2" style = "font-size:12px">选择分支处理人（'+t+'）</span>',
							offset : ['50px'],
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

								let t20191119 = top.$('#t20191119').DataTable(setting);

								if(zxms == 1){
									top.select_tr('t20191119');
								}else{
									top.select_tr2('t20191119');
								}
											
												
								top.$('#i20191119').keypress(function(e){
									let text = $.trim($('#i20191119').val());
									if(e.keyCode == 13){
										t20191119.search(text).draw();
									}
								});
												
								top.$('#btn20191119').click(function(){
									let a = [];
									top.$('#t20191119 tbody tr.selected').each(function(){
										let tmp = {};
										tmp.k = $(this).children().eq(1).text();
										tmp.v = $(this).children().eq(2).text();
										a.push(tmp);
									});
									if(a.length == 0){
										layer.msg('请选择执行人',{icon:2,time:1500,offset:'30%'});
									}else{
										top.$('#'+mSelected).attr('data-executor',JSON.stringify(a));
										let tmp = ''
										for(let i = 0; i < a.length; i++){
											if( i == a.length - 1){
												tmp += a[i]['v'];
											}else{
												tmp = tmp + a[i]['v'] + ',';
											}
										}
										top.$('#'+mSelected).val(tmp);
										top.layer.close(index2);
									}
								});

							}
											
						});

					});

				},
			});

		}
	});
}

function select_employee(id,callback){
	let url = window.location.href.substring(0,window.location.href.indexOf('.php') + 4);
	
	$(id).click(function(){
		let that = this;
		parent.layer.open({					
			type: 2,
			isOutAnim: false ,
			title: '选择员工',
			maxmin: true,
			shadeClose: true, //点击遮罩关闭层
			area : ['800px','100%'],
			content: url+'/S/select_employee',
			btn : ['确定'],
			yes : function(index,layero){
				let selected = window[layero.find('iframe')[0]['name']].app.selected;
				callback(selected,that);
				parent.layer.close(index);
			}
				
		});
	});
}

function tabs(id,callback = ''){
	$('#' + id + ' li a').click(function(){
		$('#' + id + ' li a').removeClass('active');
		$(this).addClass('active');
		$('.' + id).hide();
		let index = $(this).data('index');
		$('#' + id + index).show();
		if( callback != '' ) callback(this);
	});

	
}





