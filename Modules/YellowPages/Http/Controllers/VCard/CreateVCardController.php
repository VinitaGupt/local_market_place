<?php

namespace Modules\YellowPages\Http\Controllers\VCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VCard;
use Exception;
use App\Models\DynamicVcard;
use Modules\YellowPages\Http\Requests\StoreVCardRequest;
use App\Models\City;
use App\Models\User;
use App\Models\Category;
use App\Models\BusinessListing;
use App\Models\DynamicFeild;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Eloquent\ModelNotFoundException;


class CreateVCardController extends Controller
{
    ##------------------------- store ---------------------##

    public function store(StoreVCardRequest $request)
    {
        $validatedData = $request->validated();
    
        // Handle file uploads
        if ($request->hasFile('profile')) {
            $validatedData['profile'] = $request->file('profile')->store('yellowpages/profile');
        }
    
        if ($request->hasFile('aadhar_front')) {
            $validatedData['aadhar_front'] = $request->file('aadhar_front')->store('yellowpages/aadhar');
        }
    
        if ($request->hasFile('aadhar_back')) {
            $validatedData['aadhar_back'] = $request->file('aadhar_back')->store('yellowpages/aadhar');
        }
    
        // Get authenticated user
        $userId = Auth::id();
        $user = User::find($userId);
    
        // Assign user ID to validated data
        if ($user) {
            $user->update([
                'name'    => $validatedData['name'],
                'surname' => $validatedData['surname'],
                'aadhar'  => $validatedData['aadhar'],
                'email'   => $validatedData['email'] ?? $user->email,
                'dob'     => $validatedData['dob'] ?? $user->dob,
                'profile' => $validatedData['profile'],
            ]);
        }
    
        // Generate unique slug
        $slug = Str::slug($validatedData['name']);
        $originalSlug = $slug;
        $count = 1;
    
        while (VCard::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
    
        // Save address in `addresses` table
        $address = Address::create([
            'user_id'      => $userId,
            'house_number' => $validatedData['house_number'],
            'street'       => $validatedData['road_street'],
            'area_name'    => $validatedData['area_name'],
            'city_id'      => $validatedData['city_id'],
            'postal_code'  => $validatedData['pincode'] ?? null,
        ]);
    
        if (!$address) {
            throw new Exception('Failed to save address.');
        }
    
        // Assign address ID to validated data
        $validatedData['address_id'] = $address->id;
    
        // Save Vcard details
        $card = VCard::create([
            'user_id'      => $userId,
            'category_id'  => $validatedData['category_id'],
            'slug'         => $slug,
            'city_id'      => $validatedData['city_id'],
            'color_code'   => $validatedData['color_code'],
            'aadhar_front' => $validatedData['aadhar_front'] ?? null,
            'aadhar_back'  => $validatedData['aadhar_back'] ?? null,
            'address_id'   => $validatedData['address_id'],
        ]);
    
        if (!$card) {
            throw new Exception('Failed to create VCard.');
        }
    
        // Save dynamic fields if provided
        if (!empty($validatedData['dynamic_name']) && !empty($validatedData['dynamic_data']) && !empty($validatedData['dynamic_icon'])) {
            foreach ($validatedData['dynamic_name'] as $index => $fieldName) {
                if (!isset($validatedData['dynamic_data'][$index])) {
                    continue; 
                }
    
                DynamicVCard::create([
                    'vcard_id' => $card->id,
                    'title'    => $fieldName,
                    'data'     => $validatedData['dynamic_data'][$index],
                    'icon'     => $validatedData['dynamic_icon'][$index] ?? null,
                ]);
            }
        }
    
        return redirect()->route('vCard.view', ['slug' => $slug])
                         ->with('success', 'Card saved successfully.');
    }
    ##------------------------- END ---------------------##

    ##------------------------- vCardEdit ---------------------##public function vCardEdit($id)
    public function vCardEdit($id)
    {
        try {
            $vcard = VCard::findOrFail($id);
            $vcardInfo = DynamicVCard::where('vcard_id', $vcard->id)->get();
            $dynamicFields = DynamicFeild::where('is_active', 1)->get();
            $cities = City::all();
            $categories = Category::all();
            $address = Address::where('user_id', Auth::id())->first();
            $user = User::find($vcard->user_id); // Correct way to get user
    
            return view('yellowpages::Vcard.vcardEdit', compact(
                'vcard', 'vcardInfo', 'categories', 'cities', 'dynamicFields', 'address', 'user'
            ));
        } catch (Exception $e) {
            Log::error('Error editing VCard: ' );
            return redirect()->back()->withErrors(['error' => 'Unable to fetch VCard details for editing.']);
        }
    }
    
    ##------------------------- END ---------------------##

    ##------------------------- vCardUpdate ---------------------##
    public function vCardUpdate(Request $request, $id)
    {
        // try {
            // Validate incoming data
            $validatedData = $request->validate([
                'color_code' => 'nullable|string',
                'category_id' => 'required|exists:yp.categories,id',
                'city_id' => 'required|exists:yp.cities,id',
                'name' => 'required|string',
                'surname' => 'nullable|string',
                'house_number' => 'nullable|string',
                'street' => 'nullable|string',
                'area_name' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'dob' => 'nullable|date',
                'email' => 'nullable|email',
                'aadhar' => 'nullable|string',
                'profile' => 'nullable|image|max:2048',
                'aadhar_front' => 'nullable|image|max:2048',
                'aadhar_back' => 'nullable|image|max:2048',
                'dynamic_name'     => 'nullable|array',
                'dynamic_name.*'   => 'nullable|string',
                'dynamic_data'     => 'nullable|array',
                'dynamic_data.*'   => 'nullable|string',
            ], [
                'category_id.required' => 'श्रेणी फ़ील्ड आवश्यक है।',
                'city_id.required' => 'शहर फ़ील्ड आवश्यक है।',
                'name.required' => 'नाम फ़ील्ड आवश्यक है।',
            ]);

    
            // Retrieve the vCard
            $vcard = VCard::findOrFail($id);
    
            // Ensure user and address relationships exist
            $user = $vcard->user;
            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'User not found for this VCard.']);
            }
    
            $address = $user->address;
            if (!$address) {
                return redirect()->back()->withErrors(['error' => 'Address not found for this user.']);
            }
    
            // Handle file uploads
            if ($request->hasFile('profile')) {
                $validatedData['profile'] = $request->file('profile')->store('yellowpages/profiles', 's3');
            }
            
    
            if ($request->hasFile('aadhar_front')) {
                $validatedData['aadhar_front'] = $request->file('aadhar_front')->store('yellowpages/aadhar');
            }
    
            if ($request->hasFile('aadhar_back')) {
                $validatedData['aadhar_back'] = $request->file('aadhar_back')->store('yellowpages/aadhar');
            }
    
            // Begin Transaction
            DB::beginTransaction();
    
            // Update User Table
            if ($user) {
                $user->update([
                    'name' => array_key_exists('name', $validatedData) ? $validatedData['name'] : $user->name,
                    'surname' => array_key_exists('surname', $validatedData) ? $validatedData['surname'] : $user->surname,
                    'dob' => array_key_exists('dob', $validatedData) ? $validatedData['dob'] : $user->dob,
                    'email' => array_key_exists('email', $validatedData) ? $validatedData['email'] : $user->email,
                    'aadhar' => array_key_exists('aadhar', $validatedData) ? $validatedData['aadhar'] : $user->aadhar,
                    'profile' => array_key_exists('profile', $validatedData) ? $validatedData['profile'] : $user->profile,
                ]);
            }
            
    
            // Update Address Table
            $address->update([
                'house_number' => $validatedData['house_number'] ?? $address->house_number,
                'street' => $validatedData['street'] ?? $address->street,
                'area_name' => $validatedData['area_name'] ?? $address->area_name,
                'postal_code' => $validatedData['postal_code'] ?? $address->postal_code,
                'city_id' => $validatedData['city_id'] ?? $address->city_id,
            ]);
    
            // Handle Dynamic Fields
            if (isset($validatedData['dynamic_name']) && is_array($validatedData['dynamic_name'])) {
                foreach ($validatedData['dynamic_name'] as $index => $dynamicName) {
                    $dataValue = $validatedData['dynamic_data'][$index] ?? null;
                    
                    if ($dataValue) {
                        $existingField = DynamicVCard::where('vcard_id', $id)
                            ->where('title', $dynamicName)
                            ->first();
        
                        if ($existingField) {
                            $existingField->update(['data' => $dataValue]);
                        } else {
                            DynamicVCard::create([
                                'vcard_id' => $id,
                                'title' => $dynamicName,
                                'data' => $dataValue,
                            ]);
                        }
                    }
                }
            }
            
            // Handle Deleted Fields
            if ($request->has('deleted_fields')) {
                $deletedFieldIds = explode(',', $request->input('deleted_fields'));
                DynamicVCard::where('vcard_id', $id)
                    ->whereIn('id', $deletedFieldIds)
                    ->delete();
            }
    
            DB::commit();
    
            return redirect()->route('vCard.list')->with('success', 'वेबपेज सफलतापूर्वक अपडेट(Update) किया गया.');
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     Log::error('Error updating VCard: ' );
        //     return redirect()->back()->withErrors(['error' => 'An error occurred while updating the VCard.']);
        // }
    }
    
    ##------------------------- END ---------------------##

    ##------------------------- VCard view ---------------------##
    public function view($city_arr,$slug)
    {
        $vcard = VCard::where('slug', $slug)
            ->orderBy('id', 'desc')
            ->with( 'dynamicFields')
            ->first();
        $user = User::with('address')->find($vcard->user_id);
        $dynamicFields = DynamicFeild::where('is_active', 1)->get();
    
        // Fetch VCard data
        $category = Category::where('id', $vcard->category_id)->first();
        // Check if VCard exists and is approved
        if (!$vcard) {
            $message = 'VCard not found.';
            return view('yellowpages::Vcard.CardView', compact('user', 'address', 'message','category','city_arr'));
        }
    
        // If VCard is not approved
        if ($vcard->is_active != 1) {
            $message = 'आपका कार्ड स्वीकृति की प्रक्रिया में है।';
            return view('yellowpages::Vcard.CardView', compact('user', 'message', 'vcard','category','city_arr'));
        }    
        
        return view('yellowpages::Vcard.CardView', compact('vcard', 'user', 'category', 'dynamicFields','city_arr'));
    }
    
    ##------------------------- END ---------------------##

     ##------------------------- VCard share ---------------------##
     public function vcardShare($slug)
     {
        $vcard = VCard::where('slug', $slug)
            ->where('is_active', 1)
            ->orderBy('id', 'desc')
            ->with('dynamicFields')
            ->first();
    
        if (!$vcard) {
            abort(404, 'vCard not found.');
        }
    
        $user = User::with('address')->find($vcard->user_id);
        if (!$user) {
            abort(404, 'User not found.');
        }
    
        $dynamicFields = DynamicFeild::where('is_active', 1)->get();
    
        $category = Category::find($vcard->category_id);
    
        $businessListings = BusinessListing::where('user_id', $vcard->user_id)
        ->where('is_active', 1)
        ->get();
        
        return view('yellowpages::Vcard.share-card', compact('vcard', 'user', 'category', 'dynamicFields', 'businessListings'));
     }
     
    ##------------------------- END ---------------------##
    ##------------------------- VCard scan ---------------------##

    public function vcardScan($slug)
    {
        // Retrieve the vCard record by slug, including its dynamic fields.
        $vcard = VCard::where('slug', $slug)
            ->where('is_active', 1)
            ->orderBy('id', 'desc')
            ->with('dynamicFields')
            ->first();
    
        if (!$vcard) {
            abort(404, 'vCard not found.');
        }
    
        // Increment the scan_count column
        $count =$vcard->increment('scan_count');
    
        // Load the user with their address using the hasOne relationship.
        $user = User::with('address')->find($vcard->user_id);
        if (!$user) {
            abort(404, 'User not found.');
        }
    
        $dynamicFields = DynamicFeild::where('is_active', 1)->get();
    
        $category = Category::find($vcard->category_id);
    
        // Retrieve all business listings for the user.
        $businessListings = BusinessListing::where('user_id', $vcard->user_id)
            ->where('is_active', 1)
            ->get();
    
        // Pass the data to the view.
        return view('yellowpages::Vcard.scan-card', compact('vcard', 'user', 'category', 'dynamicFields', 'businessListings'));
    }
    
    ##------------------------- END ---------------------##

    ##------------------------- VCard list ------------------ ---##
    public function VcardList(Request $request) {
     try {
            $userId = Auth::id();
            $user = User::find($userId);
            $Vcard_list = VCard::where('user_id', $userId)->get();    
            // Fetch cities for each Vcard
            $cities = City::whereIn('id', $Vcard_list->pluck('city_id'))->get()->keyBy('id');    
            // Fetch categories if necessary
            $categories = Category::whereIn('id', $Vcard_list->pluck('category_id'))->get()->keyBy('id');
    
            return view('yellowpages::Vcard.vcard-list', compact('user','Vcard_list', 'cities', 'categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error fetching Vcard listings: ' );
        }
    }
    
    ##------------------------- END ---------------------##
    ##------------------------- VCard Delete ---------------------##
    public function vcarddelete($id)
    {
        try {
            $city = VCard::findOrFail($id);
            $city->delete();
            return redirect()->route('vCard.createCard')->with('success', 'Vcard deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('vCard.list')->withErrors(['error' => 'vcard not found.']);
        } catch (Exception $e) {
            return redirect()->route('vCard.list')->withErrors(['error' => 'An error occurred while trying to delete the VCard: ' ]);
        }
    }
    ##------------------------- END ---------------------##


    //cardview
    public function cardView($city_arr, $slug)
    {
        
        $vcard = User::select('users.*')
        ->join('cities', 'cities.id', '=', 'users.city_id')
        ->leftJoin('address', 'address.user_id', '=', 'users.id') // Optional if address exists
        ->where('cities.city_arr', $city_arr)
        ->where('users.user_code', $slug)
        ->with('address') 
        ->firstOrFail();
    

       
        
        return view('yellowpages::Vcard.newCard', compact( 'vcard'));
    }
    

}
