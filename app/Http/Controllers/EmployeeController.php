<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index() {
        return view('Employee.index');
    }

    public function store(Request $request) {
        $validator = Validator::make( $request->all(), [
            'name' => 'required|min:7',
            'phone' => 'required|integer',
            'profile' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if( $validator->fails() )
        {
            return response()->json([
                'status' => 400,
                'errors' => $validator -> messages(),
            ]);
        }
        else
        {
            $employee = new Employee;
            $employee->name = $request->input('name');
            $employee->phone = $request->input('phone');

            if( $request->hasFile('profile') )
            {
                $file = $request-> file('profile');
                $extension = $file->getClientOriginalExtension();
                $filename = time(). '.' .$extension;
                $file->move('/uploads/employee/', $filename);
                $employee->profile = $filename;
            }

            $employee->save();

            return response()->json([
                'status' => 200,
                'message' => 'Employee Details Added Successfully',
            ]);
        }
    }
}
