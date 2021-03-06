<?php

namespace App\Http\Controllers;


class HelloController extends Controller
{
    /**
     * Get PatientMedications
     * 
     * @return \Illuminate\Http\Response
     */
    public function hello()
    {
        return 'hello';
    }

    /**
     * Get PatientMedications
     * 
     * @return \Illuminate\Http\Response
     */
    public function AwsUploadFile()
    {
        return view('awsfileupload.php');
    }
}
