<?php

namespace App\Http\Controllers;

use App\Helpers\HelperMethods;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return 'zabeer';
        try {
            $colors = Color::paginate(10);
            return $colors;
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return $this->responseError('Something went wrong, please try again later.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return 'zabeer';
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255', // Code is optional
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is optional


        ]);
       

        try {
            // Handle image upload using the helper function
            $imagePath = HelperMethods::uploadImage($request->file('image'));

            // Create a new color instance
            $color = new Color();
            $color->name = $validated['name'];
            $color->code = $request->code;
            $color->image = $imagePath;

            $color->save();

            // Sync categories to the color (add or remove as necessary)
        

            // Return success response using colorsResource
            return $this->responseSuccess($color, 'color created successfully', 201);
        } catch (\Exception $e) {
            // Log the error with additional context
            Log::error('Error creating color: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'error' => $e->getTraceAsString(),
            ]);

            // Return error response
            return $this->responseError('Something went wrong', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // return 'ok';
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255', // Code is optional
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is optional
        ]);

       

        try {
            // Find the existing color by ID
            $color = Color::findOrFail($id);

            // Update the image if a new one is uploaded
 

            // Update the color's fields
            $color->name = $validated['name'];
            $color->code = $validated['code'];
            $color->image = HelperMethods::updateImage($request, $color);  // Use the existing updateImage method
            $color->save();

         
         

            // Return success response using colorsResource
            return $this->responseSuccess($color, 'Tile created successfully', 201);
        } catch (\Exception $e) {
            // Log the error with additional context
            Log::error('Error updating color: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'error' => $e->getTraceAsString(),
            ]);

            // Return error response
            return $this->responseError('Something went wrong', $e->getMessage(), 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        //
    }
}
