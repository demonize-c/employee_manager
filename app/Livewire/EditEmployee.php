<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Designation;
use App\Models\Employee;

use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class EditEmployee extends Component
{

    use WithFileUploads;

    public bool $open_desig = false;

    public string $desig_name = '';

    public Employee $employee;

    public string $name ;

    public string $email;

    public string $phone;

    public array $designation =[];

    public string $doj;

    public float $salary;

    public $photo;

    public string $photo_preview;

    public function mount($employee) 
    {
        $this->employee = $employee;

        $this->name   = $employee->name;
        $this->phone  = $employee->phone;
        $this->email  = $employee->email;
        $this->doj    = $employee->doj;
        $this->salary = $employee->salary;

        $this->designation = [
            'id'   => $employee->designation->id,
            'name' => $employee->designation->name
        ];
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
              'digits:10'
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
             'image',
             'mimes:jpeg,png,jpg,gif,svg',
             'max:2048'
          ]
      ];
    }

    public function update() 
    {
          $this->validate();
          
          $filename = null;

          if( $this->photo ) {
             $filename = Str::random(15).'-'.time().'.'.$this->photo->getClientOriginalExtension();
             $this->photo->storeAs('employee_pictures',  $filename , 'public');
             
             $old_path = public_path('media/employee_pictures/'. $this->employee->photo);
             if ( file_exists($old_path) ) {
                 unlink( $old_path );
             }
          }

          $employee         = $this->employee;
          $employee->name   = $this->pull('name');
          $employee->email  = $this->pull('email');
          $employee->phone  = $this->pull('phone');
          $employee->doj    = $this->pull('doj');  
          $employee->salary = $this->pull('salary');
          $employee->photo  = $filename;
          $employee->designation_id = $this->pull('designation')['id'];      
          $employee->save();
          return redirect()->route('employees.index');
    }

    public function render()
    {
        $designations = Designation::where('name','like','%'.$this->desig_name.'%')
                         ->orderBy('name','asc')
                         ->limit(10)
                         ->get();

        return view('livewire.edit-employee',[
            'designation_options' =>  $designations
        ])->extends('layouts.app');
    }
}
