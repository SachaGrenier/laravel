<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Company;
use Illuminate\Support\Facades\Session;


class ContactController extends Controller
{
    public static function getContacts()
    {
        return Contact::all();
    }

    public static function getCompanies()
    {
        return Company::all();
    }
    public function storecompany(request $request)
    {
    	$company = new Company;

    	$company->name = $request->input('name');
    	$company->website = $request->input('website');
    	$company->phone_number = $request->input('phone_number');


    	if ($request->hasFile('image'))
        {
            $file = $request->image;    
            if($file->isValid())
            {
                $destinationPath = 'img/companylogos/';
                $name = str_random(mt_rand(15,25)).'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath,$name); 
                $company->logo_path = $destinationPath.$name;   
            }
            else
            {
                Session::flash('status', 'Fichier invalide'); 
                Session::flash('class', 'alert-danger'); 
            }
        }
        else
        {
             Session::flash('status', 'Fichier invalide'); 
            Session::flash('class', 'alert-danger'); 
        }
        if($company->save())
        {
        	Session::flash('status', 'Entreprise ajoutée avec succès'); 
                Session::flash('class', 'alert-success'); 
        }
     	else
        {
            Session::flash('status', 'Fichier invalide'); 
            Session::flash('class', 'alert-danger'); 
        }
            return redirect('contact'); 
    }
    public function storecontact(request $request)
    {
    	$contact = new Contact;
    	$contact->last_name = $request->input('last_name');
    	$contact->first_name = $request->input('first_name');
    	$contact->phone_number = $request->input('phone_number');
    	$contact->email = $request->input('email');
    	$contact->company_id = $request->input('company_id');
	  
	  	if($contact->save())
        {
        	Session::flash('status', 'Contact ajoutée avec succès'); 
                Session::flash('class', 'alert-success'); 
        }
     	else
        {
            Session::flash('status', 'Fichier invalide'); 
            Session::flash('class', 'alert-danger'); 
        }
            return redirect('contact'); 
    }
     public function deletecompany(request $request)
    {
		$company = Company::find($request->input('id'));
    	if($company->delete())
        {
            Session::flash('status', 'L\'entreprise à correctement été supprimé'); 
            Session::flash('class', 'alert-success'); 
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }

        return redirect('contact');
    }
    public function deletecontact(request $request)
    {
    	$contact = Contact::find($request->input('id'));
    	if($contact->delete())
        {
            Session::flash('status', 'Le contact à correctement été supprimé'); 
            Session::flash('class', 'alert-success'); 
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }

        return redirect('contact');
    }
}
