<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Designation;
use App\Models\Employee;

use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class CreateEmployee extends Component
{

    use WithFileUploads;

    public bool   $loading = false;

    public bool $display_error = false;

    public string $desig_name = '';
    
    public string $open_desig;

    public string $name ;

    public string $email;

    public string $phone;

    public array $designation =[];

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
          'designation.id'=> [
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
             'required',
             'image',
             'mimes:jpeg,png,jpg,gif,svg',
             'max:2048'
          ]
      ];
    }

    public function messages()
    {
        return [
            'designation.id.required' => 'The designation field is required.',
            'designation.id.exists'   => 'The designation field is invalid.',
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
            
            $filename = null;

            if( $this->photo ) {
                $filename = Str::random(15).'-'.time().'.'.$this->photo->getClientOriginalExtension();
                $this->photo->storeAs('employee_pictures',  $filename , 'public');
            }

            $employee         = new Employee;
            $employee->name   = $this->name;
            $employee->email  = $this->email;
            $employee->phone  = $this->phone;
            $employee->doj    = $this->doj;
            $employee->salary = $this->salary;
            $employee->photo  = $filename;
            $employee->designation_id = $this->pull('designation')['id'];      
            $employee->save();
            $this->dispatch('on-save', success: true,  message: 'Employee saved successfully.');
        }catch( ValidationException $e ){
            $this->dispatch('on-save', success: false, message: 'Validation failure occurred.');
            throw $e;
        }
    }

    public function select_designation( $id, $name)
    {
        $this->designation = compact('id','name');
        $this->open_desig  = false;
    }

    public function clear_designation()
    {
        $this->designation = [];
        $this->open_desig  = false;
    }

    public function render()
    {
        $designations = Designation::where('name','like','%'.$this->desig_name.'%')
                         ->orderBy('name','asc')
                         ->limit(10)
                         ->get();

        return view('livewire.create-employee',[
           'designation_options' =>  $designations
        ])->extends('layouts.app');
    }
}
