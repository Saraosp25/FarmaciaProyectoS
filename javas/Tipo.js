$(document).ready(function(){
    buscar_tip();
    var funcion;
    var edit=false;
    $('#form-crear-tipo').submit(e=>{
        let nombre_tipo=$('#nombre-tipo').val();
        let id_editado=$('#id_editar_tip').val();
        if(edit==false){
            funcion='crear';
            //e.preventDefault();
            //console.log (edit);
        }
        else{
            funcion='editar';
            //console.log(nombre_laboratorio+id_editado);
        }
        $.post('../controlador/TipoController.php',{nombre_tipo,id_editado,funcion},(response)=>{
            console.log (response);
            if(response=='add'){
               
                $('#add-tipo').hide('slow');
                $('#add-tipo').show(1000);
                $('#add-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tip();
            }
            if(response=='noadd'){
                $('#noadd-tipo').hide('slow');
                $('#noadd-tipo').show(1000);
                $('#noadd-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tip();
            }
            if(response=='edit'){
                $('#edit-tip').hide('slow');
                $('#edit-tip').show(1000);
                $('#edit-tip').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tip();
            }
            edit==false;
        });
        e.preventDefault();
    });
    function buscar_tip(consulta){
        funcion='buscar';
        $.post('../controlador/TipoController.php',{consulta,funcion},(response)=>{
           
            const tipos = JSON.parse(response);
            template='';
            

            tipos.forEach(tipo => {
                template+=`
                <tr tipId="${tipo.id_editado}" tipNombre="${tipo.nombre}">
                    <td>
                        <button class="editar-tip btn btn-success" title="Editar el laboratorio" type="button" data-toggle="modal" data-target="#creartipo">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button class="borrar-tip btn btn-danger" title="Eliminar laboratorio">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                    <td>${tipo.nombre} </td>
                </tr>
                `;
            });

            $('#tipos').html(template);
        })
    }
    $(document).on('keyup','#buscar-tipo',function(){
        let valor =$(this).val();
        if(valor!=''){
            buscar_tip(valor);
        }
        else{
            buscar_tip();
        }
    })
    $(document).on('click','.borrar-tip',(e)=>{
        funcion='borrar';
        const elemento=$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('tipId');
        const nombre=$(elemento).attr('tipNombre');
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            title: 'Desea eliminar tipo:  '+nombre+'?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, borrar esto!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.confirmButton) {
                //console.log(id,funcion);
                $.post('../controlador/TipoController.php',{id,funcion},(response)=>{
                    console.log(response);
                    edit==false;
                    //console.log(response);
                    buscar_tip();
                })
             } else if (result.dismiss === Swal.DismissReason.cancel)
            {
              swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
              )
              buscar_tip();
              
              

            }
          })
    })
    $(document).on('click','.editar-tip',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('tipId');
        const nombre=$(elemento).attr('tipNombre');
        $('#id_editar_tip').val(id);
        $('#nombre-tip').val(nombre);
        edit=true;
        console.log(id+nombre);
    })
});