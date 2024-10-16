@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Session::has('message'))
            <div class="alert alert-success">
                {{Session::get('message')}}
            </div>
            @endif
            <div class="card">
                <div class="card-header">All Motors <a href="{{route('category.index')}}">All Categories</a></div>

                <div class="card-body">


                    <table class="table">
                        <a href="{{route('motor.create')}}"><button class="btn btn-outline-success">Create</button></a>
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Category</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($motors)>0)
                            @foreach($motors as $key=>$motor)
                            <tr>
                                <!--<th scope="row">{{$key+1}}</th>-->
                                <td><img src="{{asset('image')}}/{{$motor->image}}" width="100" alt=""></td>
                                <td>{{$motor->name}}</td>
                                <td>{{$motor->description}}</td>
                                <td>{{$motor->price}}</td>
                                <td>{{$motor->category->name}}</td>
                                <td>
                                    <a href="{{route('motor.edit', [$motor->id])}}">
                                    <button class="btn btn-outline-success">Edit</button></a>
                                </td>
                                <td>
                                    <form action="{{ route('motor.destroy', [$motor->id]) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <td>Tidak ada kategori yang dapat ditampilkan.</td>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
