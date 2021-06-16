<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        if (auth()->user()->subscribed('default')){
            redirect()->route('subscriptions.premium');
        }
        return view('subscriptions.index', [
            'intent' => auth()->user()->createSetupIntent()
        ]);
    }

    public function premium()
    {
        return view('subscriptions.premium');
    }

    public function account()
    {
        $invoices = auth()->user()->invoices();
        return view('subscriptions.account', compact('invoices'));
    }

    public function downloadInvoice($invoiceId)
    {
        return Auth::user()->downloadInvoice($invoiceId, [
            'vendor' => config('app.name'),
            'product' => "Assinatura Vip"
        ]);
    }

    public function store(Request $request)
    {
        $request->user()
            ->newSubscription('default','price_1J2d06LZxI4ek2DH4gVSUXfq')
            ->create($request->token);

        return redirect()->route('subscriptions.premium');
    }
}
