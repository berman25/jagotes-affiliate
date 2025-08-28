@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card iq-mb-3 border-primary">
                <div class="card-body text-primary">
                    <right>
                        <h4 class="card-title text-primary" >
                            <button class="btn btn-primary" onclick="history.back()">Go Back</button>
                        </h4>
                    </right>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Lihat</th>
                                <th>Jawaban</th>
                                <th>Soal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $item)
                            <tr>
                                <td>{{$item->sequence}}</td>
                                
                                <td><a href="{{route('question.show',['questionid'=>$item->id])}}">{{$item->name}}</a></td>
                                
                                <td>{{$item->correct_answer}}</td>
                                <td>
                                    {!!html_entity_decode(trim(preg_replace('/\s+/', ' ', $item->question_text)))!!}
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
