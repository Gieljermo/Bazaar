<div class="modal fade" id="{{$type}}Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($rentData as $data)
                    @if($type == "from")
                        <p class="modal-text">{{$data->from->format('H:i')}} - {{$data->listing->product->product_name}}</p>    
                    @elseif ($type == 'until')
                        <p class="modal-text">{{$data->until->format('H:i')}} - {{$data->listing->product->product_name}}</p>  
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>