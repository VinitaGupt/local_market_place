<?php

namespace Modules\YellowPages\Http\Controllers\Checker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessListing;
use Carbon\Carbon;
use App\Models\Visits;
use App\Models\UserPurchasePlan;
use App\Models\BusinessHour;
use App\Models\Category;
use App\Models\DynamicFeild;
use App\Models\BusinessSocialMedia;
use Exception;
use App\Models\City;
use App\Models\User;
use App\Models\VCard;
use App\Models\Address;
use App\Models\CompanyLegalType;
use App\Models\EmployeeRange;
use App\Models\MonthlyTurnover;
use App\Models\AdvertisingMedium;
use App\Models\AdvertisingPrice;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CheckerController extends Controller
{
    public function CheckListing(Request $request) {
        try {
            $business_listing = BusinessListing::all(); // Renamed for clarity
             $users = User::whereIn('id', $business_listing->pluck('user_id'))->get()
                     ->keyBy('id');
            return view('yellowpages::admin.checker-listing', compact('business_listing', 'users'));
        } catch (Exception $e) {
            return redirect()->route('admin.dashboard')->withErrors(['error' => 'An error occurred while fetching the business listings: ' ]);
        }
    }

    public function approveListing($id)
    {
        try {
            $listing = BusinessListing::findOrFail($id);
            $user = User::where('id',$listing->user_id)->first();
            $listinghours = BusinessHour::where('business_id', $listing->id)->get();
            $categories = Category::where('is_active', 1)->get();
            $cities = City::where('is_active', 1)->get();
            $company_legal_types = CompanyLegalType::all();
            $number_of_employees = EmployeeRange::all();
            $monthly_turnovers = MonthlyTurnover::all();
            $monthly_advertising_mediums = AdvertisingMedium::all();
            $monthly_advertising_prices = AdvertisingPrice::all();
            $social_media = DynamicFeild::on('yp')->get();  
            $social_media_data = BusinessSocialMedia::where('listing_id', $listing->id)
            ->whereIn('social_id', $social_media->pluck('id'))
            ->get();
            $listing->business_img_url = $listing->business_img ? Storage::url($listing->business_img) : null;
    
            return view('yellowpages::admin.checker-listing-approve', compact(
                'listing',
                'cities',
                'user',
                'categories',
                'company_legal_types',
                'number_of_employees',
                'monthly_turnovers',
                'monthly_advertising_mediums',
                'monthly_advertising_prices',
                'social_media',
                'social_media_data',
                'listinghours',
            ));
    
        } catch (ModelNotFoundException $e) {
            return redirect()->route('checker.listing')->withErrors(['error' => 'Listing not found.']);
        } catch (Exception $e) {
            return redirect()->route('checker.listing')->withErrors(['error' => 'An error occurred: ' ]);
        }
    }
    
    public function approveListingStatus($id)
    {
        $listing = BusinessListing::findOrFail($id);
        $listing->is_active = $listing->is_active == 1 ? 0 : 1;
        $listing->save();
    
        return redirect()->route('checker.listing')->with('success', 'सूचीकरण सफलतापूर्वक स्वीकृत हुआ।');
    }

    public function CheckCard(Request $request) {
        try {
            $Vcard_list = VCard::all();
            $users = User::whereIn('name', $Vcard_list->pluck('slug'))->get(); 

            return view('yellowpages::admin.checker-card-list', compact('Vcard_list', 'users'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error fetching Vcard listings: ' );
        }
    }
   // Controller
   public function approveCard($id)
   {
       // Fetch the VCard data by its ID, including dynamic fields relation
       $vcard = VCard::where('id', $id)
           ->with('user', 'dynamicFields') // Assuming 'user' is the relation for the user of the VCard
           ->orderBy('id', 'desc')
           ->first();
   
       if (!$vcard) {
           return redirect()->back()->with('error', 'VCard not found.');
       }
   
       // Get the user associated with the VCard
       $user = $vcard->user; // Access the associated user directly from the VCard model
   
       // Fetch the category for the VCard using the category ID
       $category = Category::find($vcard->category_id);
   
       // Fetch all dynamic fields that are active
       $dynamicFields = DynamicFeild::where('is_active', 1)->get();
   
       // Pass all the data to the view
       return view('yellowpages::admin.checker-card-approval', compact('vcard', 'user', 'category', 'dynamicFields')); 
   }
   
   public function approveCardStatus($id)
{
    $listing = VCard::findOrFail($id);

    // Toggle the 'is_active' value between 1 and 0
    $listing->is_active = $listing->is_active == 1 ? 0 : 1;
    $listing->save();

    return redirect()->route('checker.card')->with('success', 'सूचीकरण का स्थिति सफलतापूर्वक अद्यतन हुआ।');
}


    
    


}
 