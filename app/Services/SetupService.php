<?php

namespace App\Services;

use App\Models\Attendance\Type as AttendanceType;
use App\Models\Attendance\WorkShift;
use App\Models\Company\Branch;
use App\Models\Company\Department;
use App\Models\Company\Designation;
use App\Models\Employee\Employee;
use App\Models\Leave\Allocation;
use App\Models\Leave\Type as LeaveType;
use App\Models\Payroll\PayHead;
use App\Models\Payroll\SalaryStructure;
use App\Models\Payroll\SalaryTemplate;

class SetupService
{
    public function handle()
    {
        $department = Department::query()
            ->byTeam()
            ->count();

        $designation = Designation::query()
            ->byTeam()
            ->count();

        $branch = Branch::query()
            ->byTeam()
            ->count();

        $employeeIds = Employee::query()
            ->select('id')
            ->whereHas('contact', function($q) {
                $q->byTeam();
            })
            ->pluck('id')
            ->all();

        $workShift = WorkShift::query()
            ->byTeam()
            ->count();

        $attendanceType = AttendanceType::query()
            ->byTeam()
            ->count();

        $leaveType = LeaveType::query()
            ->byTeam()
            ->count();

        $leaveAllocation = Allocation::query()
            ->whereIn('employee_id', $employeeIds)
            ->count();

        $payHead = PayHead::query()
            ->byTeam()
            ->count();

        $salaryTemplateIds = SalaryTemplate::query()
            ->select('id')
            ->byTeam()
            ->pluck('id')
            ->all();

        $salaryStructure = SalaryStructure::query()
            ->whereIn('salary_template_id', $salaryTemplateIds)
            ->count();

        $header = 'This wizard will assist you in setting up your company. You can skip any step and come back later to complete it.';

        $footer = 'You can always come back to this wizard to complete the steps.';

        $completed = 'Hurray! You have completed all the steps. You can now start using the application.';

        $steps = [
            [
                'name' => 'company.department',
                'is_completed' => $department > 1 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('company.department.department')]),
                'summary' => '',
                'description' => 'Departments are the basic building block of the company structure. A department is a collection of employees that leads to an organizational goal. You can create departments like Account, HR etc. A department can have multiple designations, branches, employees etc.',
                'route' => 'CompanyDepartmentCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'company.designation',
                'is_completed' => $designation > 1 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('company.designation.designation')]),
                'summary' => '',
                'description' => 'Designations are the positions held by employees in the company. A designation can have multiple employees. For example, you can create designations like Accountant, HR Manager etc.',
                'route' => 'CompanyDesignationCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'company.branch',
                'is_completed' => $branch > 1 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('company.branch.branch')]),
                'summary' => '',
                'description' => 'Branches are different locations of the company where it operates. A branch can have multiple departments, designations, employees etc. You can create branches like Head Office, Branch Office etc.',
                'route' => 'CompanyBranchCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'employee',
                'is_completed' => count($employeeIds) > 1 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('employee.employee')]),
                'summary' => '',
                'description' => 'Add your first employee to the system. Addition of employees is a one time process. You can add more employees later.',
                'route' => 'EmployeeCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'attendance.work_shift',
                'is_completed' => $workShift > 0 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('attendance.work_shift.work_shift')]),
                'summary' => '',
                'description' => 'Work shifts are the time periods in which employees work. You can create work shifts like Morning Shift, Evening Shift etc. A work shift can have multiple employees.',
                'route' => 'AttendanceWorkShiftCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'attendance.type',
                'is_completed' => $attendanceType > 0 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('attendance.type.type')]),
                'summary' => '',
                'description' => 'Create different types of attendance like Present, Absent, Late etc. You can use these marks to mark attendance of employees.',
                'route' => 'AttendanceTypeCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'leave.type',
                'is_completed' => $leaveType > 0 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('leave.type.type')]),
                'summary' => '',
                'description' => 'Create different types of leaves like Casual Leave, Sick Leave etc. You can use these leaves to allocate leaves to employees.',
                'route' => 'LeaveTypeCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'leave.allocation',
                'is_completed' => $leaveAllocation > 0 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('leave.allocation.allocation')]),
                'summary' => '',
                'description' => 'Allocate leaves to your employees. You can allocate leaves to different employees for a specific leave type.',
                'route' => 'LeaveAllocationCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'payroll.payHead',
                'is_completed' => $payHead > 0 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('payroll.pay_head.pay_head')]),
                'summary' => '',
                'description' => 'Create different types of pay heads like Basic Salary, Allowance etc. You can use these pay heads to create salary templates.',
                'route' => 'PayrollPayHeadCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'payroll.salaryTemplate',
                'is_completed' => count($salaryTemplateIds) > 0 ? true : false,
                'title' => trans('global.add', ['attribute' => trans('payroll.salary_template.salary_template')]),
                'summary' => '',
                'description' => 'Create salary templates for your employees. You can create different salary templates for different employees.',
                'route' => 'PayrollSalaryTemplateCreate',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'payroll.salaryStructure',
                'is_completed' => $salaryStructure > 0 ? true : false,
                'title' => trans('global.assign', ['attribute' => trans('payroll.salary_structure.salary_structure')]),
                'summary' => '',
                'description' => 'Assign salary structure to your employees. You can assign different salary structures to different employees.',
                'route' => 'PayrollSalaryStructureCreate',
                'icon' => 'fas fa-users',
            ],
        ];

        return compact('steps', 'header', 'footer', 'completed');
    }
}