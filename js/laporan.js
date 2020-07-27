function openDir(sub1, idx){
	var url=base_url +"laporan/opendir/" +sub1;
	//alert(url);
	$.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            //console.log(data);

            if(data["status"]==true){
                var dir    = data["data"];
                var jmlData=dir.length;
                var listview = "<ul class=\"nav nav-stacked\">";
                var priv="";
                for(var i=0; i<jmlData;i++){
                	listview+='<li><a href="#" style="padding-left: 50px;" onclick="openSubdir(\''+dir[i]["dir1"]+'\',\''+dir[i]["dir2"]+'\','+idx+','+i+')"><span class="fa fa-folder"></span> '+dir[i]["dir2"];
                    listview+='<button class="pull-right badge bg-green"><span id="sub_point'+idx+'_'+i+'" class="sub_point fa fa-plus"></span></button></a>';
                    listview+='<div class="sub'+idx+'" id="sub'+idx+'_'+i+'" style="display: none;"></div></li>';
                    priv+='<a href="#" onclick="openSubdir(\''+dir[i]["dir1"]+'\',\''+dir[i]["dir2"]+'\','+idx+','+i+')"><div class="col-md-1 text-center">';
                    priv+='<img src="'+base_url+'assets/img/folder.png'+'" class="img img-responsive">';
                    priv+='<span class="text-center">'+dir[i]["dir2"]+'</span>';
                    priv+='</div></a>';
                }                  
                listview+="</ul>";
                console.log(listview);
                $('.point').removeClass("fa-minus");
                $('.point').addClass("fa-plus");
                $('.sub').hide();

                $('#point'+idx).removeClass("fa-plus");
                $('#point'+idx).addClass("fa-minus");
                $('#sub'+idx).show();
                $('#sub'+idx).html(listview);
                $('#priview_location').html(priv);
                $('#sub_dir1').val(sub1);
                $('#sub_dir2').val("");
                $('#sub_dir3').val("");
                $('#sub_dir4').val("");
            }
        }
    });
}

function openSubdir(dir1,dir2,idx,subidx){
    var url=base_url +"laporan/opendir/" +dir1+"/"+dir2;
    //alert(url);
     $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            console.log(data);

            if(data["status"]==true){
                var dir    = data["data"];
                var jmlData=dir.length;
                var listview = "<ul class=\"nav nav-stacked\">";
                var priv="";
                for(var i=0; i<jmlData;i++){
                    listview+='<li><a href="#" style="padding-left: 70px;" onclick="openSubsubdir(\''+dir[i]["dir1"]+'\',\''+dir[i]["dir2"]+'\',\''+dir[i]["dir3"]+'\','+idx+','+i+')"><span class="fa fa-folder"></span> '+dir[i]["dir3"];
                    listview+='<button class="pull-right badge bg-green"><span id="subsub_point'+idx+'_'+i+'" class="subsub_point fa fa-plus"></span></button>';
                    listview+='</a>';
                    listview+='<div id="subsub'+idx+'_'+i+'" class="subsub'+idx+'" style="display: none;"></div></li>';
                    priv+='<a href="#"  onclick="openSubsubdir(\''+dir[i]["dir1"]+'\',\''+dir[i]["dir2"]+'\',\''+dir[i]["dir3"]+'\','+idx+','+i+')"><div class="col-md-1 text-center">';
                    priv+='<img src="'+base_url+'assets/img/folder.png'+'" class="img img-responsive">';
                    priv+='<span class="text-center">'+dir[i]["dir3"]+'</span>';
                    priv+='</div></a>';
                }                  
                listview+="</ul>";
                console.log(listview);
                $('.sub_point').removeClass("fa-minus");
                $('.sub_point').addClass("fa-plus");
                $('.sub'+idx+'').hide();

                $('#sub_point'+idx+'_'+subidx).removeClass("fa-plus");
                $('#sub_point'+idx+'_'+subidx).addClass("fa-minus");
                $('#sub'+idx+'_'+subidx).show();
                $('#sub'+idx+'_'+subidx).html(listview);
                $('#priview_location').html(priv);
                $('#sub_dir1').val(dir1);
                $('#sub_dir2').val(dir2);
                $('#sub_dir3').val("");
                $('#sub_dir4').val("");
            }
        }
    });
}

