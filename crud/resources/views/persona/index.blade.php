@extends('layout')
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>
@section('content')
 <!-- Content Header (Page header) -->
 <section class="content-header">
      <h1>
        Crud
        <small>Persona</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Persona</a></li>
        <li class="active">Index</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-xs-12">
          <div class="box">
          <div class="box">
            <div class="box-header">
             
              
              <button type="button" class="btn btn-success" id="create">
                Nuevo
              </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped"  width="100%">
                         <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Edad</th>
                                <th>Correo</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>

          
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="modelHeading"></h4>
              </div>
              <div class="modal-body">
              <form class="form-horizontal" id="form_persona">
                    <input type="hidden" name="id" id="id" name="id">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Nombres</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombres">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Apellidos</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Edad</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" id="edad" name="edad" placeholder="Edad">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Correo</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo">
                      </div>
                    </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBtn"></button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        <div>



    </section>
    <!-- /.content -->
    @endsection

 @section('script')
 

<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript"> 

    
       $(function () {

          $('#example2').DataTable({
         serverSide: true,
         ajax: {
          url: "http://127.0.0.1:8000/api/getProducto",
          type: 'GET',
         },
         columns: [
                  {data: 'id', name: 'id', 'visible': false},
                  {data: 'nombre', name: 'nombre', orderable: true,searchable: true},
                  { data: 'apellido', name: 'apellido' },
                  { data: 'edad', name: 'edad' },
                  { data: 'correo', name: 'correo' },
                  {data: 'action', name: 'action', orderable: false},
               ],
          order: [[0, 'desc']]
        });

      });


      $('#create').click(function () {
        $(".error").remove();
        $('#saveBtn').text("Crear");
        $('#id').val('');
        $('#form_persona').trigger("reset");
        $('#modelHeading').html("Crear");
        $('#modal-default').modal('show');
    });



    $('#saveBtn').click(function (e) {
        e.preventDefault();
        var nombre=$("#nombre").val();
        var apellido=$("#apellido").val();
        var edad=$("#edad").val();
        var correo=$("#correo").val();

        var state=false;
            $(".error").remove();
            if (nombre.length < 1) {
               $('#nombre').after('<span class="error">Este campo es requerido.</span>');
               state=true;
            }
            if (apellido.length < 1) {
                $('#apellido').after('<span class="error">Este campo es requerido.</span>');
                state=true;
            }
            if (edad.length < 1 && !(/^\s+$/.test(edad))) {
                $('#edad').after('<span class="error">Este campo es requerido y numerico.</span>');
                state=true;
            
            }
            if (correo.length < 1 ) {
                $('#correo').after('<span class="error">Este campo es requerido.</span>');
                state=true;
            }else {
                var regEx = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                var validEmail = regEx.test(correo);
                if (!validEmail) {
                  state=true;
                  $('#correo').after('<span class="error">Ingresar un correo válido.</span>');
                }
            }

      if(state===false){

        var id=$("#id").val();
        if(id.length>0){
          url="http://127.0.0.1:8000/api/editar";
        }else{
          url="http://127.0.0.1:8000/api/create";
        }
              $.ajax({
                data: $('#form_persona').serialize(),
                url: url,
                type: "POST",
                dataType: 'json',
                success: function (data) {
          
                    $('#form_persona').trigger("reset");
                    $('#modal-default').modal('hide');
                    var oTable = $('#example2').dataTable();
                    oTable.fnDraw(false);
              
                },
                error: function (data) {
                }
            });
      }
     


    });

      function editar(id){
        $(".error").remove();
        $('#saveBtn').text("Editar");
        $('#form_persona').trigger("reset");
        $('#modelHeading').html("Editar");
        $('#modal-default').modal('show');
        var parametros = {"id":id};
     
        var dataObject = JSON.stringify({'id': id });
        $.ajax({
              url: "http://127.0.0.1:8000/api/buscar",
              type: "post",
              dataType: "json",
              data: dataObject,
              contentType: "application/json",
              success: function (DataJson) {
                //alert(DataJson);
                for(data in DataJson){
                  $('#id').val(DataJson[data].id);
                  $('#nombre').val(DataJson[data].nombre);
                  $('#apellido').val(DataJson[data].apellido);
                  $('#edad').val(DataJson[data].edad);
                  $('#correo').val(DataJson[data].correo);
                }
                  
              }

          })
          .fail(function (err) {
              console.log(err);
          });
      }


      function eliminar(id){
        $('#modelHeading').html("Eliminar");
        if (!confirm("¿Deseas eliminar este registro?")) {
        return 0;
        }
        var dataObject = JSON.stringify({'id': id });
        $.ajax({
              url: "http://127.0.0.1:8000/api/eliminar",
              type: "post",
              dataType: "json",
              data: dataObject,
              contentType: "application/json",
              success: function (DataJson) {
                var oTable = $('#example2').dataTable();
              oTable.fnDraw(false);
                  
              }

          })
          .fail(function (err) {
              console.log(err);
          });

      }



        
    </script>
 @endsection