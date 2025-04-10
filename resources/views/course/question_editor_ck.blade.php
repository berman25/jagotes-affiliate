@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('css')
{{-- <link href="{{ asset('text-editor/editor.css') }}" type="text/css" rel="stylesheet"/> --}}
<style>
    #container {
        width: 1000px;
        margin: 20px auto;
    }
    
    .ck-content .image {
        /* Block images */
        max-width: 80%;
        margin: 20px auto;
    }
</style>
@stop

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
                <form id="formQuestion" class="form-horizontal">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Nomor Soal</td>
                                <td><input class="form-control" name="sequence" type="text" id="questSeq"></td>
                            </tr>
                            <input type="hidden" name="name" type="text" id="questName">
                            {{-- <input type="hidden" name="type" value="singlechoice"> --}}
                            <tr>
                                <td>Question Type</td>
                                <td>
                                    <select class="form-control" id="questType" name="type" required>
                                        <option value="singlechoice">SINGLE CHOICE</option>
                                        <option value="essay">ISIAN</option>
                                        <option value="truefalse">TRUE FALSE</option>                                        
                                        <option value="multiplechoice">MULTIPLE CHOICE</option>
                                    </select>
                                </td>                                
                            </tr>
                            {{-- <tr>
                                <td>Table Header</td>
                                <td><textarea name="metadata" class="form-control" cols="30" rows="3" id="questHeader"></textarea></td>
                            </tr> --}}
                            <tr>
                                <td>Bacaan (Opsional)</td>
                                <td><div id="txtEditor1"></div></td>
                            </tr>
                            <tr>
                                <td>Pertanyaan</td>
                                <td><div id="txtEditor2"></div></td>
                            </tr>
                            
                            <tr class="choice">
                                <td colspan="2">PILIHAN</td>
                                <td>SKOR</td>          
                            </tr>
                            <tr class="choice">
                                <td>A</td>
                                <td><div id="optiona"></div></td>
                                <td>
                                    <input class="form-control" type="number" name="scorea" id="scorea" value="0">
                                </td>
                            </tr>
                            <tr class="choice">
                                <td>B</td>
                                <td><div id="optionb"></div></td>
                                <td>
                                    <input class="form-control" type="number" name="scoreb" id="scoreb" value="0">
                                </td>
                            </tr>
                            <tr class="choice">
                                <td>C</td>
                                <td><div id="optionc"></div></td>
                                <td>
                                    <input class="form-control" type="number" name="scorec" id="scorec" value="0">
                                </td>
                            </tr>
                            <tr class="choice">
                                <td>D</td>
                                <td><div id="optiond"></div></td>
                                <td>
                                    <input class="form-control" type="number" name="scored" id="scored" value="0">
                                </td>
                            </tr>
                            <tr class="choice">
                                <td>E</td>
                                <td><div id="optione"></div></td>
                                <td>
                                    <input class="form-control" type="number" name="scoree" id="scoree" value="0">
                                </td>
                            </tr>
                            
                            <tr class="essay" style="display:none">
                                <td>JAWABAN</td>
                                <td><input class="form-control" type="text" id="essay_answer" name="essay_answer"></td>
                            </tr>
                            <tr>
                                <td>Solusi</td>
                                <td><div id="txtEditor3"></div></td>
                                {{-- <td><div id="editor"></div></td> --}}
                            </tr>
                            <tr>
                                <td>Video Pembahasan</td>
                                <td><input class="form-control" name="video_solution" type="text" id="videoSolution"></td>
                            </tr>
                        </tbody>
                    </table>

                    <button class="btn btn-primary">submit</button>
                    <a href="#" target="blank" class="btn btn-secondary" id="preview">preview</a>

                </form>
                
                </div>
            </div>
        </div>        
    </div>

    
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
{{-- <script src="{{ asset('text-editor/editor.js') }}"></script> --}}
<script>
    ClassicEditor
		.create( document.querySelector( '#txtEditor1' ) )
        .then( newEditor => {
            editor1 = newEditor;
        } )
		.catch( error => {
			console.error( error );
		} );

    ClassicEditor
		.create( document.querySelector( '#txtEditor2' ) )
        .then( newEditor => {
            editor2 = newEditor;
        } )
		.catch( error => {
			console.error( error );
		} );

    ClassicEditor
		.create( document.querySelector( '#txtEditor3' ) )
        .then( newEditor => {
            editor3 = newEditor;
        } )
		.catch( error => {
			console.error( error );
		} );

    ClassicEditor
		.create( document.querySelector( '#optiona' ) )
        .then( newEditor => {
            editora = newEditor;
        } )
		.catch( error => {
			console.error( error );
		} );

    ClassicEditor
		.create( document.querySelector( '#optionb' ) )
        .then( newEditor => {
            editorb = newEditor;
        } )
		.catch( error => {
			console.error( error );
		} );

    ClassicEditor
		.create( document.querySelector( '#optionc' ) )
        .then( newEditor => {
            editorc = newEditor;
        } )
		.catch( error => {
			console.error( error );
		} );

    ClassicEditor
		.create( document.querySelector( '#optiond' ) )
        .then( newEditor => {
            editord = newEditor;
        } )
		.catch( error => {
			console.error( error );
		} );

    ClassicEditor
		.create( document.querySelector( '#optione' ) )
        .then( newEditor => {
            editore = newEditor;
        } )
		.catch( error => {
			console.error( error );
		} );
