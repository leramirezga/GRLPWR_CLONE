@if($errors->crearBlog->all() != null)
    <script>
        $(document).ready(function(){
            $('#crearInfoBlogModal').modal({show: true});
        });
    </script>
@endif


<!--modal crear blogs-->
<div class="modal fade" id="crearInfoBlogModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{route('crearBlog')}}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información de portada</h5>
                </div>
                <div class="modal-body">
                    @if ($errors->crearBlog->all() != null)
                        <div class="alert alert-danger redondeado">
                            <ul>

                                @foreach($errors->crearBlog->all() as $error)
                                    <li>
                                            <span class="invalid-feedback" role="alert" style="color: white">
                                                <strong>{{ $error}}</strong>
                                             </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label for="titulo" class="d-inline-block col-md-4 col-form-label text-md-right">Titulo</label>
                        <input id="titulo" name="titulo" required value="{{old('titulo')}}">
                    </div>
                    <div class="form-group row">
                        <label for="url" class="d-inline-block col-md-4 col-form-label text-md-right">Url</label>
                        <input id="url" name="url" required onkeypress='return validarAlfaNumerico(event, true, false)' value="{{old('titulo')}}">
                    </div>
                    <div class="form-group row">
                        <label for="portada" class="col-md-4"></label>
                        <input type="file" id="portada" name="portada" accept="image/*" value="{{old('portada')}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Escribir Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validarAlfaNumerico(tecla, guiones, espacio) {
        var valido = false;
        var validoGuiones = true;
        var validoEspacio = true;
        var validoAlfaNumerico = ((tecla.charCode >= 48 && tecla.charCode <= 57) || (tecla.charCode >= 65 && tecla.charCode <= 90) || (tecla.charCode >= 97 && tecla.charCode <= 122));
        if(guiones){
            valido = tecla.charCode == 45 || tecla.charCode == 95;
        }
        if(espacio){
            valido = valido || tecla.charCode == 32;
        }
        return valido || validoAlfaNumerico;
    }
</script>