<?php

use App\Http\Controllers\Backend\Student\AssignmentStudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\CourseController;
use App\Http\Controllers\Frontend\StudentController;
use App\Http\Controllers\Backend\NewsAdminController;
use App\Http\Controllers\Backend\AssignmentController;
use App\Http\Controllers\Backend\AttendanceController;
use App\Http\Controllers\Backend\CourseAdminController;
use App\Http\Controllers\Frontend\InstructorController;
use App\Http\Controllers\Backend\StudentAdminController;
use App\Http\Controllers\Backend\InstructorAdminController;
use App\Http\Controllers\Backend\LearningScheduleController;
use App\Http\Controllers\Backend\MenumanagerAdminController;
use App\Http\Controllers\Backend\CategoryNewsAdminController;
use App\Http\Controllers\Backend\CourseFormatAdminController;
use App\Http\Controllers\Backend\CourseCategoryAdminContrroller;
use App\Http\Controllers\Backend\Instructor\CourseInstructorController;
use App\Http\Controllers\Backend\Instructor\StudentInstructorController;
use App\Http\Controllers\Backend\Instructor\LearningMaterialInstructorController;
use App\Http\Controllers\Backend\Instructor\SubmissionInstructorController;
use App\Http\Controllers\Backend\Student\AttendanceStudentController;
use App\Http\Controllers\Backend\Student\CertificationStudentController;
use App\Http\Controllers\Backend\Student\DashboardStudentController;
use App\Http\Controllers\Backend\Student\EvaluationStudentController;
use App\Http\Controllers\Backend\Student\LearningMaterialStudentController;
use App\Http\Controllers\Backend\Student\ScheduleStudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Frontend Course
Route::controller(CourseController::class)->prefix('course')->name('course.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/format', 'format')->name('format');
    Route::get('/program', 'program')->name('program');
    Route::get('/join', 'join')->name('join');
});

// Frontend Instructor
Route::controller(InstructorController::class)->prefix('instructor')->name('instructor.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/detail/{id}', 'show')->name('show');
});

// Frontend Student
Route::controller(StudentController::class)->prefix('student')->name('student.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/register', 'signup')->name('signup');
    Route::post('/store', 'store')->name('store');
    Route::get('/detail/{id}', 'show')->name('show');
});

// Frontend News Event
Route::controller(NewsController::class)->prefix('news-event')->name('news-event.')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/{slug}', 'show')->name('show');
});

Route::controller(AuthController::class)->name('auth.')->group(function(){
    Route::get('/login', 'index')->name('index');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});


Route::get('/forgot-password', function () {
    return view('auth.forgot_password');
});
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('password/reset/{token}', function ($token) {
    return view('auth.reset_password', ['token' => $token]); // Ganti dengan view Anda
})->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


route::resource('/course', CourseController::class);

Route::get('/tambahCourse', [CourseController::class, 'create'])->name('course.create');
Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
Route::get('/course/{id}', [CourseController::class, 'show'])->name('detailCourse');

Route::get('/mycourses', [CourseController::class, 'myCourses'])->name('course.myCourses');

Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/detailCourse', function () {
    return view('pages.detailCourse');
});
// Route to set currency

// Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
// Route::post('/cart/add/{courseId}', [CartController::class, 'addToCart'])->name('cart.add');
// Route::post('/cart/remove/{courseId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/instructors/create', [InstructorController::class, 'create'])->name('instructors.create');
Route::post('/instructors', [InstructorController::class, 'store'])->name('instructors.store');
Route::get('/instructors/{id}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
Route::put('/instructors/{id}', [InstructorController::class, 'update'])->name('instructors.update');
Route::delete('/instructors/{id}', [InstructorController::class, 'destroy'])->name('instructors.destroy');

Route::group(['middleware' => ['auth', 'role:admin']], function() {
    
    
});


// Admin routes to approve/reject instructors


// Route::get('/courses/{id}/materials', [LearningMaterialController::class, 'index'])->name('course.materials');
// Route::get('/materi', function () {
    //     return view('learning_materials.index');
    // });
    
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function() {

    Route::controller('')->prefix('dashboard')->name('dashboard.')->group(function() {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(InstructorAdminController::class)->prefix('instructor')->name('instructor.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pendingInstructors')->name('pending');
        Route::post('/{id}/approve', 'approveInstructor')->name('approve');
        Route::post('/{id}/reject', 'rejectInstructor')->name('reject');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}/validation', 'validation')->name('validation');
    });

    Route::controller(MenumanagerAdminController::class)->prefix('menumanager')->name('menumanager.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });

    Route::controller(NewsAdminController::class)->prefix('news')->name('news.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
        Route::post('/upload', 'upload')->name('upload');
    });

    Route::controller(CategoryNewsAdminController::class)->prefix('category')->name('category.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
    });

    Route::controller(CourseFormatAdminController::class)->prefix('course-format')->name('course-format.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destoy')->name('destroy');
        Route::post('/upload', 'upload')->name('upload');
    });

    Route::controller(CourseCategoryAdminContrroller::class)->prefix('course-category')->name('course-category.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destoy')->name('destroy');
        Route::post('/upload', 'upload')->name('upload');
    });

    Route::controller(LearningMaterialInstructorController::class)->prefix('learning-materials')->name('learning-materials.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(StudentAdminController::class)->prefix('student')->name('student.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pendingStudents')->name('pending');
        Route::post('/{id}/approve', 'approveStudent')->name('approve');
        Route::post('/{id}/reject', 'rejectStudent')->name('reject');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}/validation', 'validation')->name('validation');
    });

    Route::controller(CourseAdminController::class)->prefix('course')->name('course.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pendingCourses')->name('pending');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}/validation', 'validation')->name('validation');
    });
    
    Route::controller(AttendanceController::class)->prefix('attendance')->name('attendance.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/download', 'downloadReport')->name('download');
    });
    
    Route::controller(LearningScheduleController::class)->prefix('schedule')->name('learning-schedule.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });
});

