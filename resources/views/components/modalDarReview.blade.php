<!--modal dar review-->
<div class="modal fade" id="{{$reviewModalId}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{$route}}" autocomplete="off">
                @csrf

                <input type="hidden" name="rating" id="rating">
                <input type="hidden" name="reviewFor" id="reviewFor" value="{{$reviewFor}}">

                <div class="modal-header" style="border-bottom: none">
                    <h5 class="modal-title">¿Qué tal estuvo tu clase de <strong>{{$questionTitle}}</strong>?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-bottom: 0">
                    <img style="width: 200px; height: 50px; margin-bottom: 0" alt="rating"
                         src="{{asset('images/empty_rating.png')}}">
                    <div style="width: 200px; height: 1px" class="mb-3">
                        <div id="rating1" class="dar-rating" style="width: calc(40px); z-index: 5;"
                             onclick="darRating(this)"></div>
                        <div id="rating2" class="dar-rating" style="width: calc(80px); z-index: 4;"
                             onclick="darRating(this)"></div>
                        <div id="rating3" class="dar-rating" style="width: calc(120px); z-index: 3;"
                             onclick="darRating(this)"></div>
                        <div id="rating4" class="dar-rating" style="width: calc(160px); z-index: 2;"
                             onclick="darRating(this)"></div>
                        <div id="rating5" class="dar-rating" style="width: calc(200px); z-index: 1;"
                             onclick="darRating(this)"></div>
                        <div id="ratingSeleccionado"></div>
                        <script>
                            function darRating(rating) {
                                var numeroRating = rating.id.substring(6, 7);
                                $('#rating' + document.getElementById('rating').value).removeClass('dar-rating-seleccionado');
                                document.getElementById('rating').value = numeroRating;
                                $('#ratingSeleccionado').css('width', 200 * numeroRating / 5 + 'px');
                            }

                            $('.dar-rating').mouseover(function () {
                                $('#ratingSeleccionado').css('display', 'none');
                            });
                            $('.dar-rating').mouseleave(function () {
                                $('#ratingSeleccionado').css('display', 'block');
                            });
                        </script>
                    </div>
                    <p>Review:</p>
                    <textarea class="text-area d-block form-control h-auto" maxlength="140" style="width: 100%;"
                              placeholder="Puedes escribir un comentario describiendo que te gustó y que no te gustó o como podemos mejorar tu experiencia"
                              rows="3" type="text" name="review"></textarea>
                </div>
                <div class="modal-footer" style="border-top: 0; padding-top: 0">
                    <button type="submit" class="btn btn-success">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
</div>