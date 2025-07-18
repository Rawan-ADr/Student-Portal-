<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\DocumentRepository;
use App\Repositories\DocumentRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\FieldRepositoryInterface;
use App\Repositories\FieldRepository;
use App\Repositories\TypeRepositoryInterface;
use App\Repositories\TypeRepository;
use App\Repositories\ValidationRepositoryInterface;
use App\Repositories\ValidationRepository;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Repositories\RequestRepositoryInterface;
use App\Repositories\RequestRepository;
use App\Repositories\AttachmentRepositoryInterface;
use App\Repositories\AttachmentRepository;
use App\Repositories\ConditionRepositoryInterface;
use App\Repositories\ConditionRepository;
use App\Repositories\LectureRepositoryInterface;
use App\Repositories\LectureRepository;
use App\Repositories\ScheduleRepositoryInterface;
use App\Repositories\ScheduleRepository;
use App\Repositories\RolePermissionsRepositoryInterface;
use App\Repositories\RolePermissionsRepository;
use App\Repositories\DepartmentRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\WorkflowRepositoryInterface;
use App\Repositories\WorkflowRepository;
use App\Repositories\MarkRepositoryInterface;
use App\Repositories\MarkRepository;
use App\Repositories\CourseRecordRepositoryInterface;
use App\Repositories\CourseRecordRepository;
use App\Models\Request;
use App\Observers\RequestObserver;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(FieldRepositoryInterface::class, FieldRepository::class);
        $this->app->bind(TypeRepositoryInterface::class, TypeRepository::class);
        $this->app->bind(ValidationRepositoryInterface::class, ValidationRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(RequestRepositoryInterface::class, RequestRepository::class);
        $this->app->bind(AttachmentRepositoryInterface::class, AttachmentRepository::class);
        $this->app->bind(ConditionRepositoryInterface::class, ConditionRepository::class);
        $this->app->bind(LectureRepositoryInterface::class, LectureRepository::class);
        $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);
        $this->app->bind(RolePermissionsRepositoryInterface::class, RolePermissionsRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(WorkflowRepositoryInterface::class, WorkflowRepository::class);
        $this->app->bind(MarkRepositoryInterface::class, MarkRepository::class);
         $this->app->bind(CourseRecordRepositoryInterface::class, CourseRecordRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Request::observe(RequestObserver::class);
    }
}
