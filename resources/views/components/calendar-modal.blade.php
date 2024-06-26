<div class="modal fade" id="{{$type}}Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @foreach ($rentData as $data)
                    @if($type == "rented")
                        <p class="modal-text">{{$data->user->name}} {{$data->user->lastname}} - {{$data->listing->product->product_name}}</p>       
                    @elseif ($type == 'hired')
                        <p class="modal-text">{{$data->listing->user->name}} {{$data->listing->user->lastname}} - {{$data->listing->product->product_name}}</p>    
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button id="close_button" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>