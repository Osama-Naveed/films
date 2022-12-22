@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Films List</div>

                <div class="card-body">
                       <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>SR #</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Release Date</th>
                                    <th>Rating</th>
                                    <th>Ticket Price</th>
                                    <th>Country</th>
                                    <th>Genre</th>
                                    @guest
                                        <th>comments</th>
                                    @else
                                        <th>Add comments</th>
                                    @endguest

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($films as $film)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{route('flims',['slug'=>$film->slug])}}">{{$film->name??''}}</a></td>
                                    <td>{{$film->description??''}}</td>
                                    <td>{{date('d-m-Y H:i A', strtotime($film->release_date))}}</td>
                                    <td>{{$film->rating??''}}</td>
                                    <td>{{$film->ticket_price??''}}</td>
                                    <td>{{$film->country??''}}</td>
                                    <td>{{$film->genre??''}}</td>
                                    @guest
                                    <th></th>
                                    @else
                                    <td><input type="text" class="form-control comment" data-id='{{$film->id}}'></td>
                                    @endguest
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $('.comment').change(function(e){
        var comment = $(this).val();
        var id = $(this).data('id');
        if (id) {
            $.ajax('{{route("add.comment")}}',{
                "method": "POST",
                "headers": {
                    'X-CSRF-Token': $("meta[name='csrf-token']").attr('content')
                },
                "data": {
                    'id'      : id, 
                    'comment' : comment,
                }
            }).then(data => {
                if (data.success) {
                    alert(data.message);
                }else{
                    alert(data.message);
                }
            })
        }
    });

});

   
</script>