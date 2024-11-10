<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Services;

use App\Models\Form;

class HomeController extends Controller
{
    // public function index()
    // {
        

    //     return view('admin.index');
    // }

    public function home ()
    {
        return view('home.index');
    }
        
    public function showForm()
    {
        $services = Services::all();

        

        return view ('home.form',compact('services'));
    }

    public function submit_form(Request $request)
    {

        $data = new Form;

        $data-> name = $request->name;

        $data->date = $request->date;

        $data-> semester = $request->semester;

        $data-> academic_year = $request->academic_year;

        $data->service_id = $request->department;

        $data-> service = $request->service;

        $data-> age = $request->age;

        $data-> sex = $request->sex;

        $data-> Municipality = $request->municipality;

        $data-> client_category = $request->client_category;

        $data-> cc1 = $request->cc1;

        $data-> cc2 = $request->cc2;

        $data-> cc3 = $request->cc3;

        $data-> expectations_0 = $request->expectations0;

        $data-> expectations_1 = $request->expectations1;

        $data-> expectations_2 = $request->expectations2;

        $data-> expectations_3 = $request->expectations3;

        $data-> expectations_4 = $request->expectations4;

        $data-> expectations_5 = $request->expectations5;
        
        $data-> expectations_6 = $request->expectations6;

        $data-> expectations_7 = $request->expectations7;

        $data-> expectations_8 = $request->expectations8;

        $data-> suggestions = $request->suggestions;

        $data->save();

        return redirect()->back();


    }
}
