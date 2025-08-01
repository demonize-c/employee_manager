<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

use \App\Traits\Notifier;
use App\Models\Designation;
use App\Models\Employee;

use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Helpers\SupabaseStorageHelper;

#[Title('Create Employee')] 
class CreateEmployee extends Component
{

    use WithFileUploads;
    use Notifier;
    use \App\Traits\DatabaseRestrictionHelper;

    public string $name ;

    public string $email;

    public string $phone;

    public string $designation_name;

    public string $designation_id;

    public string $designation_text = '';

    public string $doj;

    public float $salary;

    public $photo;

    public function rules()
    {
      return [
          'name' => [
             'required',
             'string',
          ],
          'email' => [
              'required',
              'email',
          ],
          'phone' => [ 
              'required',
              'digits:10',
          ],
          'designation_id'=> [
             'required',
              Rule::exists('designations','id')
          ],
          'salary' => [
              'required',
              'numeric',
              'gt:0'
          ],
          'doj' => [
             'required',
             'date_format:Y-m-d'
          ],
          'photo' => [
            //  'required',
             'nullable',
             'image',
             'mimes:jpeg,png,jpg,gif,svg',
             'max:2048'
          ]
      ];
    }

    public function messages()
    {
        return [
            'designation_id.required' => 'The designation field is required.',
            'designation_id.exists'   => 'The designation field is invalid.',
        ];
    }

    public function validationAttributes() 
    {
        return [
            'doj' => 'date of joining'
        ];
    }

    public function save() 
    {
        try{
            $this->validate();

            $this->can_save( Employee::class );          

            $fileinfo = null;

            if( $this->photo ) {
                 $filename = Str::random(15).'-'.time().'.'.$this->photo->getClientOriginalExtension();
                 $fileinfo = SupabaseStorageHelper::upload($this->photo, 'employee_photos/'. $filename);
            }

            $employee         = new Employee;
            $employee->name   = $this->name;
            $employee->email  = $this->email;
            $employee->phone  = $this->phone;
            $employee->doj    = $this->doj;
            $employee->salary = $this->salary;
            $employee->photo  = json_encode($fileinfo);
            $employee->designation_id = $this->designation_id;      
            $employee->save();
            $this->notify( true, 'Employee saved successfully.');
        }catch( ValidationException $e ){
            $this->notify(false, 'Validation failure occurred.');
            throw $e;
        }catch(\Exception $e){
            $this->notify(false, 'Error: '.$e->getMessage());
        }
    }

    public function render()
    {
        $designations = Designation::where('name','like','%'.$this->designation_text.'%')
                         ->orderBy('name','asc')
                         ->limit(10)
                         ->get();

        return view('livewire.create-employee',[
           'designation_options' =>  $designations
        ])->extends('layouts.app');
    }
}
