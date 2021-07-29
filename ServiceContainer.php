# Interface File
// Payment.php
<?php
namespace App\Interfaces;

interface Payment {

    public function charge();

}

# Service File (or) Dependency
// KBZPay.php
<?php
namespace App\Services;
use App\Interfaces\Payment;
use App\Models\KBZPay;

class KBZPay implements Payment{

    public function charge()
    {
        return "Charge by KBZ";
    }
}

// AYAPay.php
<?php
namespace App\Services;
use App\Interfaces\Payment;
use App\Models\AYAPay;

class AYAPay implements Payment{

    public function charge()
    {
        return "Charge by AYA";
    }
}

# AppServiceProvider File
<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use  App\Interfaces\Payment;
use App\Services\KBZPay;
use App\Services\AYAPay;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
       // Single Dependency
         $this->app->bind(Payment::class, function(){
              return new AYAPay;
        });

         // Multi Dependency
        /* $this->app->bind(Payment::class, function(){
            if( request()->type == 'aya' ) {
                return new AYAPay;
            } else {
                return new KBZPay;
            }
        }); */
    }
}

# Controller File
// PaymentController.php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\Payment;

class PostController extends Controller
{
    private $payment;

    public function __construct(Payment $payment)
    {
        $this->payment= $payment;
    }

    public function pay()
    {
        $this->payment->charge();
    }
}
