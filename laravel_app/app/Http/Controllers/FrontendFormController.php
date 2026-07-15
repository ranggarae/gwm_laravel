<?php

namespace App\Http\Controllers;

use App\EventAttendance;
use App\Events;
use App\Feedback;
use App\JobApplicant;
use App\Mail\CallBack;
use App\Mail\ContactMessage;
use App\Mail\PlaceOrder;
use App\Mail\RequestQuote;
use App\Newsletter;
use App\Order;
use App\PricePlan;
use App\Mail\FeedbackMessage;
use App\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FrontendFormController extends Controller
{
    public function store_jobs_applicant_data(Request $request)
    {

        $all_quote_form_fields = json_decode(get_static_option('apply_job_page_form_fields'));

        $required_fields = [];
        $fileds_name = [];
        $attachment_list = [];
        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if (is_object($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required->$key) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            } elseif (is_object($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } elseif (is_array($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } else if (is_array($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required[$key]) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            }
        }
        $this->validate($request, $required_fields);

        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if ($value != 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                $checkbox_value = ($value == 'checkbox' && !empty($request->$singule_field_name)) ? 'Yes' : 'No';
                $fileds_name[$singule_field_name] = ($value != 'checkbox') ? $request->$singule_field_name : $checkbox_value;

            } elseif ($value == 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                if ($request->hasFile($singule_field_name)) {
                    $filed_instance = $request->file($singule_field_name);
                    $file_extenstion = $filed_instance->getClientOriginalExtension();
                    $attachment_name = 'attachment-' . $singule_field_name . '.' . $file_extenstion;
                    $filed_instance->move('assets/uploads/attachment/applicant-', $attachment_name);
                    $attachment_list[$singule_field_name] = 'assets/uploads/attachment/applicant-' . $attachment_name;
                }
            }
        }
        $all_field_serialize_data = $request->all();
        unset($all_field_serialize_data['_token']);
        unset($all_field_serialize_data['job_id']);
        foreach ($all_field_serialize_data as $field_name => $field_value) {
            if ($request->hasFile($field_name)) {
                unset($all_field_serialize_data[$field_name]);
            }
        }
        //have to store applicant information in database
        JobApplicant::create([
            'jobs_id' => $request->job_id,
            'form_content' => serialize($all_field_serialize_data),
            'attachment' => serialize($attachment_list)
        ]);

        $succ_msg = get_static_option('apply_job_' . get_user_lang() . '_success_message');
        $success_message = !empty($succ_msg) ? $succ_msg : __('Your Application Is Submitted Successfully!!');
        Mail::to(get_static_option('job_applicant_mail'))->send(new ContactMessage($fileds_name, $attachment_list, 'You Have A Job Applicant'));

        return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);
    }

    public function send_contact_message(Request $request)
    {

        $all_quote_form_fields = json_decode(get_static_option('contact_page_form_fields'));
        $required_fields = [];
        $fileds_name = [];
        $attachment_list = [];
        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if (is_object($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required->$key) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            } elseif (is_object($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } elseif (is_array($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } else if (is_array($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required[$key]) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            }
        }
        $this->validate($request, $required_fields);

        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if ($value != 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                $checkbox_value = ($value == 'checkbox' && !empty($request->$singule_field_name)) ? 'Yes' : 'No';
                $fileds_name[$singule_field_name] = ($value != 'checkbox') ? $request->$singule_field_name : $checkbox_value;

            } elseif ($value == 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                if ($request->hasFile($singule_field_name)) {
                    $filed_instance = $request->file($singule_field_name);
                    $file_extenstion = $filed_instance->getClientOriginalExtension();
                    $attachment_name = 'attachment-' . $singule_field_name . '.' . $file_extenstion;
                    $filed_instance->move('assets/uploads/attachment/', $attachment_name);
                    $attachment_list[$singule_field_name] = 'assets/uploads/attachment/' . $attachment_name;
                }
            }
        }

        $google_captcha_result = google_captcha_check($request->captcha_token);

        if ($google_captcha_result['success']) {

            $succ_msg = get_static_option('contact_mail_' . get_user_lang() . '_subject');
            $success_message = !empty($succ_msg) ? $succ_msg : 'Thanks for your contact!!';
            $contact_mail = get_static_option('contact_page_form_email');
            $receiving_mail = !empty($contact_mail) ? $contact_mail : get_static_option('site_global_email');

            Mail::to($receiving_mail)->send(new ContactMessage($fileds_name, $attachment_list,__('You Have A Contact Mail')));

            return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);

        } else {
            return redirect()->back()->with(['msg' => __('Something goes wrong, Please try again later !!'), 'type' => 'danger']);
        }
    }

    public function subscribe_newsletter(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:191|unique:newsletters'
        ]);
        Newsletter::create($request->all());
        return response()->json([
            'msg' => __('Thanks for Subscribe Our Newsletter'),
            'type' => 'success'
        ]);
    }

    public function send_quote_message(Request $request)
    {

        $all_quote_form_fields = json_decode(get_static_option('quote_page_form_fields'));
        $required_fields = [];
        $fileds_name = [];
        $attachment_list = [];
        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if (is_object($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required->$key) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            } elseif (is_object($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } elseif (is_array($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } else if (is_array($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required[$key]) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            }
        }
        $this->validate($request, $required_fields);
        //have to insert quote data to database to show all quote in backend;
        $all_field_serialize_data = $request->all();
        unset($all_field_serialize_data['_token']);
        unset($all_field_serialize_data['captcha_token']);
        foreach($all_field_serialize_data as $field_name => $field_value){
            if ($request->hasFile($field_name)){
                unset($all_field_serialize_data[$field_name]);
            }
        }
        $quote_id = Quote::create([
            'custom_fields' => serialize($all_field_serialize_data),
            'status' => 'pending'
        ])->id;

        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if ($value != 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                $checkbox_value = ($value == 'checkbox' && !empty($request->$singule_field_name)) ? 'Yes' : 'No';
                $fileds_name[$singule_field_name] = ($value != 'checkbox') ? $request->$singule_field_name : $checkbox_value;

            } elseif ($value == 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                if ($request->hasFile($singule_field_name)) {
                    $filed_instance = $request->file($singule_field_name);
                    $file_extenstion = $filed_instance->getClientOriginalExtension();
                    $attachment_name = 'attachment-' . $quote_id .'-'.$singule_field_name. '.' . $file_extenstion;
                    $filed_instance->move('assets/uploads/attachment/', $attachment_name);

                    $attachment_list[$singule_field_name] = 'assets/uploads/attachment/' . $attachment_name;
                }
            }
        }

        Quote::find($quote_id)->update(['attachment' => serialize($attachment_list)]);

        $google_captcha_result = google_captcha_check($request->captcha_token);
        if ($google_captcha_result['success']) {
            //have to check mail
            $succ_msg = get_static_option('quote_mail_' . get_user_lang() . '_subject');
            $success_message = !empty($succ_msg) ? $succ_msg : 'Thanks for your quote. we will get back to you very soon.';

            Mail::to(get_static_option('quote_page_form_mail'))->send(new RequestQuote($fileds_name, $attachment_list));

            return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);

        }

        return redirect()->back()->with(['msg' => 'Something went wrong, Please try again later !!', 'type' => 'danger']);

    }

    public function send_order_message(Request $request)
    {

        $all_quote_form_fields = json_decode(get_static_option('order_page_form_fields'));
        $required_fields = [];
        $fileds_name = [];
        $attachment_list = [];
        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if (is_object($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required->$key) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            } elseif (is_object($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } elseif (is_array($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } else if (is_array($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required[$key]) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            }
        }
        $this->validate($request, $required_fields);
        if (!empty(get_static_option('site_payment_gateway'))){
            $this->validate($request,[
                'selected_payment_gateway' => 'required|string'
            ],
                [
                    'selected_payment_gateway.required' => "select one payment gateway to place order"
                ]);
        }
        $package_detials = PricePlan::find($request->package);
        $all_field_serialize_data = $request->all();
        unset($all_field_serialize_data['_token']);
        unset($all_field_serialize_data['captcha_token']);
        foreach($all_field_serialize_data as $field_name => $field_value){
            if ($request->hasFile($field_name)){
                unset($all_field_serialize_data[$field_name]);
            }
        }
        $order_id = Order::create([
            'custom_fields' => serialize($all_field_serialize_data),
            'status' => 'pending',
            'package_name' => $package_detials->title,
            'package_price' => $package_detials->price,
            'package_id' => $package_detials->id,
            'user_id' => auth()->guard('web')->check() ? Auth::guard('web')->user()->id : '',
        ])->id;

        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if ($value != 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                $checkbox_value = ($value == 'checkbox' && !empty($request->$singule_field_name)) ? 'Yes' : 'No';
                $fileds_name[$singule_field_name] = ($value != 'checkbox') ? $request->$singule_field_name : $checkbox_value;

            } elseif ($value == 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                if ($request->hasFile($singule_field_name)) {
                    $filed_instance = $request->file($singule_field_name);
                    $file_extenstion = $filed_instance->getClientOriginalExtension();
                    $attachment_name = 'attachment-' .$order_id.'-'. $singule_field_name . '.' . $file_extenstion;
                    $filed_instance->move('assets/uploads/attachment/', $attachment_name);

                    $attachment_list[$singule_field_name] = 'assets/uploads/attachment/' . $attachment_name;
                }
            }
        }
        Order::find($order_id)->update(['attachment' => serialize($attachment_list)]);



        //for development purpose

        if (!empty(get_static_option('site_payment_gateway')) && env('APP_DEBUG') == 'true'){

            $succ_msg = get_static_option('order_mail_' . get_user_lang() . '_subject');
            $success_message = !empty($succ_msg) ? $succ_msg : 'Thanks for your order. we will get back to you very soon.';

            return redirect()->route('frontend.order.confirm',$order_id);
        }
        //for development purpose

        $google_captcha_result = google_captcha_check($request->captcha_token);
        if ($google_captcha_result['success']) {

            $succ_msg = get_static_option('order_mail_' . get_user_lang() . '_subject');
            $success_message = !empty($succ_msg) ? $succ_msg : 'Thanks for your order. we will get back to you very soon.';

            //have to set condition for redirect in payment page with payment information
            if (!empty(get_static_option('site_payment_gateway'))){
                return redirect()->route('frontend.order.confirm',$order_id);
            }
            return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);

        } else {
            return redirect()->back()->with(['msg' => 'Something goes wrong, Please try again later !!', 'type' => 'danger']);
        }

    }

    public function send_call_back_message(Request $request)
    {

        $all_quote_form_fields = json_decode(get_static_option('call_back_page_form_fields'));
        $required_fields = [];
        $fileds_name = [];
        $attachment_list = [];
        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if (is_object($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required->$key) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            } elseif (is_object($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } elseif (is_array($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } else if (is_array($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required[$key]) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            }
        }
        $this->validate($request, $required_fields);

        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if ($value != 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                $checkbox_value = ($value == 'checkbox' && !empty($request->$singule_field_name)) ? 'Yes' : 'No';
                $fileds_name[$singule_field_name] = ($value != 'checkbox') ? $request->$singule_field_name : $checkbox_value;

            } elseif ($value == 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                if ($request->hasFile($singule_field_name)) {
                    $filed_instance = $request->file($singule_field_name);
                    $file_extenstion = $filed_instance->getClientOriginalExtension();
                    $attachment_name = 'attachment-' . $singule_field_name . '.' . $file_extenstion;
                    $filed_instance->move('assets/uploads/attachment/', $attachment_name);
                    $attachment_list[$singule_field_name] = 'assets/uploads/attachment/' . $attachment_name;
                }
            }
        }


        $succ_msg = get_static_option('request_call_back_mail_' . get_user_lang() . '_subject');
        $success_message = !empty($succ_msg) ? $succ_msg : 'Thanks for Your Contact!!! We Will Contact You Soon';

        Mail::to(get_static_option('home_page_01_faq_area_form_mail'))->send(new CallBack($fileds_name, $attachment_list));;

        return redirect()->back()->with([
            'msg' => $success_message,
            'type' => 'success'
        ]);
    }

    public function store_event_booking_data(Request $request){
        $all_quote_form_fields = json_decode(get_static_option('event_booking_form_fields'));
        $required_fields = [];
        $fileds_name = [];
        $attachment_list = [];
        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if (is_object($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required->$key) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            } elseif (is_object($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } elseif (is_array($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } else if (is_array($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required[$key]) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            }
        }
        $this->validate($request, $required_fields);
        if (!empty(get_static_option('site_payment_gateway'))) {
            $this->validate($request, [
                'selected_payment_gateway' => 'nullable|string'
            ],
                [
                    'selected_payment_gateway.required' => __("select one payment gateway to place attend")
                ]);
        }
        $event_detials = Events::find($request->event_id);
        $all_field_serialize_data = $request->all();
        unset($all_field_serialize_data['_token']);
        unset($all_field_serialize_data['captcha_token']);
        unset($all_field_serialize_data['username']);
        unset($all_field_serialize_data['password']);
        foreach ($all_field_serialize_data as $field_name => $field_value) {
            if ($request->hasFile($field_name)) {
                unset($all_field_serialize_data[$field_name]);
            }
        }
        $event_attendance_id = EventAttendance::create([
            'custom_fields' => serialize($all_field_serialize_data),
            'status' => 'pending',
            'event_name' => $event_detials->title,
            'event_cost' => $event_detials->cost,
            'quantity' => $request->quantity,
            'event_id' => $request->event_id,
            'checkout_type' => !empty($request->checkout_type) ? $request->checkout_type : '',
            'user_id' => Auth::check() ? Auth::user()->id : 0,
        ])->id;

        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if ($value != 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                $checkbox_value = ($value == 'checkbox' && !empty($request->$singule_field_name)) ? 'Yes' : 'No';
                $fileds_name[$singule_field_name] = ($value != 'checkbox') ? $request->$singule_field_name : $checkbox_value;

            } elseif ($value == 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                if ($request->hasFile($singule_field_name)) {
                    $filed_instance = $request->file($singule_field_name);
                    $file_extenstion = $filed_instance->getClientOriginalExtension();
                    $attachment_name = 'attachment-' . $event_attendance_id . '-' . $singule_field_name . '.' . $file_extenstion;
                    $filed_instance->move('assets/uploads/attachment/', $attachment_name);

                    $attachment_list[$singule_field_name] = 'assets/uploads/attachment/' . $attachment_name;
                }
            }
        }

        EventAttendance::find($event_attendance_id)->update(['attachment' => serialize($attachment_list)]);

        $google_captcha_result = google_captcha_check($request->captcha_token);
        if ($google_captcha_result['success']) {

            //have to set condition for redirect in payment page with payment information
            if (!empty(get_static_option('site_payment_gateway'))) {

                $succ_msg = get_static_option('event_attendance_mail_' . get_user_lang() . '_subject');
                $success_message = !empty($succ_msg) ? $succ_msg : __('Thanks for your Booking. we will get back to you very soon.');
                $order_mail = get_static_option('event_attendance_receiver_mail') ? get_static_option('event_attendance_receiver_mail') : get_static_option('site_global_email');

                if ($event_detials->cost == 0 || empty(get_static_option('site_payment_gateway'))){
                    return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);
                }
                Mail::to($order_mail)->send(new ContactMessage($fileds_name, $attachment_list, 'your have an event booking for '.$event_detials->title));
                return redirect()->route('frontend.event.booking.confirm', $event_attendance_id);

            }
            $success_message = __('Thanks for your Booking. we will get back to you very soon.');
            return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);

        } else {
            return redirect()->back()->with(['msg' => __('Something goes wrong, Please try again later !!'), 'type' => 'danger']);
        }
    }
    public function clients_feedback_store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'ratings' => 'required|string|max:191',
            'description' => 'nullable|string',
        ],
        [
            'name.required' => __('Name field is required'),
            'email.required' => __('Email field is required'),
            'ratings.required' =>__('Ratings field is required'),
        ]);
        $all_quote_form_fields = json_decode(get_static_option('feedback_page_form_fields'));
        $required_fields = [];
        $fileds_name = [];
        $attachment_list = [];
        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if (is_object($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required->$key) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            } elseif (is_object($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } elseif (is_array($all_quote_form_fields->field_required) && $value == 'file') {

                $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
                $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
                $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

            } else if (is_array($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required[$key]) && $value != 'file') {

                $sanitize_rule = ($value == 'email') ? 'email' : 'string';
                $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

            }
        }
        $this->validate($request, $required_fields);
        //have to insert quote data to database to show all quote in backend;
        $all_field_serialize_data = $request->all();
        unset($all_field_serialize_data['_token']);
        unset($all_field_serialize_data['captcha_token']);
        foreach($all_field_serialize_data as $field_name => $field_value){
            if ($request->hasFile($field_name)){
                unset($all_field_serialize_data[$field_name]);
            }
        }
        $feedback = Feedback::create([
            'name' => $request->name,
            'email' => $request->email,
            'ratings' => $request->ratings,
            'description' => $request->description,
            'custom_fields' => serialize($all_field_serialize_data),
        ]);

        foreach ($all_quote_form_fields->field_type as $key => $value) {
            if ($value != 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                $checkbox_value = ($value == 'checkbox' && !empty($request->$singule_field_name)) ? 'Yes' : 'No';
                $fileds_name[$singule_field_name] = ($value != 'checkbox') ? $request->$singule_field_name : $checkbox_value;

            } elseif ($value == 'file') {
                $singule_field_name = $all_quote_form_fields->field_name[$key];
                if ($request->hasFile($singule_field_name)) {
                    $filed_instance = $request->file($singule_field_name);
                    $file_extenstion = $filed_instance->getClientOriginalExtension();
                    $attachment_name = 'attachment-' . $feedback->id .'-'.$singule_field_name. '.' . $file_extenstion;
                    $filed_instance->move('assets/uploads/attachment/', $attachment_name);

                    $attachment_list[$singule_field_name] = 'assets/uploads/attachment/' . $attachment_name;
                }
            }
        }

        Feedback::find($feedback->id)->update(['attachment' => serialize($attachment_list)]);

        $google_captcha_result = google_captcha_check($request->captcha_token);
        if ($google_captcha_result['success']) {
            //have to check mail
            $succ_msg = get_static_option('feedback_mail_' . get_user_lang() . '_success_message');
            $success_message = !empty($succ_msg) ? $succ_msg : 'Thanks for your feedback.';
            Mail::to(get_static_option('feedback_notify_mail'))->send(new FeedbackMessage(['field_name' => $fileds_name,'feedback' => $feedback], $attachment_list, __('Your Have A Feedback Message')));

            return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);

        }

        return redirect()->back()->with(['msg' => __('Something went wrong, Please try again later !!'), 'type' => 'danger']);
    }
}
