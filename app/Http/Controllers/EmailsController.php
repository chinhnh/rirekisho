<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Gate;
use Session;
use App\User;

class EmailsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new email.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('Admin')) {
            abort(403);
        }
        return view('emails.create');
    }

    /**
     * Send email to receiver.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        if (Gate::denies('Admin')) {
            abort(403);
        }
        
        $recipients = explode(",", $request->recipient);

        foreach ($recipients as $recipient) {
            if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                $errors = 'Recipitents must be email.';
                return redirect()->back()->withErrors($errors);
            }
        }
        
        $this->validate($request, [
            'sender' => 'required',
            'subject' => 'required',
            'content' => 'required',
        ]);
        
        if (isset($request->attach[0])) {
            //upload file to server
            $files = $request->attach;
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                Storage::disk('local')->put($file->getFilename() . '.' . $extension, File::get($file));
                $filename = $file->getFilename() . '.' . $extension;

                $attachs[] = url('../storage/app') . '/' . $filename;
                $filenames[] = $filename;
            }

            //send email
            Mail::send('emails._email', ['content' => $request->content], function($m) use ($request, $recipients, $attachs) {
                $m->from(config('mail.username'), $request->sender)
                    ->subject($request->subject)
                    ->to($recipients);

                for ($i = 0; $i < sizeOf($attachs); $i++) {
                    $m->attach($attachs[$i]);
                }
            });

            //delete file
            for ($i = 0; $i < sizeOf($filenames); $i++) {
                Storage::disk('local')->delete($filenames[$i]);
            }

            Session::flash('flash_message', 'Email has been sent.');
            return redirect()->back();
        }

        Mail::send('emails._email', ['content' => $request->content], function ($m) use ($request, $recipients) {
            $m->from(config('mail.username'), $request->sender);
            $m->to($recipients)->subject($request->subject);
        });

        Session::flash('flash_message', 'Email has been sent.');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new email type 1.
     *
     * @return view
     */
    public function createFormEmail(Request $request)
    {
        if (Gate::denies('Admin')) {
            abort(403);
        }

        if($request->type)
        {
            $email = $request->email;
            
            $data = array('email' => $email);
            
            return view('emails._form_email_1')->with($data);
        }
        
        return 1;
    }

    /**
     * send email type 1.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendEmail1(Request $request)
    {
        if (Gate::denies('Admin')) {
            abort(403);
        }

        $this->validate($request, [
            'recipient' => 'required|email',
            'sender' => 'required',
            'date' => 'required|after:now',
            'time' => 'required',
            'address' => 'required',
        ]);

        $data = array(
            'date' => $request->date,
            'time' => $request->time,
            'address' => $request->address,
        );

        Mail::send('emails._email_1', $data, function ($m) use ($request) {
            $m->from(config('mail.username'), $request->sender);
            $m->to($request->recipient)->subject($request->subject);
        });
        
        Session::flash('flash_message', 'Email has been sent.');
    }

    /**
     * get Email address for ajax.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmailAddress(Request $request)
    {
        $key = $request->term;
        
        $emails = User::select('name', 'email')
            ->where('email', 'like' , '%'.$key.'%')
            ->orWhere('name', 'like', '%'.$key.'%')
            ->get();
        
        return Response::json($emails);
    }
}