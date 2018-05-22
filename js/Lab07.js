var select1,select2,button1,div1,underdiv1,div2;
var currentTable;
var tables=[];
const FUNCTIONSFORSELECT1=[function(){
	underdiv1.innerHTML="";
	button1.style.display="none";
	button1.onclick=function(){
		let table=[];
		let row=[];
		let length=document.getElementById("colNumber").value;
		for(let i=0;i<length;i++){
			row[i]=document.getElementById("attribute"+i).value;
		}
		table[0]=row;
		table[1]=document.getElementById("tableName").value;
		tables[tables.length]=table;
		select2.innerHTML=select2.innerHTML+"<option>"+tables[tables.length-1][tables[tables.length-1].length-1]+"</option>";
		select2.selectedIndex=tables.length;
		div2.innerHTML=FUNCTIONSFORCHANGE.getTableCode();
	}
	div1.innerHTML="<input id='tableName' type='text' placeholder='Table Name'><input id='colNumber' type='number' placeholder='Columns Numbers'>";
	document.getElementById("colNumber").onchange=FUNCTIONSFORCHANGE.check1whencreate;
	document.getElementById("tableName").onchange=FUNCTIONSFORCHANGE.check1whencreate;
},function(){
	if(select2.selectedIndex==0){
		button1.style.display="none";
		return;
	}
	let table=tables[select2.selectedIndex-1];
	button1.onclick=function(){
		if(select2.selectedIndex==0){
			return;
		}
		let row=[];
		for(let i=0;i<table[0].length;i++){
			row[i]=document.getElementById("attribute"+i).value;
		}
		table.splice(table.length-1,0,row);
		div2.innerHTML=FUNCTIONSFORCHANGE.getTableCode();
	}
	let content="";
	for(let i=0;i<table[0].length;i++){
		content+="<input type='text' id='attribute"+i+"' placeholder='"+table[0][i]+"'>";
	}
	div1.innerHTML=content;
},function(){
	if(select2.selectedIndex==0){
		button1.style.display="none";
	    return;
	}
	let table=tables[select2.selectedIndex-1];
	button1.onclick=function(){
		if(select2.selectedIndex==0){
			return;
		}
		let row=[];
		for(let i=0;i<table[0].length;i++){
			row[i]=document.getElementById("attribute"+i).value;
		}
		let shouldDelete=function(index){
			for(let j=0;j<table[0].length;j++){
				if((!(row[j]===""))&&(!((table[index][j]+"")===(row[j]+"")))){
					return false;
				}
			}
			return true;
		}
		for(let i=table.length-2;i>0;i--){
			if(shouldDelete(i)){
				table.splice(i,1);
			}
		}
		div2.innerHTML=FUNCTIONSFORCHANGE.getTableCode();
	}
	let content="";
	for(let i=0;i<table[0].length;i++){
		content+="<input type='text' id='attribute"+i+"' placeholder='"+table[0][i]+"'>";
	}
	div1.innerHTML=content;
},function(){
	if(select2.selectedIndex==0){
		button1.style.display="none";
	    return;
	}
	button1.style.display="inline";
	div1.innerHTML="<p>WARNING: You cannot undo this action!</p>";
	button1.onclick=function(){
		let index=select2.selectedIndex-1;
		select2.innerHTML=select2.innerHTML.replace("<option>"+tables[index].pop()+"</option>","");
		tables.splice(index,1);
		if(tables.length==0){
		    button1.style.display="none";
			select2.selectedIndex=0;
		}else{
			select2.selectedIndex=1;
		}
		div2.innerHTML=FUNCTIONSFORCHANGE.getTableCode();
	}
}];
const FUNCTIONSFORCHANGE={
getTableCode:function(){
	if(select2.selectedIndex==0){
		return "";
	}
	let content="<table>";
	let table=tables[select2.selectedIndex-1];
	for(let i=0;i<table.length-1;i++){
		content+="<tr>";
		for(let j=0;j<table[0].length;j++){
			if(i==0){
				content+="<th>"+table[i][j]+"</th>";
			}else{
				content+="<td>"+table[i][j]+"</td>";
			}
		}
	content+="</tr>";
	}
	content+="</table>";
	return content;
},
check1whencreate:function(){
	let tableName=document.getElementById("tableName").value;
	let number=document.getElementById("colNumber").value;
	if((!tableName=="")&&(number>0)){
		underdiv1.innerHTML="";
		for(let i=0;i<number;i++){
			underdiv1.innerHTML=underdiv1.innerHTML+"<input id=attribute"+i+" type='text' name='attribute' class='mark' placeholder='Attribute' onchange='FUNCTIONSFORCHANGE.check2whencreate()'>";
		}
	}else{
		underdiv1.innerHTML="";
	}
},
check2whencreate:function(){
	let b=true;
	let s=document.getElementsByClassName("mark");
	for(let i=0;i<s.length;i++){
		if(s[i].value===""){
			b=false;
		}
	}
	if(b){
		button1.style.display="inline";
	}else{
	    button1.style.display="none";
	}
}
}
window.onload=function(){
	div1=document.getElementById("div1");
	underdiv1=document.getElementById("underdiv1");
	div2=document.getElementById("div2");
	button1=document.getElementById("button1");
	select1=document.getElementById("select1");
	select2=document.getElementById("select2");
	select1.onchange=function(){
		let select1index=select1.selectedIndex;
		underdiv1.innerHTML="";
		if(select1index===0){
			button1.style.display="none";
			div1.innerHTML=div2.innerHTML="";
		}else{
			button1.style.display="inline";
			FUNCTIONSFORSELECT1[select1index-1]();
		}
    }
	select2.onchange=function(){
		let select2index=select2.selectedIndex;
		if(select2index===0){
			div1.innerHTML=underdiv1.innerHTML=div2.innerHTML="";
		}else{
			FUNCTIONSFORSELECT1[select1.selectedIndex-1]();
			div2.innerHTML=FUNCTIONSFORCHANGE.getTableCode(select2.selectedIndex-1);
		}
		if(!(select1.selectedIndex==0)){
			FUNCTIONSFORSELECT1[select1.selectedIndex-1]();
		}
	}
}