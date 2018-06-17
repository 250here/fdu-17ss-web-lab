<html>
<head>
<base id="myBaseId" href="" />
<title>LRC 歌词编辑器</title>
<style>
   #lyric::selection{
	   color:grey;
	   background-color:white;
   }
    nav ul {
        position: fixed;
        z-index: 99;
        right: 5%;
        border: 1px solid darkgray;
        border-radius: 5px;
        list-style:none;
        padding: 0;
    }

    .tab {
        padding: 1em;
        display: block;
    }

    .tab:hover {
        cursor: pointer;
        background-color: lightgray !important;
    }

    td {
        padding:0.2em;
    }

    textarea[name="edit_lyric"] {
        width: 100%;
        height: 50em;
    }

    input[type="button"] {
        width: 100%;
        height: 100%;
    }

    input[type="submit"] {
        width: 100%;
        height: 100%;
    }

    #td_submit {
        text-align: center;
    }

    select {
        display: block;
    }

    #lyric {
		color:black;
        width: 35%;
        height: 60%;
        border: 0;
        resize: none;
        font-size: large;
        line-height: 2em;
        text-align: center;
    }
	.storage{
		display:none;
	}
</style>
</head>
<body>
    <!--pj截止日期临近，实在是做不完了，十分抱歉。歌词滚动没有做，没有高亮显示（textarea高亮显示一行我实在是做不到啊555555555）-->
    <?php
	    
		$dhmusic = opendir("upload/musics/");
	    if($dh = opendir("upload/lrcs/")){
			while (($file = readdir($dh)) !== false){
				if($file != '.' && $file != '..'){
					$formart;
					if(is_file("upload/musics/" . substr($file,0,strlen($file)-4) . '.mp3')){$formart='.mp3';}
					if(is_file("upload/musics/" . substr($file,0,strlen($file)-4) . '.wav')){$formart='.wav';}
					if(is_file("upload/musics/" . substr($file,0,strlen($file)-4) . '.ogg')){$formart='.ogg';}
					$myfile = fopen("upload/lrcs/" . $file, "r");
					echo '<textarea class="storage" id="' . $file . '" name="' . $formart . '">' . fread($myfile,filesize("upload/lrcs/".$file)) . '</textarea>';
					fclose($myfile);
				}
			}
			closedir($dh);
        }
		closedir($dhmusic);
	?>
    <nav><ul>
        <li id="d_edit" class="tab">Edit Lyric</li>
        <li id="d_show" class="tab">Show Lyric</li>
    </ul></nav>

<!--歌词编辑部分-->
<section id="s_edit" class="content">
<form id="f_upload" enctype="multipart/form-data" action="lab11.php" method="post">
    <p>请上传音乐文件</p>
	
	<audio id="audio" src="" autoplay=true controls='controls'>
	   Your browser does not support HTML5 video.
	</audio>
    <!--TODO: 在这里补充 html 元素，使 file_upload 上传后若为音乐文件，则可以直接播放-->

    <input type="file" name="file_upload" id="file_upload">
    <table>
        <tr><td>Title: <input type="text" name="edit_title"></td><td>Artist: <input type="text" name="edit_artist"></td></tr>
        <tr><td colspan="2"><textarea name="edit_lyric" id="edit_lyric"></textarea></td></tr>
        <tr><td><input id="insert" type="button" value="插入时间标签"></td><td><input id="replace" type="button" value="替换时间标签"></td></tr>
        <tr><td colspan="2" id="td_submit"><input type="submit" value="Submit"></td></tr>   
    </table>
</form>
</section>

<!--歌词展示部分-->
<section id="s_show" class="content">
    <audio id="audio2" src="" autoplay=true controls='controls'>
	   Your browser does not support HTML5 video.
	</audio><br/>
    <select id="selectsong">
    <!--TODO: 在这里补充 html 元素，使点开 #d_show 之后这里实时加载服务器中已有的歌名-->
   
    </select><br/>
    <label id="show_ti"></label><br/><label id="show_ar"></label><br/>
    <textarea id="lyric" readonly="true" >
    </textarea>
	<br/>
	<button id='up' disabled="disabled">上一首</button> <button id='down' disabled="disabled" >下一首</button>
    <!--TODO: 在这里补充 html 元素，使选择了歌曲之后这里展示歌曲进度条，并且支持上下首切换-->

