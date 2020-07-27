
getJenisberkas(0);
function getJenisberkas(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "jenisberkas/data?q=" + search + "&start=" +start;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        beforeSend: function () {
            // setting a timeout
            $('#data').html("<tr><td colspan='4'><span class='fa fa-spinner fa-spin'></span>Loading ...</td></tr>");
        },
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var jenisberkas    = data["data"];
                var jmlData=jenisberkas.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+jenisberkas[i]["kode_jenis"]+"</td>";
                    tabel+="<td>"+jenisberkas[i]["jenis_berkas"]+"</td>";
                    tabel+='<td class=\'text-right\'><div class="btn btn-group">';
                    tabel+='<button type=\'button\' class=\'btn btn-warning btn-xs\'  onclick=\'show("' +start +'","'+jenisberkas[i]["kode_jenis"]+'")\'><span class=\'fa fa-plus\' id=\'btnshow'+start+'\' ></span> Berkas</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'edit("' +jenisberkas[i]["kode_jenis"] +'")\'><span class=\'fa fa-pencil\' ></span></button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +jenisberkas[i]["kode_jenis"] +'")\'><span class=\'fa fa-remove\' ></span></div></td>';
                    tabel+="</tr>";
                    tabel+="<tr style='display:none;' id='tabelberkasklaim"+start+"'>";
                    tabel+="<td colspan='4' style='padding-left:100px;'>";
                    tabel+="<table class='table table-bordered table-striped'>";
                    tabel+="<tr class='bg-green'>";
                    tabel+="<th>Berkas<input type='hidden' id='showstatus"+start+"' value='0' /></th>";
                    tabel+="<th>Softcopy</th>";
                    tabel+="<th>Hardcopy</th>";
                    tabel+="<th>Wajib</th>";
                    tabel+="</tr>";
                    tabel+="<tbody id='databerkasklaim"+start+"'>";
                    tabel+="</tbody>";
                    tabel+="</table>";
                    tabel+="</td>";
                    tabel+="</tr>";
                }
                $('#data').html(tabel);
                //Create Pagination
                if(data["row_count"]<=limit){
                    $('#pagination').html("");
                }else{
                    var pagination="";
                    var btnIdx="";
                    jmlPage=Math.ceil(data["row_count"]/limit);
                    offset  = data["start"] % limit;
                    curIdx  = Math.ceil((data["start"]/data["limit"])+1);
                    prev    = (curIdx-2) * data["limit"];
                    next    = (curIdx) * data["limit"];
                    
                    var curSt=(curIdx*data["limit"])-jmlData;
                    var st=start;
                    var btn="btn-default";
                    var lastSt=(jmlPage*data["limit"])-jmlData
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getJenisberkas(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getJenisberkas("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getJenisberkas("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getJenisberkas("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
                    if(jmlPage>=25){
                        if(curIdx>=20){
                            var idx_start=curIdx - 20;
                            var idx_end=idx_start+ 25;
                            if(idx_end>=jmlPage) idx_end=jmlPage;
                        }else{
                            var idx_start=1;
                            var idx_end=25;
                        }
                        for (var j = idx_start; j<=idx_end; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getJenisberkas("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getJenisberkas("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function show(start,kode_jenis){
    //alert(start);
    var url=base_url+'jenisberkas/berkasklaim/'+kode_jenis;
    $.ajax({
        url:url,
        type:"GET",
        dataType:"JSON",
        success:function(data){
            var status=$('#showstatus'+start).val();
            if(status==0){
                $('#showstatus'+start).val("1")
                $('#tabelberkasklaim'+start).show();
                $('#btnshow'+start).removeClass("fa-plus");
                $('#btnshow'+start).addClass("fa-minus");
                $('#databerkasklaim'+start).html(data["data"]);
            }else{
                $('#showstatus'+start).val("0")
                $('#tabelberkasklaim'+start).hide();
                $('#btnshow'+start).removeClass("fa-minus");
                $('#btnshow'+start).addClass("fa-plus");
            }
            
            //alert(data["message"]);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Pengambilan data",
             type: "error",
             timer: 5000
            });
        }
    });
}
function setSoftcopy(id_berkas, jenis){
    //alert(jenis);
    if ($('#softcopy'+id_berkas).is(':checked')) {
        var url=base_url+"jenisberkas/softcopy/"+jenis+"/"+id_berkas+"/1";
    }else{
        var url=base_url+"jenisberkas/softcopy/"+jenis+"/"+id_berkas+"/0";
    }
    $.ajax({
        url:url,
        type:"GET",
        dataType:"JSON",
        success:function(data){
            if(data["status"]==false){
                swal({
                    title: "Error",
                    text: data["message"],
                    type: "success",
                    timer: 5000
                });
            }
            /*else{
                swal({
                    title: "Sukses",
                    text: data["message"],
                    type: "success",
                    timer: 5000
                });
            }*/
            
            //alert(data["message"]);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Pengambilan data"+url,
             type: "error"
            });
        }
    });
}

function setHardcopy(id_berkas, jenis){
    //alert(jenis);
    if ($('#hardcopy'+id_berkas).is(':checked')) {
        var url=base_url+"jenisberkas/hardcopy/"+jenis+"/"+id_berkas+"/1";
    }else{
        var url=base_url+"jenisberkas/hardcopy/"+jenis+"/"+id_berkas+"/0";
    }
    $.ajax({
        url:url,
        type:"GET",
        dataType:"JSON",
        success:function(data){
            if(data["status"]==false){
                swal({
                    title: "Error",
                    text: data["message"],
                    type: "success",
                    timer: 5000
                });
            }
            /*else{
                swal({
                    title: "Sukses",
                    text: data["message"],
                    type: "success",
                    timer: 5000
                });
            }*/
            
            //alert(data["message"]);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Pengambilan data"+url,
             type: "error"
            });
        }
    });
}
function setWajib(id_berkas, jenis){
    //alert(jenis);
    if ($('#wajib'+id_berkas).is(':checked')) {
        var url=base_url+"jenisberkas/wajib/"+jenis+"/"+id_berkas+"/1";
    }else{
        var url=base_url+"jenisberkas/wajib/"+jenis+"/"+id_berkas+"/0";
    }
    $.ajax({
        url:url,
        type:"GET",
        dataType:"JSON",
        success:function(data){
            if(data["status"]==false){
                swal({
                    title: "Error",
                    text: data["message"],
                    type: "success",
                    timer: 5000
                });
            }
            /*else{
                swal({
                    title: "Sukses",
                    text: data["message"],
                    type: "success",
                    timer: 5000
                });
            }*/
            
            //alert(data["message"]);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Pengambilan data"+url,
             type: "error"
            });
        }
    });
}
function add(){
    save_method = 'add';
    $('#form')[0].reset(); 
    $('#modal_form').modal('show'); 
    $('#err_kode_jenis').html("");
    $('#err_jenis_berkas').html("");
    $('.modal-title').text('Tambah Data Jenisberkas'); 
}
function save(){
    var url;
    url = base_url + "jenisberkas/save";
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(data)
        {
            $('#csrf').val(data["csrf"]);
            if(data["status"]==true){
                if(data["error"]==true){
                    
                    
                if(data["err_kode_jenis"]!="") $('#err_kode_jenis').html(data["err_kode_jenis"]); else $('#err_kode_jenis').html("");
                
                if(data["err_jenis_berkas"]!="") $('#err_jenis_berkas').html(data["err_jenis_berkas"]); else $('#err_jenis_berkas').html("");
                
                }else{
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    getJenisberkas(start);
                    swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });
                }
            }
            else{
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "warning",
                    timer: 5000
                });
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan ",
             text: "Gagal Menyimpan Data",
             type: "error",
             timer: 5000
            });
        }
    });
}
function edit(id)
{
    var url;
    save_method = 'update';
    $('#form')[0].reset(); 
    $.ajax({
        url : base_url + "jenisberkas/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data["status"]==false){
                swal({
                 title: "Peringatan",
                 text: data["message"],
                 type: "error",
                 timer: 5000
                });
                //alert(data["message"]);
            }else{
                var jenisberkas = data["data"];
                
                $('#kode_jenis').val(jenisberkas.kode_jenis);
                $('#jenis_berkas').val(jenisberkas.jenis_berkas);
                
                $('#err_kode_jenis').html("");
                $('#err_jenis_berkas').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Jenisberkas'); 
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Pengambilan data",
             type: "error",
             timer: 5000
            });
        }
    });
}
function hapus(id){
    swal({
      title: "Apakah Anda Yakin?",
      text: "Data ini akan dihapus dari database",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, Saya Yakin!",
      cancelButtonText: "Tidak, Tolong Batalkan!",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm){
      if (isConfirm) {
        $.ajax({
            url : base_url + "jenisberkas/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getJenisberkas(start);
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                 title: "Terjadi Kesalahan..!",
                 text: "Gagal Saat Pengapusan data",
                 type: "error",
                 timer: 5000
                });
            }
        });
      } else {
        swal("Batal", "Data Tidak jadi dihapus :)", "error");
      }
    });
}