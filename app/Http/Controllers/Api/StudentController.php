<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    public function index(){
        $student = Students::all();

        if($student->count()>0){

            return response()->json([
                'status' => 200,
                'students' => $student
            ], 200);

        } else {

            return response()->json([
                'status' => 404,
                'message' => 'No record'
            ], 404);

        }


    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $student = Students::create([
            'name' => $request->name,
            'course' => $request->course,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if($student){
            return response()->json([
                'status' => 200,
                'message' => "Student created successfully"
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Something went wrong"
            ], 500);
        }
    }
    public function show($id){
        $student = Students::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'students' => $student
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No student found!'
            ], 404);

        }


    }
    public function edit($id){
        $student = Students::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'students' => $student
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No student found!'
            ], 404);

        }


    }

    public function update(Request $request, int $id ){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        $student = Students::find($id);

        if($student){

            $student -> update([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Student updated successfully"
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Something went wrong"
            ], 404);
        }




    }


    public function destroy(int $id) {
        $student = Students::find($id);

        if ($student) {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => "Student deleted successfully"
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Student not found"
            ], 404);
        }
    }
}
