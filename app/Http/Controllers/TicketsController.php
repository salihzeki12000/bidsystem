<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TicketCategory;
use App\Ticket;
use App\TicketFile;
use App\TicketResponse;
use App\TicketResponseFile;
use Illuminate\Support\Facades\Mail;
use App\TicketAdminEmail;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('company', 'category')->get();

        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = TicketCategory::lists('name', 'id');

        return view('ticket.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $allowed_file_extension = array('jpg', 'png', 'jpeg', 'gif');

        $folder_id = 'admin';
        if(\Auth::user()->company_id != null){
            $folder_id = \Auth::user()->company_id;
        }

        $ticket_array = array(
            'company_id' => \Auth::user()->company_id,
            'category_id' => $request->category,
            'issue_subject' => $request->subject,
            'issue_description' => $request->description,
            'status' => 'open',
            'created_by' => \Auth::user()->id
        );

        $new_ticket = Ticket::create($ticket_array);

        if($new_ticket){

            //send email to inform admin
            if(!empty($new_ticket->company_id)){
                $company_name = $new_ticket->company->company_name;
            }else{
                $company_name = 'Admin';
            }

            $admin_email = TicketAdminEmail::first();
            Mail::send('emails.ticket', array('company_name'=>$company_name), function($message) use ($admin_email){
                $message->to($admin_email->email, 'Bidsystem Admin')->subject('New ticket received...');
            });


            //save ticket attachments
            if($request->file('files')){
                foreach($request->file('files') as $file){
                    if(!empty($file)){
                        $destination_path = public_path().sprintf('/uploads/%s/ticket_files/ticket_id_%s/', $folder_id, $new_ticket->id);
                        if($file->isValid()){
                            $file_name = $file->getClientOriginalName();
                            $get_file_extension = explode('.', $file_name);
                            $file_extension = $get_file_extension[count($get_file_extension) - 1];
                            if(!in_array($file_extension, $allowed_file_extension)){
                                break;
                            }else{
                                if($file->move($destination_path, $file_name)){
                                    $ticket_file_array = array(
                                        'ticket_id' => $new_ticket->id,
                                        'file_name' => $file_name,
                                        'file_path' => \URL::asset('uploads/'.$folder_id.'/ticket_files/ticket_id_'.$new_ticket->id.'/'.$file_name),
                                        'created_by' => \Auth::id()
                                    );
                                    if(TicketFile::create($ticket_file_array)){

                                    }else{
                                        \Session::flash('alert_message', 'File cannot be saved.');
                                        return redirect()->back()->withInput();
                                    }
                                }else{
                                    \Session::flash('alert_message', 'File cannot be saved.');
                                    return redirect()->back()->withInput();
                                }
                            }
                        }else{
                            \Session::flash('alert_message', 'Invalid file.');
                            return redirect()->back()->withInput();
                        }
                    }
                }
            }
            \Session::flash('success_message', 'Ticket has been sent successfully.');
            return redirect('/ticket/'.$new_ticket->id);
        }else{
            \Session::flash('alert_message', 'Ticket cannot be sent.');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::with('company', 'category', 'files', 'responses.files', 'responses.creator', 'responses.creator.company')->find($id);

        return view('ticket.show', compact('ticket'));
    }

    /**
     * Display the specified resource.
     */
    public function showMyTickets($id)
    {
        if(\Auth::user()->type != 'super_admin' && \Auth::user()->type != 'globe_admin'){
            if(\Auth::user()->company_id != $id){
                abort(403);
            }
        }
        $tickets = Ticket::where('company_id', $id)->with('company', 'category', 'files', 'responses.files', 'responses.creator', 'responses.creator.company')->get();

        return view('ticket.show_my_tickets', compact('tickets'));
    }

    /**
     * Save ticket response
     */
    public function saveResponse(Request $request)
    {
        $allowed_file_extension = array('jpg', 'png', 'jpeg', 'gif');

        $folder_id = 'admin';
        if(\Auth::user()->company_id != null){
            $folder_id = \Auth::user()->company_id;
        }

        $response_array = array(
            'ticket_id' => $request->ticket_id,
            'reply_description' => $request->description,
            'created_by' => \Auth::id()
        );

        $new_ticket_response = TicketResponse::create($response_array);

        if($new_ticket_response){
            $ticket = Ticket::findOrFail($request->ticket_id);
            $ticket->is_attended = 1;
            $ticket->save();

            //send email to inform company
            if(!empty($new_ticket_response->ticket->company_id)){
                $company_name = $new_ticket_response->ticket->company->company_name;
            }else{
                $company_name = 'Admin';
            }

            $receiver = $new_ticket_response->creator->email;
            $first_name = $new_ticket_response->creator->first_name;
            $last_name = $new_ticket_response->creator->last_name;
            Mail::send('emails.ticket_response', array('company_name'=>$company_name), function($message) use($receiver, $first_name, $last_name) {
                $message->to($receiver, $first_name.' '.$last_name)->subject('Response to ticket...');
            });

            //save response attachments
            if($request->file('files')){
                foreach($request->file('files') as $file){
                    if(!empty($file)){
                        $destination_path = public_path().sprintf('/uploads/%s/ticket_response_files/ticket_response_id_%s/', $folder_id, $new_ticket_response->id);
                        if($file->isValid()){
                            $file_name = $file->getClientOriginalName();
                            $get_file_extension = explode('.', $file_name);
                            $file_extension = $get_file_extension[count($get_file_extension) - 1];
                            if(!in_array($file_extension, $allowed_file_extension)){
                                break;
                            }else{
                                if($file->move($destination_path, $file_name)){
                                    $ticket_response_file_array = array(
                                        'ticket_response_id' => $new_ticket_response->id,
                                        'file_name' => $file_name,
                                        'file_path' => \URL::asset('uploads/'.$folder_id.'/ticket_response_files/ticket_response_id_'.$new_ticket_response->id.'/'.$file_name),
                                        'created_by' => \Auth::id()
                                    );
                                    if(TicketResponseFile::create($ticket_response_file_array)){

                                    }else{
                                        \Session::flash('alert_message', 'File cannot be saved.');
                                        return redirect()->back()->withInput();
                                    }
                                }else{
                                    \Session::flash('alert_message', 'File cannot be saved.');
                                    return redirect()->back()->withInput();
                                }
                            }
                        }else{
                            \Session::flash('alert_message', 'Invalid file.');
                            return redirect()->back()->withInput();
                        }
                    }
                }
            }
            \Session::flash('success_message', 'Ticket has been sent successfully.');
        }else{
            \Session::flash('alert_message', 'Ticket cannot be sent.');
        }

        return redirect()->back();
    }


    /**
     * Save admin email
     */
    public function saveAdminEmail(Request $request)
    {
        $status = false;
        $email = TicketAdminEmail::find($request->id);

        if($email){
            $email->email = $request->value;
            $email->modified_by = \Auth::id();
            if($email->save()){
                $status = true;
            }
        }else{
            $email_array = array(
                'email' => $request->value,
                'created_by' => \Auth::id()
            );
            $new_email = TicketAdminEmail::create($email_array);

            if($new_email){
                $status = true;
            }
        }

        return response()->json(['status' => $status]);
    }
}