Route::middleware(['auth', 'role:instructor,Admin'])->prefix('instructor')->name('instructor.')->group(function() {

    // Route::controller(DashboardAdminController::class)->prefix('dashboard')->name('dashboard.')->group(function() {
    //     Route::get('/', 'index')->name('index');
    // });

    Route::controller(LearningMaterialInstructorController::class)->prefix('{course}/materials')->name('learning-materials.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(AttendanceController::class)->prefix('{course}/attendance')->name('attendance.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/download', 'downloadReport')->name('download');
    });

    Route::controller(LearningScheduleController::class)->prefix('{course}/schedule')->name('learning-schedule.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(AssignmentController::class)->prefix('{course}/assignments')->name('assignments.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(SubmissionInstructorController::class)->prefix('{course}/submission')->name('submission.')->group(function() {
        Route::get('/{id}', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(CourseInstructorController::class)->prefix('course')->name('course.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(StudentInstructorController::class)->prefix('{course}/student')->name('student.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });
});

Route::middleware(['auth', 'role:student,Admin'])->prefix('student')->name('student.')->group(function() {
    Route::controller(DashboardStudentController::class)->prefix('dashboard')->name('dashboard.')->group(function() {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(AttendanceStudentController::class)->prefix('{course}/attendance')->name('attendance.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(ScheduleStudentController::class)->prefix('{course}/schedule')->name('schedule.')->group(function() {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(LearningMaterialStudentController::class)->prefix('{course}/material')->name('material.')->group(function() {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(AssignmentStudentController::class)->prefix('{course}/assignment')->name('assignment.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}/create', 'create')->name('create');
        Route::post('/{id}/store', 'store')->name('store');
    });

    Route::controller(EvaluationStudentController::class)->prefix('{course}/evaluation')->name('evaluation.')->group(function() {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(CertificationStudentController::class)->prefix('{course}/certification')->name('certification.')->group(function() {
        Route::get('/', 'index')->name('index');
    });
});

Route::get('/update', function () {
    return view('profile.update');
});
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.edit');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');



Route::get('/certifications', [CertificationController::class, 'index'])->name('certifications.index');
Route::get('/certifications/{id}', [CertificationController::class, 'show'])->name('certifications.show');
Route::resource('certifications', CertificationController::class);
Route::get('/certificate/download/{id}', [CertificationController::class, 'download'])->name('certificate.download');
Route::get('/get-users-by-course', [CertificationController::class, 'getUsersByCourse'])->name('get.users.by.course');

Route::get( '/students', [StudentController::class, 'index'])->name('students.index');




// routes/web.php
// Route::get('/checkout/{course}', [CheckoutController::class, 'checkoutForm'])->name('checkout.form')->middleware('auth');
// Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process')->middleware('auth');
// Route::get('/checkout/success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success')->middleware('auth');




// Route untuk menampilkan keranjang
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');

// Route untuk menambahkan course ke keranjang
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');

Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');


// Route untuk menampilkan form checkout (mengirim course ID)
Route::get('/checkout/form/{id}', [CartController::class, 'checkoutForm'])->name('checkout.form');

// Route untuk menampilkan halaman checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

// routes/web.php
Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
Route::post('/admin/transactions/{id}/confirm', [AdminController::class, 'confirmTransaction'])->name('admin.transactions.confirm');
Route::post('/admin/transactions/{id}/reject', [AdminController::class, 'rejectTransaction'])->name('admin.transactions.reject');

Route::get('/my-courses', [UserController::class, 'myCourses'])->name('user.my-courses')->middleware('auth');
Route::get('/courses/{course}/materials', [CourseController::class, 'showMaterials'])->name('courses.materials');



// Route::get('/assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit')->middleware('auth');
// Route::post('/assignments/{assignment}/submit', [AssignmentController::class, 'storeSubmission'])->name('assignments.storeSubmission')->middleware('auth');

// Route::middleware(['auth', 'role:instructor'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('assignments', AssignmentController::class);
//     Route::get('submissions', [SubmissionController::class, 'review'])->name('submissions.index');
//     Route::post('submissions/{id}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
// });

// Route::middleware(['auth', 'role:student'])->prefix('user')->name('user.')->group(function () {
//     Route::get('assignments', [SubmissionController::class, 'index'])->name('assignments.index');
//     Route::get('assignments/{id}/submit', [SubmissionController::class, 'create'])->name('assignments.submit');
//     Route::post('assignments/{id}/submit', [SubmissionController::class, 'store'])->name('assignments.store');
// });

Route::get('feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');

Route::resource('feedback', FeedbackController::class);

// User routes
Route::middleware('auth')->group(function () {
    Route::get('feedback/user/{id}', [FeedbackController::class, 'showForUser'])->name('feedback.user');
});
