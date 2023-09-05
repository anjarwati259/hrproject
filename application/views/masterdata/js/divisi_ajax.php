<script type="text/javascript">
  var pesan = localStorage.getItem("sukses");
  if(pesan)
  {
      Swal.fire({
        icon: 'success',
        title: pesan,
        showConfirmButton: false,
        timer: 3000
      })
      localStorage.removeItem('sukses');
  }

  function save(){
    var data = new FormData(document.getElementById("form-divisi"));
    for (const keyinput of data.keys()){
        let inputAwal = $("#form-divisi").find('.is_invalid').remove();
    }

    $.ajax({
        type: 'POST',
        url: "<?php echo base_url('masterdata/divisi/save'); ?>",
        data:data,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){
          $( ".btn-submit" ).addClass( "d-none" );
          $( ".btn-loading" ).removeClass( "d-none" );
        },
        success: function(data){
            console.log(data);
            $( ".btn-loading" ).addClass( "d-none" );
            $( ".btn-submit" ).removeClass( "d-none" );

            if(data.status == 'success'){
                // $('#addNewCard').modal('hide');
                localStorage.setItem("sukses",data.message)
                location.reload();
            }else{
                // localStorage.setItem("error",data.message)
                Swal.fire('Oppss...',data.message,'error')
            }

            $.each(data.atribute, function (key, value){
                let formCheck = $("#form-divisi #"+key);

                if(value){
                    formCheck.addClass('is-invalid') 
                }else{
                    formCheck.removeClass('is-invalid')
                }
                formCheck.after("<div class='invalid-feedback'>"+value+"</div>");
            })
        },
    });
  }

  function edit(id){
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url('masterdata/divisi/getDivisiById'); ?>",
        data:{id:id},
        dataType : 'json',
        success: function(hasil) {
           $.each(hasil, function (key, value){
            let formCheck = $("#"+key);
            formCheck.val(value);
        }) 
        }
    });
  }

  function hapus(id){
        Swal.fire({
            title: '',
            text: 'Apakah Anda Yakin Akan Menghapus Data Ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes',
            allowOutsideClick: false 
        }).then((result, e) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('masterdata/divisi/delete'); ?>",
                    data:{id:id},
                    dataType : 'json',
                    success: function(hasil) {
                      console.log(hasil)
                      if(hasil.status == 'success'){
                            localStorage.setItem("sukses",hasil.message)
                            window.location.reload();
                        }else{
                            // localStorage.setItem("error",data.message)
                            Swal.fire('Oppss...',hasil.message,'error')
                        } 
                    }
                });
            }
        })
    }
  
  var dataTable = $('.datatables-basic').DataTable({  
     "processing":true,  
     "serverSide":true,  
     "order":[],  
     "ajax":{  
          url:"<?php echo base_url('masterdata/divisi/getDivisi'); ?>",  
          type:"POST"  
     },  
     "columnDefs":[  
          {  
               "targets":[0],
               "orderable":false,  
          },  
     ],  
  });
</script>