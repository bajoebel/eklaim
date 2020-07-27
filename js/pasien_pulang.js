getpasien_pulang(0);
function getpasien_pulang(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "pasien_pulang/data?q=" + search + "&start=" +start;
    console.clear();
    console.log(url);
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        beforeSend: function () {
            // setting a timeout
            $('#data').html("<tr><td colspan='14'><span class='fa fa-spinner fa-spin'></span>Loading ...</td></tr>");
        },
        success : function(data){
            //menghitung jumlah data
            //
            if(data["status"]==true){
                var pasien_pulang    = data["data"];
                var jmlData=pasien_pulang.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["id_daftar"]+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["nomr"]+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["no_bpjs"]+"</td>";
                    //tabel+="<td>"+pasien_pulang[i]["no_ktp"]+"</td>";
                    if(pasien_pulang[i]["no_sep"]!=null) tabel+="<td>"+pasien_pulang[i]["no_sep"]+"</td>";
                    else tabel+="<td>-</td>";
                    tabel+="<td>"+pasien_pulang[i]["nama"]+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["jns_kelamin"]+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["alamat"]+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["tempat_lahir"]+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["tgl_reg"]+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["tgl_keluar"]+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["keadaan_pulang"]+"</td>";
                    tabel+="<td>"+pasien_pulang[i]["grNama"]+"</td>";
                    tabel+='<td class=\'text-right\'>';
                    //tabel+='<a href=\''+base_url+'pasien_pulang/form/'+pasien_pulang[i]['id_file']+'\' class=\'btn btn-success btn-xs\' ><span class=\'fa fa-pencil\' ></span></a>|';
                    if(pasien_pulang[i]["tgl_keluar"] =="0000-00-00 00:00:00") tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'pulangkan("' +pasien_pulang[i]["id_daftar"] +'")\'><span class=\'fa fa-home\' ></span> Pulangkan</button>';
                    else tabel+='<button type=\'button\' class=\'btn btn-success btn-xs\' ><span class=\'fa fa-home\' ></span> Sudah DIpulangkan</button>';
                    tabel+='</td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getpasien_pulang(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getpasien_pulang("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getpasien_pulang("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getpasien_pulang("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getpasien_pulang("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getpasien_pulang("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function pulangkan(iddaftar){
    
    var url;
    save_method = 'update';
    $('#form')[0].reset(); 
    $.ajax({
        url : base_url + "pasien_pulang/pulangkan/" + iddaftar,
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
                var pasien_pulang = data["data"];
                $('#id_daftar').val(iddaftar);
                $('#tgl_pulang').val(pasien_pulang["tgl_keluar"]);
                $('#tgl_reg').val(pasien_pulang["tgl_reg"]);
                $('#keadaan_pulang').val(pasien_pulang["keadaan_pulang"]);
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Pulangkan Pasien'); 
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
function pulangkanPasien(){
    swal({
      title: "Apakah Anda Yakin?",
      text: "Akan memulangkan pasien",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, Saya Yakin!",
      cancelButtonText: "Tidak, Tolong Batalkan!",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm){
        var formData = new FormData($('#form')[0]);
        if (isConfirm) {
            $.ajax({
                url : base_url + "pasien_pulang/pulangkan_pasien",
                type: "POST",
                data : formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(data)
                {
                  console.log(data);

                    if(data["status"]==true){
                        swal({
                         title: "Sukses",
                         text: data["message"],
                         type: "success",
                         timer: 5000
                        });
                        location.reload(); 
                    }else{
                      alert(data["message"]);
                        swal({
                         title: "Error",
                         text: data["message"],
                         type: "error",
                         timer: 5000
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    swal({
                     title: "Terjadi Kesalahan..!",
                     text: "Gagal Memulangkan Pasien",
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

