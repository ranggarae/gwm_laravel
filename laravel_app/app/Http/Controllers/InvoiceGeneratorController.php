<?php

namespace App\Http\Controllers;

use App\DonationLogs;
use App\EventAttendance;
use App\EventPaymentLogs;
use App\GigOrder;
use App\PaymentLogs;
use App\ProductOrder;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class InvoiceGeneratorController extends Controller
{
    public function generate_package_invoice(Request $request){
        $payment_details = PaymentLogs::where(['order_id' => $request->id])->first();
        $pdf = PDF::loadview('invoice.package-order', ['payment_details' => $payment_details]);
        return $pdf->download('package-invoice.pdf');
    }

    public function generate_product_invoice(Request $request){
        $order_details = ProductOrder::find($request->order_id);
        $pdf = PDF::loadView('invoice.product-order', ['order_details' => $order_details]);
        return $pdf->download('product-order-invoice.pdf');
    }

    public function generate_event_invoice(Request $request){
        $attendance_details = EventAttendance::find($request->id);
        $payment_log = EventPaymentLogs::where(['attendance_id' => $request->id])->first();
        $pdf = PDF::loadView('invoice.event-attendance', ['attendance_details' => $attendance_details,'payment_log' => $payment_log]);
        return $pdf->download('event-attendance-invoice.pdf');
    }

    public function generate_donation_invoice(Request  $request){
        $donation_details = DonationLogs::find($request->id);
        $pdf = PDF::loadView('invoice.donation-invoice', ['donation_details' => $donation_details]);
        return $pdf->download('donation-invoice.pdf');
    }

    public function generate_gig_invoice(Request $request){
        $gig_details = GigOrder::find($request->id);
        $pdf = PDF::loadView('invoice.gig-invoice', ['gig_details' => $gig_details]);
        return $pdf->download('gig-invoice.pdf');
    }
}
