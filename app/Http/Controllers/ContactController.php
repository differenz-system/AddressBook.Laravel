<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts.index');
    }

    public function favoritesIndex()
    {
        return view('favorites.index');
    }

    public function favoritesDatatable(): JsonResponse
    {
        $contacts = Contact::query()
            ->where('user_id', Auth::id())
            ->where('is_favorite', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get([
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'city',
                'is_favorite',
                'photo_path',
                'created_at'
            ]);

        return response()->json(['data' => $contacts]);
    }

    public function datatable(): JsonResponse
    {
        $contacts = Contact::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get([
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'address',
                'city',
                'state',
                'country',
                'postal_code',
                'is_favorite',
                'photo_path',
                'created_at',
                'updated_at'
            ]);

        return response()->json(['data' => $contacts]);
    }

    public function show($id): JsonResponse
    {
        $contact = Contact::where('user_id', Auth::id())->where('id', $id)->first();
        if (!$contact) {
            return response()->json(['status' => 'error', 'message' => 'Contact not found.'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $contact]);
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('contacts', 'public');
            $data['photo_path'] = $path;
        }
        $contact = Contact::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact created successfully.',
            'data' => $contact,
        ]);
    }

    public function update(UpdateContactRequest $request, $id): JsonResponse
    {
        $contact = Contact::where('user_id', Auth::id())->where('id', $id)->first();
        if (!$contact) {
            return response()->json(['status' => 'error', 'message' => 'Contact not found.'], 404);
        }

        $data = $request->validated();
        // Handle photo replacement
        if ($request->boolean('remove_photo')) {
            if ($contact->photo_path && Storage::disk('public')->exists($contact->photo_path)) {
                Storage::disk('public')->delete($contact->photo_path);
            }
            $data['photo_path'] = null;
        }
        if ($request->hasFile('photo')) {
            if ($contact->photo_path && Storage::disk('public')->exists($contact->photo_path)) {
                Storage::disk('public')->delete($contact->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('contacts', 'public');
        }
        $contact->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact updated successfully.',
            'data' => $contact,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $contact = Contact::where('user_id', Auth::id())->where('id', $id)->first();
        if (!$contact) {
            return response()->json(['status' => 'error', 'message' => 'Contact not found.'], 404);
        }

        if ($contact->photo_path && Storage::disk('public')->exists($contact->photo_path)) {
            Storage::disk('public')->delete($contact->photo_path);
        }
        $contact->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Contact deleted successfully.',
        ]);
    }

    public function toggleFavorite($id): JsonResponse
    {
        $contact = Contact::where('user_id', Auth::id())->where('id', $id)->first();
        if (!$contact) {
            return response()->json(['status' => 'error', 'message' => 'Contact not found.'], 404);
        }
        $contact->is_favorite = !$contact->is_favorite;
        $contact->save();
        return response()->json(['status' => 'success', 'data' => $contact]);
    }

    public function exportCsv()
    {
        $userId = Auth::id();
        $fileName = 'contacts_'.now()->format('Ymd_His').'.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ];

        $columns = [
            'First Name','Last Name','Email','Phone','Address','City','State','Country','Postal Code',
            'Job Title','Company','Department','Work Email','Work Phone','Website','Birthday','Notes',
            'Favorite','Photo URL','Created At','Updated At'
        ];

        $callback = function() use ($userId, $columns) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fprintf($out, "%s", "\xEF\xBB\xBF");
            fputcsv($out, $columns);

            Contact::where('user_id', $userId)
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->chunk(500, function($chunk) use ($out) {
                    foreach ($chunk as $c) {
                        $photoUrl = $c->photo_path ? asset('storage/'.$c->photo_path) : '';
                        $row = [
                            $c->first_name,
                            $c->last_name,
                            $c->email,
                            $c->phone,
                            $c->address,
                            $c->city,
                            $c->state,
                            $c->country,
                            $c->postal_code,
                            $c->job_title ?? null,
                            $c->company ?? null,
                            $c->department ?? null,
                            $c->work_email ?? null,
                            $c->work_phone ?? null,
                            $c->website ?? null,
                            $c->birthday ?? null,
                            $c->notes ?? null,
                            $c->is_favorite ? 'Yes' : 'No',
                            $photoUrl,
                            optional($c->created_at)->toDateTimeString(),
                            optional($c->updated_at)->toDateTimeString(),
                        ];
                        fputcsv($out, $row);
                    }
                });
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
