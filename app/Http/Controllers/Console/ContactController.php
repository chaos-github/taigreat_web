<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/** 後台查看前台「聯絡我們」送出的留言。 */
class ContactController extends Controller
{
    public function index(): View
    {
        return view('console.contacts.index', [
            'contacts' => Contact::query()
                ->latest()
                ->paginate(12),
        ]);
    }

    public function show(Contact $contact): View
    {
        return view('console.contacts.show', [
            'contact' => $contact,
        ]);
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('console.contacts.index')->with('status', '留言已刪除。');
    }
}
