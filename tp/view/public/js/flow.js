var flow = {
	
	multiIndex : '',

	count : 10000,

	L : {},

	H : {},  //记录 占了多少行

	label : '',

	post : '',

	department: '',
	
	itemWidth : 0,

	pointWidth: 0,

	unitHeight : 60,    //单位高度

	unitWidth  : 50,    //单位宽度

	selectedNode : {},  //当前选中的节点

	nH : new Map(), //下一节点累计高度  nextHeight

	point : {},

	isDrawed : new Map(),
	
	nodeToPoint : {},
	
	p : '',             // 父级关系     father include children

	node : '',

	executor : '',

	c : {},               // 子级关系     child belones which father
	
	insert_back_id : [],
	
	hasCaled : {},

	adjustLeft : function(id,px,first = true){
		if(first == true) flow.hasCaled = {};

		if(flow.isDrawed.get(id) == true && flow.hasCaled[id] == undefined){
			flow.hasCaled[id] = true;
			$('#' + id).css('left' , $('#' + id).offset().left + px);
			for(let i in flow.p[id]){
				flow.adjustLeft(flow.p[id][i],px,false);
			}
		}
	},

	get_H_N : function(p1,p2){
		
		if(flow.isDrawed.get(p2) == undefined){
			let tmp = flow.get_drawed_node(p2);
			if(tmp == false){
				return 0;
			}else{
				p2 = tmp;
			}
		}
		return flow.get_H_N2(p1,p2);
	},

	get_H_N2 : function(p1,p2,f = true,first = true){

		if(first) flow.hasCaled = {};

		//if(p1 == 'id27' && p2 == 'id93') alert(1);
		let r = 0;
		for(let i in flow.p[p1]){
			if(flow.isDrawed.get(flow.p[p1][i])){
				if(f){
					if(flow.hasCaled[flow.p[p1][i]] == undefined){
						flow.hasCaled[flow.p[p1][i]] = 1;
						r++;
					}
					
				}else{
					if(i > 0){
						if(flow.hasCaled[flow.p[p1][i]] == undefined){
							flow.hasCaled[flow.p[p1][i]] = 1;
							r++;
						}
					}
				}
			}else{
				break;
			}
		}
		
		if(flow.p[p1][0] == p2){
			return r;
		}else{
			
			for(let i in flow.p[p1]){
				if( flow.p[p1][i] != 'end'){
					r += flow.get_H_N2(flow.p[p1][i],p2,false,false);
				}
			}
			return r;
		}
	},

	

	get_drawed_node : function(id){
		if(flow.p[id] == undefined) return false;
		for(let i in flow.p[id]){
			if(flow.isDrawed.get(flow.p[id][i]) == true){
				return flow.p[id][i];
			}else{
				return flow.get_drawed_node(flow.p[id][i]);
			}
		}
	},

	draw : function( id ){

	

		let imgUrl = get_parent().publicUrl + '/image/flow/';
		if( $('#creator' + flow.multiIndex).length == 0 ){
			flow.container.empty().append("<div class = 'item item_creator' id = 'creator"+flow.multiIndex+"'><img src = '"+imgUrl+"creator.png'  /></div>");
		}

		flow.H[id] = -1;	
		
		let offset = $('#' + id).offset();

		if(flow.offset){
			offset.left -= flow.offset.left;
			offset.top -= flow.offset.top;
		}

		let top,left;

		

		for(let i in flow.p[id]){

			flow.H[id]++;

			let N = flow.node[flow.p[id][i]];  //节点id的 next 节点
			
			if(N.S == 'p'){
	
				if(flow.node[id].D > 0){
					top  = offset.top  + flow.H[id] * flow.unitHeight + 17;   
				}else{
					top  = offset.top  + flow.H[id] * flow.unitHeight + 16;   
				}

				if(flow.node[id].S == 'n'){
					// 块 => 点
					left = offset.left + $('#'+id).width() + flow.unitWidth / 2;
					
				}else{
					left = offset.left + $('#'+id).width() + flow.unitWidth / 2;
					top  = offset.top  + flow.H[id] * flow.unitHeight ;  
					// 点 => 点
				}

				if(flow.isDrawed.get(flow.p[id][i]) == true){
					if(left > $('#' + flow.p[id][i]).offset().left){
						let tmp = left - $('#' + flow.p[id][i]).offset().left;
						flow.adjustLeft(flow.p[id][i],tmp);
					}
					continue;
				}
				
				flow.container.append("<div class = 'point' style = 'top:"+top+"px;left:"+left+"px' id = '"+N.id+"'></div>");
				flow.isDrawed.set(flow.p[id][i],true);
				
				let tmp = flow.draw(N.id);
				flow.H[id] += tmp;
				continue;

			}
			
			//只有在画NODE的时候，才考虑nH
			
			let nextId;

			if(N.id != 'end' && N.id.substring(0,5) != 'nextN'){
				nextId = flow.p[N.id][0];
			}
			
			let HNum = 0;	
			if(N.S == 'n'){
				if(N.id != 'end' && id != 'end' && N.id.substring(0,5) != 'nextN' && id.substring(0,5) != 'nextN' ){
					HNum = flow.get_H_N(id,flow.p[N.id][0]);
					
				} 
			}
				
			if(flow.node[id].S == 'p'){
				if(N.D > 0 ){
					top  = offset.top + HNum * flow.unitHeight - 17;
				}else{
					top  = offset.top + HNum * flow.unitHeight - 16;
				}
				left = offset.left + $('#' + id).width()  + flow.unitWidth / 2;
			}else{
				top  = offset.top  + flow.nH.get(nextId) * flow.unitHeight;
				left = offset.left + $('#'+id).width() + flow.unitWidth;
			}

			let tmp2 = N['D'] == 0?'_noreach':'';

			

			if(N['id'].substring(0,3) == 'end'){
				flow.container.append("<div  style = 'width:60px;top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"' data-key = '' id = 'end'>结束</div>");
			}else if(N['id'].substring(0,5) == 'nextN'){
				flow.container.append("<div  style = 'width:60px;top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"' data-key = '' id = 'nextN"+flow.multiIndex+"'>...</div>");
			}else if(N['T'] == 'P'){
				flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"' data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"person"+tmp2+".png' class = 'icon1' title = '个人' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+N['V']+"</div></div></div>");
				
			}else if(N['T'] == 'R'){
				if(N['V'] == 'F'){
					flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"'  data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"leader"+tmp2+".png' class = 'icon2' title = '分管领导' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+N['B']+"</div></div></div>");
				}else{
					flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"'  data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"leader"+tmp2+".png' class = 'icon2' title = '部门主管' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+N['B']+"</div></div></div>");
				}
			}else if(N['T'] == 'G'){
				flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"' data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"post"+tmp2+".png' class = 'icon1' title = '岗位' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+N['V']+"</div></div></div>");
			}else if(N['T'] == 'D'){
				flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"' data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"department"+tmp2+".png' class = 'icon1' title = '部门' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+N['V']+"</div></div></div>");
				
			}else if(N['T'] == 'Z'){
				flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"' data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"group"+tmp2+".png' class = 'icon1' title = '组' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+N['V']+"</div></div></div>");
				
			}else if(N['T'] == 'X'){
				let tmp = '';
				if(N['K'] == 2 || N['K'] == 4){
					
					if(N['K'] == 2){
						tmp = "发起者部门<br />分管领导";
					}else{
						tmp = '执行者部门<br />分管领导';
					}

					flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"'  data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"leader"+tmp2+".png' class = 'icon3' title = '"+N['K']+"' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+tmp+"</div></div></div>");
				}else if(N['K'] == 1 || N['K'] == 3){
					
					if(N['K'] == 1){
						tmp = "发起者<br />部门主管";
					}else{
						tmp = '执行者<br />部门主管';
					}

					flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"'  data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"leader"+tmp2+".png' class = 'icon3' title = '"+N['V']+"' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+tmp+"</div></div></div>");
				}else if(N['K'] == 9){
					flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"'  data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"null"+tmp2+".png' class = 'icon2' title = '空' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+N['V']+"</div></div></div>");
				}else if(N['K'] == 5){
					flow.container.append("<div style = 'top:"+top+"px;left:"+left+"px' class = 'item done-status"+N['D']+"'  data-key = '"+N['K']+"' id = '"+N['id']+"'><div class = 'item-in-icon'><img src = '"+imgUrl+"person"+tmp2+".png' class = 'icon2' title = '发起者' /></div><div  class = 'item-in' ><div class = 'item-in-text'>"+N['V']+"</div></div></div>");
				}
			}

			flow.isDrawed.set(flow.p[id][i],true);
			
			if(typeof flow.p[N.id] != 'undefined'){
				let tmp = flow.draw(N.id);
			}
		}
		
		
	},


	insert_node : function(node ,type , ID = 0 ,isDraw = false , addBranch = 0 ,focus,back = false){ // 1.并发   2.串发

		if(addBranch == 0){
			
			let startNodeId;

			if(ID == 0){
				startNodeId = $(flow.selectedNode).prop('id');
			}else{
				startNodeId = ID;
			}

			
			
			if(type == 1){        //并发
				let point1,point2;
				point1 = {
					'id' : flow.get_id(),
					'S' : 'p',
				};
				flow.node[point1.id] = point1;
				let nextId = flow.p[startNodeId][0];
				if(flow.node[nextId]['S'] == 'n'){
					point2 = {
						'id' : flow.get_id(),
						'S' : 'p',
					};
					flow.node[point2.id] = point2;
					flow.p[point2.id] = [];
					flow.p[point2.id].push(nextId);
				}else{
					point2 = flow.node[nextId];	
				}
				flow.p[startNodeId] = [];
				flow.p[startNodeId].push(point1.id);
				flow.p[point1.id] = [];

				for(let i in node){
					node[i]['S'] = 'n',
					node[i]['X'] = [];
					node[i]['C'] = flow.defaultJdqx;
					node[i]['id']   = flow.get_id();
					flow.p[node[i]['id']] = [];
					flow.p[node[i]['id']].push(point2.id);
					flow.node[node[i]['id']] = node[i];
					flow.p[point1.id].push(node[i]['id']);
				}
			}else{
				for(let i in node){
					node[i]['S'] = 'n',
					node[i]['X'] = [];
					node[i]['C'] = flow.defaultJdqx;
					node[i]['id']   = flow.get_id();
					let a = [];
					a.push(node[i]);
					flow.insert_node(a,1,startNodeId,false);
					startNodeId = node[i]['id'];
				}
			}
		}else{
			let nextP = flow.p[ID][0];
			if( back == true){
				let me = {
					'C' : 1,
					'K' : '{$Think.session.userinfo.username}',
					'V' : '{$Think.session.userinfo.name}',
					'T' : 'P',
					'S' : 'n',
					'Z' : 1,
					'id' : flow.get_id()
				};

				let tmpP = {
					'id' : flow.get_id(),
					'S'  : 'p',
				};

				flow.node[tmpP.id] = tmpP;
				flow.node[me.id] = me;

				for(let i in node){
					node[i]['S'] = 'n',
					node[i]['Z'] = 1;
					node[i]['X'] = [];
					node[i]['id']   = flow.get_id();
					flow.node[node[i]['id']] = node[i];
					flow.p[nextP].push(node[i]['id']);

					flow.p[node[i]['id']] = [];
					flow.p[node[i]['id']].push(tmpP.id);
					
				}
				flow.p[tmpP.id] = [me.id];
				flow.p[me.id] = [focus];
			}else{
				for(let i in node){
					node[i]['S'] = 'n',
					node[i]['Z'] = 1;
					node[i]['X'] = [];
					node[i]['id']   = flow.get_id();
					flow.node[node[i]['id']] = node[i];
					flow.p[nextP].push(node[i]['id']);

					flow.p[node[i]['id']] = [];
					flow.p[node[i]['id']].push(focus);
					
				}
			}
		}
		if(isDraw) flow.re_draw();
	},

	
	get_id : function(){
		return 'id' + flow.count++;
	},

	get_next_n : function(nodeId){
		let a = [];
		for(let i in flow.p[nodeId]){
			if( flow.node[flow.p[nodeId][i]]['S'] == 'p' ){
				a.push.apply( a,flow.get_next_n( flow.p[nodeId][i] ) );
			}else{
				a.push( flow.p[nodeId][i] );
			}
		}
		return a;
	},

	get_next_p : function (nodeId){
		let a = [];
		for(let i in flow.p[nodeId]){
			if( flow.node[flow.p[nodeId][i]]['S'] == 'p' ){
				a.push( flow.p[nodeId][i] );
			}
			if(nodeId != 'end') a.push.apply( a,flow.get_next_p( flow.p[nodeId][i] ) );
		}
		return a;
	},

	handleStopId : function(stopId){
		var p = [];
		$.each(flow.p,function(k,v){
			for(let i = 0; i < v.length ; i++){
				if( v[i] == stopId ){
					p.push( k );
				}
			}
		});
		for(let i = 0; i < p.length; i++){
			if( flow.p[p[i]].length > 1 ){
				flow.p[p[i]] = [ stopId ];
			}
		}
		
		
	},

	handleStopId2 : function(stopId){

		let tmp = '';
	
		$.each(flow.p,function(k,v){

			
			for( let i = 0; i < v.length; i++){
				if( v[i] == stopId ){
					let a = [];
					a.push(stopId);
					
					flow.tmpP[k] = a;
					
					tmp = k;
					return false;
				}
			}
		});
		
		if( stopId.substring(0,5) != 'crea' && tmp != ''){
			flow.handleStopId2(tmp);
		}


		
	},
	

	ini : function(obj = {} ){

		if( obj.multiIndex ){
			let tmpNode = {}, tmpP = {};
			$.each(obj.node ,function(k,v){
				tmpNode[ k + obj.multiIndex ] = v;
			});

			$.each(obj.p , function(k,v){
				tmpP[ k + obj.multiIndex ] = [];
				for(let i = 0; i < v.length; i++){
					tmpP[ k + obj.multiIndex ].push( v[i] + obj.multiIndex );
				}
			});

			obj.node = tmpNode;
			obj.p = tmpP;

			obj.stopId = obj.stopId + obj.multiIndex;
		}
		
		
		
		$.each( obj ,function(i,v){
			flow[i] = v;
		});


		


		
		for(let i in flow.node){
			flow.node[i].id = i;
		}
	
	
		if( obj.stopId ){
			
			flow.handleStopId( obj.stopId );
			flow.p[ obj.stopId ] = [ 'nextP' + obj.multiIndex ];
			flow.p[ 'nextP' + obj.multiIndex] = ['nextN' + obj.multiIndex];
			flow.node[ 'nextP' + obj.multiIndex] = { S:'p' , D:0, id:'nextP'  + obj.multiIndex };
			flow.node[ 'nextN' + obj.multiIndex] = { S:'n' , D:0, id:'nextN'  + obj.multiIndex, T:'P', V:'...'};
			flow.tmpP = {};
			flow.handleStopId2( 'nextN' + obj.multiIndex );


		

			flow.p = flow.tmpP;

			

			


		}

		

		if(top.tmp2 != undefined && top[top.tmp2] != undefined ){
			if(top[top.tmp2].flow.add.length > 0){
				for(let i in top[top.tmp2].flow.add){
					let tmp = top[top.tmp2].flow.add[i];
					alert('test');
					let nodeId = '{$Request.get.nodeid}';
					if(tmp[1] == 1 || tmp[1] == 2){
						flow.insert_node(tmp[0],tmp[1],nodeId);

						
					}else{
						let tmp1 = flow.p[nodeId];
						let nextN = flow.get_next_n(nodeId);
						let nextP = [];
						for(let j in nextN){
							nextP.push(flow.get_next_p(nextN[j]));
						}
						let focus;
						let find ;
						for(let j in nextP[0]){
							focus = nextP[0][j];
							find = true;
							for(let k = 1; k < nextP.length; k++){
								if( $.inArray(focus,nextP[k]) === -1 ){
									find = false;
									break;
								}
							}
							if (find){
								break;
							}
						}
						
						//insert_node : function(node ,type , ID = 0 ,isDraw = false , addBranch = 0 , focus){ // 1.并发   2.串发
						flow.insert_node(tmp[0],1,nodeId,false,1,focus,tmp[2]);
						
					}
					
				}
			}
		}
		
		flow.re_draw();

	},

	

	

	get_prev_id : function(id){
		let prev = [];
		for(let i in flow.p){
			for(let j in flow.p[i]){
				if(flow.p[i][j] == id){
					prev.push(i);
					found = true;
					break;
				}
			}
		}
		return prev;
	},
	
	

	add_x : function(){
		let imgUrl = get_parent().publicUrl + '/image/flow/';
		for(let i in flow.node){
			if(flow.node[i].S == 'p' || flow.node[i].D == -1) continue;
			if(flow.node[i].X == undefined || flow.node[i].X.length == 0 || $('#' + i).length == 0) continue;
			let offset = $('#' + i).offset();
			let left = offset.left - 16;
			let top  = offset.top ;
			if(flow.offset){
				left -= flow.offset.left;
				top  -= flow.offset.top;
			}

			let tmp;
			if( flow.node[i]['E'] != undefined){
				flow.container.append("<img id = 'x"+i+"' src = '"+imgUrl+"if.png' style = 'cursor:pointer;height:16px;position:absolute;left:"+left+"px;top:"+top+"px' />");
				$('#x' + i).hover(function(){
					tmp = layer.tips("分支说明：<br />" + flow.node[i]['E'], '#' + i, {
					  time : 100000,
					  tips: [3, '#1296db']
					})
				},function(){
					layer.close(tmp);
				});
			}else{
				if(flow.node[i]['X'] != undefined && flow.node[i]['X'].length > 0){
					flow.container.append("<img id = 'x"+i+"' src = '"+imgUrl+"if.png' style = 'cursor:pointer;height:16px;position:absolute;left:"+left+"px;top:"+top+"px' />");
					let c = "";
					tmp = flow.node[i]['X'][0];
					if(tmp[1] == 'aya1'){
						let tmp2 = tmp[3].substr(0,tmp[3].length - 2);
						c = "发起者部门" + (tmp[2]=='=='?'=':tmp[2]) +  flow.department[tmp2].name;
					}else if(tmp[1] == 'aya2'){
						let tmp2 = tmp[3].substr(0,tmp[3].length - 2);
						c = "发起者岗位" + (tmp[2]=='=='?'=':tmp[2]) +  flow.post[tmp2].name;
					}else if(tmp[1] == 'aya3'){
						let tmp2 = tmp[3].substr(0,tmp[3].length - 2);
						c = "执行者部门" + (tmp[2]=='=='?'=':tmp[2]) +  flow.department[tmp2].name;
					}else if(tmp[1] == 'aya4'){
						let tmp2 = tmp[3].substr(0,tmp[3].length - 2);
						c = "执行者部门" + (tmp[2]=='=='?'=':tmp[2]) +  flow.post[tmp2].name;
					}else{
						if(tmp.length == 6){  // checkbox or radio
							if(flow.enumI[tmp[1]]){
								c = flow.label[tmp[1]] +  (tmp[2]=='=='?'=':tmp[2]) +  flow.enum[ tmp[3] ];
							}else{
								c = flow.label[tmp[1]] +  (tmp[2]=='=='?'=':tmp[2]) +  tmp[3];
							}
						}else{
							c = flow.label[tmp[1]] +  (tmp[2] == 1?'被选中':'未选中');
						}
					}
					let c1 = '';
					if(flow.node[i]['X'].length > 1){
						for(let j in flow.node[i]['X']){
							let tmp2 = flow.node[i]['X'][j];
							
							let last = tmp2[tmp2.length - 1];

							if(last == '&&'){
								tmp2[tmp2.length - 1] = "<span style = 'color:#ff9900'> 并且 </span>";
							}else if(last == '||'){
								tmp2[tmp2.length - 1] = "<span style = 'color:#ff9900'> 或者 </span>";
							}


							if(tmp2[1] == 'aya1'){
								c1 += tmp2[0] + "发起者部门" + (tmp2[2]=='=='?'=':tmp2[2]) + flow.department[tmp2[3].substr(0,tmp2[3].length -2)].name + tmp2[4] + tmp2[5] + " ";
							}else if(tmp2[1] == 'aya2'){
								
								c1 += tmp2[0] + "发起者岗位" + (tmp2[2]=='=='?'=':tmp2[2]) + flow.post[tmp2[3]].name + tmp2[4] + tmp2[5] + " ";
							}else if(tmp2[1] == 'aya3'){
								c1 += tmp2[0] + "执行者岗位" + (tmp2[2]=='=='?'=':tmp2[2]) + flow.department[tmp2[3].substr(0,tmp2[3].length -2)].name + tmp2[4] + tmp2[5] + " ";
							}else if(tmp2[1] == 'aya4'){
								c1 += tmp2[0] + "执行者部门" + (tmp2[2]=='=='?'=':tmp2[2]) + flow.post[tmp2[3]].name + tmp2[4] + tmp2[5] + " ";
							}else{
								if(tmp2.length == 6){
									if(flow.enumI[tmp[1]]){
										c1 +=  tmp2[0] + flow.label[tmp2[1]] + (tmp2[2]=='=='?'=':tmp2[2]) + flow.enum[tmp2[3]] + tmp2[4] + tmp2[5] + " ";
									}else{
										c1 +=  tmp2[0] + flow.label[tmp2[1]] + (tmp2[2]=='=='?'=':tmp2[2]) + tmp2[3] + tmp2[4] + tmp2[5] + " ";
									}
								}else{
									
									c1 += tmp2[0] + flow.label[tmp2[1]] +  (tmp2[2] == 1?'被选中':'未选中') + tmp2[3] + tmp2[4];
								}

							}
						}
					}
					let title = '';
					if(flow.node[i]['X'].length > 1){
						
						$('#x' + i).hover(function(){
							tmp = layer.tips("分支说明：<br />" + c1, '#' + i, {
							  time : 100000,
							  tips: [3, '#1296db']
							})
						},function(){
							layer.close(tmp);
						});
					}else{
						$('#x' + i).hover(function(){
							tmp = layer.tips("分支说明：<br />" + c, '#' + i, {
							  time : 100000,
							  tips: [3, '#1296db']
							})
						},function(){
							layer.close(tmp);
						});
					}
					



				}
			}

			

		}
	},


	add_hover : function(){
		for(let i in flow.node){
			if(flow.node[i].S == 'p' || flow.node[i].D == -1) continue;
			if(flow.executor[i] == undefined) continue;
			let tmp;
			let content = '';
			if(flow.node[i].Z == 1){
				content += "单人执行</br>";	
			}else if(flow.node[i].Z == 2){
				content += "多人执行</br>";	
			}else if(flow.node[i].Z == 3){
				content += "全体执行</br>";	
			}else if(flow.node[i].Z == 4){
				content += "竞争执行</br>";	
			}

		
			for(let j in flow.executor[i]){
				content += "<div><div style = 'display:inline-block;width:50px' >" + flow.executor[i][j]['name'] + "</div>" +  flow.executor[i][j]['status'] + "</div>";
			}
			$('#' + i).hover(function(){
				tmp = layer.tips(content, '#' + i, {
				  time : 100000,
				  tips: [3, '#4cae4c']
				})
			},function(){
				layer.close(tmp);
			});

			
			
		}
	},


	re_get_c : function(){
		flow.c = {};
		for(let i in flow.p){
			for(let j in flow.p[i]){
				if(flow.c[flow.p[i][j]] == undefined){
					flow.c[flow.p[i][j]] = [];
				}
				if(flow.node[i] != undefined) flow.c[flow.p[i][j]].push(i);
			}
		}
	},

	

	re_draw:function(){
		
		flow.hasConnected = new Map();

		flow.nH = new Map();

		flow.container.empty();

		flow.isDrawed = new Map();
	
		flow.re_get_c();

		let needReGetC = false;

		let tmpId = 1;
		
		for(let i in flow.node){
			let nodeId = flow.node[i]['id'];
			if(flow.p[nodeId] != undefined && flow.p[nodeId].length > 1 && flow.c[nodeId] != undefined && flow.c[nodeId].length > 1){
				let newPoint = {
					'S' : 'p',
					'id' : 'tmp' + tmpId,
					'D' : flow.node[nodeId]['D']
				};
				flow.node[i]['noaddbranch'] = 1;
				flow.node[newPoint.id] = newPoint;
				flow.p[newPoint.id] = flow.p[nodeId];
				flow.p[nodeId] = [];
				flow.p[nodeId].push(newPoint.id	);
				needReGetC = true;
				tmpId++;
			}
		}

		if(needReGetC) flow.re_get_c();



		for(let i in flow.node){
			
			if(flow.node[i]['S'] == 'n' || !flow.p[i] ) continue;
			
			if(flow.node[flow.p[i][0]]['S'] == 'p'){
				if(flow.c[i].length == 1 || flow.p[flow.p[i][0]].length == 1){
					if(flow.p[flow.p[i][0]].length == 1){
						let tmp = flow.p[i][0];
						let prev = flow.c[tmp][0];
						flow.p[prev] = flow.p[tmp];
						delete flow.node[tmp];
						delete flow.p[tmp];
					}else{
						let prev = flow.c[i][0];
						flow.p[prev] = flow.p[i];
						delete flow.node[i];
						delete flow.p[i];
					}
				}
			}
		}
		

		flow.draw( 'creator' + flow.multiIndex );


		
		
		//整体右移
		
		if(!flow.offset){
			
			let tmp = (($(window).width() - $('#end').offset().left + $('#end').width() - $('#creator').offset().left)/2 - $('#creator').offset().left) / 3;
		
			if(tmp > 0){
				$('div.item').each(function(){
					$(this).css('left',$(this).offset().left + tmp);
				});
				$('div.point').each(function(){
					$(this).css('left',$(this).offset().left + tmp);
				});
				$('div.point2').each(function(){
					$(this).css('left',$(this).offset().left + tmp);
				});
			}
		}

		

		flow.add_x();

		flow.add_hover();

		flow.createLine('creator' + flow.multiIndex);
	
	},
	

	createDiv : function(top,left,width,height,borderColor){
		let div;
		if(borderColor == '#4cae4c'){

			if(height == 0){
				div = "<div style = 'position:absolute;top:"+top+"px;left:"+left+"px;width:"+width+"px;height:"+height+"px;border-top:2px solid "+borderColor+"'></div>";
			}else{
				div = "<div style = 'position:absolute;top:"+top+"px;left:"+left+"px;width:"+width+"px;height:"+height+"px;border-left:2px solid "+borderColor+"'></div>";
			}

			
		}else{
			if(height == 0){
				div = "<div style = 'position:absolute;top:"+top+"px;left:"+left+"px;width:"+width+"px;height:"+height+"px;border-top:1px solid "+borderColor+"'></div>";
			}else{
				div = "<div style = 'position:absolute;top:"+top+"px;left:"+left+"px;width:"+width+"px;height:"+height+"px;border-left:1px solid "+borderColor+"'></div>";
			}
		}
		
		flow.container.append(div);
	},
	createLine : function(id){
		for(let i in flow.p[id]){
			let color = '#4cae4c';
			tmpWidth = 2;
			if(flow.node[id]['D'] != 2){
				color = '#959595';
				tmpWidth = 1;
			}
			let o1 = $('#' + id).offset();
			let o2 = $('#' + flow.p[id][i]).offset();
	

			if(flow.offset){
				o1.left -= flow.offset.left;
				o1.top  -= flow.offset.top;
				o2.left -= flow.offset.left;
				o2.top  -= flow.offset.top;
			}

			let h1 = $('#' + id).outerHeight();
			let h2 = $('#' + flow.p[id][i]).outerHeight();
			

			let w1 = $('#' + id).outerWidth();
			let w2 = $('#' + flow.p[id][i]).outerWidth();

			let tmp1 = o1.top +  h1 / 2;
			let tmp2 = o2.top +  h2 / 2;
			
			let top,left,width,height,div;

			if(tmp1 == tmp2){

				top = tmp1;
				left = o1.left + w1;
				width = o2.left - o1.left - w1 ;
				flow.createDiv(top,left,width,0,color);
				
			}else if(tmp1 < tmp2){
			
				
				top = tmp1;
				left = o1.left + w1 / 2;

			
				height = o2.top + h2 / 2 - o1.top - h1 / 2;
			
				flow.createDiv(top,left,0,height,color);
				
				top = tmp2;
				left = left + w1;
				width = o2.left - o1.left - w1 / 2;
				flow.createDiv(top,left,width,0,color);
				

			}else{
				top = tmp1;
				left = o1.left + w1;
				width = o2.left - o1.left - w1 + tmpWidth ;
				flow.createDiv(top,left,width,0,color);

				top = o2.top;
				left = o2.left;
				height = tmp1 - tmp2  ;
				
				flow.createDiv(top,left,0,height,color);
			}
			if(flow.p[flow.p[id][i]] != undefined){
				flow.createLine(flow.p[id][i]);
			}

		}
	},

	
};


