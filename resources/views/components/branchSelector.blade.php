<div class="p-0 m-0">
        <h4>Sucursal:</h4>
        <select class="form-control color-white px-3" id="branch" name="branch" onchange="onSelectBranch(this)">
                <option style="color: black" value="" disabled>Selecciona...</option>
            @foreach($branches as $branch)
                <option style="color: black" value="{{$branch->id}}">{{$branch->name}}</option>
            @endforeach
        </select>
</div>


@push('scripts')
        <script>
                function onSelectBranch(input) {
                        var query = input.value;
                        if (query != '') {
                                //var _token = ('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                        headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "{{ route($route) }}",
                                        method: "POST",
                                        data: {query: query},
                                        success: function (data) {
                                                if (data.includes('<li')) {//solo cuando trae resultado muestra el div
                                                        $('#tagList' + id).fadeIn();
                                                        $('#tagList' + id).html(data);
                                                } else {
                                                        $('#tagList' + id).fadeOut();
                                                }
                                        },
                                });
                        }
                }
        </script>
@endpush