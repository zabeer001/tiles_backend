<?php

namespace App\Http\Controllers;

use App\Helpers\HelperMethods;
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
            // return 'zabeer';
            // Fetch all tiles with their related categories
            $tiles = Tiles::with('categories')->paginate(10);

            // Return a successful response
            return $this->responseSuccess([
                'data' => $tiles, // Only tile data
                'current_page' => $tiles->currentPage(),
                'total_pages' => $tiles->lastPage(), // Total pages
                'per_page' => $tiles->perPage(),
                'total' => $tiles->total(),
            ]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error fetching tiles: ' . $e->getMessage());

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
        // Validate incoming data
        // $validated = $request->validate([
        //     'name' => 'required|string',
        //     'grid_category' => 'required|string',
        //     'description' => 'required|string',
        //     'image' => 'nullable|image|max:2048', // Allow image files up to 2MB
        //     'category_id' => 'nullable|array',
        // ]);

        // If validation passes, save the new tile
        try {
            $tile = new Tile();
            $tile->name = $request->name;
            $tile->grid_category = $request->grid_category;
            $tile->description = $request->description;

            if ($request->hasFile('image')) {
                $tile->image = $request->file('image')->store('tiles');
            }

            // If categories are passed, associate them with the tile (many-to-many)
            if ($request->category_id) {
                $tile->categories()->sync($request->category_id);
            }

            $tile->save();

            return response()->json(['message' => 'Tile created successfully!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function storea(Request $request)
    {
        // Validate the incoming request
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'grid_category' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'image' => 'nullable|image|mimes:svg|max:5120',
        //     'category_id' => 'required|array', // Validate category_id is an array

        // ]);

        try {
            // Handle image upload using the helper function
            $imagePath = HelperMethods::uploadImage($request->file('image'));

            // Create a new tile instance
            $tile = new Tiles();
            $tile->name = $validated['name'];
            $tile->grid_category = $validated['grid_category'];
            $tile->description = $validated['description'];
            $tile->image = $imagePath;  // Save the image path in DB
            $tile->save();

            // Sync categories to the tile (add or remove as necessary)
            $tile->categories()->sync($validated['category_id']);  // Sync categories with the given array

            // Return success response using TilesResource
            return $this->responseSuccess($tile, 'Tile created successfully', 201);
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
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grid_category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:svg|max:5120',
            'category_id' => 'required|array', // Validate category_id is an array
        ]);

        try {
            // Find the existing tile by ID
            $tile = Tiles::findOrFail($id);

            // Update the image if a new one is uploaded
            $tile->image = HelperMethods::updateImage($request, $tile);  // Use the existing updateImage method

            // Update the tile's fields
            $tile->name = $validated['name'];
            $tile->grid_category = $validated['grid_category'];
            $tile->description = $validated['description'];
            $tile->save();

            // Sync categories to the tile (add or remove as necessary)
            $tile->categories()->sync($validated['category_id']);  // Sync categories with the given array

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




}

//app/Helpers/HelperMethods.php