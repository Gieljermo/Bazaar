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
                    <div class="listing-select" data-index="{{$index}}">
                        <div tabindex="0" class="form-control listing-id-container">
                            @foreach ($component->listings as $listing)
                                <input type="hidden" name="component[{{$index}}][product][]" value="{{$listing->id}}"/>
                                <p>{{$listing->product->product_name}}</p>
                            @endforeach
                            <input type="text" class="hidden-search"/>
                        </div>
                        <div class="listing-list">
                           @include('partials.page-builder.listing-list', ['listings' => $listings])
                        </div>
                    </div>
                </div>
                @php
                    $index++
                @endphp
                @endforeach
            </div>
            <input type="submit" value="verzenden"/>
        </form>
        <button id="addComponent" class="btn btn-primary">Component toevoegen</button>
    </div>
    <div class="col">

    </div>

    <script defer>
        UpdateSelectBoxes();
        
        function UpdateSelectBoxes() {
            let searchBoxes = document.querySelectorAll('.listing-id-container');
            let inputs = document.querySelectorAll('.hidden-search');

            
            document.removeEventListener('click', handleDocumentClick);
            document.addEventListener('click', handleDocumentClick);

            searchBoxes.forEach(element => {
                if (!element.dataset.listener) {
                    element.addEventListener('click', handleSearchBoxClick);
                    element.dataset.listener = 'true';
                }
            });

            inputs.forEach(element => {
                if (!element.dataset.listener) {
                    element.addEventListener('input', function (e) {
                        searchListing(e.target.value);
                    });
                    element.dataset.listener = 'true';
                }
            });

            updateListingOptions();
        }

        function handleDocumentClick(event) {
            if (!event.target.closest('.listing-id-container') && !event.target.closest('.listing-list')) {
                document.querySelectorAll('.listing-list').forEach(list => {
                    list.style.display = 'none';
                });
            }
        }

        function handleSearchBoxClick() {
            let input = this.querySelector('.hidden-search');
            let siblingListingList = this.closest('.listing-select').querySelector('.listing-list');

            document.querySelectorAll('.listing-list').forEach(list => {
                list.style.display = 'none';
            });

            siblingListingList.style.display = 'block';
            input.focus();
        }

        function updateListingOptions() {
            let listingOptions = document.querySelectorAll('.listing-option');
            listingOptions.forEach(option => {
                if (!option.dataset.listener) {
                    option.addEventListener('click', handleListingOptionClick);
                    option.dataset.listener = 'true';
                }
            });
        }

        function handleListingOptionClick() {
            let listingSelect = this.closest('.listing-select');
            let searchbox = listingSelect.querySelector('.listing-id-container');
            let idText = document.createElement('p');
            let componentIndex = listingSelect.dataset.index;

            idText.innerText = this.querySelector('.listing-name').innerText;
            
            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden'
            hiddenInput.name = 'component['+componentIndex+'][product][]'
            hiddenInput.value = this.dataset.id

            searchbox.appendChild(idText);
            searchbox.appendChild(hiddenInput);

            this.remove();
        }
        

        function searchListing(text){
            fetch(`/commercial/page-builder/search/autocomplete?query=${text}`)
                .then(response => response.json())
                .then(data => {
                    console.log(text)
                    console.log(data); 
                });
        }




        let componentContainer = document.getElementById('componentContainer');
        let addButton =  document.getElementById('addComponent');

        addButton.addEventListener('click', addComponent);

        function addComponent(){
            let index = document.querySelectorAll('.component-form-group').length;

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

            let productLabel = document.createElement('label');
            productLabel.innerText = 'Producten toevoegen';
            productLabel.classList.add('mb-2');

            let listingSelect  = document.createElement('div');
            listingSelect.classList.add('listing-select');
            listingSelect.setAttribute('data-index', index);

            let hiddenSearchContainer = document.createElement('div');
            hiddenSearchContainer.tabIndex = 0;
            hiddenSearchContainer.classList.add('form-control', 'listing-id-container')
            

            let hiddenSearch = document.createElement('input');
            hiddenSearch.type = 'text';
            hiddenSearch.classList.add('hidden-search');

            listingSelect.appendChild(hiddenSearchContainer);
            hiddenSearchContainer.appendChild(hiddenSearch);

            let listingList = document.createElement('div');
            listingList.classList.add('listing-list');
            

            fetch('http://bazaar.test/api/listing-partial', {
                    credentials: 'include'
                })
                .then(response => response.text())
                .then(html => {
                    const div = document.createElement('div');
                    div.innerHTML = html;
                    listingList.appendChild(div);

                    listingSelect.appendChild(listingList);

                    container.appendChild(titelLabel);
                    container.appendChild(titleInput);
                    container.appendChild(textLabel);
                    container.appendChild(textInput);
                    container.appendChild(productLabel);
                    container.appendChild(listingSelect);

                    componentContainer.appendChild(container);

                    UpdateSelectBoxes();
                })

        }
    </script>
@endsection

