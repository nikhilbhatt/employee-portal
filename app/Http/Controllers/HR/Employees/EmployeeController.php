<?php

namespace App\Http\Controllers\HR\Employees;

use App\Models\HR\Employee;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::active()->orderBy('name')->get();
        return view('hr.employees.index', compact('employees'));
    }

    public function show(Employee $employee)
    {
        return view('hr.employees.show', compact('employee'));
    }

    /**
     * Display the project details of an Employee
     *
     * @param  \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function showProjects(Employee $employee)
    {
        $employee->load('projects');

        return view('hr.employees.projects', compact('employee'));
    }
}
