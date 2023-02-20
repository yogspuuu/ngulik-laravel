
   Symfony\Component\ErrorHandler\Error\FatalError 

  Type of App\Http\Controllers\ProfileController::$user must not be defined (as in class App\Http\Controllers\Controller)

  at app/Http/Controllers/ProfileController.php:9
      5▕ use App\Http\Resources\Profile\ProfileResouce;
      6▕ use App\Models\User;
      7▕ use Symfony\Component\HttpKernel\Profiler\Profile;
      8▕ 
  ➜   9▕ class ProfileController extends Controller
     10▕ {
     11▕     protected User $user;
     12▕ 
     13▕     public function __construct(User $user)


   Whoops\Exception\ErrorException 

  Type of App\Http\Controllers\ProfileController::$user must not be defined (as in class App\Http\Controllers\Controller)

  at app/Http/Controllers/ProfileController.php:9
      5▕ use App\Http\Resources\Profile\ProfileResouce;
      6▕ use App\Models\User;
      7▕ use Symfony\Component\HttpKernel\Profiler\Profile;
      8▕ 
  ➜   9▕ class ProfileController extends Controller
     10▕ {
     11▕     protected User $user;
     12▕ 
     13▕     public function __construct(User $user)

      [2m+1 vendor frames [22m
  2   [internal]:0
      Whoops\Run::handleShutdown()
