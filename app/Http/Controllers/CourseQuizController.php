<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseQuizController extends Controller
{
    public function createQuiz(Request $request, $module_id)
    {
        $id = "CQ".uniqid();
        $module = \App\Models\CourseModule
            ::where('id', $module_id)
            ->first();
            
        $quiz_section = \App\Models\CourseQuiz
            ::create([
                'id' => $id,
                'module_id' => $module_id,
                'name' => "Kuis ".$module->title,
                'duration' => $request->duration
            ]);

        for ($i = 1; $i <= $request->total_question; $i++) {
            $question = \DB::table('questions')
                ->insertGetId([
                    'type' => 'singlechoice',
                    'name' => $id. ' - ' . $i,
                    'assessment_id' => $id,
                    'sequence' => $i
                ]);

            $arr = ['a', 'b', 'c', 'd', 'e'];
            foreach ($arr as $item) {
                \DB::table('question_options')
                    ->insert([
                        'question_id' => $question,
                        'text' => strtoupper($item),
                        'option' => $item
                    ]);
            }

        }
       
        return redirect()->back();
    }

    public function viewQuiz($module_id)
    {
        $module = \App\Models\CourseModule
            ::where('id', $module_id)
            ->first();

        $quiz = \DB::table('course_quiz')
            ->where('module_id', $module_id)
            ->first();

        $questions = null;

        if($quiz){

            $question_options = \DB::table('question_options')
                ->where('grade', '>', 0)
                ->selectRaw('question_id, 
                            GROUP_CONCAT(question_options.option ORDER BY grade DESC ) as correct_answer')
                ->groupBy('question_id');
    
            $questions = \DB::table('questions')
                ->leftJoinSub($question_options, 'question_options', function ($join) {
                    $join->on('questions.id', '=', 'question_options.question_id');
                })
                ->leftJoin('utbk_topics', 'topic', 'utbk_topics.id')
                ->where('assessment_id', $quiz->id)
                ->selectRaw('questions.*,question_options.*,topic_name')
                ->get();
        }

        return view('course.quiz')->with(compact('module', 'quiz', 'questions'));
    }

    public function showQuestion(Request $request)
    {
        if(request()->ajax()){
            $question = \DB::table('questions')
                    ->where('id', $request->question_id)
                    ->first();

            $assessment_id = $question->assessment_id;
            $subject_name = \DB::table('course_quiz')
                ->where('id', $assessment_id)
                ->first()->name;

            $question->description = html_entity_decode($question->description);
            $question->question_text = html_entity_decode($question->question_text);
            $question->question_solution = html_entity_decode($question->question_solution);

            $options = \DB::table('question_options')
                        ->where('question_id', $request->question_id)
                        ->get();            

            foreach($options as $e){
                $e->text = html_entity_decode($e->text);
            }

            return response()->json(compact(['question', 'options', 'subject_name']));
        }        

        return view('course.question_editor_ck');
    }

    public function dataready($data, $middle_path) 
    {
        //$data = trim($data);
        //$data = stripslashes($data);
        if(!$data){
            return "";
        }
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($data);
        $xpath = new \DOMXPath($dom);
        $nodelist = $xpath->query("//img");

        foreach($nodelist as $node){
            $value = $node->attributes->getNamedItem('src')->nodeValue;
            
            if(str_contains($value, 'data:image/png')){
                // echo($value."\n");
                
                $imagePath = 'soal-quiz/'.$middle_path."/".uniqid().".jpg";

                $b64 = explode( ',', $value);
                $im = base64_decode($b64[1]);

                $path = Storage::disk('s3')->put($imagePath, $im, 'public');
                $path = Storage::disk('s3')->url($path);
                // echo($path."\n");
                $url = "https://".env("AWS_BUCKET", "kliktes").".s3.ap-southeast-1.amazonaws.com/".$imagePath;
                $node->setAttribute('src', $url);
            }elseif(str_contains($value, 'googleusercontent')){
                // echo($value."\n");
                
                $imagePath = 'soal-quiz/'.$middle_path."/".uniqid().".jpg";
                $im = file_get_contents($value);

                $path = Storage::disk('s3')->put($imagePath, $im, 'public');
                $path = Storage::disk('s3')->url($path);
                // echo($path."\n");
                $url = "https://".env("AWS_BUCKET", "kliktes").".s3.ap-southeast-1.amazonaws.com/".$imagePath;
                $node->setAttribute('src', $url);
            }
        }
        $data = $dom->saveHTML();        
        $data = htmlspecialchars($data);
        return $data;
    }

    public function updateQuestion(Request $request)
    {
        \DB::table('question_options')
            ->where('question_id', $request->question_id)
            ->delete();

        if(!empty($request->optiona)){
            \DB::table('question_options')
                ->updateOrInsert([
                    'question_id' => $request->question_id,
                    'option' => 'a'
                ],[
                    'text' => $this->dataready($request->optiona, $request->question_id),
                    'is_true' => $request->scorea ? 1 : 0,
                    'grade' => $request->scorea
                ]);
        }        
        
        if(!empty($request->optionb)){
            \DB::table('question_options')
                ->updateOrInsert([
                    'question_id' => $request->question_id,
                    'option' => 'b'
                ],[
                    'text' => $this->dataready($request->optionb, $request->question_id),
                    'is_true' => $request->scoreb ? 1 : 0,
                    'grade' => $request->scoreb
                ]);
        }

        if(!empty($request->optionc)){
            \DB::table('question_options')
                ->updateOrInsert([
                    'question_id' => $request->question_id,
                    'option' => 'c'
                ],[
                    'text' => $this->dataready($request->optionc, $request->question_id),
                    'is_true' => $request->scorec ? 1 : 0,
                    'grade' => $request->scorec
                ]);
        }

        if(!empty($request->optiond)){
            \DB::table('question_options')
                ->updateOrInsert([
                    'question_id' => $request->question_id,
                    'option' => 'd'
                ],[
                    'text' => $this->dataready($request->optiond, $request->question_id),
                    'is_true' => $request->scored ? 1 : 0,
                    'grade' => $request->scored
                ]);
        }

        if(!empty($request->optione)){
            \DB::table('question_options')
                ->updateOrInsert([
                    'question_id' => $request->question_id,
                    'option' => 'e'
                ],[
                    'text' => $this->dataready($request->optione, $request->question_id),
                    'is_true' => $request->scoree ? 1 : 0,
                    'grade' => $request->scoree
                ]);
        }

        $answer_key = \DB::table('question_options')
            ->where('question_id', $request->question_id)
            ->where('is_true', 1)
            ->selectRaw("GROUP_CONCAT(question_options.option) as ak")
            ->first();
        
        \DB::table('questions')
            ->where('id', $request->question_id)
            ->update([
                'name' => $request->name,
                'description' => $this->dataready($request->description, $request->question_id),
                'question_text' => $this->dataready($request->question_text, $request->question_id),
                'question_solution' => $this->dataready($request->question_solution, $request->question_id),
                'video_solution' => $request->video_solution,
                'answer_key' => $answer_key ? $answer_key->ak : null
            ]);

        return response()->json($request->question_id);
    }
}
