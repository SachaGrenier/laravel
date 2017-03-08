<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Company;
use App\Applicant;
use Illuminate\Support\Facades\Session;


class ContactController extends Controller
{
    public static function getContacts()
    {
        return Contact::all();
    }

    public static function getContact($id)
    {
        return Contact::find($id);
    }

    public static function getCompanies()
    {
        return Company::all();
    }

    public static function getCompany($id)
    {
        return Company::find($id);
    }
    
    public static function getApplicants()
    {
         return Applicant::all();  
    }
        public static function getApplicant($id)
    {
        return Applicant::find($id);
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
        	Session::flash('status', 'Contact ajouté avec succès'); 
                Session::flash('class', 'alert-success'); 
        }
     	else
        {
            Session::flash('status', 'Fichier invalide'); 
            Session::flash('class', 'alert-danger'); 
        }
            return redirect('contact'); 
    }
        public function storeapplicant(request $request)
    {
        $applicant = new Applicant;
        $applicant->last_name = $request->input('last_name');
        $applicant->first_name = $request->input('first_name');
        $applicant->phone_number = $request->input('phone_number');
        $applicant->email = $request->input('email');
      
        if($applicant->save())
        {
            Session::flash('status', 'Demandeur ajouté avec succès'); 
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

        $contacts = Contact::where('company_id', $request->input('id'))->get();
        
        $listnames = "";
            
        foreach ($contacts as $contact)
        {
            $listnames .= $contact->first_name.' '.$contact->last_name.',';
        }
        $listnames=rtrim($listnames,", ");

        if (count($contacts) > 0) 
        {
            if(count($contacts) == 1)
            Session::flash('status', 'Le contact '.$listnames.' est actuellement assigné à cette entreprise. Veuillez le modifier!'); 
            else
            Session::flash('status', 'Les contacts '.$listnames.' sont actuellement assignés à cette entreprise. Veuillez les modifier!'); 

            Session::flash('class', 'alert-danger');
        }
        else
        {
            $company = Company::find($request->input('id'));
            unlink($company->logo_path);
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

    public function updatecontact(request $request)
    {
        $contact = Contact::find($request->input('id'));
        $contact->first_name = $request->input('first_name');
        $contact->last_name = $request->input('last_name');
        $contact->email = $request->input('email');
        $contact->phone_number = $request->input('phone_number');
        $contact->company_id = $request->input('company_id');
        
        if($contact->save())
        {
            Session::flash('status', 'Le profil à correctement été mis à jour'); 
            Session::flash('class', 'alert-success'); 
              
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }

        return redirect('editcontact/'. $request->input('id'));

    }

    public function updatecompany(request $request)
    {
        $company = Company::find($request->input('id'));
        $company->name = $request->input('name');
        $company->website = $request->input('website');
        $company->phone_number = $request->input('phone_number');
        
        if($company->save())
        {
            Session::flash('status', 'L\'entreprise à correctement été mis à jour'); 
            Session::flash('class', 'alert-success'); 
              
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }

        return redirect('editcompany/'. $request->input('id'));

    }

    public function updateapplicant(request $request)
    {
        $applicant = Applicant::find($request->input('id'));
        $applicant->first_name = $request->input('first_name');
        $applicant->last_name = $request->input('last_name');
        $applicant->email = $request->input('email');
        $applicant->phone_number = $request->input('phone_number');
        
        if($applicant->save())
        {
            Session::flash('status', 'Le demandeur à été mis à jour'); 
            Session::flash('class', 'alert-success'); 
              
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }

        return redirect('editapplicant/'. $request->input('id'));

    }
    

    public static function updatelogo(Request $request)
    {
        
        if ($request->hasFile('image'))
        {
            $file = $request->image;    
            if($file->isValid())
            {
                $destinationPath = 'img/companylogos/';
                $name = str_random(mt_rand(15,25)).'.'.$file->getClientOriginalExtension();
                $company = ContactController::getCompany($request->input('id')); 
                $file->move($destinationPath,$name); 
                unlink($company->logo_path);
                $company->logo_path = $destinationPath.$name;

                $company->save();
                Session::flash('status', 'La photo de profil à bien été mise à jour'); 
                Session::flash('class', 'alert-success'); 
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
        return redirect('editcompany/'. $request->input('id'));  


    }


    
}