</script>
<script type="text/javascript">
$(document).ready( function($) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    jQuery.validator.setDefaults({
        // This will ignore all hidden elements alongside `contenteditable` elements
        // that have no `name` attribute
        ignore: ":hidden, [contenteditable='true']:not([name])"
    });

    function isNumeric(value) {
        return /^-?\d+$/.test(value);
    }

    $('#questType').change(function(){ 
        var value = $(this).val();
        if(value == 'essay'){
            $('.choice').hide()
            $('.essay').show()
        }else{
            $('.choice').show()
            $('.essay').hide()
        }
    });

    function loadquestion(question_id){
        $.ajax({
            url: '{{ url("course/quiz/show-question") }}',           
            type: "get",
            data: {
                question_id : question_id
            },
            success: function (data) {
                $('#subject-name').html(data.subject_name);
                editor1.setData(data.question.description ?? "")
                editor2.setData(data.question.question_text ?? "")
                editor3.setData(data.question.question_solution ?? "")
                // $('#txtEditor1').Editor("setText", data.question.description);
                // $('#txtEditor2').Editor("setText", data.question.question_text);
                // $('#txtEditor3').Editor("setText", data.question.question_solution);
                $('#questSeq').val(data.question.sequence);
                $('#questName').val(data.question.name);
                $('#questHeader').val(data.question.metadata);      
                $('#questType').val(data.question.type);
                $('#videoSolution').val(data.question.video_solution);

                if(data.question.type == 'essay'){
                    $('.choice').hide()
                    $('.essay').show()
                    $('#essay_answer').val(data.options[0].option)
                }else{
                    
                    data.options.forEach(e => {
                        switch (e.option) {
                            case 'a':
                                editora.setData(e.text ?? "")
                                break;
                        
                            case 'b':
                                editorb.setData(e.text ?? "")
                                break;
                                
                            case 'c':
                                editorc.setData(e.text ?? "")
                                break;
                        
                            case 'd':
                                editord.setData(e.text ?? "")
                                break;
                        
                            case 'e':
                                editore.setData(e.text ?? "")
                                break;
                        
                            default:
                                break;
                        }
                        
                        $('#score'+e.option).val(e.grade);
                        console.log('#score'+e.option, e.grade)
                    });
                }
                
                                

                

                preview = "https://portal-cpns.jagotes.id/preview/cat/" + data.question.id
                $("#preview").attr("href", preview)

                
                
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    // $("#txtEditor2").Editor();
    // $("#txtEditor3").Editor();

    var urlParams = new URLSearchParams(window.location.search);

    if(urlParams.has('questionid')){        
        loadquestion(urlParams.get('questionid'))
    }

    $("#formQuestion").validate({        
        submitHandler: function(form) {
            jQuery("#loading").show();

            data = $('#formQuestion').serialize()+'&question_id='+urlParams.get('questionid')
                        +'&description='+encodeURIComponent(editor1.getData())
                        +'&question_text='+encodeURIComponent(editor2.getData())
                        +'&question_solution='+encodeURIComponent(editor3.getData())
                        +'&optiona='+encodeURIComponent(editora.getData())
                        +'&optionb='+encodeURIComponent(editorb.getData())
                        +'&optionc='+encodeURIComponent(editorc.getData())
                        +'&optiond='+encodeURIComponent(editord.getData())
                        +'&optione='+encodeURIComponent(editore.getData())
                        
            $.ajax({
                data: data,
                url: '{{ route("question.update") }}',           
                type: "put",
                dataType: 'json',            
                success: function (data) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }        
    });
});
</script>

@stop