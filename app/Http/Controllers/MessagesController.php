<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use App\ReplyMessage;
use App\Company;
use App\AppointmentObjectives;
use App\AppointmentRequest;
use Illuminate\Support\Facades\Mail;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store initial messages.
     */
    public function sendMessage(Request $request)
    {
        //var_dump($request->all());

        $sender = $request->sender_id;
        if(empty($sender)){
            $sender = \Auth::user()->company_id;
        }

        $this->authorize('create', Message::class);

        $message_array = array(
            'sender' => $sender,
            'receiver' => $request->receiver_id,
            'subject' => $request->subject,
            'description' => $request->description,
            'message_type' => $request->message_type,
            'status' => 'Send',
            'created_by' => \Auth::user()->id
        );

        $new_message = Message::create($message_array);
        if($new_message){

//            $receiver = $new_message->creator->email;
//            $first_name = $new_message->creator->first_name;
//            $last_name = $new_message->creator->last_name;
//            Mail::send('emails.message', array(), function($message) use($receiver, $first_name, $last_name) {
//                $message->to($receiver, $first_name.' '.$last_name)->subject('New message received...');
//            });

            \Session::flash('success_message', 'Message has been sent.');
        }else{
            \Session::flash('alert_message', 'Message cannot be sent.');
        }

        if($request->create_appointment == 1){
            $refined_date_time = date('Y-m-d H:i', strtotime($request->appointment_date));
            $appointment_array = array(
                'sender' => $sender,
                'receiver' => $request->receiver_id,
                'no_of_pic' => $request->appointment_no_of_pic,
                'objective_id' => $request->appointment_objective,
                'description' => $request->appointment_description,
                'location' => $request->appointment_location,
                'date_time' => $refined_date_time,
                'response_status' => 'Accept',
                'created_by' => \Auth::user()->id
            );

            $new_appointment = AppointmentRequest::create($appointment_array);

            $receiver = $new_appointment->creator->email;
            $first_name = $new_appointment->creator->first_name;
            $last_name = $new_appointment->creator->last_name;
            Mail::send('emails.appointment', array(), function($message) use($receiver, $first_name, $last_name){
                $message->to($receiver, $first_name.' '.$last_name)->subject('New message received...');
            });
        }

        return redirect()->back();
    }

    /**
     * Store reply messages.
     */
    public function sendReplyMessage(Request $request)
    {
        $this->authorize('create', Message::class);
        $sender = $request->sender_id;
        if(empty($sender)){
            $sender = \Auth::user()->company_id;
        }

        $message_array = array(
            'sender' => $sender,
            'receiver' => $request->receiver_id,
            'subject' => $request->subject,
            'description' => $request->description,
            'message_type' => $request->message_type,
            'status' => 'Send',
            'created_by' => \Auth::user()->id
        );

        $new_message = Message::create($message_array);
        if($new_message){

//            $receiver = $new_message->creator->email;
//            $first_name = $new_message->creator->first_name;
//            $last_name = $new_message->creator->last_name;
//            Mail::send('emails.message', array(), function($message) use($receiver, $first_name, $last_name) {
//                $message->to($receiver, $first_name.' '.$last_name)->subject('New message received...');
//            });

            $reply_message_array = array(
                'reply_message_id' => $new_message->id,
                'reply_to' => $request->reply_to,
                'create_by' => \Auth::user()->id
            );
            $reply_message = ReplyMessage::create($reply_message_array);
            $initial_message = Message::find($request->reply_to);
            $initial_message->is_read = 0;
            $initial_message->save();

            \Session::flash('success_message', 'Message has been sent.');
        }else{
            \Session::flash('alert_message', 'Message cannot be sent.');
        }

        return redirect()->back();
    }

    /**
     * Show all messages for the company.
     */
    public function showAllMessages($id)
    {
        $sent_messages = Message::where('sender', $id)->where('message_type', 'Initiate')->with('get_sender', 'get_receiver', 'reply_messages')->orderBy('updated_at', 'desc')->get();
        $received_messages = Message::where('receiver', $id)->where('message_type', 'Initiate')->orderBy('updated_at', 'desc')->with('get_sender', 'reply_messages')->get();

        if(\Auth::user()->type != 'super_admin' && \Auth::user()->type != 'globe_admin'){
            if(\Auth::user()->company_id != $id){
                abort(403);
            }
        }

        if(count($received_messages) > 0){
            foreach($received_messages as $key => $individual_received_message){
                $reply_message_ids = array();
                if(!empty($individual_received_message->reply_messages)){
                    foreach($individual_received_message->reply_messages as $message_dependency){
                        $reply_message_ids[] = $message_dependency['reply_message_id'];
                    }
                }
                $reply_messages = Message::whereIn('id', $reply_message_ids)->orderBy('updated_at', 'asc')->get();
                $received_messages[$key]['reply_messages_list'] = $reply_messages->toArray();
            }
        }

        if(count($sent_messages) > 0){
            foreach($sent_messages as $send_message_key => $individual_sent_message){
                $reply_message_ids = array();
                if(!empty($individual_sent_message->reply_messages)){
                    foreach($individual_sent_message->reply_messages as $message_dependency){
                        $reply_message_ids[] = $message_dependency['reply_message_id'];
                    }
                }
                $reply_messages = Message::whereIn('id', $reply_message_ids)->orderBy('updated_at', 'asc')->get();
                $sent_messages[$send_message_key]['reply_messages_list'] = $reply_messages->toArray();
            }
        }

        $companies = Company::lists('company_name', 'id');
        $appointment_objectives = AppointmentObjectives::lists('app_objective', 'id');

        return view('message.messages', compact('sent_messages', 'received_messages', 'companies', 'appointment_objectives'));
    }

    /**
     * list all messages.
     */
    public function index()
    {
        $this->authorize('list_messages', Message::class);
        $messages = Message::with('get_sender', 'get_receiver')->orderBy('updated_at', 'desc')->get();
        $companies = Company::lists('company_name', 'id');
        $appointment_objectives = AppointmentObjectives::lists('app_objective', 'id');

        //var_dump($messages->toArray());

        return view('message.index', compact('messages', 'companies', 'appointment_objectives'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $message = Message::find($id);
        $this->authorize('update', $message);

        if($message->update($request->all())){
            \Session::flash('success_message', 'Message has been deleted.');
        }else{
            \Session::flash('alert_message', 'Message cannot be deleted.');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified message from storage.
     */
    public function destroy($id)
    {
        $message = Message::find($id);
        $this->authorize('delete', $message);

        if($message->delete()){
            \Session::flash('success_message', 'Message has been deleted.');
        }else{
            \Session::flash('alert_message', 'Message cannot be deleted.');
        }

        return redirect()->back();
    }

    /**
     * Mark message as read.
     */
    public function readMessage(Request $request)
    {
        $status = false;
        $message = Message::find($request->id);
        $message->is_read = 1;

        if($message->save()){
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

}