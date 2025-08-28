@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card iq-mb-3 border-primary">
                <div class="card-body text-primary">
                    
                    <h4 class="card-title text-primary" >
                        <button class="btn btn-primary" onclick="history.back()">Go Back</button>
                    </h4>
                    
                    <table class="table table-bordered mt-5">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Total Question</th>
                                <th>Duration(minutes)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subject as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td><a href="{{route('tryout.question-view',['assessment_id'=>$item->id])}}">{{$item->name}}</a></td>
                                <td>{{$item->total_question}}</td>
                                <td>{{$item->duration}}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>

                    </table>
                
                </div>
            </div>
        </div>        
    </div>    
</div>


@endsection