function openSubsubdir(dir1,dir2,dir3,idx,subidx){
    var url=base_url +"laporan/opendir/" +dir1+"/"+dir2+"/"+dir3;
    //alert(url);
     $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            console.log(url);
            var priv="";
            if(data["status"]==true){
                var dir    = data["data"];
                var jmlData=dir.length;
                var listview = "<ul class=\"nav nav-stacked\">";
                for(var i=0; i<jmlData;i++){

                    listview+='<li><a href="#" style="padding-left: 100px;" onclick="openSubsubsubdir(\''+dir[i]["dir1"]+'\',\''+dir[i]["dir2"]+'\',\''+dir[i]["dir3"]+'\',\''+dir[i]["dir4"]+'\','+idx+','+i+')"><span class="fa fa-folder"></span> '+dir[i]["dir4"]+'</a>';
                    listview+='<div id="subsub'+idx+'_'+i+'" class="subsub'+idx+'" style="display: none;"></div></li>';
                    priv+='<a href="#"  onclick="openSubsubsubdir(\''+dir[i]["dir1"]+'\',\''+dir[i]["dir2"]+'\',\''+dir[i]["dir3"]+'\',\''+dir[i]["dir4"]+'\','+idx+','+i+')"><div class="col-md-1 text-center">';
                    priv+='<img src="'+base_url+'assets/img/folder.png'+'" class="img img-responsive">';
                    priv+='<span class="text-center">'+dir[i]["dir4"]+'</span>';
                    priv+='</div></a>';

                    /*priv+='<a href="'+base_url+'report/'+dir1+'/'+dir2+'/'+dir3+'/'+dir[i]["file"]+'" target="_blank"><div class="col-md-1 text-center">';
                    priv+='<img src="'+base_url+'assets/img/pdf.png'+'" class="img img-responsive">';
                    priv+='<span class="text-center">'+dir[i]["file"]+'</span>';
                    priv+='</div></a>';*/
                }                  
                listview+="</ul>";
                //console.log(listview);
                $('.subsub_point').removeClass("fa-minus");
                $('.subsub_point').addClass("fa-plus");
                $('.subsub'+idx).hide();

                $('#subsub_point'+idx+'_'+subidx).removeClass("fa-plus");
                $('#subsub_point'+idx+'_'+subidx).addClass("fa-minus");
                //alert('#subsub'+idx+'_'+subidx);
                $('#subsub'+idx+'_'+subidx).show();
                $('#subsub'+idx+'_'+subidx).html(listview);
                //alert('subsub'+idx+'_'+subidx);
                $('#priview_location').html(priv);
                $('#sub_dir1').val(dir1);
                $('#sub_dir2').val(dir2);
                $('#sub_dir3').val(dir3);
                $('#sub_dir4').val("");
            }
        }
    });
}

function openSubsubsubdir(dir1,dir2,dir3,dir4,idx,subidx){
    var url=base_url +"laporan/opendir/" +dir1+"/"+dir2+"/"+dir3+"/"+dir4;
    //alert(url);
     $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            console.log(url);
            var priv="";
            if(data["status"]==true){
                var dir    = data["data"];
                var jmlData=dir.length;
                var listview = "<ul class=\"nav nav-stacked\">";
                for(var i=0; i<jmlData;i++){
                    priv+='<a href="'+base_url+'report/'+dir1+'/'+dir2+'/'+dir3+'/'+dir4+"/"+dir[i]["file"]+'" target="_blank"><div class="col-md-1 text-center">';
                    priv+='<img src="'+base_url+'assets/img/pdf.png'+'" class="img img-responsive">';
                    priv+='<span class="text-center">'+dir[i]["file"]+'</span>';
                    priv+='</div></a>';
                }                  
                listview+="</ul>";
                console.log(listview);
                //$('.sub_point').removeClass("fa-minus");
                //$('.sub_point').addClass("fa-plus");
                //$('.sub'+idx+'').hide();

                $('#subsub_point'+idx+'_'+subidx).removeClass("fa-plus");
                $('#subsub_point'+idx+'_'+subidx).addClass("fa-minus");
                $('#subsub'+idx+'_'+subidx).show();
                $('#priview_location').html(priv);
                $('#sub_dir1').val(dir1);
                $('#sub_dir2').val(dir2);
                $('#sub_dir3').val(dir3);
                $('#sub_dir4').val(dir4);
            }
        }
    });
}

function unduh(){
    var dir1 = $('#sub_dir1').val();
    var dir2 = $('#sub_dir2').val();
    var dir3 = $('#sub_dir3').val();
    var dir4 = $('#sub_dir4').val();
    //alert(dir4);
    if(dir1=="" && dir2=="" && dir3=="" && dir4==""){
        location.href=base_url+'laporan/download/';
    }else{
        if(dir2=="" && dir3=="" && dir4==""){
            location.href=base_url+'laporan/download/'+dir1;
        }else{
            if(dir3=="" && dir4==""){
                location.href=base_url+'laporan/download/'+dir1+"/"+dir2;
            }else{
                if(dir4==""){
                    location.href=base_url+'laporan/download/'+dir1+"/"+dir2+"/"+dir3;
                }
                else{
                    location.href=base_url+'laporan/download/'+dir1+"/"+dir2+"/"+dir3+"/"+dir4;
                }
            }
        }
    }
    
}

/*
if(dir2=="" && dir3=="" && dir4=""){
            location.href=base_url+'laporan/download/'+dir1;
        }else{
            if(dir3=="" && dir4=""){
                location.href=base_url+'laporan/download/'+dir1+"/"+dir2;
            }else{
                if(dir4=="") location.href=base_url+'laporan/download/'+dir1+"/"+dir2+"/"+dir3;
                else location.href=base_url+'laporan/download/'+dir1+"/"+dir2+"/"+dir3+"/"+dir4;
            }
        }
*/