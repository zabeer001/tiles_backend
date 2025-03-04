<?php

namespace App\Http\Controllers;

use App\Http\Requests\TilesRequest;
use App\Http\Resources\TilesResource;
use App\Models\Tiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index()
    {
        try {
            // Your logic to fetch data, e.g., retrieving projects or tasks
            $data = Tiles::all();  // Example, adjust as per your needs

            // Return a successful response
            return $this->responseSuccess($data);
        } catch (\Exception $e) {
            // Log the error if needed
            \Log::error('Error fetching data: ' . $e->getMessage());

            // Return an error response
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
        try {

            // Handle image upload using the helper function
            $imagePath = $this->uploadImage($request->file('image'));

            // Create a new tile instance
            $tile = new Tiles();
            $tile->name = $request->name;
            $tile->price = $request->price;
            $tile->description = $request->description;
            $tile->image = $imagePath;  // Save the image path in DB
            $tile->save();

            // Return success response using TilesResource
            return $this->responseSuccess(new TilesResource($tile), 'Tile created successfully', 201);
        } catch (\Exception $e) {
            // Log the error with additional context
            Log::error('Error creating tile: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'error' => $e->getTraceAsString(),
            ]);

            // Return error response
            return $this->responseError('Something went wrong', $e->getMessage(), 500);
        }
    }





    // In your controller




    /**
     * Display the specified resource.
     */
    public function show(Tiles $tiles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tiles $tiles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Find the existing tile by ID
            $tile = Tiles::findOrFail($id);

            // Use the new method to handle the image update
            $imagePath = $this->updateImage($request, $tile);

            // Update tile data
            $tile->name = $request->name;
            $tile->price = $request->price;
            $tile->description = $request->description;
            $tile->image = $imagePath;  // Update the image path
            $tile->save();

            // Return success response using TilesResource
            return $this->responseSuccess(new TilesResource($tile), 'Tile updated successfully', 200);
        } catch (\Exception $e) {
            // Log the error with additional context
            Log::error('Error updating tile: ' . $e->getMessage(), [
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
    public function destroy(Tiles $tiles)
    {
        //
    }

    protected function uploadImage($image)
    {
        try {
            // Check if the image is valid
            if ($image && $image->isValid()) {
                // Define the destination path (public/tiles folder)
                $destinationPath = public_path('uploads');

                // Generate a unique filename for the image (optional)
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Move the image to the tiles folder
                $image->move($destinationPath, $imageName);

                // Return the relative path to the image
                return 'uploads/' . $imageName;
            }

            // Return null if no image is uploaded or it is invalid
            return null;
        } catch (\Exception $e) {
            // Log the error if something goes wrong
            Log::error('Image upload failed: ' . $e->getMessage(), [
                'error' => $e->getTraceAsString(),
            ]);

            // Return null in case of an error
            return null;
        }
    }

    protected function updateImage(Request $request, $tile)
    {
        // Check if a new image is uploaded and delete the previous image if it exists
        if ($request->hasFile('image')) {
            // Delete the previous image if it exists
            if ($tile->image && file_exists(public_path($tile->image))) {
                unlink(public_path($tile->image)); // Delete the old image
            }

            // Handle image upload using the helper function
            return $this->uploadImage($request->file('image'));
        }

        // If no new image is uploaded, keep the old image
        return $tile->image;
    }

}
