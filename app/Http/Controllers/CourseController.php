<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $sites = \DB::table('multi_tenant_sites')
                ->where('organization', auth()->user()->organization)
                ->selectRaw('id, domain_1')
                ->get();

        return view('course.index')->with(compact('sites'));
    }

    public function view($site_id)
    {
        $collection = \App\Models\Course
            ::where('tenant_id', $site_id)
            ->get();

        return view('course.view')->with(compact('collection'));
    }

    public function update(Request $request, $course_id)
    {        
        
        $model = \App\Models\Course
            ::where('id', $course_id)
            ->first();

        if($request->cover){
            $imagePath = 'cover/course/'.$course_id.'.png';
            $url = app('App\Http\Controllers\SiteSettingController')
                ->uploadImage($request->cover, $imagePath);
            $model->cover = $url;
        }

        $info = array(
            "subtitle" => $request->subtitle
        );

        if($request->button_text && $request->button_link){
            $info["button"] = array(
                "text" => $request->button_text,
                "link" => $request->button_link
            );
        }

        $model->title = $request->title;
        $model->description = $this->dataready($request->description, 'course_description');
        $model->info = [$info];
        $model->save();

        return redirect()->back();
    }

    public function detail($course_id)
    {
        $product = \DB::table('multi_tenant_products')
            ->where('product_type', 'kelas');

        $course = \DB::table('courses')
            ->leftJoinSub($product, 'p', function ($join) {
                $join->on('p.instance_id', '=', 'courses.id');
            })
            ->where('courses.id', $course_id)
            ->selectRaw('courses.id, courses.title')
            ->first();

        $collection = \App\Models\CourseModule
            ::where('course_id', $course_id)
            ->orderBy('schedule')
            ->get();

        return view('course.detail')->with(compact('course', 'collection')); 
    }

    public function moduleUpdate(Request $request, $module_id)
    {
        
        if($request->link_zoom){
            $detail["link_zoom"] = $request->link_zoom;
        }

        if($request->record){
            $detail["record"] = $request->record;
        }

        // if($request->file){
        //     $detail["file"] = $request->file;
        // }

        \App\Models\CourseModule
            ::where('id', $module_id)
            ->update([
                'title' => $request->title,
                'schedule' => $request->schedule,
                'schedule_detail' => $request->schedule_detail,
                'detail' => $detail ?? null
            ]);

        foreach($request->file as $k => $e){
            \DB::table('course_module_details')
                ->insert([
                    'number' => $k + 1,
                    'name' => $request->file_name[$k],
                    'module_type' => 'file',
                    'value' => $e,
                    'module_id' => $module_id
                ]);
        }

        return redirect()->back();
    }

    public function moduleCreate(Request $request)
    {
        if($request->link_zoom){
            $detail["link_zoom"] = $request->link_zoom;
        }

        if($request->record){
            $detail["record"] = $request->record;
        }

        if($request->file){
            $detail["file"] = $request->file;
        }

        \App\Models\CourseModule
            ::create([                
                'course_id' => $request->course_id,
                'title' => $request->title,
                'schedule' => $request->schedule,
                'schedule_detail' => $request->schedule_detail,
                'event_type' => 'liveclass',
                'detail' => $detail ?? null
            ]);

        return redirect()->back();
    }

    // public function dataready($data) 
    // {        
    //     $dom = new \DOMDocument();
    //     libxml_use_internal_errors(true);
    //     $dom->loadHTML($data);        
    //     $data = $dom->saveHTML();        
    //     $data = htmlspecialchars($data);
    //     return $data;
    // }

    public function createQuiz(Request $request, $module_id)
    {
        $id = "CQ".uniqid();
        $module = \App\Models\CourseModule
            ::where('id', $module_id)
            ->first();
            
        $quiz_section = \App\Models\CourseQuiz
            ::create([
                'id' => $id,
                'subject' => $request->subject,
                'name' => "Kuis ".$module->title
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

        $module = \App\Models\CourseModule
            ::where('id', $module_id)
            ->first();

        $module_detail = $module->detail;
        $module_detail["quiz_id"] = $id;
        $module->detail = $module_detail;
        $module->save();

        return redirect()->back();
    }

    public function viewQuiz($module_id)
    {
        $module = \App\Models\CourseModule
            ::where('id', $module_id)
            ->first();

        if($module->detail && key_exists("quiz_id", $module->detail)){
            $quiz = \DB::table('course_quiz')
                ->where('id', $module->detail["quiz_id"])
                ->first();

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
                ->where('assessment_id', $module->detail["quiz_id"])
                ->selectRaw('questions.*,question_options.*,topic_name')
                ->get();
        }else{
            $quiz = null;
            $questions = null;
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
        \DB::table('questions')
            ->where('id', $request->question_id)
            ->update([
                'name' => $request->name,
                'description' => $this->dataready($request->description, $request->question_id),
                'question_text' => $this->dataready($request->question_text, $request->question_id),
                'question_solution' => $this->dataready($request->question_solution, $request->question_id),
                'video_solution' => $request->video_solution
            ]);

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
                'is_true' => $request->optionanswera,
                'grade' => 10
            ]);
        }        
        
        if(!empty($request->optionb)){
            \DB::table('question_options')
                ->updateOrInsert([
                    'question_id' => $request->question_id,
                    'option' => 'b'
                ],[
                    'text' => $this->dataready($request->optionb, $request->question_id),
                    'is_true' => $request->optionanswerb,
                    'grade' => 10
                ]);
        }

        if(!empty($request->optionc)){
            \DB::table('question_options')
                ->updateOrInsert([
                    'question_id' => $request->question_id,
                    'option' => 'c'
                ],[
                    'text' => $this->dataready($request->optionc, $request->question_id),
                    'is_true' => $request->optionanswerc,
                    'grade' => 10
                ]);
        }

        if(!empty($request->optiond)){
            \DB::table('question_options')
                ->updateOrInsert([
                    'question_id' => $request->question_id,
                    'option' => 'd'
                ],[
                    'text' => $this->dataready($request->optiond, $request->question_id),
                    'is_true' => $request->optionanswerd,
                    'grade' => 10
                ]);
        }

        if(!empty($request->optione)){
            \DB::table('question_options')
                ->updateOrInsert([
                    'question_id' => $request->question_id,
                    'option' => 'e'
                ],[
                    'text' => $this->dataready($request->optione, $request->question_id),
                    'is_true' => $request->optionanswere,
                    'grade' => 10
                ]);
        }

        return response()->json($request->question_id);
    }
}
