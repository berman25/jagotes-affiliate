@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card iq-mb-3 border-primary">
                <div class="card-body text-primary">
                    <div class="d-flex flex-row">
                        <h4 class="card-title text-primary" >
                            <button class="btn btn-primary" onclick="history.back()">Go Back</button>
                        </h4>
                        
                    </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collection as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @if ($item->is_active)
                                                PUBLISH
                                            @else
                                                DRAFT
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('tryout.question-management', ['utbk_id' => $item->id])}}" class="btn btn-info"><i class="bi bi-gear-fill"></i></a>
                                    
                                        </td>
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