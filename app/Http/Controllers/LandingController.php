<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Slider;
use Illuminate\View\View;
use App\Mail\ContactMailer;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LandingController extends Controller
{
    public function home() 
    {
        $slider = Slider::where('status', 1)->orderBy('index', 'asc')->get();
        $plans = Plan::where('status', 1)->orderBy('index', 'asc')->get();
        $testimonials = Testimonial::where('status', 1)->get();
        return view('landing.home', compact('testimonials', 'plans', 'slider'));
    }

    public function privacy()
    {
        return view('landing.privacy-policy');
    }

    public function terms()
    {
        return view('landing.terms');
    }

    public function contact_us(Request $request)
    {
        Mail::to('butrint.xh.babuni@gmail.com')->send(new ContactMailer($request));
        return redirect()->route('landing.home')
                 ->with('message','Mesazhi u dergua me sukses!')
                 ->with('message_type','success');
    }
}
