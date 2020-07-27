function getUpload_berkas(start){
    $('#start').val(start);
    var ritl = $('#ritl:checked').val();
    var rjtl = $('#rjtl:checked').val();
    //alert(ritl);
    if(rjtl!="1") rjtl = "0";
    if(ritl!="1") ritl = "0";
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "upload_berkas/data?q=" + search + "&start=" +start +"&ritl="+ritl+"&rjtl="+rjtl;
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
            //console.log(url);
            if(data["status"]==true){
                var upload_berkas    = data["data"];
                var jmlData=upload_berkas.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    
                    tabel+="<td>"+upload_berkas[i]["tgl_upload"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["nomr"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["id_daftar"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["no_sep"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["nama_pasien"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["kode_jenis"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["nama_berkas"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["jml_halaman"]+" Halaman</td>";
                    tabel+="<td>"+upload_berkas[i]["status_verifikasi"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["user_upload"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["tgl_reg"]+"</td>";
                    tabel+="<td>"+upload_berkas[i]["user_verifikasi"]+"</td>";
                    if(upload_berkas[i]["status_verifikasi"]==1){
                        tabel+='<td class=\'text-right\'>';
                        tabel+='<button type=\'button\' class=\'btn btn-success btn-xs\'><span class=\'fa fa-check\'></span> Sudah diverifikasi</td>';
                    }else{
                        if(username==upload_berkas[i]["user_upload"]||username=="admin"){
                            tabel+='<td class=\'text-right\'><a href=\''+base_url+'upload_berkas/form/'+upload_berkas[i]['id_file']+'\' class=\'btn btn-success btn-xs\' ><span class=\'fa fa-pencil\' ></span></a>|';
                            tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +upload_berkas[i]["id_file"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
                        }else{
                            tabel+='<td class=\'text-right\'>';
                            tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\'><span class=\'fa fa-remove\'></span> Tidak bisa dihapus</td>';
                        }
                    }
                        
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getUpload_berkas(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getUpload_berkas("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getUpload_berkas("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getUpload_berkas("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getUpload_berkas("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getUpload_berkas("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function inputTagihan(){
    var berkas=$('#id_berkas').val();
    var url=base_url+"upload_berkas/pilih_berkas/"+berkas;
    console.log(url);
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var berkas = data["data"];
            var input_tagihan="";
            if(berkas["ada_tagihan"]==1){
                input_tagihan+='<div class="form-group">';
                input_tagihan+='<label for="inputEmail3" class="col-sm-3 control-label">JUMLAH TAGIHAN</label>';
                input_tagihan+='<div class="col-sm-9">';
                input_tagihan+='<input type="text" name="jml_tagihan" id="jml_tagihan" class="form-control " value="">';
                input_tagihan+='<span class ext-error" id="err_jml_tagihan"></span>';
                input_tagihan+='</div>';
                input_tagihan+='</div>';
            }else{
                 input_tagihan+='<input type="hidden" name="jml_tagihan" id="jml_tagihan" value="0">';
            }
            //alert(berkas["nama_berkas"]);
            $('#tagihan').html(input_tagihan);
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
function add(){
    save_method = 'add';
    $('#form')[0].reset(); 
    $('#modal_form').modal('show'); 
    
                $('#err_id_file').html("");
                $('#err_tgl_upload').html("");
                $('#err_nomr').html("");
                $('#err_id_daftar').html("");
                $('#err_no_sep').html("");
                $('#err_nama_pasien').html("");
                $('#err_kode_jenis').html("");
                $('#err_id_berkas').html("");
                $('#err_nama_file').html("");
                $('#err_status_verifikasi').html("");
                $('#err_user_upload').html("");
                $('#err_user_verifikasi').html("");
    $('.modal-title').text('Tambah Data Upload_berkas'); 
}
function save(){
    var url;
    url = base_url + "upload_berkas/save";
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
                    //alert(data["message"]);
                    $('#csrf').val(data["csrf"]);
                    if(data["err_id_file"]!="") $('#err_id_file').html(data["err_id_file"]); else $('#err_id_file').html("");
                    if(data["err_tgl_upload"]!="") $('#err_tgl_upload').html(data["err_tgl_upload"]); else $('#err_tgl_upload').html("");
                    if(data["err_nomr"]!="") $('#err_nomr').html(data["err_nomr"]); else $('#err_nomr').html("");
                    if(data["err_id_daftar"]!="") $('#err_id_daftar').html(data["err_id_daftar"]); else $('#err_id_daftar').html("");
                    if(data["err_no_sep"]!="") $('#err_no_sep').html(data["err_no_sep"]); else $('#err_no_sep').html("");
                    if(data["err_nama_pasien"]!="") $('#err_nama_pasien').html(data["err_nama_pasien"]); else $('#err_nama_pasien').html("");
                    if(data["err_kode_jenis"]!="") $('#err_kode_jenis').html(data["err_kode_jenis"]); else $('#err_kode_jenis').html("");
                    if(data["err_id_berkas"]!="") $('#err_id_berkas').html(data["err_id_berkas"]); else $('#err_id_berkas').html("");
                    if(data["err_nama_file"]!="") $('#err_nama_file').html(data["err_nama_file"]); else $('#err_nama_file').html("");
                    if(data["err_status_verifikasi"]!="") $('#err_status_verifikasi').html(data["err_status_verifikasi"]); else $('#err_status_verifikasi').html("");
                    if(data["err_user_upload"]!="") $('#err_user_upload').html(data["err_user_upload"]); else $('#err_user_upload').html("");
                    if(data["err_user_verifikasi"]!="") $('#err_user_verifikasi').html(data["err_user_verifikasi"]); else $('#err_user_verifikasi').html("");
                    if(data['id_file']>0){
                        swal({
                          title: data["message"],
                          text: "Apakah Anda ingin mengedit?",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonText: "Ya, Saya Yakin!",
                          cancelButtonText: "Tidak, Tolong Batalkan!",
                          closeOnConfirm: true,
                          closeOnCancel: true
                        },
                        function(isConfirm){
                          if (isConfirm) {
                            window.location.href=base_url+"upload_berkas/form/"+data["id_file"];
                          } else {
                            swal("Batal", "Data Tidak jadi dihapus :)", "error");
                          }
                        });
                        //window.location.href=base_url+"form/"+data["id_file"]
                    }
                }else{
                    //$('#modal_form').modal('hide');
                    //var start=$('#start').val();
                    swal({
                      title: "Apakah Anda Yakin?",
                      text: "Apakah masih ada data yang akan diupload",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonText: "Ya, Masih ada!",
                      cancelButtonText: "Tidak, Upload Selesai!",
                      closeOnConfirm: true,
                      closeOnCancel: true
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        $('#id_berkas').val("");
                        $('#no_sep').prop('readonly', true);
                        $('#halaman_berkas').val("1");
                        var id_daftar=$('#id_daftar').val();
                        getHistoriberkas(id_daftar);
                        $('#csrf').val(data["csrf"]);
                      } else {
                        var id_daftar=$('#id_daftar').val();
                        swal("Berhasil", "Data sudah diupload", "error");
                        if(level==6){
                            window.location.href=base_url+"verifikasi/form/"+id_daftar;
                        }else{
                            window.location.href=base_url+"upload_berkas";
                        }
                      }
                    });

                    /*swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });*/
                    //window.location.href=base_url+"upload_berkas";
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
        url : base_url + "upload_berkas/edit/" + id,
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
                var upload_berkas = data["data"];
                
                $('#id_file').val(upload_berkas.id_file);
                $('#tgl_upload').val(upload_berkas.tgl_upload);
                $('#nomr').val(upload_berkas.nomr);
                $('#id_daftar').val(upload_berkas.id_daftar);
                $('#no_sep').val(upload_berkas.no_sep);
                $('#nama_pasien').val(upload_berkas.nama_pasien);
                $('#kode_jenis').val(upload_berkas.kode_jenis);
                $('#id_berkas').val(upload_berkas.id_berkas);
                $('#nama_file').val(upload_berkas.nama_file);
                if(upload_berkas.status_verifikasi==1) $('#status_verifikasi').prop( "checked", true );
                $('#user_upload').val(upload_berkas.user_upload);
                $('#user_verifikasi').val(upload_berkas.user_verifikasi);
                $('#err_id_file').html("");
                $('#err_tgl_upload').html("");
                $('#err_nomr').html("");
                $('#err_id_daftar').html("");
                $('#err_no_sep').html("");
                $('#err_nama_pasien').html("");
                $('#err_kode_jenis').html("");
                $('#err_id_berkas').html("");
                $('#err_nama_file').html("");
                $('#err_user_upload').html("");
                $('#err_user_verifikasi').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Upload_berkas'); 
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
            url : base_url + "upload_berkas/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                console.clear();
                console.log(data);

                if(data["status"]==false){
                    alert(data["message"]);
                    //swal("Batal", data["message"], "error");
                    /*swal({
                        title: "Opps..!",
                        text: data["message"],
                        type: "error",
                        timer: 5000
                    });*/
                }
                var start=$('#start').val();
                getUpload_berkas(start);
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
function getBerkas(){
    var kode_jenis=$('#kode_jenis').val();
    var url = base_url + "upload_berkas/berkas/"+kode_jenis;
    //alert(url);
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
                var jmlData=data.length;
                var tabel   = "<option value=''>Pilih Berkas</option>";
                //Create Tabel
                console.log(data);
                for(var i=0; i<jmlData;i++){
                    if(data[i]["wajib"]==1) tabel+="<option value='"+data[i]["id_berkas"]+"'>"+data[i]["nama_berkas"]+ "(*)" + "</option>";
                    else tabel+="<option value='"+data[i]["id_berkas"]+"'>"+data[i]["nama_berkas"] + "</option>";
                    
                }
                $('#id_berkas').html(tabel);
        } 
    });
}
function getPoliklinik(jenis){
    var url=base_url+"upload_berkas/ruangan/"+jenis;
    console.log(url);
    //alert(url);
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            var option="<option value=''>Pilih Ruangan</option>";
            if(data["status"]==false){
                swal({
                 title: "Peringatan",
                 text: data["message"],
                 type: "error",
                 timer: 5000
                });
                //alert(data["message"]);
            }else{
                var ruangan = data["data"];
                var jmlData=ruangan.length;
                //alert(jmlData);
                for(var i=0; i<jmlData;i++){
                    option+="<option value='"+ruangan[i]["idx"]+"'>"+ruangan[i]["ruang"]+"</option>";
                }
            }
            $('#ruangan').html(option);
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
function cariKunjungan(){
    //$('#form')[0].reset(); 
    $('#modal_form').modal('show'); 
    var kode_jenis=$('#kode_jenis').val();
    getKunjungan(0);
    getPoliklinik(kode_jenis);
}
function urlencode(str) {
    str = (str + '').toString();
    return encodeURIComponent(str)
        .replace(/!/g, '%21')
        .replace(/'/g, '%27')
        .replace(/\(/g, '%28')
        .replace(/\)/g, '%29')
        .replace(/\*/g, '%2A')
        .replace(/%20/g, '+');
}
function urldecode(str) {
    return decodeURIComponent((str + '').replace(/%(?![\da-f]{2})/gi, function () {
        return '%25'
    }).replace(/\+/g, '%20'))
}

function getKunjungan(start=0){
    //$('#form')[0].reset(); 
    var kode_jenis=$('#kode_jenis').val();
    var grId=$('#ruangan').val();
    var tgl_reg=$('#tgl_registrasi').val();
    var key_word=$('#q').val();
    if(kode_jenis=='RITL'){
        //url untuk menngambil data pasien rawat inap
        var url=base_url+"upload_berkas/ritl?ruang="+grId+"&tglreg="+tgl_reg+"&start="+start+"&key_word="+key_word;
    }else{
        //url untuk menngambil data pasien rawat Jalam
        var url=base_url+"upload_berkas/rjtl?ruang="+grId+"&tglreg="+tgl_reg+"&start="+start+"&key_word="+key_word;
    }
    console.log(url);
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        beforeSend: function () {
            // setting a timeout
            $('#data-pendaftaran').html('<tr><td colspan=7>Sedang Mengambil data...</td></tr>');
        },
        success: function(data)
        {
            var tabel="";
            if(data["status"]==false){
                swal({
                 title: "Peringatan",
                 text: data["message"],
                 type: "error",
                 timer: 5000
                });
                //alert(data["message"]);
            }else{
                var ruangan = data["data"];
                var jmlData=ruangan.length;
                //alert(jmlData);
                //$('#data-pendaftaran').html('');
                for(var i=0; i<jmlData;i++){
                    if (ruangan[i]["no_sep"] == null) var no_sep = ''; else var no_sep = ruangan[i]["no_sep"];
                    tabel += "<tr onclick='getRowkunjungan(\"" + ruangan[i]["nomr"] + "\",\"" + ruangan[i]["id_daftar"] + "\",\"" + ruangan[i]["reg_unit"] + "\",\"" + ruangan[i]["no_bpjs"] + "\",\"" + ruangan[i]["no_ktp"] + "\",\"" + ruangan[i]["nama"] + "\",\"" + ruangan[i]["tgl_reg"] + "\",\"" + ruangan[i]["tempat_lahir"] + "\",\"" + ruangan[i]["tgl_lahir"] + "\",\"" + ruangan[i]["grId"] + "\",\"" + ruangan[i]["grNama"] + "\",\"" + no_sep + "\")'>";
                    if(ruangan[i]["no_sep"]==null||ruangan[i]["no_sep"]=="") tabel+="<td>Belum Diinput</td>";
                    else tabel+="<td>"+ruangan[i]["no_sep"] +"</td>";
                    tabel+="<td>"+ruangan[i]["nomr"] +"</td>";
                    tabel+="<td>"+ruangan[i]["no_bpjs"]+"</td>";
                    tabel+="<td>"+ruangan[i]["no_ktp"]+"</td>";
                    tabel+="<td>"+ruangan[i]["nama"]+"</td>";
                    tabel += "<td>" + ruangan[i]["grNama"] + "</td>"; //nomr, id_daftar,reg_unit, no_bpjs, no_ktp, nama_pasien, tgl_reg, tempat_lahir, tgl_lahir,grId,grNama,no_sep,tgl_keluar,id_daftar
                                                                                                                //"181618","2020043392","GD-200720-04-0001","00","1308145908840001","SALMIANTI","2020-07-20 05:48:18","PULAU","1984-08-19","4","RAWAT DARURAT LAINNYA","null"
                    
                    tabel += "<td><button type='button' class='btn btn-success btn-xs' onclick='getRowkunjungan(\"" + ruangan[i]["nomr"] + "\",\"" + ruangan[i]["id_daftar"] + "\",\"" + ruangan[i]["reg_unit"] + "\",\"" + ruangan[i]["no_bpjs"] + "\",\"" + ruangan[i]["no_ktp"] + "\",\"" + ruangan[i]["nama"] + "\",\"" + ruangan[i]["tgl_reg"] + "\",\"" + ruangan[i]["tempat_lahir"] + "\",\"" + ruangan[i]["tgl_lahir"] + "\",\"" + ruangan[i]["grId"] + "\",\"" + ruangan[i]["grNama"] + "\",\"" + no_sep + "\")'><span class='fa fa-check'></span></button></td>";
                    tabel+="</tr>";
                    //$('#data-pendaftaran').append(tabel)
                }
                //Create Pagination
                if (data["row_count"] <= data["limit"]) {
                    $('#pagination1').html("");
                } else {
                    var pagination = "";
                    var btnIdx = "";
                    jmlPage = Math.ceil(data["row_count"] / data["limit"]);
                    offset = data["start"] % data["limit"];
                    curIdx = Math.ceil((data["start"] / data["limit"]) + 1);
                    prev = (curIdx - 2) * data["limit"];
                    next = (curIdx) * data["limit"];

                    var curSt = (curIdx * data["limit"]) - jmlData;
                    var st = start;
                    var btn = "btn-default";
                    var lastSt = (jmlPage * data["limit"]) - jmlData
                    var btnFirst = "<button type='button' class='btn btn-default btn-sm' onclick='getKunjungan(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if (curIdx > 1) {
                        var prevSt = ((curIdx - 1) * data["limit"]) - jmlData;
                        btnFirst += "<button type='button' class='btn btn-default btn-sm' onclick='getKunjungan(" + prevSt + ")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast = "";
                    if (curIdx < jmlPage) {
                        var nextSt = ((curIdx + 1) * data["limit"]) - jmlData;
                        btnLast += "<button type='button' class='btn btn-default btn-sm' onclick='getKunjungan(" + nextSt + ")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast += "<button type='button' class='btn btn-default btn-sm' onclick='getKunjungan(" + lastSt + ")'><span class='fa fa-angle-double-right'></span></button>";

                    if (jmlPage >= 5) {
                        if (curIdx >= 3) {
                            var idx_start = curIdx - 2;
                            var idx_end = curIdx + 2;
                            
                            if (idx_end >= jmlPage) idx_end = jmlPage;
                            
                        } else {
                            var idx_start = 1;
                            var idx_end = 5;
                        }
                        for (var j = idx_start; j <= idx_end; j++) {
                            st = (j * data["limit"]) - jmlData;
                            if (curSt == st) btn = "btn-success"; else btn = "btn-default";
                            btnIdx += "<button type='button' class='btn " + btn + " btn-sm' onclick='getKunjungan(" + st + ")'>" + j + "</button>";
                        }
                    } else {
                        for (var j = 1; j <= jmlPage; j++) {
                            st = (j * data["limit"]) - jmlData;
                            if (curSt == st) btn = "btn-success"; else btn = "btn-default";
                            btnIdx += "<button type='button' class='btn " + btn + " btn-sm' onclick='getKunjungan(" + st + ")'>" + j + "</button>";
                        }
                    }
                    pagination += btnFirst + btnIdx + btnLast;
                    $('#pagination1').html(pagination);
                }

            }
            $('#data-pendaftaran').html(tabel);
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
    //alert(url);
}

function getRowkunjungan_old(id_daftar){
    var kode_jenis=$('#kode_jenis').val();
    if(kode_jenis=='RITL'){
        //url untuk menngambil data pasien rawat inap
        var url=base_url+"upload_berkas/ritlbyid/"+id_daftar;
    }else{
        //url untuk menngambil data pasien rawat Jalam
        var url=base_url+"upload_berkas/rjtlbyid/"+id_daftar;
    }

    $.ajax({
        url : url,
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
                var upload_berkas = data["data"];
                console.clear();
                console.log(upload_berkas);
                $('#nomr').val(upload_berkas.nomr);
                $('#id_daftar').val(upload_berkas.id_daftar);
                $('#no_bpjs').val(upload_berkas.no_bpjs);
                $('#no_ktp').val(upload_berkas.no_ktp);
                $('#nama_pasien').val(upload_berkas.nama);
                $('#tgl_reg').val(upload_berkas.tgl_reg);
                $('#tempat_lahir').val(upload_berkas.tempat_lahir);
                $('#tgl_lahir').val(upload_berkas.tgl_lahir);
                $('#grId').val(upload_berkas.grId);
                $('#grNama').val(upload_berkas.grNama);
                $('#no_sep').val(upload_berkas.no_sep);
                $('#tgl_pulang').val(upload_berkas.tgl_keluar);
                getHistoriberkas(upload_berkas.id_daftar);
                //alert(upload_berkas.no_sep);
                if(upload_berkas.no_sep==""||upload_berkas.no_sep==null) $('#no_sep').prop('readonly', false);
                else $('#no_sep').prop('readonly', true);
                //$('#csrf').val(data["csrf"]),
                $('#modal_form').modal('hide'); 
                $('.modal-title').text('Edit Data Upload_berkas'); 
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


function getRowkunjungan(nomr, id_daftar,reg_unit, no_bpjs, no_ktp, nama_pasien, tgl_reg, tempat_lahir, tgl_lahir,grId,grNama,no_sep){
    //"181618","2020043392","GD-200720-04-0001","00","1308145908840001","SALMIANTI","2020-07-20 05:48:18","PULAU","1984-08-19","4","RAWAT DARURAT LAINNYA","null"
    //alert(nomr);
    $('#nomr').val(nomr);
    $('#id_daftar').val(id_daftar);
    $('#reg_unit').val(reg_unit);
    $('#no_bpjs').val(no_bpjs);
    $('#no_ktp').val(no_ktp);
    $('#nama_pasien').val(nama_pasien);
    $('#tgl_reg').val(tgl_reg);
    $('#tempat_lahir').val(tempat_lahir);
    $('#tgl_lahir').val(tgl_lahir);
    $('#grId').val(grId);
    $('#grNama').val(grNama);
    $('#no_sep').val(no_sep);
    //alert("NOMR : " +nomr);
    getBerkas(id_daftar);
    getHistoriberkas(id_daftar);
    //alert(nomr);
    //alert(upload_berkas.no_sep);

    if (no_sep == "" || no_sep == null) $('#no_sep').prop('readonly', false);
    else $('#no_sep').prop('readonly', true);
    //$('#csrf').val(data["csrf"]),
    $('#modal_form').modal('hide');
    $('.modal-title').text('Edit Data Upload_berkas'); 
}
function getBerkas(id_daftar){
    var url = base_url + "upload_berkas/getberkas/" + id_daftar;
    console.clear();
    console.log(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            if (data["status"] == false) {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "error",
                    timer: 5000
                });
                //alert(data["message"]);
            } else {
                var a=data["data"];
                if (a.no_sep == "" || a.no_sep == null) {
                    $('#no_sep').prop('readonly', false);
                }
                else {
                    $('#no_sep').prop('readonly', true);
                    $('#no_sep').val(a.no_sep);
                }
                $('#tgl_pulang').val(a.tgl_pulang);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal({
                title: "Terjadi Kesalahan..!",
                text: "Gagal Saat Pengambilan data",
                type: "error",
                timer: 5000
            });
        }
    });
}
function getHistoriberkas(id_daftar){
    var url=base_url+"upload_berkas/histori/"+id_daftar;
    console.clear();
    console.log(url);
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var tabel=""
            if(data["status"]==false){
                swal({
                 title: "Peringatan",
                 text: data["message"],
                 type: "error",
                 timer: 5000
                });
                //alert(data["message"]);
            }else{
                var berkas = data["data"];
                var jmlData=berkas.length;
                //alert(jmlData);
                for(var i=0; i<jmlData;i++){
                    tabel+="<tr>";
                    tabel+="<td>"+berkas[i]["nama_berkas"] +"</td>";
                    tabel+="<td><div style='float:left'>"+berkas[i]["jml_halaman"]+" Halaman </div><div class='text-right'><a href='#' onclick='lihatDokumen(\""+berkas[i]["d_idfile"]+"\")'><span class='btn btn-success btn-xs '>Lihat</span></a></div></td>";
                    tabel+="</tr>";
                }
            }
            tabel+='</table>';
            $('#histori_berkas').html(tabel);
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

function lihatDokumen(idfile){
    var url = base_url+"upload_berkas/detail_berkas/"+idfile;
    $.ajax({
        url : url,
        type: "GET",
        dataType: "HTML",
        success: function(data)
        {
            $('#modal_detail').modal('show'); 
            $('#detail_berkas').html(data);
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
function halamanBerkas(){
    var jmlhalaman=$('#halaman_berkas').val();
    var form = "";
    var hal=0;
    for(var i=0; i<jmlhalaman; i++){
        hal++;
        form+='<div class="form-group">';
        form+='<label for="inputEmail3" class="col-sm-3 control-label">HALAMAN '+hal+'</label>';
        form+='<div class="col-sm-9">';
        form+='<input type="file" id="halaman'+i+'" name="userfile[]" >';
        form+='</div>';
        form+='</div>';
    }
    $('#file_berkas').html(form);
}

function hapusBerkas(id){
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
                window.location.href=base_url+"upload_berkas/form/"+id_file;
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