</section>
<?php
		if(count($_POST)>0){
			$name=substr($_FILES["file_upload"]["name"],0,strlen($_FILES["file_upload"]["name"])-4);
		    if (file_exists("upload/musics/" . $_FILES["file_upload"]["name"])){
				//unlink($_FILES["file_upload"]["tmp_name"],"upload/lrcs/" . $name . '.lrc');
				//unlink($_FILES["file_upload"]["tmp_name"],"upload/musics/" . $_FILES["file_upload"]["name"]);
            } else{
                move_uploaded_file($_FILES["file_upload"]["tmp_name"],"upload/musics/" . $_FILES["file_upload"]["name"]);
		    }
			$lrc_content = '[ti:' . $_POST['edit_title'] . "]\r\n";
			$lrc_content .= '[ar:' . $_POST['edit_artist'] . "]\r\n";
			$lrc_content .= $_POST["edit_lyric"];
			$lrcfile = fopen("upload/lrcs/" . $name . ".lrc", "w");
			fwrite($lrcfile,$lrc_content);
			fclose($lrcfile);
		};
	?>
</body>
<script>
     
    var allsongs=[];
    var src;
	var songs=[];//0名字，1标题，2作者，3歌词，4格式
	var lrcs=[];
	var select=document.getElementById("selectsong");
	var edit_lyric=document.getElementById("edit_lyric");

// 界面部分
document.getElementById("d_edit").onclick = function () {click_tab("edit");document.getElementById("audio2").src="";};
document.getElementById("d_show").onclick = function () {click_tab("show");refreshlist();play(0)};
document.getElementById("insert").onclick = function () {click_insert();};
document.getElementById("file_upload").onchange = function () {file_add();};
document.getElementById("up").onclick = function () {play(selectedIndex-1);};
document.getElementById("down").onclick = function () {play(selectedIndex+1);};
function play(index){
	let audio2=document.getElementById("audio2");
	select.selectedIndex=index;
	if(index==0){
		document.getElementById("up").disabled="disabled";
		document.getElementById("down").disabled="value";
	}else if(index==songs[0].length-1){
		document.getElementById("up").disabled="value";
		document.getElementById("down").disabled="disabled";
	}else{
		document.getElementById("up").disabled="value";
		document.getElementById("down").disabled="value";
	}
	audio2.src="upload/musics/"+songs[0][index]+songs[4][index];
	let lyriccontent="";
	for(let i=0;i<songs[3][index].length/2;i++){
		lyriccontent+=songs[3][index][i+songs[3][index].length/2]+"\n";
	}
	document.getElementById("lyric").value=lyriccontent;
	document.getElementById("lyric").name=index;
	document.getElementById("show_ti").innerHTML=" Title:"+songs[1][index];
	document.getElementById("show_ar").innerHTML=" Artist:"+songs[2][index];
}
window.onload=function(){
	function getlrc(texts){
		let lrc=[];
		for(let i=2;i<texts.length;i++){
			let text=texts[i].replace("[","").split("]");
			let times=text[0].split(":");
			lrc[i-2]=3600*times[0]+60*times[1]+times[3];
			lrc[i-2+texts.length-2]=text[1];
		}
		return lrc;
	}
	for(let i=0;i<5;i++){songs[i]=[];}
	let storages=document.getElementsByClassName("storage");
	for(let i=0;i<storages.length;i++){
		let name=storages[i].id;
		songs[0][i]=name.substring(0,name.length-4);
		let texts=storages[i].value.split("\n");
		songs[1][i]=texts[0].replace("[ti:","").replace("]","");
		songs[2][i]=texts[1].replace("[ar:","").replace("]","");
		songs[3][i]=getlrc(texts);
		songs[4][i]=storages[i].name;;
	}
	refreshlist();
	

    document.getElementById("d_show").click();
	document.getElementById("lyric").seletionStart=0;
	document.getElementById("lyric").seletionEnd=3;
}
function click_insert(){
	let toInt=function(num){return (num-num%1);}
    let time=document.getElementById("audio").currentTime;
	let hour=toInt(time/3600);
	let minute=(toInt(time/60))-60*hour;
	let record=time-hour*3600-minute*60;
	let numbertostr=function(num){
	    let resultstring;
		if((num-num%1)===num){
		    resultstring=num+"";
			if(resultstring.length==1){resultstring="0"+resultstring;}
		}else{
		    let numberObj=new Number(num);
		    resultstring=numberObj.toFixed(2);
			if(resultstring.length==4){resultstring="0"+resultstring;}
		}
		return resultstring;
	}
	let index=get_target_pos();
	let value=edit_lyric.value;
	edit_lyric.value=value.substring(0,index)+"["+numbertostr(hour)+":"+numbertostr(minute)+":"+numbertostr(record)+"]"+value.substring(index,value.length);
}
function refreshlist(){
	if(songs.length==0){return 0;}
    select.innerHTML="";
    for(let i=0;i<songs[0].length;i++){
	    select.innerHTML=select.innerHTML+"<option>"+songs[0][i]+"</option>";
	}
	
}
function file_add(){
    let truepath = document.getElementById("file_upload").files[0];
    let path=document.getElementById("file_upload").value;
	let formats=".ogg.wav.mp3";
	if(path.split(".").length==0){
	    document.getElementById("file_upload").value="";
	    alert("对不起，不支持该格式。");
		return;
	}
	let format=path.split(".").pop().toLowerCase();
	if(format=="ogg"||format=="wav"||format=="mp3"){
	    src=document.getElementById("audio").src=window.URL.createObjectURL(truepath);;
	}else{
	    document.getElementById("file_upload").value="";
	    alert("对不起，不支持该格式。");
	}
	
}
function click_tab(tag) {
    for (let i = 0; i < document.getElementsByClassName("tab").length; i++) document.getElementsByClassName("tab")[i].style.backgroundColor = "transparent";
    for (let i = 0; i < document.getElementsByClassName("content").length; i++) document.getElementsByClassName("content")[i].style.display = "none";

    document.getElementById("s_" + tag).style.display = "block";
    document.getElementById("d_" + tag).style.backgroundColor = "darkgray";
} 

