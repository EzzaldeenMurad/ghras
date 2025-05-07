<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * Store a newly created certificate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'certificate_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        // Check if user is a consultant
        if ($user->role !== 'consultant') {
            return redirect()->back()->with('certificate_error', 'فقط المستشارين يمكنهم إضافة شهادات');
        }
        // Handle file upload
        if ($request->hasFile('certificate_image')) {
            $image = $request->file('certificate_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/users/consultants'), $imageName);
            $path = 'images/users/consultants/' . $imageName;
            // Create certificate record
            Certificate::create([
                'consultant_id' => $user->id,
                'image_path' =>  $path,
                'title' => $request->title,
            ]);

            return redirect()->back()->with('certificate_success', 'تم إضافة الشهادة بنجاح');
        }

        return redirect()->back()->with('certificate_error', 'حدث خطأ أثناء رفع الشهادة');
    }

    /**
     * Remove the specified certificate from storage.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        // Check if the certificate belongs to the authenticated user
        if ($certificate->consultant_id !== auth()->id()) {
            return redirect()->back()->with('certificate_error', 'غير مصرح لك بحذف هذه الشهادة');
        }

        // Delete the file from storage
        $filePath = public_path($certificate->image_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the record
        $certificate->delete();

        return redirect()->back()->with('certificate_success', 'تم حذف الشهادة بنجاح');
    }
}