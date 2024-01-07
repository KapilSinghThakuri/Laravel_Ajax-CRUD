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
    
    public function fetchStudent()
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
}