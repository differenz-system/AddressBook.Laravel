<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreContactRequest;
use App\Http\Requests\Api\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Http\Resources\ContactCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index(Request $request): JsonResponse
    {
        $contacts = $request->user()->contacts()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('company', 'like', "%{$search}%");
                });
            })
            ->when($request->is_favorite, function ($query, $isFavorite) {
                $query->where('is_favorite', filter_var($isFavorite, FILTER_VALIDATE_BOOLEAN));
            })
            ->when($request->sort_by, function ($query, $sortBy) use ($request) {
                $direction = $request->sort_direction ?? 'asc';
                $query->orderBy($sortBy, $direction);
            }, function ($query) {
                $query->orderBy('first_name', 'asc')->orderBy('last_name', 'asc');
            })
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'message' => 'Contacts retrieved successfully',
            'data' => new ContactCollection($contacts)
        ]);
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = $request->user()->contacts()->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Contact created successfully',
            'data' => new ContactResource($contact)
        ], 201);
    }

    /**
     * Display the specified contact.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $contact = $request->user()->contacts()->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Contact retrieved successfully',
            'data' => new ContactResource($contact)
        ]);
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(UpdateContactRequest $request, $id): JsonResponse
    {
        $contact = $request->user()->contacts()->findOrFail($id);
        $contact->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Contact updated successfully',
            'data' => new ContactResource($contact)
        ]);
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $contact = $request->user()->contacts()->findOrFail($id);
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact deleted successfully'
        ]);
    }

    /**
     * Toggle favorite status of a contact
     */
    public function toggleFavorite(Request $request, $id): JsonResponse
    {
        $contact = $request->user()->contacts()->findOrFail($id);
        $contact->update(['is_favorite' => !$contact->is_favorite]);

        return response()->json([
            'success' => true,
            'message' => 'Contact favorite status updated successfully',
            'data' => new ContactResource($contact)
        ]);
    }

    /**
     * Get favorite contacts
     */
    public function favorites(Request $request): JsonResponse
    {
        $contacts = $request->user()->contacts()
            ->where('is_favorite', true)
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'message' => 'Favorite contacts retrieved successfully',
            'data' => new ContactCollection($contacts)
        ]);
    }
}
