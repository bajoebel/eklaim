
getM_berkasklaim(0);
function getM_berkasklaim(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "m_berkasklaim/data?q=" + search + "&start=" +start;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var m_berkasklaim    = data["data"];
                var jmlData=m_berkasklaim.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    
            tabel+="<td>"+m_berkasklaim[i]["kode_jenis"]+"</td>";
            tabel+="<td>"+m_berkasklaim[i]["id_berkas"]+"</td>";
            tabel+="<td>"+m_berkasklaim[i]["hardcopy"]+"</td>";
            tabel+="<td>"+m_berkasklaim[i]["softcopy"]+"</td>";
            tabel+="<td>"+m_berkasklaim[i]["wajib"]+"</td>";
                    tabel+='<td class=\'text-right\'><button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'edit("' +m_berkasklaim[i]["id_bklaim"] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +m_berkasklaim[i]["id_bklaim"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getM_berkasklaim(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getM_berkasklaim("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getM_berkasklaim("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getM_berkasklaim("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getM_berkasklaim("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getM_berkasklaim("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function add(){
    save_method = 'add';
    $('#form')[0].reset(); 
    $('#modal_form').modal('show'); 
    
                $('#err_id_bklaim').html("");
                $('#err_kode_jenis').html("");
                $('#err_id_berkas').html("");
                $('#err_hardcopy').html("");
                $('#err_softcopy').html("");
                $('#err_wajib').html("");
    $('.modal-title').text('Tambah Data M_berkasklaim'); 
}
function save(){
    var url;
    url = base_url + "m_berkasklaim/save";
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
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf').val(data["csrf"]);
                    
                if(data["err_id_bklaim"]!="") $('#err_id_bklaim').html(data["err_id_bklaim"]); else $('#err_id_bklaim').html("");
                
                if(data["err_kode_jenis"]!="") $('#err_kode_jenis').html(data["err_kode_jenis"]); else $('#err_kode_jenis').html("");
                
                if(data["err_id_berkas"]!="") $('#err_id_berkas').html(data["err_id_berkas"]); else $('#err_id_berkas').html("");
                
                if(data["err_hardcopy"]!="") $('#err_hardcopy').html(data["err_hardcopy"]); else $('#err_hardcopy').html("");
                
                if(data["err_softcopy"]!="") $('#err_softcopy').html(data["err_softcopy"]); else $('#err_softcopy').html("");
                
                if(data["err_wajib"]!="") $('#err_wajib').html(data["err_wajib"]); else $('#err_wajib').html("");
                
                }else{
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    getM_berkasklaim(start);
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
        url : base_url + "m_berkasklaim/edit/" + id,
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
                var m_berkasklaim = data["data"];
                
                $('#id_bklaim').val(m_berkasklaim.id_bklaim);
                $('#kode_jenis').val(m_berkasklaim.kode_jenis);
                $('#id_berkas').val(m_berkasklaim.id_berkas);
            if(m_berkasklaim.hardcopy==1) $('#hardcopy').prop( "checked", true );
            if(m_berkasklaim.softcopy==1) $('#softcopy').prop( "checked", true );
            if(m_berkasklaim.wajib==1) $('#wajib').prop( "checked", true );
                
                $('#err_id_bklaim').html("");
                $('#err_kode_jenis').html("");
                $('#err_id_berkas').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data M_berkasklaim'); 
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
            url : base_url + "m_berkasklaim/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getM_berkasklaim(start);
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