@extends('layout', [
    'title' => 'Bazaar',
    'heading' => 'Producten van '.Auth::user()->name. " ".Auth::user()->lastname
])
@section("content")
    @php
        $countRow = 1;

        $typeProduct = [
            'set' => "Vaste prijs",
            'bidding' => "Bieden",
            'rental' => "Verhuur"
            ]
    @endphp
    <div class="row">
        <div class="col-2">
            <form id="filterForm" action="{{ route('advert.listings') }}" method="GET">
                <div class="d-flex flex-column">
                    <label>Filter op Type:</label>
                    <select class="w-50" name="type" id="type" onchange="this.form.submit()">
                        <option value="" >Geen filter</option>
                        <option value="bidding" @if(request('type')=='bidding') selected @endif>Veiling</option>
                        <option value="rental" @if(request('type')=='rental') selected @endif>Verhuur</option>
                        <option value="set" @if(request('type')=='set') selected @endif>Vaste Prijs</option>
                    </select>
                </div>

                <fieldset class="d-flex flex-column">
                    <legend>Sorteren:</legend>
                    <label>
                        <input checked type="radio" name="sort" value="" onchange="this.form.submit()">
                        Geen filter
                    </label>

                    <label>
                        <input type="radio" @if(request('sort')=='asc') checked @endif name="sort" value="asc" onchange="this.form.submit()">
                        Prijs (Laag naar Hoog)
                    </label>

                    <label>
                        <input type="radio" @if(request('sort')=='desc') checked @endif name="sort" value="desc" onchange="this.form.submit()">
                        Price (Hoog naar Laag)
                    </label>
                </fieldset>
            </form>
        </div>
        <div class="col mt-5">
            @if (session('success'))
                <div class="alert alert-success w-50">
                    <li>
                        {{ session('success') }}
                    </li>
                </div>
            @endif
            @if (session('failed'))
                <div class="alert alert-danger w-25">
                    <li>
                        {{ session('failed') }}
                    </li>
                </div>
            @endif
            <h2 class="mb-5 text-uppercase">Jouw  producten</h2>
            <table class="table" >
                <thead class="text-center text-uppercase">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Product naam</th>
                    <th scope="col">Product prijs</th>
                    <th scope="col">beschrijven</th>
                    <th scope="col">type producten</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($listings as $listing)
                    <tr>
                        <th scope="row">{{$countRow++}}</th>
                        <td>{{$listing->product->product_name}}</td>
                        <td>{{ ($listing->type == "bidding") ? $listing->price_from : $listing->price}}</td>
                        <td>{{$listing->product->description}}</td>
                        <td>{{$typeProduct[$listing ->type] ?? ""}}</td>
                        <td>
                            <form method="GET" action="{{ route('listings.edit', $listing->id) }}">
                                @csrf
                                <button class="btn btn-primary" type="submit">Wijzigen</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('listings.destroy', $listing->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="page-link mt-3 ms-2">
                {{$listings->links()}}
            </div>
            <div class="mt-4 ms-2">
                <a href="{{ route('advert.export.csv') }}" class="btn btn-primary">Export to CSV</a>
            </div>
        </div>
        <div class="col-3">
            <form class="mt-3 p-5"  action="{{route('advert.upload.csv')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="text-uppercase" for="">Upload een CSV </label>
                    <input class="btn-primary mt-2 form-control" type="file" accept=".csv" name="csv_file">
                    <button class="btn btn-secondary mt-2" type="submit">Upload CSV</button>
                </div>
            </form>

        </div>
    </div>
@endsection
