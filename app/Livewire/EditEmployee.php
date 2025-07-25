<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Designation;
use App\Models\Employee;

use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use App\Helpers\SupabaseStorageHelper;

class EditEmployee extends Component
{

    use WithFileUploads;


    public bool $loading  = false;

    public bool $display_error = false;

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
             'nullable',
             'image',
             'mimes:jpeg,png,jpg,gif,svg',
             'max:2048'
          ]
      ];
    }

    // public function ready_reset(){
    //     $this->ready = false;
    // }

    public function update() 
    {

         try{

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

            $fileinfo = null;
            
            if( $this->photo ) {
                 $filename = Str::random(15).'-'.time().'.'.$this->photo->extension();
                 $fileinfo = SupabaseStorageHelper::upload($this->photo, 'employee_photos/'. $filename);
                 $old_fileinfo = $this->employee->photo? 
                                 json_decode($this->employee->photo,true):
                                 null;
                 if($old_fileinfo  && isset($old_fileinfo['Key'])){
                    SupabaseStorageHelper::delete($old_fileinfo['Key']);
                 }
            }
  
            $employee         = $this->employee;
            $employee->name   = $this->name;
            $employee->email  = $this->email;
            $employee->phone  = $this->phone;
            $employee->doj    = $this->doj; 
            $employee->salary = $this->salary;
            
            $employee->designation_id = $this->designation['id']?? null;
            
            if($fileinfo){
              $employee->photo  = json_encode($fileinfo);
            }
            
            $employee->save();
            $this->dispatch('on-update', success: true, message: 'Employee updated successfully.');

         }catch( ValidationException $e ){
            $this->dispatch('on-update', success: false, message: 'Validation failure occurred.');
            throw $e;
         }
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