// Edit 部分
var edit_lyric_pos = 0;
document.getElementById("edit_lyric").onmouseleave = function () {
    edit_lyric_pos = document.getElementById("edit_lyric").selectionStart;
};

// 获取所在行的初始位置。
function get_target_pos(n_pos) {
    if (n_pos === undefined) n_pos = edit_lyric_pos;
    let value = document.getElementById("edit_lyric").value; 
    let pos = 0;
    for (let i = n_pos; i >= 0; i--) {
        if (value.charAt(i) === '\n') {
            pos = i + 1;
            break;
        }
    }
    return pos;
}

// 选中所在行。
function get_target_line(n_pos) {
    let value = document.getElementById("edit_lyric").value; 
    let f_pos = get_target_pos(n_pos);
    let l_pos = 0;

    for (let i = f_pos;; i++) {
        if (value.charAt(i) === '\n') {
            l_pos = i + 1;
            break;
        }
    }
    return [f_pos, l_pos];
}

/* HINT: 
 * 已经帮你写好了寻找每行开头的位置，可以使用 get_target_pos()
 * 来获取第一个位置，从而插入相应的歌词时间。
 * 在 textarea 中，可以通过这个 DOM 节点的 selectionStart 和
 * selectionEnd 获取相对应的位置。
 *
 * TODO: 请实现你的歌词时间标签插入效果。
 */

/* TODO: 请实现你的上传功能，需包含一个音乐文件和你写好的歌词文本。
 */

/* HINT: 
 * 实现歌词和时间的匹配的时候推荐使用 Map class，ES6 自带。
 * 在 Map 中，key 的值必须是字符串，但是可以通过字符串直接比较。
 * 每一行行高可粗略估计为 40，根据电脑差异或许会有不同。
 * 当前歌词请以粗体显示。
 * 从第八行开始，当歌曲转至下一行的时候，需要调整滚动条，使得当前歌
 * 词保持在正中。
 *
 * TODO: 请实现你的歌词滚动效果。
 */

</script>
</html>
