getVerifikasi(0);
function getVerifikasi(start){
    $('#start').val(start);
    var search = $('#q').val();
    var ritl = $('#ritl:checked').val();
    var rjtl = $('#rjtl:checked').val();
    //alert(ritl);
    if(rjtl!="1") rjtl = "0";
    if(ritl!="1") ritl = "0";
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "verifikasi/data?q=" + search + "&start=" +start+"&ritl="+ritl+"&rjtl="+rjtl;
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
            //console.clear();
            if(data["status"]==true){
                var verifikasi    = data["data"];
                var jmlData=verifikasi.length;
                var limit   = data["limit"]
                var tabel   = "";
                var status=false;
                //Create Tabel
                $('#data').html("");
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+verifikasi[i]["no_sep"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["nomr"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["nama_pasien"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["tempat_lahir"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["tgl_lahir"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["jns_kelamin"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["kode_jenis"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["jenis_berkas"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["poliklinik"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["tgl_reg"]+"</td>";
                    tabel+="<td>"+verifikasi[i]["tgl_pulang"]+"</td>";
                    if(verifikasi[i]['jml_verifikasi']==0 || verifikasi[i]['jml_verifikasi']==null) tabel+="<td><a href='"+base_url+"verifikasi/form/"+verifikasi[i]["id_daftar"]+"'><span class='btn btn-warning btn-xs'>0 Dari "+verifikasi[i]["jml_berkas"]+" Belum Diverifikasi</span></a></td>";
                    else {
                        if(verifikasi[i]["jml_verifikasi"]==verifikasi[i]["jml_berkas"]){
                            tabel+="<td><a href='"+base_url+"verifikasi/form/"+verifikasi[i]["id_daftar"]+"'><span class='btn btn-success btn-xs'>"+ verifikasi[i]["jml_verifikasi"] +" dari "+verifikasi[i]["jml_berkas"]+" Sudah Diverifikasi</span></a></td>";
                        }else{
                            tabel+="<td><a href='"+base_url+"verifikasi/form/"+verifikasi[i]["id_daftar"]+"'><span class='btn btn-warning btn-xs'>"+ verifikasi[i]["jml_verifikasi"] +" dari "+verifikasi[i]["jml_berkas"]+" Sudah Diverifikasi</span></a></td>";
                        }
                        
                    }
                    status = cekStatusVerifikasi(verifikasi[i]["id_daftar"]);
                    //alert(status);
                    console.log(status);
                    if(status=='false'){
                        console.log("Belum Diverifikasi")
                      tabel+="<td><a href='"+base_url+"verifikasi/form/"+verifikasi[i]["id_daftar"]+"'><span class='btn btn-danger btn-xs'>Belum Diverifikasi</span></a></td>";
                    }else{
                        console.log("Sudah Diverifikasi")
                      tabel+="<td><a href='"+base_url+"verifikasi/form/"+verifikasi[i]["id_daftar"]+"'><span class='btn btn-success btn-xs'>Sudah Diverifikasi</span></a></td>";
                    }
                    //tabel += "<td><a href='" + base_url + "verifikasi/form/" + verifikasi[i]["id_daftar"] + "' id='status_verifikasi" + verifikasi[i]["id_daftar"]+"'></a></td>";
                    //tabel+="<td>"+verifikasi[i]["jml_verifikasi"]+"</td>";
                    
                    //tabel+='<td class=\'text-right\'><button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'edit("' +verifikasi[i][""] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    //tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +verifikasi[i][""] +'")\'><span class=\'fa fa-remove\' ></span></td>';
                    tabel+="</tr>";
                    $('#data').append(tabel);
                }
                //$('#data').html(tabel);
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getVerifikasi(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getVerifikasi("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getVerifikasi("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getVerifikasi("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
                    if(jmlPage>=5){
                        if(curIdx>=4){
                            var idx_start=curIdx - 2;
                            var idx_end=curIdx+ 2;
                            if(idx_end>=jmlPage) idx_end=jmlPage;
                        }else{
                            var idx_start=1;
                            var idx_end=5;
                        }
                        for (var j = idx_start; j<=idx_end; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getVerifikasi("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getVerifikasi("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function cekStatusVerifikasi(id_daftar){
    var url = base_url+"verifikasi/cekstatus/"+id_daftar;
    //alert(url)
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        data: { get_param: 'value' },
        async:false,
        success: function (data) {
            status=data.status;
        }
    });

    return status;
}
function add(){
    save_method = 'add';
    $('#form')[0].reset(); 
    $('#modal_form').modal('show'); 
    
                $('#err_no_sep').html("");
                $('#err_nomr').html("");
                $('#err_nama_pasien').html("");
                $('#err_tempat_lahir').html("");
                $('#err_tgl_lahir').html("");
                $('#err_jns_kelamin').html("");
                $('#err_kode_jenis').html("");
                $('#err_jenis_berkas').html("");
                $('#err_poliklinik').html("");
                $('#err_berkas_wajib').html("");
                $('#err_jml_verifikasi').html("");
                $('#err_jml_berkas').html("");
    $('.modal-title').text('Tambah Data Verifikasi'); 
}
function update(){
    var url;
    url = base_url + "verifikasi/update";
    var formData = new FormData($('#form_pasien')[0]);
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
                    if(data["err_no_sep"]!="") $('#err_no_sep').html(data["err_no_sep"]); else $('#err_no_sep').html("");
                    if(data["err_nomr"]!="") $('#err_nomr').html(data["err_nomr"]); else $('#err_nomr').html("");
                    if(data["err_jenis_berkas"]!="") $('#err_jenis_berkas').html(data["err_jenis_berkas"]); else $('#err_jenis_berkas').html("");
                }else{
                    $('#form_pasien').modal('hide');
                    location.reload(); 
                    //var start=$('#start').val();
                    //getVerifikasi(start);
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

function save(){
    var url;
    url = base_url + "verifikasi/save";
    var formData = new FormData($('#form_upload')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(data)
        {
            console.log(data);
            if(data["status"]==true){
                if(data["error"]==true){
                    //alert(data["message"]);
                    $('#csrf').val(data["csrf"]);
                    swal({
                     title: "Error",
                     text: data["message"],
                     type: "error",
                     timer: 5000
                    });
                    window.location.href=base_url+"upload_berkas/form/"+data["id_file"];
                }else{
                    //$('#modal_form').modal('hide');
                    //var start=$('#start').val();
                    
                    swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });
                    var id_daftar=$('#xid_daftar').val();
                    var id_berkas=$('#id_berkas').val();
                    window.location.href=base_url+"verifikasi/form/"+id_daftar+"/"+id_berkas;
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
        url : base_url + "verifikasi/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            if(data["status"]==false){
                swal({
                 title: "Peringatan",
                 text: data["message"],
                 type: "error",
                 timer: 5000
                });
                //alert(data["message"]);
            }else{
                var verifikasi = data["data"];
                
                $('#x-no_sep').val(verifikasi.no_sep);
                $('#x-nomr').val(verifikasi.nomr);
                $('#x-nama_pasien').val(verifikasi.nama_pasien);
                $('#x-kode_jenis').val(verifikasi.kode_jenis);
                $('#x-id_daftar').val(verifikasi.id_daftar);
                $('#err_no_sep').html("");
                $('#err_nomr').html("");
                $('#err_nama_pasien').html("");
                $('#err_jenis_pasien').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_pasien').modal('show'); 
                $('.modal-title').text('Edit Data Pasien'); 
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
function uploadDokumen(iddaftar,iddokumen,nama_berkas){
    var url;
    save_method = 'update';
    $('#form')[0].reset(); 
    $.ajax({
        url : base_url + "verifikasi/edit/" + iddaftar,
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
                var verifikasi = data["data"];
                $('#xid_daftar').val(iddaftar);
                $('#no_sep').val(verifikasi.no_sep);
                $('#nomr').val(verifikasi.nomr);
                $('#nama_pasien').val(verifikasi.nama_pasien);
                $('#tempat_lahir').val(verifikasi.tempat_lahir);
                $('#tgl_lahir').val(verifikasi.tgl_lahir);
                $('#jns_kelamin').val(verifikasi.jns_kelamin);
                $('#kode_jenis').val(verifikasi.kode_jenis);
                $('#jenis_berkas').val(verifikasi.jenis_berkas);
                $('#poliklinik').val(verifikasi.poliklinik);
                $('#xtgl_reg').val(verifikasi.tgl_reg);
                $('#xtgl_pulang').val(verifikasi.tgl_pulang);
                $('#id_berkas').val(iddokumen);
                $('#nama_berkas').val(nama_berkas);
                $('#grId').val(verifikasi.grId);
                $('#xkeadaan_pulang').val(verifikasi.keadaan_pulang);
                
                $('#csrf').val(data["csrf"]),
                $('#modal_upload').modal('show'); 
                $('.modal-title').text('Upload ' + nama_berkas); 
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
            url : base_url + "verifikasi/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getVerifikasi(start);
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
function verifikasi(iddaftar,dokumen){
    swal({
      title: "Apakah Anda Yakin?",
      text: "Data sudah benar diakan diverifikasi",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, Saya Yakin!",
      cancelButtonText: "Tidak, Tolong Batalkan!",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm){
        //alert(base_url + "verifikasi/verifikasi_dokumen/" +nosep+"/"+dokumen);
      if (isConfirm) {
        $.ajax({
            url : base_url + "verifikasi/verifikasi_dokumen/" +iddaftar+"/"+dokumen,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert("test");
                if(data["status"]==true){
                    swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });
                    location.reload(); 
                }else{
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
                 text: "Gagal Verifikasi Data",
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

function batalVerifikasi(iddaftar,dokumen){
    swal({
      title: "Apakah Anda Yakin?",
      text: "Apakah anda akan memverifikasi Ulang",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, Saya Yakin!",
      cancelButtonText: "Tidak, Tolong Batalkan!",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm){
        //alert(base_url + "verifikasi/verifikasi_dokumen/" +nosep+"/"+dokumen);
      if (isConfirm) {
        $.ajax({
            url : base_url + "verifikasi/batal_verifikasi_dokumen/" +iddaftar+"/"+dokumen,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert("test");
                if(data["status"]==true){
                    swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });
                    location.reload(); 
                }else{
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
                 text: "Gagal Verifikasi Data",
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

function generateReport(iddaftar){
    swal({
      title: "Apakah Anda Yakin?",
      text: "Akan mengenerate report",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, Saya Yakin!",
      cancelButtonText: "Tidak, Tolong Batalkan!",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm){
        //alert(base_url + "verifikasi/verifikasi_dokumen/" +nosep+"/"+dokumen);
        console.log(base_url + "verifikasi/generate_report/" +iddaftar);
      if (isConfirm) {
        $.ajax({
            url : base_url + "verifikasi/generate_report/" +iddaftar,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              console.log(data);

                if(data["status"]==true){
                    swal({
                     title: "Sukses",
                     text: data["message"] + data["id"],
                     type: "success",
                     timer: 5000
                    });
                    location.reload(); 
                }else{
                  //alert(data["message"]);
                    swal({
                     title: "Error",
                     text: data["message"] + data["id"],
                     type: "error",
                     timer: 5000
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                 title: "Terjadi Kesalahan..!",
                 text: "Gagal Verifikasi Data",
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

function pulangkan(iddaftar){
    $('#modal_form').modal('show'); 
    $('.modal-title').html("Pemulangan Pasien");
    $('#id_daftar').val(iddaftar);
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
                url : base_url + "verifikasi/pulangkan",
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

function halamanBerkas(){
    var jmlhalaman=$('#halaman_berkas').val();
    var form = "";
    var hal=0;
    for(var i=0; i<jmlhalaman; i++){
        hal++;
        form+='<div class="form-group">';
        form+='<label for="inputEmail3" class="col-sm-4 control-label">HALAMAN '+hal+'</label>';
        form+='<div class="col-sm-8">';
        form+='<input type="file" id="halaman'+i+'" name="userfile[]" >';
        form+='</div>';
        form+='</div>';
    }
    $('#file_berkas').html(form);
}

function updateFile(d_id){
    var url;
    url = base_url + "verifikasi/update_file";
    var formData = new FormData($('#form'+d_id)[0]);
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
                    //alert(data["message"]);
                    $('#csrf').val(data["csrf"]);
                    
                }else{
                    //$('#modal_form').modal('hide');
                    //var start=$('#start').val();
                    
                    swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });
                    window.location.reload();
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

function addFile(){
    var url;
    url = base_url + "verifikasi/add_file";
    var formData = new FormData($('#form_addfile')[0]);
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
                    //alert(data["message"]);
                    $('#csrf').val(data["csrf"]);
                    
                }else{
                    //$('#modal_form').modal('hide');
                    //var start=$('#start').val();
                    
                    swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });
                    window.location.reload();
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



function hapusFile(id){
    swal({
      title: "Apakah Anda Yakin?",
      text: "Berkas ini akan dihapus dari database",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, Saya Yakin!",
      cancelButtonText: "Tidak, Tolong Batalkan!",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm){
      if (isConfirm) {
        //alert('Mulai');
        $.ajax({
            url : base_url + "upload_berkas/delete_berkas/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var id_file=$('#id_file').val();
                window.location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Terjadi Kesalahan..!",
                    ext: "Gagal Saat Pengapusan data",
                    type: "error",
                    timer: 5000
                });
            }
        });
        //alert('Selesai');
      } else {
        swal("Batal", "Data Tidak jadi dihapus :)", "error");
      }
    });
}