<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;



class ProfileController extends Controller
{

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */

public function update(ProfileUpdateRequest $request): RedirectResponse|JsonResponse
{
    $user = $request->user();

    $user->fill($request->only([
        'name',
        'email',
        'designation',
        'mobile'
    ]));

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    if ($request->ajax()) {
        return response()->json(['message' => 'Profile updated']);
    }

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}


public function updateProfilePic(Request $request){
    $id = Auth::user()->id;
     $user = Auth::user();
    // dd($request->all());
    $validator = Validator::make($request->all(),[
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'

    ]);
    if( $validator->passes()){
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = $id . '-'. time() . $ext;

         if ($user->image && file_exists(public_path('profile_pic/' . $user->image))) {
            unlink(public_path('profile_pic/' . $user->image));
             unlink(public_path('profile_pic/thumb/' . $user->image));
        }
          $image->move(public_path('/profile_pic'),$imageName);
        //   Create small thumbnail
$sourcePath = public_path('/profile_pic'.$imageName);
$manager = new ImageManager(Driver::class);
$image = $manager->read($sourcePath);
$image->cover(150, 150);
$image->toPng()->save(public_path('/profile_pic/thumb/').$imageName);

        User::where('id', $id)->update(['image' =>$imageName ]);

        return response()->json([
        'status' => true,
        'message' => 'Image uploaded successfully'
    ]);
    }else{
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
