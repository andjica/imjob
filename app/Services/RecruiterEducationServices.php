<?php

namespace App\Services;

use App\Interfaces\RecruiterEducationInterface;
use App\Models\RecruiterEducation;
use Exception;
use Illuminate\Http\Request;

class RecruiterEducationServices implements RecruiterEducationInterface
{
    public function create(Request $request)
    {
            //Validate the incoming request data
            $request->validate([
                'school' => 'required|string|max:255',
                'degree' => 'required|string|max:255',
                'fieldOfStudy' => 'nullable|string|max:255',
                'yearOfGraduation' => 'required|integer|min:1900|max:' . now()->year,
                'description' => 'nullable|string|max:200',
            ]);
            //return dd($request->all());
            $recruiterEducation = new RecruiterEducation();
            $recruiterEducation->recruiter_id = auth()->user()->recruiter->id ?? abort(404); // Set recruiter ID
            $recruiterEducation->school = $request->get('school'); // Get school name
            $recruiterEducation->degree = $request->get('degree'); // Get degree
            $recruiterEducation->field_of_study = $request->get('fieldOfStudy'); // Get field of study (nullable)
            $recruiterEducation->year_of_graduation = $request->get('yearOfGraduation'); // Get graduation year
            $recruiterEducation->description = $request->get('description'); // Get description (nullable)
            
            //return dd($recruiterEducation);
            try {
                $recruiterEducation->save();
                
            } catch (\Exception $e) {
                return abort(500);
            }
                
        
         
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'fieldOfStudy' => 'nullable|string|max:255',
            'yearOfGraduation' => 'required|integer|min:1900|max:' . now()->year,
            'description' => 'nullable|string|max:200',
        ]);

         // Create a new RecruiterEducation instance
         $recruiterEducation = RecruiterEducation::where('recruiter_id', auth()->user()->recruiter->id)?? abort(404);
         $recruiterEducation->recruiter_id = $recruiterEducation->recruiter_id;
         $recruiterEducation->school = $request->school;
         $recruiterEducation->degree = $request->degree;
         $recruiterEducation->field_of_study = $request->fieldOfStudy; // Nullable
         $recruiterEducation->year_of_graduation = $request->yearOfGraduation;
         $recruiterEducation->description = $request->description; // Nullable
 
         try{
             // Save the record to the database
            $recruiterEducation->save();
         }
         catch(Exception $e)
         {
            return abort(500);
         }
        
        
    }
}