<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Models\GuestLead;
use App\Mail\GuestContact;

class GuestLeadController extends Controller
{
	public function store(Request $request)
	{
		//RECUPERO I DATI DELLA FORM
		$form_data = $request->all();
		//VALIDAZIONE DATI
		$validator = Validator::make($form_data, [
			'name'    => 'required',
			'surname' => 'required',
			'mail'    => 'required',
			'phone'   => 'required',
			'message' => 'required'
		]);
		//SE LA VALIDAZIONE FALLISCE
		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors'  => $validator->errors()
			]);
		}
		//ALTRIMENTI VA AVANTI E SALVA NEL DB I DATI
		// $newContact = new GuestLead();
		// $newContact->fill($form_data);

		// $newContact->save();
		$newContact = GuestLead::create($form_data);

		//INVIO DELLA MAIL
		Mail::to('info@boolpress.com')->send(new GuestContact($newContact));

		return response()->json([
			'success' => true,

		]);
	}
}
