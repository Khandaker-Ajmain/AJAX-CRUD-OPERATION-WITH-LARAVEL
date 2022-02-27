<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    
    public function index() {
        return view('index');
    }

    public function fetchStudent() {
        $students = Student::all();
        return response()->json([
            'students' => $students
        ]);
    }

    public function store(Request $request) {

        $validated = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            'course'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:10|min:10',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);

        }else {
            $student = new Student;
            $student->name = $request->input('name');
            $student->course = $request->input('course');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->save();
            return response()->json([
                'status'=>200,
                'message'=>'Student Added Successfully.'
            ]);
        }

    }

    public function edit($id) {

        $student = Student::find($id);
        if($student) {
            return response()->json([
                'status' => 200,
                'student' => $student 
            ]);
        }else {
            return response()->json([
                'status' => 400,
                'error' => 'Student not found'
            ]);
        }

    }

    public function update(Request $request, $id) {
        
        $validated = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            'course'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:10|min:10',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);

        }else {
            $student = Student::find($id);
            if($student) {
                $student->name = $request->input('name');
                $student->course = $request->input('course');
                $student->email = $request->input('email');
                $student->phone = $request->input('phone');
                $student->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Student Updated Successfully.'
                ]);
            }else {
                return response()->json([
                    'status' => 404,
                    'error' => 'Student not found'
                ]);
            }
            
        }

    }

    public function destroy($id) {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Student Deleted Successfully.'
        ]);
    }

}
