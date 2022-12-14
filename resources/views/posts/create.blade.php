@extends('layouts.app')

@section('title')Create @endsection

@section('content')
<form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Title</label>
    <input name="title" type="text" class="form-control" id="exampleFormControlInput1" value="{{old('title')}}">
  </div>
  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
    <textarea name='description' class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('description')}}</textarea>
  </div>
  <div class="my-3">
    <input class="form-control form-control-lg" name="image" id="formFileLg" type="file" value="{{old('image')}}">
  </div>
  <div class="mb-3">
    <button type="submit" class="btn btn-success">Create Post</button>
  </div>
</form>
@endsection