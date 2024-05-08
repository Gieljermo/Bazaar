@extends('layout', [
    'title' => 'Profiel bewerken'
])

@section('content')
    <div class="col">
        @include('partials.sidebar')
    </div>
    <div class="col">
        <form action="{{Route('commercial.page-builder.store', Auth::user()->id)}}" method="POST">
            @csrf
            <div id="componentContainer">
                @php
                    $index = 0
                @endphp
                @foreach ($components as $component)
                <div class="component-form-group form-group mb-4 card">
                    <label class="mb-2">
                        Titel
                    </label>
                    <input class="form-control" name="component[{{$index}}][header]" type="text" value="{{$component->header}}" placeholder="component titel"/>
                    <label class="mb-2">
                        Component Tekst
                    </label>
                    <input class="form-control" name="component[{{$index}}][text]" type="text" value="{{$component->text}}" placeholder="component tekst"/>
                    <label class="mb-2">
                        Producten toevoegen
                    </label>
                    <div class="listing-select">
                        <div tabindex="0" class="form-control listing-id-container">
                            <input type="text" class="hidden-search"/>
                        </div>
                        <div class="listing-list">
                            @foreach ($listings as $listing)
                                <div class="listing-option">
                                    <img src="{{$listing->getImageUrl()}}" alt="listing foto">
                                    <p>{{$listing->product->product_name}}</p>
                                    <p>{{$listing->price}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <input type="submit" value="verzenden"/>
        </form>
        <button id="addComponent" class="btn btn-primary">Component toevoegen</button>
    </div>
    <div class="col">

    </div>

    <script>

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.listing-id-container') && !event.target.closest('.listing-list')) {
                document.querySelectorAll('.listing-list').forEach(list => {
                    list.style.display = 'none';
                });
            }
        });

        
        let searchBoxes = document.querySelectorAll('.listing-id-container');
        let inputs = document.querySelectorAll('.hidden-search');
        let listingOptions = document.querySelectorAll('.listing-option');

        inputs.forEach(element => {
            element.addEventListener('input', function(e) {
                searchListing(e.target.value);
            })
        });

        listingOptions.forEach(option => {
            option.addEventListener('click', function() {
                let listingSelect = option.closest('.listing-select');
                let searchbox = listingSelect.querySelector('.listing-id-container');
                let idText = document.createElement('p');
                idText.innerText = "hallo";
                searchbox.appendChild(idText);
            })
        })


        searchBoxes.forEach(element => {
            element.addEventListener('click', function() {
                let input = element.querySelector('.hidden-search');

                let siblingListingList = element.closest('.listing-select').querySelector('.listing-list');

                document.querySelectorAll('.listing-list').forEach(list => {
                    list.style.display = 'none';
                });

                siblingListingList.style.display = 'block';

                input.focus();
            });
        });
        

        function searchListing(text){
            fetch(`/commercial/page-builder/search/autocomplete?query=${text}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Process and display your search suggestions here
                });
        }




        let componentContainer = document.getElementById('componentContainer');
        let addButton =  document.getElementById('addComponent');

        addButton.addEventListener('click', addComponent);

        function addComponent(){
            let index = document.querySelectorAll('.component-form-group').length;
            console.log(index);

            let container = document.createElement('div');
            container.classList.add('component-form-group','form-group' ,'mb-4', 'card')

            let titelLabel = document.createElement('label');
            titelLabel.innerText = 'Titel';
            titelLabel.classList.add('mb-2');
            

            let titleInput = document.createElement('input');
            titleInput.name = 'component['+index+'][header]';
            titleInput.placeholder = 'component titel';
            titleInput.classList.add('form-control')

            let textLabel = document.createElement('label');
            textLabel.innerText = 'Component Tekst';
            textLabel.classList.add('mb-2');

            let textInput = document.createElement('input');
            textInput.name = 'component['+index+'][text]';
            textInput.placeholder = 'component text';
            textInput.classList.add('form-control')

            container.appendChild(titelLabel);
            container.appendChild(titleInput);
            container.appendChild(textLabel);
            container.appendChild(textInput);

            componentContainer.appendChild(container);
        }
    </script>
@endsection

