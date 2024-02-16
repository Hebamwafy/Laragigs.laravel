<?php

namespace App\Http\Controllers;

use App\Models\listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class listingController extends Controller
{
    //show all listings
    public function index()
    {
     
        return view('listings.index',[
            'listings'=>listing::latest()->filter(request(['tag', 'search']))->paginate(4)
        ]);
    }
    //show single listing
    public function show ( listing $listing)
    {
        return view('listings.show',['listing'=>$listing]);
    }

    //create form 
    public function create()
    {
        return view ('listings.create');
    }
    //store form 
    public function store(Request $request)
    {
        $formFields=$request->validate([
            'title'=>'required',
            'company'=>['required', Rule::unique('listings', 'company')],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
        ]);
        if ($request->hasFile('logo'))
        {
            // $formFields['logo']= $request->file('the name of the page')
            $formFields['logo']= $request->file('logo')->store('logos','public');
        }
        $formFields['user_id']= auth()->id(); 

        listing::create($formFields);
        return redirect('/');
    }

    //Edit the form 
    public function edit(listing $listing)
    {
        return view ('listings.edit',['listing'=>$listing]);
    }

    //update the form 
    public function update(Request $request , listing $listing)
    {
        // make sure that the logged in user is the owner

        if ($listing->user_id !=auth()->id())
        {
            abort(403, 'UnAuthorized Action');
        }
        $formFields=$request->validate([
            'title'=>'required',
            'company'=>['required'],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
        ]);
        if ($request->hasFile('logo'))
        {
            // $formFields['logo']= $request->file('the name of the page')
            $formFields['logo']= $request->file('logo')->store('logos','public');
        }
        $listing->update($formFields);
        return back()->with('message','listing Updated Successfully!' );
    }

    public function destroy(listing $listing)
    {
        if ($listing->user_id !=auth()->id())
        {
            abort(403, 'UnAuthorized Action');
        }
        
        $listing->delete();
          return redirect('/');

    }
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
