<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\Gig;
use App\GigMessage;
use App\GigOrder;
use App\Mail\GigNewMessage;
use App\Mail\UserEmailVerify;
use App\Order;
use App\ProductOrder;
use App\Products;
use App\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function user_index(){
        $user_details = User::find(Auth::guard('web')->user()->id);
        $package_orders = Order::where('user_id',$user_details->id)->orderBy('id','DESC')->paginate(10);
        $event_attendances = EventAttendance::where('user_id',$user_details->id)->orderBy('id','DESC')->paginate(10);
        $product_orders = ProductOrder::where('user_id',$user_details->id)->orderBy('id','DESC')->paginate(10);
        $product_success_orders = ProductOrder::where(['user_id' => $user_details->id ,'payment_status' => 'complete'])->orderBy('id','DESC')->paginate(10);
        $donation = DonationLogs::where('user_id',$user_details->id)->orderBy('id','DESC')->paginate(10);
        $gigs = GigOrder::where('user_id',$user_details->id)->orderBy('id','DESC')->paginate(10);

        $downloads = [];
        if (!empty($product_success_orders)){
            foreach ($product_success_orders as $order){
                $cart_items = unserialize($order->cart_items);
                foreach ($cart_items as $product){
                    $product_details = Products::find($product['id']);
                    if (!empty($product_details->is_downloadable)){
                        if (array_key_exists($product_details->id,$downloads)){
                            $new_quantity = intval($downloads[$product_details->id]['quantity']) + intval($product['quantity']);
                            $downloads[$product_details->id] = [
                                'order_id' => $order->id,
                                'order_date' => $order->created_at,
                                'id' => $product_details->id,
                                'image' => $product_details->image,
                                'slug' => $product_details->slug,
                                'title' => $product_details->title,
                                'date' => $product_details->created_at,
                                'quantity' => $new_quantity,
                                'amount' => $product_details->sale_price * $new_quantity,
                                'downloadable_file' => $product_details->downloadable_file,
                                'downloadable_file_link' => $product_details->downloadable_file_link,
                            ];
                        }else{
                            $downloads[$product_details->id] = [
                                'order_id' => $order->id,
                                'order_date' => $order->created_at,
                                'image' => $product_details->image,
                                'id' => $product_details->id,
                                'slug' => $product_details->slug,
                                'title' => $product_details->title,
                                'date' => $product_details->created_at,
                                'quantity' => $product['quantity'],
                                'amount' => $product_details->sale_price * $product['quantity'],
                                'downloadable_file' => $product_details->downloadable_file,
                                'downloadable_file_link' => $product_details->downloadable_file_link,
                            ];
                        }
                    }
                }
            }
        }

        return view('frontend.user.dashboard.user-home')->with(
            [
                'user_details' => $user_details,
                'package_orders' => $package_orders,
                'event_attendances' => $event_attendances,
                'product_orders' => $product_orders,
                'donation' => $donation,
                'downloads' => $downloads,
                'gigs' => $gigs,
            ]);
    }

    public function user_email_verify_index(){
        $user_details = Auth::guard('web')->user();
        if ($user_details->email_verified == 1){
            return redirect()->route('user.home');
        }
        if (empty($user_details->email_verify_token)){
            User::find($user_details->id)->update(['email_verify_token' => \Str::random(20)]);
            $user_details = User::find($user_details->id);
            Mail::to($user_details->email)->send(new UserEmailVerify($user_details));
        }
        return view('frontend.user.email-verify');
    }

    public function reset_user_email_verify_code(){
        $user_details = Auth::guard('web')->user();
        if ($user_details->email_verified == 1){
            return redirect()->route('user.home');
        }
        Mail::to($user_details->email)->send(new UserEmailVerify($user_details));

        return redirect()->route('user.email.verify')->with(['msg' => 'Resend Verify Email Success','type' => 'success']);
    }

    public function user_email_verify(Request $request){
        $this->validate($request,[
            'verification_code' => 'required'
        ]);
        $user_details = Auth::guard('web')->user();
        $user_info = User::where(['id' =>$user_details->id,'email_verify_token' => $request->verification_code])->first();
        if (empty($user_info)){
            return redirect()->back()->with(['msg' => 'your verification code is wrong, try again','type' => 'danger']);
        }
        $user_info->email_verified = 1;
        $user_info->save();
        return redirect()->route('user.home');
    }

    public function user_profile_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'nullable|string|max:191',
            'state' => 'nullable|string|max:191',
            'city' => 'nullable|string|max:191',
            'zipcode' => 'nullable|string|max:191',
            'country' => 'nullable|string|max:191',
            'address' => 'nullable|string',
        ]);
        User::find(Auth::guard('web')->user()->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $request->image,
            'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
            'address' => $request->address,
            ]
        );

        return redirect()->back()->with(['msg' => 'Profile Update Success', 'type' => 'success']);
    }

    public function user_password_change(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::findOrFail(Auth::guard('web')->user()->id);

        if (Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->password);
            $user->save();
            Auth::guard('web')->logout();

            return redirect()->route('user.login')->with(['msg' => 'Password Changed Successfully', 'type' => 'success']);
        }

        return redirect()->back()->with(['msg' => 'Somethings Going Wrong! Please Try Again or Check Your Old Password', 'type' => 'danger']);
    }

    public function download_file($id){
        $product_details = Products::find($id);
        if (file_exists('assets/uploads/downloadable/'.$product_details->downloadable_file)){
            $temp_file = asset('assets/uploads/downloadable/'.$product_details->downloadable_file);
            $file = new Filesystem();

            $file->copy($temp_file, 'assets/uploads/downloadable/'.\Str::slug($product_details->title).'.zip');
            return response()->download('assets/uploads/downloadable/'.\Str::slug($product_details->title).'.zip')->deleteFileAfterSend(true);
        }
        return redirect()->route('user.home');
    }

    public function gig_details($id,Request $request){
        $gig_details = GigOrder::where(['id' => $id,'user_id' => Auth::guard('web')->user()->id])->first();
        if (empty($gig_details)){ return redirect_404_page();}

        $query = GigMessage::where('gig_order_id',$id);
        $q = '';
        if (!empty($request->q) && $request->q == 'all'){
            $gig_message = $query->orderBy('id','ASC')->get();
        }else{
            $q = 'all';
            $gig_message = $query->latest()->get()->take(3);
        }

        return view('frontend.user.dashboard.gig-order-message')->with(['gig_details' => $gig_details,'gig_message' => $gig_message,'q' => $q]);
    }

    public function gig_new_message(Request $request){
        $this->validate($request,[
           'message' => 'required|string',
           'send_notify_mail' => 'nullable',
           'file' => 'nullable|mimes:zip|max:280000'
        ]);
        $gig_message =  GigMessage::create([
            'notify_mail' => $request->send_notify_mail ? 'yes' : 'no',
            'user_id' => Auth::guard('web')->user()->id,
            'gig_order_id' => $request->gig_order_id,
            'user_type' => $request->user_type,
            'message' => $request->message,
            'status' => 'unseen',
        ]);
        //add file name to database;
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = Str::slug($file->getClientOriginalName());
            $file_ext = strtolower($file->getClientOriginalExtension());
            if ($file_ext == 'zip'){
                $db_file_name = $gig_message->id.$file_name.'.'.$file_ext;
                $file->move('assets/uploads/gig-files',$db_file_name);
                $gig_message->file = $db_file_name;
                $gig_message->save();
            }
        }

        if ($gig_message->notify_mail == 'yes'){
            $admin_email = !empty(get_static_option('gig_page_notify_email')) ? get_static_option('gig_page_notify_email') : get_static_option('site_global_email');
            Mail::to($admin_email)->send(new GigNewMessage($gig_message,__('New Message from order #'.$gig_message->gig_order_id)));
        }

        return redirect()->back();
    }

    public function package_order_cancel(Request  $request){
        Order::where('id',$request->id)->update(['status' => 'canceled']);
        return redirect()->back()->with(['msg' => __('order cancel'),'type' => 'danger']);
    }

    public function product_order_cancel(Request  $request){
        ProductOrder::where('id',$request->id)->update(['status' => 'cancel']);
        return redirect()->back()->with(['msg' => __('order cancel'),'type' => 'danger']);
    }

    public function gig_order_cancel(Request $request){
        GigOrder::where('id',$request->id)->update(['order_status' => 'cancel']);
        return redirect()->back()->with(['msg' => __('order cancel'),'type' => 'danger']);
    }
}
