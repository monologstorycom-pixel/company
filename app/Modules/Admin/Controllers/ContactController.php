<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts.
     */
    public function index(Request $request)
    {
        $this->authorize('view contacts');

        $query = Contact::orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact)
    {
        $this->authorize('view contacts');

        // Mark as read if unread
        if ($contact->status === 'unread' && !$contact->read_at) {
            $contact->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $this->authorize('edit contacts');

        $validated = $request->validated();

        $contact->update([
            'status' => $validated['status'],
        ]);

        // Mark as read if status is being updated to read or replied
        if ($validated['status'] !== 'unread' && !$contact->read_at) {
            $contact->update(['read_at' => now()]);
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete contacts');

        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}
