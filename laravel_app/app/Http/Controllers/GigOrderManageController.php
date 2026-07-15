<?php

namespace App\Http\Controllers;

use App\GigMessage;
use App\GigOrder;
use App\Mail\BasicMailTemplate;
use App\Mail\GigNewMessage;
use App\Mail\GigOrderReminder;
use App\Mail\GigOrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GigOrderManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query = GigOrder::query();
        $order_status = !empty($request->order_status) ? $request->order_status : '';
        $payment_status = !empty($request->payment_status) ? $request->payment_status : '';
        if (!empty($order_status)){
            $query->where('order_status',$order_status);
        }
        if (!empty($payment_status)){
            $query->where('payment_status',$payment_status);
        }
        $all_gigs = $query->get();

        return view('backend.gigs.gig-order-manage')->with(['all_gigs' => $all_gigs, 'order_status' => $order_status, 'payment_status' => $payment_status]);
    }

    public function gig_message($id, Request $request)
    {
        $gig_details = GigOrder::where('id', $id)->first();
        if (empty($gig_details)) {
            return redirect_404_page();
        }

        $query = GigMessage::where('gig_order_id', $id);
        $q = '';
        if (!empty($request->q) && $request->q == 'all') {
            $gig_message = $query->orderBy('id', 'ASC')->get();
        } else {
            $q = 'all';
            $gig_message = $query->latest()->get()->take(3);
        }

        return view('backend.gigs.gig-order-message')->with(['gig_details' => $gig_details, 'gig_message' => $gig_message, 'q' => $q]);
    }

    public function store_gig_message(Request $request)
    {
        $this->validate($request, [
            'message' => 'required|string',
            'send_notify_mail' => 'nullable',
            'file' => 'nullable|mimes:zip|max:280000'
        ]);
        $gig_message = GigMessage::create([
            'notify_mail' => $request->send_notify_mail ? 'yes' : 'no',
            'user_id' => Auth::guard('admin')->user()->id,
            'gig_order_id' => $request->gig_order_id,
            'user_type' => $request->user_type,
            'message' => $request->message,
            'status' => 'unseen',
        ]);
        //add file name to database;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = Str::slug($file->getClientOriginalName());
            $file_ext = strtolower($file->getClientOriginalExtension());
            if ($file_ext == 'zip') {
                $db_file_name = $gig_message->id . $file_name . '.' . $file_ext;
                $file->move('assets/uploads/gig-files', $db_file_name);
                $gig_message->file = $db_file_name;
                $gig_message->save();
            }
        }

        if ($gig_message->notify_mail == 'yes') {
            $gig_order = GigOrder::find($request->gig_order_id);
            if (!empty($gig_order)) {
                Mail::to($gig_order->email)->send(new GigNewMessage($gig_message, __('New Message from gig order #' . $gig_message->gig_order_id)));
            }
        }

        return redirect()->back();
    }

    public function delete_gig_order(Request $request, $id)
    {
        GigOrder::find($id)->delete();
        return redirect()->back()->with(['msg' => __('order deleted'), 'type' => 'danger']);
    }

    public function payment_approve(Request $request, $id)
    {
        GigOrder::find($id)->update(['payment_status' => 'complete']);
        return redirect()->back()->with(['msg' => __('Payment Approve Success of order' . ' #' . $id), 'type' => 'success']);
    }

    public function order_status_change(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|string',
            'order_status' => 'required|string',
        ]);
        $gig_order_details = GigOrder::find($request->order_id);
        $gig_order_details->order_status = $request->order_status;
        $gig_order_details->save();

        Mail::to($gig_order_details->email)->send(new GigOrderStatus($gig_order_details, __('your order status change to ' . ucwords(str_replace('_', ' ', $request->order_status)))));

        return redirect()->back()->with(['msg' => __('Order status change Success'), 'type' => 'success']);
    }

    public function order_mail(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        $gig_order_details = GigOrder::find($request->order_id);
        $data['message'] = $request->message;
        Mail::to($gig_order_details->email)->send(new BasicMailTemplate($data, $request->subject));

        return redirect()->back()->with(['msg' => __('Mail Send Success'), 'type' => 'success']);
    }

    public function order_reminder_mail(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required'
        ]);
        $gig_order_details = GigOrder::find($request->order_id);
        Mail::to($gig_order_details->email)->send(new GigOrderReminder($gig_order_details, __('You have a pending order in' . ' ' . get_static_option('site_' . get_default_language() . '_title'))));

        return redirect()->back()->with(['msg' => __('Reminder Mail Send Success'), 'type' => 'success']);
    }

    public function bulk_action(Request $request)
    {
        $all = GigOrder::find($request->ids);
        foreach ($all as $item) {
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

}
