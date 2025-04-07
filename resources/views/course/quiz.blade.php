@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="pagetitle">
    <h1>Course Quiz</h1>    
</div><!-- End Page Title -->
<button class="btn btn-secondary mb-3" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>

<section class="section dashboard">
    <div class="row">
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    
                    <h5 class="card-title">{{$module->title}}</h5>
                    @if (!$quiz)                        
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
                      Tambah Quiz
                  </button>                        
                    @else
                    <h4 class="card-title text-primary">{{$quiz->name}}</h4>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>               
                                <th>Answer</th>
                                <th>Text</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $item)
                            <tr>
                                <td><a href="{{route('question.show',['questionid'=>$item->id])}}">{{$item->id}}</a></td>
                                <td>{{$item->correct_answer}}</td>
                                <td>
                                    {!!html_entity_decode(trim(preg_replace('/\s+/', ' ', $item->question_text)))!!}
                                </td>
                            </tr>                            
                            @endforeach
                            
                        </tbody>
                    </table>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Create -->
    <div class="modal fade" id="modalAdd" tabindex="-1">
      <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>                
          </div>
          
          <div class="modal-body">
              <form action="{{route('course-quiz.create', ['module_id' => $module->id])}}" method="POST">
                @csrf                                          
                @method('POST')                                   
                  <div class="form-group">
                      <label class="control-label">Jumlah Soal</label>                    
                      <input type="number" class="form-control" name="total_question" required>                    
                  </div>                  

                  <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Create
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
</section>

@stop