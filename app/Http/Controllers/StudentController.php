<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    public function index()
    {
        return view('Student.index');
    }
    
    public function fetchStudent(Request $request)
    {
        $students = Student::all();
        return response()->json([
            'Students' => $students,
        ]);
    }
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:255',
            'email'=> 'required|email',
            'phone'=> 'required|integer',
            'course'=> 'required|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        
        else{
             $student = new Student;
             $student -> name = $request -> input('name');
             $student -> email = $request -> input('email');
             $student -> phone = $request -> input('phone');
             $student -> course = $request -> input('course');
             $student -> save();

             return response()->json([
                'status' => 200,
                'message' => 'Student Added Successfully',
             ]);

        }

    }


    public function editStudent($id) {
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student,
            ]);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => 'Student not found',
            ]);
        }
    }

    
    public function updateStudent(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:255',
            'email'=> 'required|email',
            'phone'=> 'required|integer',
            'course'=> 'required|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        
        else{
            $student = Student::find($id);
            if($student){
                $student -> name = $request -> input('name');
                $student -> email = $request -> input('email');
                $student -> phone = $request -> input('phone');
                $student -> course = $request -> input('course');
                $student -> update();
   
                return response()->json([
                   'status' => 200,
                   'message' => 'Student Updated Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found',
                ]);
            }
        }
    }

    public function deleteStudent($id) {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Student Delete Successfully',
        ]);
    }


    // FOR SEARCHING DATA FEATURES

    public function search( Request $request ){
        $output = " ";

        $student = Student::where('name','LIKE', '%' . $request->search . '%')
                        ->orWhere('email','LIKE', '%' . $request->search . '%')
                        ->orWhere('course','LIKE', '%' . $request->search . '%')
                        ->orWhere('phone','LIKE', '%' . $request->search . '%')->get();
        

        foreach($student as $student){

            $output.= 
            '<tr>   <td>'. $student->id  .'</td> 
                    <td>'. $student->name  .'</td> 
                    <td>'. $student->email  .'</td> 
                    <td>'. $student->phone  .'</td> 
                    <td>'. $student->course  .'</td> 

                    <td>'.' <a href="" class="btn btn-sm btn-primary"> '.' Edit </a> '.'</td>
                    <td>'.' <a href="" class="btn btn-sm btn-danger"> '.' Delete </a> '.'</td>

             </tr>';

        }
        return response($output);
    }
}
