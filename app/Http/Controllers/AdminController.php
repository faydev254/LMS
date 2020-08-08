<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon; 
use Image; 
use Illuminate\Http\Response;
use Storage;
use Illuminate\Support\Facades\Input; 
use File; 

use App\Vehicle;
use App\Transaction;
 
// use Charts;
use App\Charts\DashboardChart;
use App\Charts\RevenueChart;

use Illuminate\Support\Facades\Hash;



class AdminController extends Controller
{


           public function dashboard()
    {
        //
      $adm = 1;
         $admins = User::where( 'admin', '=', $adm )->get();

         // return view('admin.extras.add_event');

         return view( 'admin.dashboard', compact('admins'));
   
    }




         public function profileUpdate()
    {
        //
      $adm = 1;
         $admins = User::where( 'admin', '=', $adm )->get();

         // return view('admin.extras.add_event');

         return view( 'admin.extras.update_profile', compact('admins'));
   
    }


   public function storeProfile(Request $request)
    {
      $id = $request->user_id;
      $pass = $request->password;
      $pwd = bcrypt($pass);
        
      $user = User::find($id)->update(['name' => $request->name,'email' => $request->email,'password'=>$pwd]);

        return redirect()->back()->with('success', 'Profile Updated Successfully');

 
 }



   public function storeAdmin(Request $request)
    {
     
 

  if ($request->isMethod('post')) {
            
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $adminDef = 1;

            $adminNew = new User;
            $adminNew->name = $data['name'];
            $adminNew->email = $data['email'];
            $adminNew->admin = $adminDef;
            $adminNew->password = Hash::make($data['password']);
           

            $adminNew->save();

        return redirect()->back()->with('adminsuccess', 'Admin Added Successfully');
            
            
        }
 
 }




    public function deleteAdmin($id=null){

        $delAd = User::where('id', '=', $id)->firstOrFail();
        $delAd->delete();
        return redirect()->back()->with('deletesuccess', 'successfully deleted record');

    }




    // Vehicles
     public function create_vehicle()
    {
        //

         $showvehicles = Vehicle::get();


         return view( 'admin.create_vehicle', compact('showvehicles'));
   
    }


    public function save_vehicle(Request $request)
    {
        // save 

        $vehicles = Vehicle::create( $request->all() );

        // event image

         if ( $request->hasFile( 'image' ) ) {
            $image_tmp =$request->image;
            if ( $image_tmp->isValid() ) {
                $extension         = $image_tmp->getClientOriginalExtension();
                $filename          = rand( 111, 9999 ) . '.' . $extension;
                $large_image_path  = 'images/vehicleImages/large/' . $filename;
                $medium_image_path = 'images/vehicleImages/medium/' . $filename;         

                // Resize Imgs
                Image::make( $image_tmp )->save( $large_image_path );
                Image::make( $image_tmp )->resize( 279, 165 )->save( $medium_image_path );
           
                // Storing Image
             
                $vehicles['image'] = $filename;
            }

        }
 
        $vehicles->save(); 

        // redirect to same page        

        return redirect()->back()->with('success', 'Vehicle Created Successfully'); 

    }

    public function deleteVehicle( $id ) {

        $vehicle = Vehicle::destroy( $id );

       return redirect()->back()->with('deletesuccess', 'Vehicle Deleted Successfully'); 
         
    }


    // Vehicles
     public function create_transaction()
    {
        //

         $showtransactions = Transaction::get();


         return view( 'admin.create_transaction', compact('showvehicles'));
   
    }


    public function save_transaction(Request $request)
    {
        // save 

        $transaction = Transaction::create( $request->all() );

        // event image

         if ( $request->hasFile( 'image' ) ) {
            $image_tmp =$request->image;
            if ( $image_tmp->isValid() ) {
                $extension         = $image_tmp->getClientOriginalExtension();
                $filename          = rand( 111, 9999 ) . '.' . $extension;
                $large_image_path  = 'images/transactionImages/large/' . $filename;
                $medium_image_path = 'images/transactionImages/medium/' . $filename;         

                // Resize Imgs
                Image::make( $image_tmp )->save( $large_image_path );
                Image::make( $image_tmp )->resize( 279, 165 )->save( $medium_image_path );
           
                // Storing Image
             
                $transaction['image'] = $filename;
            }

        }
 
        $transaction->save(); 

        // redirect to same page        

        return redirect()->back()->with('transaction_success', 'Transaction Created Successfully'); 

    }

    public function deleteTransaction( $id ) {

        $transaction = Transaction::destroy( $id );

       return redirect()->back()->with('deletesuccess', 'Transaction Deleted Successfully'); 
         
    }
 

 
 
}
